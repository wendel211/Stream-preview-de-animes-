<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    mensagemErro::show("Sem ID declarada na URL");
}
$idEntidade = $_GET["id"];
$entidade = new Entidade($con, $idEntidade);

$provedorPreview = new criarPrevia($con, $usuarioLogado);
echo $provedorPreview->criadorPreview($entidade);

$provedorTemporadas = new criarTemp($con, $usuarioLogado);
echo $provedorTemporadas->criar($entidade);

$categorias = new categorias($con, $usuarioLogado);
echo $categorias->mostrarCategorias($entidade->getIdCategoria(), "Talvez você goste desses: ");
?>