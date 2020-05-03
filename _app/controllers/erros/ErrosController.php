<?php

namespace App\Controllers\Erros;

use App\Helpers\View;

/**
 * Class ErrosController
 * @package App\Controllers\Erros
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class ErrosController
{
    /**
     * @param array $data
     */
    public function notfound(array $data)
    {
        $View = new View;
        $tpl = $View->Load('error/error_404');
        $data['title'] = SITENAME.' - '.SITEDESC;
        $data['INCLUDE_PATH'] = INCLUDE_PATH;
        $View->Show($data, $tpl);
    }
}