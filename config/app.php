<?php

# Escrito por: Mardônio de Melo Filho
# Email: mardonio.quimico@gmail.com

# hora local
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set("Brazil/East");

# Contantes obrigatórias
$env_require = [
    "ENV_HOST", "ENV_USER", "ENV_PASS", "ENV_DBSA",
    "ENV_MAILUSER", "ENV_MAILPASS", "ENV_MAILPORT", "ENV_MAILHOST",
    "ENV_PROTOCOLO", "ENV_DOMINIO"
];

$dotenv = new App\Helpers\DotEnvConf($env_require);

# CONFIGURAÇÕES DO BANCO DE DADOS ##########
define("DATA_LAYER_CONFIG", [
    "driver" => $dotenv->getEnv('ENV_DRIVE'),
    "host" => $dotenv->getEnv('ENV_HOST'),
    "port" => $dotenv->getEnv('ENV_PORT'),
    "dbname" =>$dotenv->getEnv('ENV_DBSA'),
    "username" => $dotenv->getEnv('ENV_USER'),
    "passwd" => $dotenv->getEnv('ENV_PASS'),
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

# DEFINE SERVIDOR DE E-MAIL ###############
define('MAILUSER', $dotenv->getEnv('ENV_MAILUSER'));
define('MAILPASS', $dotenv->getEnv('ENV_MAILPASS'));
define('MAILPORT', $dotenv->getEnv('ENV_MAILPORT'));
define('MAILHOST', $dotenv->getEnv('ENV_MAILHOST'));

# DEFINE DOMINIO DO SITE ################
define('PROTOCOLO', $dotenv->getEnv('ENV_PROTOCOLO'));
define('DOMINIO', $dotenv->getEnv('ENV_DOMINIO'));

# DEFINE A HOME E BASE ################
define('HOME', PROTOCOLO . DOMINIO);
define("BASE", HOME); // Base para Router
define('INCLUDE_PATH', HOME . '/public');

# DEFINE A HOME DE UPLOADS
define('HOMEUPLOAD', INCLUDE_PATH . '/uploads');

# DEFINE A HOME TEMPLATE ################
define('REQUIRE_PATH', '../resources');
define('LAYOUTS_PATH', '../resources/layouts');

# DEFINE IDENTIDADE DO SITE ################
define('SITENAME', 'Ministart');
define('SITEDESC', 'Framework simples');

# VERSÃO DO SISTEMA
define('VERSION', '0.0.0');

# DEFINE OS DIREITOS AUTORAIS
define('AUTORAIS', '<a href="https://www.startmelo.com.br/">Startmelo</a>');

# VERSÃO DO SISTEMA
define('DISABLE_ERROS', $dotenv->getEnv('DEBUG'));

# TRATAMENTO DE ERROS #####################

#CSS constantes :: Mensagens de Erro
define('SM_ACCEPT', 'alert-success');
define('SM_INFOR', 'alert-info');
define('SM_ALERT', 'alert-warning');
define('SM_ERROR', 'alert-danger');

#SMErro :: Exibe erros lançados :: Front
function SMErro($ErrMsg, $ErrNo, $ErrDie = null)
{
    if (DISABLE_ERROS !== "true"):
        $CssClass = ($ErrNo == E_USER_NOTICE ? SM_INFOR : ($ErrNo == E_USER_WARNING ? SM_ALERT : ($ErrNo == E_USER_ERROR ? SM_ERROR : $ErrNo)));
        echo "<div class=\"alert {$CssClass} alert-dismissable\">{$ErrMsg}<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button></div>";

        if ($ErrDie):
            die;
        endif;
    endif;
}

#PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine)
{
    if (DISABLE_ERROS !== "true"):
        $CssClass = ($ErrNo == E_USER_NOTICE ? SM_INFOR : ($ErrNo == E_USER_WARNING ? SM_ALERT : ($ErrNo == E_USER_ERROR ? SM_ERROR : $ErrNo)));
        echo "<div class=\"alert {$CssClass} alert-dismissable\">";
        echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
        echo "<small>{$ErrFile}</small>";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button></div>";

        if ($ErrNo == E_USER_ERROR):
            die;
        endif;
    endif;
}

set_error_handler('PHPErro');
