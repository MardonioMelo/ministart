<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="theme-color" content="#605ca8"/>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= SITENAME . ' | ' . SITEDESC ?></title>
    <link href="<?= INCLUDE_PATH ?>/assets/img/icon.png" rel="icon" type="image/png"/>
    <!-- CSS núcleo - Incluir todos os arquivos css global -->
    <link href="<?= INCLUDE_PATH ?>/assets/import-all.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script data-main="<?= INCLUDE_PATH ?>/assets/js/main"
            src="<?= INCLUDE_PATH ?>/assets/libs/require-2.3.6.js"></script>

</head>
<body>
<!-- Site wrapper -->
<div>

   <p>Hellou Word!</p>

</div>
<!-- end wrapper -->

<!-- =============================================== -->

<!-- script JS do modulo -->
<script> requirejs(['<?= empty($script_js) ? 'home' : $script_js ?>']); </script>
</body>
</html>