<?php 

include_once ('../objectClasses/user.php');
include_once '../database/connection.php';
include_once '../config/staticStatus.php';

class UserActivities 
{

    private $conn;
    private $status;

    public function __construct() {
        $database = new Connection();
        $conn = $database->getConnection();
        $this->conn = $conn;
        $statusCode = new staticStatus();
        $status = $statusCode->getStatus();
    }

    public function authenticate(User $user) : array
    {

        try {
            $query = 'SELECT * FROM  users WHERE email = ? AND password = ? ';
            $statement = $this->conn->prepare($query);
            $email = $user->getEmail();
            $pass = $user->getPassword();
            $statement->bindParam(1, $email);
            $statement->bindParam(2, $pass, PDO::PARAM_STR);
            $statement->execute();
          
            if($statement->rowCount() > 0) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $status['SUCCESS'];
            } else {
                return $status['NOT_FOUND'];
            }
           
        } catch (Exception $e) {
            return $status['BAD'];
        }

    }

}