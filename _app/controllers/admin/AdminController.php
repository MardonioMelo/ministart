<?php

namespace App\Controllers\Admin;

use App\Controllers\All\Controller;

/**
 * Class AdminController
 * @package App\Controllers\Admin
 */
class AdminController extends Controller
{

    private $Data;
    private $jSon;

    public function __construct()
    {
        $this->setBasic();


    }

    /**
     * Painel
     */
    public function pagePanel()
    {
        $tpl = $this->View->Load('/admin/test');
        $data["oi"] = "Hellou Word!";
        $data['content_layout'] = $this->View->ReturnTemplate($data, $tpl);
        $this->panel($data, 'home');
    }

    /*
    * ***************************************
    * **********       API         **********
    * ***************************************
    */


    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */


}