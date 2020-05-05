<?php

namespace App\Conn;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Respnsável por gerenciar a tabela Newsletter
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class TableNewsletter extends DataLayer
{

    /**
     * Newsletter constructor.
     */
    public function __construct()
    {
        parent::__construct("sm_newsletter", ["newsletter_email"], "newsletter_id");
    }

}