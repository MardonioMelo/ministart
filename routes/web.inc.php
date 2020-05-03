<?php

use CoffeeCode\Router\Router;

$router = new Router(BASE);

/**
 * Group Site
 */
$router->group("/")->namespace("App\Controllers\Site");
# GET
$router->get("/", "SiteController:home");
$router->get("/termos", "SiteController:termos");

/**
 * Group Admin-Panel
 */
$router->group("/panel")->namespace("App\Controllers\admin");
# GET
$router->get("/", "AdminController:pagePanel");


/**
 * Group Error
 */
$router->group("error")->namespace("App\Controllers\Erros");
$router->get("/{errcode}", "ErrosController:notFound");

/**
 * execute
 */
$router->dispatch();

if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}

