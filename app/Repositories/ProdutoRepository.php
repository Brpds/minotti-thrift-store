<?php 

namespace App\Repositories;

class ProdutoRepository extends AbstractRepository{
    protected array $allowedAttributes = [
        'id', 'etiqueta', 'nome', 'categoria_id', 'descricao', 'marca_id',
        'valor_venda', 'tipo_divisao', 'fornecedor_id', 'status', 'parte_loja',
        'imagem', 'tamanho', 'condicao', 'destaque', 'created_at', 'updated_at',
    ];
}

?>
