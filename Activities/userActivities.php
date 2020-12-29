<?php 

require __DIR__ . './../vendor/autoload.php';
include_once ('../objectClasses/user.php');
include_once '../database/connection.php';
include_once '../config/staticStatus.php';

use \Firebase\JWT\JWT;

class UserActivities 
{

    private $conn;
    private $status;
    private $payload;
    private $key;

    public function __construct() {
        $database = new Connection();
        $conn = $database->getConnection();
        $this->conn = $conn;
        $statusCode = new staticStatus();
        $this->status = $statusCode->getStatus();

        $time = time() + 3600;
        $this->payload = array(
            "iat" => time(),
            "exp" => $time,
        );
        $this->key = "78945oiuttgh@TFREDVGGG";
    }

    public function authenticate(User $user) : array
    {
        try {
            $query = 'SELECT * FROM  users WHERE email = ? AND password = ? ';
            $statement = $this->conn->prepare($query);
            $email = $user->getEmail();
            $pass = $user->getPassword();
            $statement->bindParam(1, $email, PDO::PARAM_STR);
            $statement->bindParam(2, $pass, PDO::PARAM_STR);
            $statement->execute();
            if($statement->rowCount() > 0) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $this->payload['data'] = $result;
                $jwt = JWT::encode($this->payload, $this->key);
                $data = ['key' => $jwt, "status" => $this->status['SUCCESS']];
                return $data;
            } else {
                return ["status" => $this->status['NOT_FOUND']];
            }
        } catch (Exception $e) {
            return ["status" => $this->status['BAD']];
        }
    }

}