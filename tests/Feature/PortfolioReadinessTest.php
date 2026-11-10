<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PortfolioReadinessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();

        // Only build disposable test tables; never run migrations or seeders.
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        config(['filesystems.default' => 'public']);

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        foreach (['categorias', 'marcas', 'fornecedores'] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->string('cpf')->nullable();
                $table->timestamps();
            });
            DB::table($tableName)->insert(['id' => 1, 'nome' => 'Demo']);
        }

        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('etiqueta')->nullable();
            $table->string('status');
            $table->boolean('destaque')->default(false);
            $table->unsignedBigInteger('categoria_id')->default(1);
            $table->string('imagem')->default('demo.jpg');
            $table->integer('valor_venda')->default(1000);
            $table->string('tamanho')->default('M');
            $table->string('descricao')->default('Demo');
            $table->string('condicao')->default('Seminova');
            $table->timestamps();
        });
    }

    private function user(string $role): User
    {
        return User::create([
            'nome' => 'Demo',
            'email' => $role.'@example.test',
            'password' => 'test-password',
            'role' => $role,
        ]);
    }

    private function token(User $user): string
    {
        $token = auth('api')->login($user);
        auth()->forgetGuards();

        return $token;
    }

    public function test_dashboard_pages_require_an_administrator_session(): void
    {
        $paths = ['/home', '/produtos', '/marcas', '/fornecedores', '/usuarios',
            '/relatorios', '/avaliacoes', '/categorias', '/adicionar'];

        foreach ($paths as $path) {
            $this->get($path)->assertRedirect('/login');
        }

        $this->actingAs($this->user('user'), 'web');
        foreach ($paths as $path) {
            $this->get($path)->assertForbidden();
        }

        $this->actingAs($this->user('admin'), 'web');
        foreach ($paths as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_public_registration_is_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [])->assertNotFound();
    }

    public function test_admin_api_rejects_guests_and_non_admin_tokens(): void
    {
        $requests = [];
        foreach (['produtos', 'categorias', 'marcas', 'fornecedores'] as $resource) {
            foreach ([['GET', ''], ['POST', ''], ['GET', '/1'], ['PUT', '/1'],
                ['PATCH', '/1'], ['DELETE', '/1']] as [$method, $suffix]) {
                $requests[] = [$method, '/api/v1/'.$resource.$suffix];
            }
        }
        foreach (['opcoes/status', 'opcoes/divisao', 'opcoes/condicao', 'marcas/list',
            'fornecedores/list', 'categorias/list', 'tamanhocalcado', 'tamanhoroupa'] as $path) {
            $requests[] = ['GET', '/api/v1/'.$path];
        }

        foreach ($requests as [$method, $path]) {
            $this->json($method, $path)->assertUnauthorized();
        }

        $token = $this->token($this->user('user'));
        // An administrator's web session must not authorize a non-admin API identity.
        $this->actingAs($this->user('admin'), 'web');
        foreach ($requests as [$method, $path]) {
            $this->withToken($token)->json($method, $path)->assertForbidden();
        }
    }

    public function test_admin_token_can_use_existing_lists_and_filters(): void
    {
        DB::table('produtos')->insert(['nome' => 'Demo', 'status' => 'disponivel']);
        $token = $this->token($this->user('admin'));

        foreach (['produtos', 'categorias', 'marcas', 'fornecedores'] as $resource) {
            $query = http_build_query(['atributos' => 'id, nome', 'filtro' => 'nome:like:De%']);
            $this->withToken($token)->getJson('/api/v1/'.$resource.'?'.$query)
                ->assertOk()->assertJsonPath('data.0.nome', 'Demo')
                ->assertJsonCount(2, 'data.0');
        }
        $this->withToken($token)->getJson('/api/v1/opcoes/status')->assertOk();
    }

    #[DataProvider('invalidQueries')]
    public function test_query_input_is_rejected_before_execution(string $key, mixed $value): void
    {
        $token = $this->token($this->user('admin'));
        foreach (['produtos', 'categorias', 'marcas', 'fornecedores'] as $resource) {
            $this->withToken($token)->getJson('/api/v1/'.$resource.'?'.http_build_query([$key => $value]))
                ->assertUnprocessable()->assertJsonValidationErrors($key);
        }
    }

    public static function invalidQueries(): array
    {
        return [
            'SQL expression' => ['atributos', 'id,(select password from users limit 1)'],
            'wildcard' => ['atributos', '*'],
            'foreign field' => ['atributos', 'password'],
            'empty selection' => ['atributos', ''],
            'selection array' => ['atributos', ['id']],
            'unknown filter field' => ['filtro', 'password:=:anything'],
            'unsupported operator' => ['filtro', 'nome:raw:1=1'],
            'malformed filter' => ['filtro', 'nome:like'],
            'filter array' => ['filtro', ['nome:like:Demo']],
            'trailing separator' => ['filtro', 'nome:like:Demo;'],
        ];
    }

    public function test_filter_values_remain_bound_and_can_contain_colons(): void
    {
        $token = $this->token($this->user('admin'));
        DB::table('produtos')->insert(['nome' => 'Demo: item', 'status' => 'disponivel']);
        foreach (['Demo: item' => 1, "' OR 1=1 --" => 0] as $value => $count) {
            $query = http_build_query(['filtro' => 'nome:=:'.$value]);
            $this->withToken($token)->getJson('/api/v1/produtos?'.$query)
                ->assertOk()->assertJsonCount($count, 'data');
        }
    }

    public function test_featured_products_allow_empty_and_small_catalogs(): void
    {
        $this->getJson('/api/v1/destaque')->assertOk()->assertJsonCount(0, 'data');
        DB::table('produtos')->insert([
            ['nome' => 'Featured', 'status' => 'disponivel', 'destaque' => true],
            ['nome' => 'Fallback', 'status' => 'disponivel', 'destaque' => false],
            ['nome' => 'Sold', 'status' => 'vendido', 'destaque' => true],
            ['nome' => 'Pending', 'status' => 'pendente', 'destaque' => false],
        ]);
        $this->getJson('/api/v1/destaque')->assertOk()->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.nome', 'Featured')->assertJsonPath('data.1.nome', 'Fallback');
    }

    public function test_featured_products_fill_remaining_slots_without_duplicates(): void
    {
        foreach (range(1, 7) as $id) {
            DB::table('produtos')->insert([
                'nome' => 'Item '.$id, 'status' => 'disponivel', 'destaque' => $id === 1,
            ]);
        }
        $data = $this->getJson('/api/v1/destaque')->assertOk()->assertJsonCount(4, 'data')->json('data');
        $this->assertSame(1, $data[0]['id']);
        $this->assertCount(4, array_unique(array_column($data, 'id')));
        DB::table('produtos')->update(['destaque' => true]);
        $this->getJson('/api/v1/destaque')->assertOk()->assertJsonCount(4, 'data');
    }

    public function test_public_pages_reference_the_exact_tracked_view_paths(): void
    {
        foreach (['/vitrine' => 'allProducts', '/vitrine/1' => 'viewProduct',
            '/vendaconosco' => 'sellWithUs', '/sobrenos' => 'aboutUs', '/perguntasfrequentes' => 'faq'] as $path => $view) {
            $this->get($path)->assertOk()->assertViewIs('app.publicViews.'.$view);
        }
    }

    public function test_credentials_can_establish_both_jwt_and_web_session(): void
    {
        $user = $this->user('admin');
        $credentials = ['email' => $user->email, 'password' => 'test-password'];
        $token = $this->postJson('/api/login', $credentials)->assertOk()->json('token');
        auth()->forgetGuards();
        $this->withToken($token)->getJson('/api/v1/opcoes/status')->assertOk();
        $this->post('/login', $credentials)->assertRedirect('/home');
        $this->assertAuthenticatedAs($user, 'web');
        $this->get('/home')->assertOk();
    }
}
