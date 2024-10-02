<?php

use app\controllers\ControllerAluno;
use app\controllers\ControllerCliente;
use app\controllers\ControllerHome;
use app\controllers\ControllerLogin;
use app\controllers\ControllerUsuario;
use app\controllers\ControllerAdotante;
use app\controllers\ControllerMedicamento;
use app\controllers\ControllerResgate;
use app\middleware\Middleware;

use Slim\Routing\RouteCollectorProxy;


$app->get('/', ControllerHome::class . ':home')->add(Middleware::route());


$app->get('/login', ControllerLogin::class . ':login')->add(Middleware::route());
$app->post('/autenticacao', ControllerLogin::class . ':autenticacao')->add(Middleware::route());
$app->post('/cadastro', ControllerUsuario::class . ':insert')->add(Middleware::route());


$app->group('/adotantes', function (RouteCollectorProxy $group) {
    $group->get('/lista', ControllerAdotante::class . ':lista');
    $group->post('/cadastro', ControllerAdotante::class . ':insert');

});

$app->group('/medicamentos', function (RouteCollectorProxy $group) {
    $group->get('/lista', ControllerMedicamento::class . ':lista');
    $group->post('/cadastro', ControllerMedicamento::class . ':insert');

});

$app->group('/resgates', function (RouteCollectorProxy $group) {
    $group->get('/lista', ControllerResgate::class . ':lista');
    $group->post('/cadastro', ControllerResgate::class . ':insert');

});














#
#$app->group('/cliente', function (RouteCollectorProxy $group) {
#    $group->get('/cadastro', ControllerCliente::class . ':cadastro');
#    $group->get('/lista', ControllerCliente::class . ':lista');
#});
#
#
#
#
#
#
#
#
#
#
#
#
#
#
#
#$app->group('/aluno', function (RouteCollectorProxy $group) {
#    $group->get('/lista', ControllerAluno::class . ':lista');
#});
#
#
#$app->group('/disciplina', function (RouteCollectorProxy $group) {
#    $group->get('/lista', ControllerDisciplina::class . ':lista');
#    $group->get('/cadastro', ControllerDisciplina::class . ':cadastro');
#    $group->get('/alterar/{id}', ControllerDisciplina::class . ':alterar');
#    $group->post('/delete', ControllerDisciplina::class . ':delete');
#});
#