<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\31.1/src/Exception.php';
require 'C:\xampp\htdocs\31.1/src/PHPMailer.php';
require 'C:\xampp\htdocs\31.1/src/SMTP.php';

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $recipient_email = $_POST["recipient_email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    if ($recipient_email !== 'suporte@ifbaflix.com') {
        $response['message'] = "Destinatário inválido.";
        echo json_encode($response);
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.outlook.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'wendel044@outlook.com';
        $mail->Password = 'php.javascript';

        $mail->setFrom('wendel044@outlook.com', 'Nome do Remetente');
        $mail->addAddress($recipient_email, 'Nome do Destinatário');

        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = "De: $name\n\n$message";

        $mail->send();
        $response['success'] = true;
        $response['message'] = 'Mensagem enviada com sucesso!';
    } catch (Exception $e) {
        $response['message'] = "Erro ao enviar mensagem: {$mail->ErrorInfo}";
    }
} else {
    $response['message'] = "Acesso direto a este script não é permitido.";
}

echo json_encode($response);
?>
