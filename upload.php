<?php
require_once("includes/header.php");


  $provedorPreview = new criarPrevia($con, $usuarioLogado);
  echo $provedorPreview->criadorPreview(null);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Arquivos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="paginaSobre">
        <h2>Formulário de Upload</h2>
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="file">Selecione um arquivo:</label>
                <input type="file" id="file" name="file" accept=".pdf, .doc, .docx">
            </p>
            <p>
                <button type="button" onclick="uploadFile()">Enviar</button>
            </p>
        </form>
        </div>
    </div>

    <script src="assets/js/upload.js"></script>
    <?php require_once("includes/footer.php");?>
</body>
</html>


