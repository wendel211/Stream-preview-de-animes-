<?php
require_once("includes/header.php");

$provedorPreview = new criarPrevia($con, $usuarioLogado);
echo $provedorPreview->criadorPreviewSobre();

$containers = new categorias($con, $usuarioLogado);
echo $containers->mostrarPaginaSobre();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Contato</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="container">
        <div class="paginaSobre">
        <h2>Formulário de Contato</h2>
        <form id="contactForm" action="enviaremail.php" method="post">
            <p>
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>
            </p>
            <p>
                <label for="recipient_email">E-mail Destinatário:</label>
                <input type="email" placeholder="suporte@ifbaflix.com" id="recipient_email" name="recipient_email" required>
            </p>
            <p>
                <label for="subject">Assunto:</label>
                <input type="text" id="subject" name="subject" required>
            </p>
            <p>
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" required></textarea>
            </p>
            <p>
                <button type="submit">Enviar</button>
            </p>
        </form>
        </div>
    </div>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Mensagem enviada com sucesso!');
                } else {
                    alert('Erro ao enviar mensagem: ' + data.message);
                }
            })
            .catch(error => {
                alert('Erro ao conectar ao servidor.');
            });
        });
    </script>
    <?php require_once("includes/footer.php");?>
</body>
</html>
