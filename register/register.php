<?php
session_start();
if (isset($_POST['reg'])) {
    $nome = 
}else{
    $_SESSION['msg'] = "Invalid Method!";
    header('location: http://localhost:3000/register');
    exit();
}