<?php
ob_start(); 
session_start();

date_default_timezone_set("America/Sao_Paulo");

try {
    $con = new PDO("mysql:dbname=ifbaflix;host=localhost", "root", "");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    exit("A Conexão falhou: " . $e->getMessage());
}
?>