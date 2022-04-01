<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController{
    public function homeInit(Request $req, Response $res){
        $body = [
            "code"          => 200,
            "status"        => "success",
            "documentación" => "https://github.com/fernandorzbs/slimv4-apirest",
            "endpoints"     => [
                "clientes"  => $_SERVER['APP_DOMAIN'].$_SERVER['APP_PORT']."/clientes"
            ]
        ];
        $res->getBody()->write(json_encode($body));
        return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
    }
}
?>