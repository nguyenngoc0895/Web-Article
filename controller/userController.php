<?php
session_start();
include "model/user.php";

class userController
{
    function register($name, $email, $password){
        $user = new User();
        $register = $user->register($name, $email, $password);

        if($register>0)
        {
            $_SESSION['success'] = "register success";
            header('location:index.php');

            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }

        }else{
            $_SESSION['error'] = "register fail";
            header('location:register.php');
        }
    }

    function login($email, $password){
        $user = new User();
        $userLogin = $user->login($email, $password);

        if($userLogin == true){
            $_SESSION['name'] = $userLogin->name;
            $_SESSION['id_user'] = $userLogin->id;
            header('location:index.php');

            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }

            if(isset($_SESSION['error_comment'])){
                unset($_SESSION['error_comment']);
            }

        }else{
            $_SESSION['error'] = "something wrong=)))";
            header('location:login.php');
        }
    }

    function logout(){
        session_destroy();
        header("location:index.php");
    }
}

?>