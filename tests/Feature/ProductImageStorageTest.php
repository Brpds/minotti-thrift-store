<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class ProductImageStorageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        // Authorization is covered separately; these tests exercise image handling.
        $this->withoutMiddleware(Authenticate::class);
        $this->actingAs(new User(['role' => 'admin']), 'api');
        config(['filesystems.default' => 'local']);
        foreach (['public', 'local', 's3'] as $disk) {
            Storage::fake($disk);
        }
        foreach (['categorias', 'marcas', 'fornecedores'] as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->string('nome');
            });
            DB::table($name)->insert(['id' => 1, 'nome' => 'Synthetic']);
        }
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('etiqueta')->unique();
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('fornecedor_id');
            $table->string('descricao');
            $table->integer('valor_venda');
            $table->integer('parte_loja');
            $table->string('tipo_divisao');
            $table->string('status');
            $table->string('imagem');
            $table->string('tamanho')->nullable();
            $table->string('condicao');
            $table->boolean('destaque')->default(false);
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Produto::flushEventListeners();
        parent::tearDown();
    }

    private function image(): UploadedFile
    {
        return UploadedFile::fake()->createWithContent('synthetic.png', base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+jRZkAAAAASUVORK5CYII='
        ));
    }

    private function productData(): array
    {
        return [
            'nome' => 'Synthetic product', 'etiqueta' => 'IMG-TEST',
            'categoria_id' => 1, 'marca_id' => 1, 'fornecedor_id' => 1,
            'descricao' => 'Disposable image test', 'valor_venda' => 1000,
            'parte_loja' => 500, 'tipo_divisao' => 'fixo', 'status' => 'disponivel',
            'tamanho' => 'M', 'condicao' => 'Seminova',
        ];
    }

    private function existingProduct(): Produto
    {
        Storage::disk('public')->put('imagens/produtos/original.png', $this->image()->getContent());

        return Produto::create($this->productData() + ['imagem' => 'imagens/produtos/original.png']);
    }

    public function test_upload_display_replacement_and_deletion_use_public_disk(): void
    {
        $created = $this->postJson('/api/v1/produtos', $this->productData() + ['imagem' => $this->image()])
            ->assertCreated()->json();
        $path = $created['imagem'];
        $id = $created['id'];
        $this->assertStringStartsWith('imagens/produtos/', $path);
        $this->assertSame($path, Produto::findOrFail($id)->imagem);
        Storage::disk('public')->assertExists($path);

        foreach (['/api/v1/vitrine', '/api/v1/destaque'] as $endpoint) {
            $this->getJson($endpoint)->assertOk()->assertJsonPath('data.0.imagem', '/storage/'.$path);
        }
        $this->getJson('/api/v1/vitrine/'.$id)->assertOk()->assertJsonPath('data.imagem', '/storage/'.$path);
        $this->getJson('/api/v1/produtos')->assertOk()->assertJsonPath('data.0.imagem', $path);
        $this->getJson('/api/v1/produtos/'.$id)->assertOk()->assertJsonPath('imagem', $path);

        $this->patchJson('/api/v1/produtos/'.$id, ['condicao' => 'Nova'])->assertOk();
        Storage::disk('public')->assertExists($path);
        $replacement = $this->patchJson('/api/v1/produtos/'.$id, ['imagem' => $this->image()])
            ->assertOk()->json('imagem');
        $this->assertNotSame($path, $replacement);
        Storage::disk('public')->assertMissing($path);
        Storage::disk('public')->assertExists($replacement);
        $this->assertSame($replacement, Produto::findOrFail($id)->imagem);

        $this->deleteJson('/api/v1/produtos/'.$id)->assertOk();
        Storage::disk('public')->assertMissing($replacement);
        $this->assertNull(Produto::find($id));
        $this->assertSame([], Storage::disk('local')->allFiles());
        $this->assertSame([], Storage::disk('s3')->allFiles());
    }

    public function test_creation_requires_an_image_and_invalid_replacement_preserves_original(): void
    {
        $this->postJson('/api/v1/produtos', $this->productData())
            ->assertUnprocessable()->assertJsonValidationErrors('imagem');
        $product = $this->existingProduct();
        $this->patchJson('/api/v1/produtos/'.$product->id, [
            'imagem' => UploadedFile::fake()->createWithContent('invalid.txt', 'not an image'),
        ])->assertUnprocessable()->assertJsonValidationErrors('imagem');
        $this->assertSame($product->imagem, $product->fresh()->imagem);
        Storage::disk('public')->assertExists($product->imagem);
    }

    public function test_failed_database_creation_cleans_up_the_new_upload(): void
    {
        Produto::creating(function () { throw new \RuntimeException('Synthetic save failure'); });
        $this->postJson('/api/v1/produtos', $this->productData() + ['imagem' => $this->image()])
            ->assertStatus(500);
        $this->assertSame([], Storage::disk('public')->allFiles());
        $this->assertSame(0, Produto::count());
    }

    public function test_failed_database_replacement_preserves_original_and_cleans_new_file(): void
    {
        $product = $this->existingProduct();
        Produto::updating(function () { throw new \RuntimeException('Synthetic save failure'); });
        $this->patchJson('/api/v1/produtos/'.$product->id, ['imagem' => $this->image()])->assertStatus(500);
        $this->assertSame($product->imagem, $product->fresh()->imagem);
        $this->assertSame([$product->imagem], Storage::disk('public')->allFiles());
    }

    public function test_failed_database_deletion_preserves_the_image(): void
    {
        $product = $this->existingProduct();
        Produto::deleting(function () { throw new \RuntimeException('Synthetic delete failure'); });
        $this->deleteJson('/api/v1/produtos/'.$product->id)->assertStatus(500);
        $this->assertNotNull($product->fresh());
        Storage::disk('public')->assertExists($product->imagem);
    }
}
