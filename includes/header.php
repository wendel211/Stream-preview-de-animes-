<?php
require_once("includes/config.php");
require_once("includes/classes/criarPrevia.php");
require_once("includes/classes/categorias.php");
require_once("includes/classes/entidade.php");
require_once("includes/classes/gerarEnt.php");
require_once("includes/classes/mensagemErro.php");
require_once("includes/classes/criarTemp.php");
require_once("includes/classes/temporada.php");
require_once("includes/classes/gerarVideo.php");
require_once("includes/classes/video.php");
require_once("includes/classes/usuario.php");

if(!isset($_SESSION["usuarioLogado"])){
	header("Location: registro.php");
}

$usuarioLogado = $_SESSION["usuarioLogado"];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Esse é o IFBAFLIX</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css"/>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/9e77834378.js" crossorigin="anonymous"></script>
        <script src="assets/js/script.js"></script>

    </head>
    	<div class="wrapper">
    		
<?php
    if(!isset($escondeBarraNaveg)){
        include_once("includes/Navegar.php");
    }   
?>
