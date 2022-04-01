<?php
namespace App\Controllers;
use App\Models\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \PDO;
use \PDOException;

class ClienteController{
    public function getAll(Request $req, Response $res){
        $sql = "SELECT * FROM clientes";
        try {
            $db         = new Db();
            $conn       = $db->connect();
            $stmt       = $conn->query($sql);
            $result     = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db         = null;

            $body = [
                "code"      => 200,
                "status"    => "success",
                "total"     => $stmt->rowCount(),
                "results"   => $result
            ];

            $res->getBody()->write(json_encode($body));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (PDOException $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];
            $res->getBody()->write(json_encode($error));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function getById(Request $req, Response $res){
        $idClient   = $req->getAttribute('id');
        $sql        = "SELECT * FROM clientes WHERE idclient=?";
        try {
            $db         = new Db();
            $conn       = $db->connect();
            $stmt       = $conn->prepare($sql);
            $stmt->execute([$idClient]);
            $db         = null;

            $body = [
                "code"      => 200,
                "status"    => "success",
                "total"     => $stmt->rowCount(),
                "results"   => $stmt->fetch(PDO::FETCH_OBJ)
            ];

            $res->getBody()->write(json_encode($body));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(200);
        } catch (PDOException $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];
            $res->getBody()->write(json_encode($error));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function addNew(Request $req, Response $res){
        extract($req->getParsedBody());
        $sql = "INSERT INTO clientes (firstname, lastname, email, status) VALUES (:firstname, :lastname, :email, :status)";
        try{
            $db         = new Db();
            $conn       = $db->connect();
            $stmt       = $conn->prepare($sql);
            
            if(filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)) {
                $code   = 200;
                $bodyStatus = "success";
                $stmt->bindParam(':firstname'   , $firstname);
                $stmt->bindParam(':lastname'    , $lastname);
                $stmt->bindParam(':email'       , $email);
                $stmt->bindParam(':status'      , $status);
                $stmt->execute();
                $message = "Cliente agregado correctamente";
            }else {
                $code   = 400;
                $bodyStatus = "error";
                $message = "E-mail no válido";
            }
            $db         = null;

            $body = [
                "code"      => $code,
                "status"    => $bodyStatus,
                "message"   => $message
            ];

            $res->getBody()->write(json_encode($body));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus($code);
        }catch(PDOException $e){
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];
            $res->getBody()->write(json_encode($error));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function update(Request $req, Response $res){
        $idclient = $req->getAttribute('id');
        extract($req->getParsedBody());
        try {
            //----------------------------------
            // BUSCAMOS SI EXISTE EL ID
            //----------------------------------
            $queryUpdate    = "UPDATE clientes SET firstname = :firstname, lastname = :lastname, email = :email, status = :status WHERE idclient = '$idclient'";
            $queryFindById  = "SELECT * FROM clientes WHERE idclient = '$idclient'";
            $db             = new Db();
            $conn           = $db->connect();
            $findRow        = $conn->prepare($queryFindById);
            $findRow->execute();
            //------------------------------------
            // VERIFICAMOS QUE EXISTA EL ROW
            //------------------------------------
            if($findRow->rowCount() > 0){
                $updateRow = $conn->prepare($queryUpdate);
                //------------------------------------
                // VALIDAR CORREO
                //------------------------------------
                (isset($firstname)) ? $updateRow->bindParam(':firstname' , $firstname) : $updateRow->bindParam(':firstname' , $findRow->fetch(PDO::FETCH_OBJ)->firstname);
                (isset($lastname)) ? $updateRow->bindParam(':lastname' , $lastname) : $updateRow->bindParam(':lastname' , $findRow->fetch(PDO::FETCH_OBJ)->firstname);
                (isset($email)) ? $updateRow->bindParam(':email' , $email) : $updateRow->bindParam(':email' , $findRow->fetch(PDO::FETCH_OBJ)->email);
                (isset($status)) ? $updateRow->bindParam(':status' , $status) : $updateRow->bindParam(':status' , $findRow->fetch(PDO::FETCH_OBJ)->status);
                $updateRow->execute();
            }else{
                $code           = 200;
                $bodyStatus     = "error";
                $message        = "El cliente con ID ${idclient} no existe";
            }

            $db         = null;

            $body = [
                "code"      => $code,
                "status"    => $bodyStatus,
                "message"   => $message
            ];

            $res->getBody()->write(json_encode($body));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus($code);
        } catch (PDOException $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];
            $res->getBody()->write(json_encode($error));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
    public function delete(Request $req, Response $res, array $arg){
        $idclient = $req->getAttribute('id');
        $sql = "DELETE FROM clientes WHERE idclient = $idclient";

        try {
            $db         = new Db();
            $conn       = $db->connect();
            $stmt       = $conn->prepare($sql);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                //Row existe
                $code           = 200;
                $bodyStatus     = "success";
                $message        = "Datos eliminados";
            }else{
                $code           = 200;
                $bodyStatus     = "error";
                $message        = "El cliente con ID ${idclient} no existe";
            }

            $body = [
                "code"      => $code,
                "status"    => $bodyStatus,
                "message"   => $message
            ];

            $res->getBody()->write(json_encode($body));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus($code);
        } catch (PDOException $e) {
            $error = [
                "status" => "error",
                "message" => $e->getMessage()
            ];
            $res->getBody()->write(json_encode($error));
            return $res
                ->withHeader('content-type', 'application/json')
                ->withStatus(500);
        }
    }
}
?>