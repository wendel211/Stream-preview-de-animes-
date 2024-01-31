<?php
require_once("includes/header.php");

if(!isset($_GET["id"])){
	mensagemErro::show("ID não foi passada para a URL");
}

$provedorPreview = new criarPrevia($con, $usuarioLogado);
echo $provedorPreview->criadorCategoriaPreview($_GET["id"]);

$containers = new categorias($con, $usuarioLogado);
echo $containers->mostrarCategorias($_GET["id"]);
?>