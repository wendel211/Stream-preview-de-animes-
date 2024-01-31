<?php
require_once("includes/config.php");
require_once("includes/classes/formatadorForm.php");
require_once("includes/classes/constantes.php");
require_once("includes/classes/conta.php");

  $conta = new Conta($con);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o formulário de edição foi enviado
    if (isset($_POST['editarCategoria'])) {
        $idParaEditar = $_POST['idParaEditar'];
        $novoNomeCategoria = $_POST['novoNomeCategoria'];

        $conta->editarCategoria($idParaEditar, $novoNomeCategoria);
        header("Location: admin.php");
        exit();
    }
}

// Obter a lista de categorias do banco de dados
$categorias = $conta->listarCategorias();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias - IFBAFLIX</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
</head>

<body>
    <div class="cadastro">
        <div class="colunas-admin">
            <div class="header">
                <h1>Lista de Categorias</h1>
            </div>

            <div class="lista-categorias">
                <?php foreach ($categorias as $categoria) : ?>
                    <div class="categoria-item">
                        <strong>ID:</strong> <?php echo $categoria['id']; ?><br>
                        <strong>Nome:</strong> <?php echo $categoria['name']; ?><br>

                        <!-- Formulário de Edição -->
                        <form method="POST" class="acao-form">
                            <input type="hidden" name="idParaEditar" value="<?php echo $categoria['id']; ?>">
                            <label for="novoNomeCategoria">Novo Nome da Categoria:</label>
                            <input type="text" name="novoNomeCategoria" value="<?php echo $categoria['name']; ?>" required>
                            <input type="submit" name="editarCategoria" value="Editar" class="acao-botao">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="admin.php" class="mensagemCadastro">Voltar</a>
        </div>
    </div>
</body>

</html>
