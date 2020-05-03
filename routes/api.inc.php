<?php

use CoffeeCode\Router\Router;

$router = new Router(BASE);


/**
 * Group Site
 */
$router->group("/")->namespace("App\Controllers\Site");
# POST
$router->post("/newsletter", "SiteController:newsletter");

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

