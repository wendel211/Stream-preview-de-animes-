<?php
require_once("../includes/config.php");
require_once("../includes/classes/gerarRes.php");
require_once("../includes/classes/gerarEnt.php");
require_once("../includes/classes/Entidade.php");
require_once("../includes/classes/criarPrevia.php");

if(isset($_POST["termo"]) && isset($_POST["nomeUsuario"])){
	
	$provedorResultados = new gerarRes($con, $_POST["nomeUsuario"]);
	echo $provedorResultados->getResultados($_POST["termo"]);
}
else{
	echo "Nenhum termo ou nome de usuário passado para o arquivo.";
}
?>