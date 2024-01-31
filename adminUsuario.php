<?php
require_once("includes/config.php");
require_once("includes/classes/formatadorForm.php");
require_once("includes/classes/constantes.php");
require_once("includes/classes/conta.php");

$conta = new Conta($con);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o formulário de exclusão foi enviado
    if (isset($_POST['excluirUsuario'])) {
        $idParaExcluir = $_POST['idParaExcluir'];
        $conta->excluirUsuario($idParaExcluir);
        header("Location: admin.php");
        exit();
    }

    // Verificar se o formulário de edição foi enviado
    if (isset($_POST['editarUsuario'])) {
        $idParaEditar = $_POST['idParaEditar'];
        $novoNome = formatadorForm::formatarUsuario($_POST['novoNome']);
        $novoSobrenome = formatadorForm::formatarUsuario($_POST['novoSobrenome']);
        $novoEmail = formatadorForm::formatarEmail($_POST['novoEmail']);

        $conta->editarUsuario($idParaEditar, $novoNome, $novoSobrenome, $novoEmail);
        header("Location: admin.php");
        exit();
    }
}

// Obter a lista de usuários do banco de dados
$usuarios = $conta->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários - IFBAFLIX</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
</head>

<body>
    <div class="cadastro">
        <div class="colunas-admin">
            <div class="header">
                <h1>Lista de Usuários</h1>
            </div>

            <div class="lista-usuarios">
                <?php foreach ($usuarios as $usuario) : ?>
                    <div class="usuario-item">
                        <strong>ID:</strong> <?php echo $usuario['id']; ?><br>
                        <strong>Nome:</strong> <?php echo $usuario['nome'] . ' ' . $usuario['sobrenome']; ?><br>
                        <strong>Nome de Usuário:</strong> <?php echo $usuario['nomeUsuario']; ?><br>
                        <strong>Email:</strong> <?php echo $usuario['email']; ?><br>
                        <strong>Data de Cadastro:</strong> <?php echo $usuario['dataCadastro']; ?><br>
                        <strong>Admin:</strong> <?php echo ($usuario['admin'] == 1 ? 'Sim' : 'Não'); ?><br>

                        <!-- Formulário de Exclusão -->
                        <form method="POST" class="acao-form">
                            <input type="hidden" name="idParaExcluir" value="<?php echo $usuario['id']; ?>">
                            <input type="submit" name="excluirUsuario" value="Excluir" class="acao-botao">
                        </form>

                        <!-- Formulário de Edição -->
                        <form method="POST" class="acao-form">
                            <input type="hidden" name="idParaEditar" value="<?php echo $usuario['id']; ?>">
                            <label for="novoNome">Novo Nome:</label>
                            <input type="text" name="novoNome" value="<?php echo $usuario['nome']; ?>" required>
                            <label for="novoSobrenome">Novo Sobrenome:</label>
                            <input type="text" name="novoSobrenome" value="<?php echo $usuario['sobrenome']; ?>" required>
                            <label for="novoEmail">Novo Email:</label>
                            <input type="email" name="novoEmail" value="<?php echo $usuario['email']; ?>" required>
                            <input type="submit" name="editarUsuario" value="Editar" class="acao-botao">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="admin.php" class="mensagemCadastro">Voltar</a>
        </div>
    </div>
</body>

</html>