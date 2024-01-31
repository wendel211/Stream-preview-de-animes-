<?php
require_once("includes/header.php");

$provedorPreview = new criarPrevia($con, $usuarioLogado);
echo $provedorPreview->criadorPreview(null);

$containers = new categorias($con, $usuarioLogado);
echo $containers->mostrarCategorias();

require_once("includes/footer.php");
?>