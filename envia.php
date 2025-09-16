<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // se instalou via composer
// require 'phpmailer/src/PHPMailer.php';
// require 'phpmailer/src/SMTP.php';
// require 'phpmailer/src/Exception.php'; // se baixou manualmente

// === CONFIGURAÇÕES DO SMTP ===
$smtpHost = 'smtp.gmail.com'; // servidor SMTP
$smtpUser = 'seuemail@gmail.com'; // seu e-mail
$smtpPass = 'SENHA_DO_APP'; // senha de app (não a senha normal do Gmail)
$smtpPort = 587; // porta TLS

// === CAPTURA OS DADOS DO FORMULÁRIO ===
$nome     = $_POST['nome'] ?? '';
$email    = $_POST['email'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';

$mail = new PHPMailer(true);

try {
    // Configurações do servidor
    $mail->isSMTP();
    $mail->Host       = $smtpHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtpUser;
    $mail->Password   = $smtpPass;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = $smtpPort;

    // Remetente e destinatário
    $mail->setFrom($smtpUser, 'Site RAM Engenharia');
    $mail->addAddress('juniorgarruth@gmail.com', 'RAM Engenharia'); // quem recebe

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = 'Novo contato do site RAM Engenharia';
    $mail->Body    = "
        <strong>Nome:</strong> {$nome}<br>
        <strong>Email:</strong> {$email}<br><br>
        <strong>Mensagem:</strong><br>" . nl2br($mensagem);
    $mail->AltBody = "Nome: $nome\nEmail: $email\n\nMensagem:\n$mensagem";

    $mail->send();
    header('Location: obrigado.html');
    exit;
} catch (Exception $e) {
    echo "Erro ao enviar: {$mail->ErrorInfo}";
}
