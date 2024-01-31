<?php
$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Verifica se o arquivo é uma imagem real ou um arquivo falso
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        echo json_encode(["success" => false, "message" => "O arquivo é uma imagem - " . $check["mime"] . "."]);
        $uploadOk = 0;
    } else {
        $uploadOk = 1;
    }
}

// Verifica se o arquivo já existe
if (file_exists($targetFile)) {
    echo json_encode(["success" => false, "message" => "Desculpe, o arquivo já existe."]);
    $uploadOk = 0;
}

// Verifica o tamanho do arquivo
if ($_FILES["file"]["size"] > 500000) {
    echo json_encode(["success" => false, "message" => "Desculpe, seu arquivo é muito grande."]);
    $uploadOk = 0;
}

// Permitir apenas certas extensões de arquivo
if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
    echo json_encode(["success" => false, "message" => "Desculpe, apenas arquivos PDF, DOC e DOCX são permitidos."]);
    $uploadOk = 0;
}

// Se houver erros, exiba uma mensagem
if ($uploadOk == 0) {

    //faça essa mensagem aparecer como um alerta na tela

    echo json_encode(["success" => false, "message" => "Desculpe, seu arquivo não foi enviado."]);
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo json_encode(["success" => true, "message" => "O arquivo ". htmlspecialchars( basename( $_FILES["file"]["name"])). " foi enviado."]);
    } else {
        echo json_encode(["success" => false, "message" => "Desculpe, ocorreu um erro ao enviar o arquivo."]);
    }
}


?>
