<?php

namespace App\Controllers\All;

use App\Helpers\View;
use App\Helpers\Check;

/**
 * Class IndexController
 * @package App\Controllers\All
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class IndexController
{
    /** @var View */
    private $View;

    /**
     * ControllerAll constructor.
     */
    public function __construct()
    {
        $this->View = new View;
        $this->check();
    }

    /**
     * Varifica tipo de requisição
     */
    private function check()
    {
        Check::checkRequestMethod() === true ?
            $this->api() :
            $this->web();
    }

    /**
     * Rotas para Ajax
     */
    private function api()
    {
        $this->View->Request("../routes/api", []);
    }

    /**
     * Rotas para Web
     */
    private function web()
    {
        ob_start();

        $this->View->Request("../routes/web", []);

        ob_end_flush();
    }

}