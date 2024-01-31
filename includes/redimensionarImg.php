<?php

function redimensionarImagem($caminho, $larguraDesejada) {
    list($larguraOriginal, $alturaOriginal) = getimagesize($caminho);

    // Calcula a nova altura mantendo a proporção
    $novaAltura = ($larguraDesejada / $larguraOriginal) * $alturaOriginal;

    $novaImagem = imagecreatetruecolor($larguraDesejada, $novaAltura);

    
    $extensao = strtolower(pathinfo($caminho, PATHINFO_EXTENSION));

    switch ($extensao) {
        case 'jpeg':
        case 'jpg':
            $imagemOriginal = imagecreatefromjpeg($caminho);
            break;
        case 'png':
            $imagemOriginal = imagecreatefrompng($caminho);
            break;
        case 'gif':
            $imagemOriginal = imagecreatefromgif($caminho);
            break;
        default:
            // Adicione suporte para outras extensões, se necessário
            return;
    }

 
    imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, $larguraDesejada, $novaAltura, $larguraOriginal, $alturaOriginal);


    imagejpeg($novaImagem, $caminho);

    imagedestroy($imagemOriginal);
    imagedestroy($novaImagem);
}
?>
