<?php

use app\controllers\ControllerAnimal;
use Slim\Routing\RouteCollectorProxy;


// Define your routes
$app->group('/animais', function (RouteCollectorProxy $group) {
    // Route to list animals
    $group->get('/lista', ControllerAnimal::class . ':lista');

    // Route to show the registration form
    $group->get('/cadastro', ControllerAnimal::class . ':cadastro');

    // Route to register a new animal
    $group->post('/cadastro', ControllerAnimal::class . ':insert');

    // Route to show the form for editing an animal
    $group->get('/alterar/{id}', ControllerAnimal::class . ':alterar');

    // Route to delete an animal
    $group->delete('/delete/{id}', ControllerAnimal::class . ':delete');
});