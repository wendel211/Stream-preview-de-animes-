<?php

require_once("includes/classes/conta.php");



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Admin</title>

    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    
<body>
    <header class="header">
        <h1>Página de Administração</h1>
    </header>

   
    <div class="cadastro">
        <div class="colunas-admin">
            <div class="header">
   <ul class="linkNaveg">
            <li><a href="adminUsuario.php">Editar Usuários</a></li>
            <li><a href="adminCategoria.php">Editar Categorias</a></li>
            <li><a href="adminEntidade.php">Editar Entidades</a></li>
     </ul>
    </div>
    <a class="admin" href="login.php" class="mensagemEntrar" style="color: #dc1928;  text-align: center"   >Clique aqui para voltar</a></a>
      </div>

</body>

</html>

