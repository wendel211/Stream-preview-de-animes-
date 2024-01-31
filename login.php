<?php
require_once("includes/config.php");
require_once("includes/classes/formatadorForm.php");
require_once("includes/classes/constantes.php");
require_once("includes/classes/conta.php");

$conta = new Conta($con);

if (isset($_POST["botaoConfirmar"])) {
    $nomeUsuario = formatadorForm::formatarUsuario($_POST["nomeUsuario"]);
    $senha = formatadorForm::formatarSenha($_POST["senha"]);

    $sucesso = $conta->login($nomeUsuario, $senha);

    if ($sucesso["sucesso"]) {
        $_SESSION["usuarioLogado"] = $nomeUsuario;

        if ($conta->isAdmin($nomeUsuario, $senha)) {
            header("Location: admin.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    }
}

function salvaValor($nome)
{
    if (isset($_POST[$nome])) {
        echo $_POST[$nome];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bem vindo ao IFBAFLIX</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
</head>

<body>

    <div class="cadastro">
        <div class="colunas">
            <div class="header">
                <img src="assets/images/logo.png" title="Logo" alt="Logo do Site" />
                <h3>Entre</h3>
                <span>Faça login no IFBAFLIX</span>
            </div>
            <form method="POST">
                <?php echo $conta->getErro(constantes::$loginFalhou); ?>
                <input type="text" name="nomeUsuario" placeholder="Nome de usuário" value="<?php salvaValor("nomeUsuario"); ?>" required>
                <input type="password" name="senha" placeholder="******" required>
                <input type="submit" name="botaoConfirmar" value="Confirmar">
            </form>
            <a href="registro.php" class="mensagemEntrar">Caso não tenha conta: <a href="registro.php" class="mensagemEntrar" style="color: #dc1928;">Crie por aqui!</a></a>
        </div>
    </div>
</body>

</html>
