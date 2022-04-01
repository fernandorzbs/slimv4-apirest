<?php
declare(strict_types=1);

require __DIR__ . '/../../public/index.php';

try {
    
    $host   = $_SERVER['DB_HOST'];
    $user   = $_SERVER['DB_USER'];
    $pass   = $_SERVER['DB_PASS'];
    $dbname = $_SERVER['DB_NAME'];
    $port   = $_SERVER['DB_PORT'];

    $pdo = new PDO("mysql:host=${host};port=${port};charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("DROP DATABASE IF EXISTS ${dbname}");
    echo '[OK] La base de datos se eliminó con éxito' . PHP_EOL;

    $pdo->exec("CREATE DATABASE ${dbname}");
    echo '[OK] Base de datos creada con éxito' . PHP_EOL;

    $pdo->exec("USE ${dbname}");
    echo '[OK] Base de datos seleccionada con éxito' . PHP_EOL;

    $sql = file_get_contents(__DIR__ . '/apirest.sql');
    $pdo->exec($sql);
    echo '[OK] Registros insertados con éxito' . PHP_EOL;
} catch (PDOException $exception) {
    echo '[ERROR] ' . $exception->getMessage() . PHP_EOL;
}

?>