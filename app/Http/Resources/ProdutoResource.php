<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'valor_venda' => $this->valor_venda,
            #para retornar o pathlink completo direto do backend
            'imagem' => Storage::url($this->imagem),
            'categoria' => $this->categoria,
            'tamanho' => $this->tamanho,
            'descricao' => $this->descricao,
            'condicao' => $this->condicao
        ];
    }
}
