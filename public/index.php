<?php
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

$baseDir = __DIR__ . '/../';
require_once $baseDir.'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable($baseDir);
$envFile = $baseDir.'.env';
if (file_exists($envFile)) {
    $dotenv->load();
}

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);

require $baseDir.'src/Routes/Routes.php';

$app->run();
?>