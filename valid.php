<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require 'conn.php';
global $conn;
if(isset($_POST['login'])){
    if ($_POST['username'] != '' || $_POST['password'] != '') {
        $login = $_POST['username'];
        $pass = hash('sha256',$_POST['password']);
        $exec = $conn->query("SELECT * FROM usuarios WHERE login='$login';");
        $dados = $exec->fetchObject();
        if($dados){
            $id = $dados->id;
            $dbPass = $dados->senha;
            $tentativa = $dados->tentativas;
            if ($dbPass == $pass) {
                unset($_SESSION['msg']);
                if($dados->access == 1){
                    $data = date("d/m/y H:i:sa");
                    $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, 'Realizou login.', '$data')");
                    if ($log) {

                    }else{
                        echo "erro ao inserir dados.<br />";
                        echo "Error: ".$conn->error;
                        die();
                    }
                }else{
                    $_SESSION['msg'] = "Seu usuário foi bloqueado.\nPor favor, entre em contato com o Suporte.";
                    $data = date("d/m/y H:i:sa");
                    $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, 'Usuário bloqueado.', '$data')");
                    if ($log) {
                        header('location: http://localhost:3000');
                        exit();
                    }else{
                        echo "erro ao inserir dados.<br />";
                        echo "Error: ".$conn->error;
                        die();
                    }
                }
            }else{
                $data = date("d/m/y H:i:sa");
                $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, 'Tentou realizar login.', '$data')");
                if($log){
                    if($tentativa == 3) {
                        $alert = "Excesso de tentativas de login.";
                        $data = date("d/m/y H:i:sa");
                        $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, '$alert', '$data')");
                        if($log){
                            $usr = $conn->query("UPDATE usuarios SET access = 0, tentativas = 0 WHERE id = $id");
                            if($usr) {
                                $_SESSION['login'] = $login;
                                $_SESSION['msg'] = "Realizaste várias tentativas!\nPor favor, realizar recuperação de senha.";
                                header('location: http://localhost:3000/forget');
                                exit();
                            }else{
                                echo "erro ao inserir dados.<br />";
                                echo "Error: ".$conn->error;
                                die();
                            }
                        }else{
                            echo "erro ao inserir dados.<br />";
                            echo "Error: ".$conn->error;
                            die();
                        }
                    } else {
                        $tentativa += 1;
                        $up = "UPDATE usuarios SET tentativas = $tentativa WHERE id = $id;";
                        $upR = $conn->query($up);
                        if($upR) {
                            $_SESSION['login'] = $login;
                            $_SESSION['msg'] = "Usuário ou Senha incorreto!";
                            header('location: http://localhost:3000');
                            exit();
                        }else{
                            echo "erro ao inserir dados.<br />";
                            echo "Error: ".$conn->error;
                            die();
                        }
                    }
                }else{
                    $_SESSION['msg'] = "Erro ao inserir log!";
                    header('location: http://localhost:3000');
                    exit();
                }
            }
        }else{
            $_SESSION['login'] = $login;
            $_SESSION['msg'] = "Usuário não encontrado!";
            header('location: http://localhost:3000/register');
            exit();
        }
    } else {
        $_SESSION['msg'] = "Algum campo está vazio!";
        header('location: http://localhost:3000');
        exit();
    }
}else{
    $_SESSION['msg'] = "Invalid Method!";
    header('location: http://localhost:3000');
    exit();
}