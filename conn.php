<?php
$host = '192.168.15.200';
$dbname = 'test';
$username = 'root';
$password = 'gcplayers';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    global $conn;
    //echo "Conexão estabelecida com sucesso!";
} catch (PDOException $e) {
    echo "Falha na conexão: " . $e->getMessage();
}
?>
