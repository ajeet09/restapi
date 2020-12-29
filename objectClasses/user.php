<?php

class User {

    // object properties
    private $id;
    private $name;
    private $email;
    private $password;

    public function setId(int $id) 
    {
        $this->id = htmlspecialchars(strip_tags($id));
    }

    public function getId(){
        return $this->id;
    }

    public function setName(string $name) 
    {
        $this->name = htmlspecialchars(strip_tags($name));
    }

    public function getName(){
        return $this->name;
    }

    public function setEmail(string $email) 
    {
        $this->email = htmlspecialchars(strip_tags($email));
    }

    public function getEmail(){
        return $this->email;
    }

    public function setPassword(string $password) 
    {
        $this->password = htmlspecialchars(strip_tags($password));
    }

    public function getPassword(){
        return $this->password;
    }
     
}


?>