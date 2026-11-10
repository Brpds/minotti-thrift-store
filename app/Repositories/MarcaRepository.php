<?php 

namespace App\Repositories;

class MarcaRepository extends AbstractRepository{
    protected array $allowedAttributes = ['id', 'nome', 'created_at', 'updated_at'];
}

?>
