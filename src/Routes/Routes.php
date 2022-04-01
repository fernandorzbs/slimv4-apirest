<?php
use Slim\Routing\RouteCollectorProxy;

//--------------------------------------
// HOME
//--------------------------------------
$app->group('/', function(RouteCollectorProxy $group){
    $group->get(''  , 'App\Controllers\HomeController:homeInit');
});
//--------------------------------------
// CLIENTES
//--------------------------------------
$app->group('/clientes', function(RouteCollectorProxy $group){
    $group->get(''                  , 'App\Controllers\ClienteController:getAll');
    $group->get('/{id}'             , 'App\Controllers\ClienteController:getById');
    $group->post('/add'             , 'App\Controllers\ClienteController:addNew');
    $group->put('/update/{id}'      , 'App\Controllers\ClienteController:update');
    $group->delete('/delete/{id}'   , 'App\Controllers\ClienteController:delete');
});
?>