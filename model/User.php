<?php

include "database.php";

class User extends database {

    function register($name, $email, $password){
        $sql = "INSERT INTO users(name, email, password) value(?, ?, ?)";
        $this->setQuery($sql);
        $result = $this->execute(array($name, $email, md5($password)));
        if($result){
            return $this->getLastId();
        }else{
            return false;
        }
    }

    function login($email, $password){
        $sql = "SELECT * FROM users where email = '$email' and password = '$password'";
        $this->setQuery($sql);
        return $this->loadRow(array($email, $password));
    }
}
?>