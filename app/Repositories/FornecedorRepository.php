<?php 

namespace App\Repositories;

class FornecedorRepository extends AbstractRepository{
    protected array $allowedAttributes = [
        'id', 'nome', 'cpf', 'endereco', 'numero', 'cep', 'referencia',
        'telefone', 'chave_pix', 'created_at', 'updated_at',
    ];
}

?>
