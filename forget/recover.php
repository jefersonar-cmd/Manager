<?php
session_start();
require '../conn.php';
global $conn;
if(isset($_POST['rec'])){
    $login = $_POST['login'];
    $rec = $_POST['recover'];
    $npass = hash('sha256', $_POST['pass']);
    $nrpass = hash('sha256',$_POST['repass']);
    if ($login != '' and $rec != '' and $npass != '' and $nrpass != ''){
        $loginq = $conn->query("SELECT id, tentativas FROM usuarios WHERE login = '$login'");
        $dadosU = $loginq->fetchObject();
        if($dadosU){
            $id = $dadosU->id;
            $tentativas = $dadosU->tentativas;
            $req = $conn->query("SELECT hash FROM unicHash WHERE user = $id");
            $res = $req->fetchObject();
            $hash = $res->hash;
            if($hash == $rec){
                if ($npass == $nrpass){
                    $upload = $conn->query("UPDATE usuarios SET senha = '$npass', tentativas = 0 WHERE id = $id");
                    if($upload->rowCount() > 0){
                        $alert = "Troca de senha efetivada.";
                        $data = date("d/m/y H:i:sa");
                        $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, '$alert', '$data')");
                        if ($log) {
                            $usr = $conn->query("UPDATE usuarios SET access = 1, tentativas = 0 WHERE id = $id");
                            if ($usr) {
                                $_SESSION['login'] = $login;
                                $_SESSION['msg'] = "Senha alterada com sucesso!";
                                header('location: http://localhost:3000');
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
                    }
                } else {
                    if($tentativas == 3){
                        $alert = "Excesso de tentativas de recuperação.";
                        $data = date("d/m/y H:i:sa");
                        $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, '$alert', '$data')");
                        if($log) {
                            $usr = $conn->query("UPDATE usuarios SET access = 0, tentativas = 0 WHERE id = $id");
                            if ($usr){
                                unset($_SESSION['login']);
                                $_SESSION['msg'] = "Altas tentativas de recuperação!\nPor favor, entre em contato com o SUPORTE.";
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

                    }else{
                        $alert = "Tentou reset de senha.";
                        $data = date("d/m/y H:i:sa");
                        $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, '$alert', '$data')");
                        if ($log) {
                            $tentativas += 1;
                            $usr = $conn->query("UPDATE usuarios SET tentativas = $tentativas WHERE id = $id");
                            if ($usr) {
                                $_SESSION['login'] = $login;
                                $_SESSION['msg'] = "Senhas não correspondem!";
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
                    }
                }
            }else{
                if($tentativas == 3){
                    $alert = "Excesso de tentativas de recuperação.";
                    $data = date("d/m/y H:i:sa");
                    $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, '$alert', '$data')");
                    if ($log) {
                        unset($_SESSION['login']);
                        $usr = $conn->query("UPDATE usuarios SET access = 0, tentativas = 0 WHERE id = $id");
                        if ($usr) {
                            $_SESSION['msg'] = "Altas tentativas de recuperação!\nPor favor, entre em contato com o SUPORTE.";
                            header('location: http://localhost:3000');
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
                }else {
                    $alert = "Informou código de recuperação incorreto.";
                    $data = date("d/m/y H:i:sa");
                    $log = $conn->query("INSERT INTO log (user, action, data_action) VALUES ($id, '$alert', '$data')");
                    if ($log) {
                        $tentativas += 1;
                        $usr = $conn->query("UPDATE usuarios SET tentativas = $tentativas WHERE id = $id");
                        if ($usr) {
                            $_SESSION['login'] = $login;
                            $_SESSION['msg'] = "Hash de Recuperação Incorreto!";
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
                }
            }
        }else{
            $_SESSION['login'] = $login;
            $_SESSION['msg'] = "Usuário inexistente!";
            header('location: http://localhost:3000/register');
            exit();
        }
    }else{
        $_SESSION['msg'] = "Algum campo ficou vazio";
        header('location: http://localhost:3000/forget');
        exit();
    }
}else{
    $_SESSION['msg'] = "Invalid Method!";
    header('location: http://localhost:3000/forget');
    exit();
}