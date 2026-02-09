<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

// Dados do formulário
$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$curso = trim($_POST['curso'] ?? '');

if ($nome === '' || $telefone === '' || $curso === '') {
    echo 'ERRO';
    exit;
}

$mail = new PHPMailer(true);

try {
    // 🔥 CONFIGURAÇÃO MAILTRAP
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '097442cac2b594'; // seu username
    $mail->Password = '75779819fe21a1'; // coloque a senha completa
    $mail->Port = 2525;
    $mail->CharSet = 'UTF-8';

    // Remetente
    $mail->setFrom('no-reply@unifatecie.com', 'Site UniFatecie');

    // Destinatário (quem recebe)
    $mail->addAddress('teste@unifatecie.com');

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = 'Novo interesse - UniFatecie';

    $mail->Body = '
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
    <meta charset="UTF-8">
    <title>Novo Interesse</title>
    </head>
    <body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:30px 0;">
        <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

            <!-- HEADER -->
            <tr>
                <td style="background:#f8f8f8; padding:20px; text-align:center;">
                <img src="https://unifatecie.com/wp-content/uploads/2022/12/logo-fatecie-ofc.png"
                    alt="UniFatecie"
                    style="max-width:180px;">
                </td>
            </tr>

            <!-- CONTEÚDO -->
            <tr>
                <td style="padding:30px; color:#333;">
                <h2 style="margin-top:0; color:#ff9a2e;">
                    Novo interesse recebido
                </h2>

                <p style="font-size:15px;">
                    Um novo potencial aluno demonstrou interesse em um curso.
                </p>

                <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse; margin-top:20px;">
                    <tr style="background:#f8f8f8;">
                    <td width="30%"><strong>Nome:</strong></td>
                    <td>' . $nome . '</td>
                    </tr>
                    <tr>
                    <td><strong>WhatsApp:</strong></td>
                    <td>' . $telefone . '</td>
                    </tr>
                    <tr style="background:#f8f8f8;">
                    <td><strong>Curso:</strong></td>
                    <td>' . $curso . '</td>
                    </tr>
                </table>

                <p style="margin-top:30px; font-size:14px; color:#666;">
                    Este contato foi enviado através do formulário do site UniFatecie.
                </p>
                </td>
            </tr>

            <!-- FOOTER -->
            <tr>
                <td style="background:#eeeeee; padding:15px; text-align:center; font-size:12px; color:#777;">
                © ' . date('Y') . ' UniFatecie • Centro Universitário
                </td>
            </tr>

            </table>

        </td>
        </tr>
    </table>

    </body>
    </html>
    ';


    $mail->send();
    echo 'OK';

} catch (Exception $e) {
    echo 'ERRO';
}
