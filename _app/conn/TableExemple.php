<?php


namespace App\conn;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Classe de exemplo para outras
 * Class Crud
 * @package App\conn
 */
class TableExemple extends DataLayer
{

    /**
     * Crud constructor.
     */
    public function __construct()
    {
        parent::__construct(
            "name_table", # nome da tabela
            [],                 # colunas obrigatórias
            "id",       # nome da coluna id
            true    # false - se não tiver as colunas created_at (timestamp) e updated_at (timestamp)
        );
    }

}