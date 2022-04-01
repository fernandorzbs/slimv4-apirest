<?php
namespace App\Models;

use \PDO;

class Db{
    public function connect()
    {
        $host   = $_SERVER['DB_HOST'];
        $user   = $_SERVER['DB_USER'];
        $pass   = $_SERVER['DB_PASS'];
        $dbname = $_SERVER['DB_NAME'];

        $conn_str = "mysql:host=$host;dbname=$dbname";
        $conn = new PDO($conn_str, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
?>