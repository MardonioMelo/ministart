<?php

namespace App\Conn;

use CoffeeCode\DataLayer\Connect;

/**
 * Classe usada para conexões PDO personalidas
 *
 * Class CrudPdo
 * @package App\Conn
 */
class PdoExemple
{

    /*
     * GET PDO instance AND errors
     */
    public function setPDO()
    {
        $connect = Connect::getInstance();
        $error = Connect::getError();

        /*
         * CHECK connection/errors
         */
        if ($error) {
            echo $error->getMessage();
            die();
        }

        /*
         * FETCH DATA
         */
        $users = $connect->query("SELECT * FROM sm_newsletter LIMIT 5");
        var_dump($users->fetchAll());
    }

}
