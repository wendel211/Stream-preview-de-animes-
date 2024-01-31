<?php
require_once("includes/config.php");
require_once("includes/classes/formatadorForm.php");
require_once("includes/classes/constantes.php");
require_once("includes/classes/conta.php");

// Objeto da classe Conta
$conta = new Conta($con);

// Verificar se o formulário de exclusão foi enviado
if (isset($_POST['excluirEntidade'])) {
    $idParaExcluir = $_POST['idParaExcluir'];
    $conta->excluirEntidade($idParaExcluir);
    header("Location: admin.php"); // Redirecionar para atualizar a lista após a exclusão
    exit();
}

// Verificar se o formulário de edição foi enviado
if (isset($_POST['editarEntidade'])) {
    $idParaEditar = $_POST['idParaEditar'];
    $novoNome = $_POST['novoNome'];
    $novaThumbnail = $_POST['novaThumbnail'];
    $novaPreview = $_POST['novaPreview'];
    $novaCategoriaId = $_POST['novaCategoriaId'];

    $conta->editarEntidade($idParaEditar, $novoNome, $novaThumbnail, $novaPreview, $novaCategoriaId);
    header("Location: admin.php"); // Redirecionar para atualizar a lista após a edição
    exit();
}

// Verificar se o formulário de adição foi enviado
if (isset($_POST['adicionarEntidade'])) {
    $nome = $_POST['nome'];
    $thumbnail = $_POST['thumbnail'];
    $preview = $_POST['preview'];
    $categoriaId = $_POST['categoriaId'];

    $conta->adicionarEntidade($nome, $thumbnail, $preview, $categoriaId);
    header("Location: admin.php"); // Redirecionar para atualizar a lista após a adição
    exit();
}

// Obter a lista de entidades do banco de dados
$entidades = $conta->listarEntidades();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Entidades - IFBAFLIX</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
</head>

<body>
    <div class="cadastro">
        <div class="colunas-admin">
            <div class="header">
                <h1>Administrar Entidades</h1>
            </div>

            <div class="lista-entidades">
                <?php foreach ($entidades as $entidade) : ?>
                    <div class="entidade-item">
                        <strong>ID:</strong> <?php echo $entidade['id']; ?><br>
                        <strong>Nome:</strong> <?php echo $entidade['name']; ?><br>
                        <strong>Thumbnail:</strong> <?php echo $entidade['thumbnail']; ?><br>
                        <strong>Preview:</strong> <?php echo $entidade['preview']; ?><br>
                        <strong>Categoria ID:</strong> <?php echo $entidade['categoryId']; ?><br>
                        <br>

                        <!-- Formulário de Exclusão -->
                        <form method="POST" class="acao-form">
                            <input type="hidden" name="idParaExcluir" value="<?php echo $entidade['id']; ?>">
                            <input type="submit" name="excluirEntidade" value="Excluir" class="acao-botao">
                        </form>

                        <!-- Formulário de Edição -->
                        <form method="POST" class="acao-form">
                            <input type="hidden" name="idParaEditar" value="<?php echo $entidade['id']; ?>">
                            <label for="novoNome">Novo Nome:</label>
                            <input type="text" name="novoNome" required>
                            <label for="novaThumbnail">Nova Thumbnail:</label>
                            <input type="text" name="novaThumbnail" required>
                            <label for="novaPreview">Nova Preview:</label>
                            <input type="text" name="novaPreview" required>
                            <label for="novaCategoriaId">Nova Categoria ID:</label>
                            <input type="text" name="novaCategoriaId" required>
                            <input type="submit" name="editarEntidade" value="Editar" class="acao-botao">
                            <br> <br> 
                            <hr>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Formulário de Adição -->
            <form method="POST" class="acao-form">
                <br> <br> 
                <strong for="">Adicione uma entidade:</strong>
                <br> <br> 
                <label for="nome">Nome:</label>
                <input type="text" name="nome" required>
                <label for="thumbnail">Thumbnail:</label>
                <input type="text" name="thumbnail" required>
                <label for="preview">Preview:</label>
                <input type="text" name="preview" required>
                <label for="categoriaId">Categoria ID:</label>
                <input type="text" name="categoriaId" required>
                <input type="submit" name="adicionarEntidade" value="Adicionar" class="acao-botao">
            </form>

            <a href="admin.php" class="mensagemCadastro">Voltar</a>
        </div>
    </div>
</body>

</html>
