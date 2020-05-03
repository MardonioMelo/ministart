<?php

namespace App\Helpers;

use Dotenv;

/**
 * Class DotEnvConf
 * @package App\Helpers
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class DotEnvConf
{

    /** @var Dotenv\ */
    private $dotenv;
    private $dir_env = __DIR__ . '../../../';

    /**
     * DotEnvConf constructor.
     * @param array $varname
     */
    public function __construct($varname = [])
    {
        $this->load($varname);
    }

    /**
     * @param $varname
     * @return array|false|string
     */
    public function getEnv($varname)
    {
        return getenv($varname);
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    /**
     * Verifca se as variaveis de ambiente foram declaradas
     * @param $varname
     */
    private function load($varname)
    {
        if (empty($this->getEnv('ENV_CHECK'))) {

            $this->dotenv = Dotenv\Dotenv::createImmutable($this->dir_env);
            $this->dotenv->load();

            if (!empty($varname)) {
                $this->dotenv->required($varname);
            }

        }
    }


}