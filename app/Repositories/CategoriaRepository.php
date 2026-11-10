<?php 

namespace App\Repositories;

class CategoriaRepository extends AbstractRepository {
    protected array $allowedAttributes = ['id', 'nome', 'created_at', 'updated_at'];
}

?>
