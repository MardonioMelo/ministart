<?php

namespace App\Controllers\All;

use App\Helpers\View;
use CoffeeCode\Router\Router;

/**
 * Class Controller
 * @package App\Controllers\All
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class Controller
{
    /** @var View */
    protected $View;
    /** @var Router */
    private $jSon;


    /**
     * Set Basico
     */
    public function setBasic()
    {
        $this->View = new View();
        $this->router = new Router(BASE);
    }

    /*
    * ***************************************
    * **********       WEB         **********
    * ***************************************
    */

    /**
     * Config de templ padrão
     * @param $data
     * @param $tpl
     */
    public function viewDefault($data, $tpl)
    {
        $data['title'] = SITENAME . ' - ' . SITEDESC;
        $data['INCLUDE_PATH'] = INCLUDE_PATH;
        $tpl = $this->View->Load($tpl);
        $this->View->Show($data, $tpl);
    }

    /**
     * @param $data
     * @param $script_js
     */
    public function panel($data, $script_js)
    {
        $data['script_js'] = $script_js;
        $this->View->Request(LAYOUTS_PATH . "/home/index", $data);
    }

    /*
     * **************************************
    * **********       API         **********
    * ***************************************
    */

    /**
     * Resposta Rest padrão
     * @param $data
     */
    public function restDefault($data)
    {
        $this->jSon['exit'] = $data;
        $this->View->Request(REQUIRE_PATH . "/api/json", (array)$this->jSon);
    }

    /*
    * ***************************************
    * **********  PRIVATE METHODS  **********
    * ***************************************
    */




}