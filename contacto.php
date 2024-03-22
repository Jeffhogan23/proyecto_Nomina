<?php
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$nombre = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$correo = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$asunto = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
$mensaje = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

$mail = new PHPMailer\PHPMailer\PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ortegonplazas15@gmail.com';
    $mail->Password = 'ipasdpfczdsbutyp';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('ortegonplazas15@gmail.com', 'Contax Employee');
    $mail->addAddress('ortegonplazas15@gmail.com', 'Contax Employee');
    

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'Mensaje para Contax Employee';
    $mail->Body = '
    <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f8f9fa;
                    border: 1px solid #dee2e6;
                    border-radius: 5px;
                }
                .header {
                    background-color: #007bff;
                    color: #fff;
                    padding: 20px;
                    text-align: center;
                }
                .content {
                    padding: 20px;
                }
                .footer {
                    background-color: #007bff;
                    color: #fff;
                    padding: 20px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Mensaje para Contax Employee</h1>
                </div>
                <div class="content">
                    <p>Nombre: ' . $nombre . '</p>
                    <p>Correo: ' . $correo . '</p>
                    <p>Asunto: ' . $asunto . '</p>
                    <p>Mensaje: ' . $mensaje . '</p>
                </div>
                <div class="footer">
                    <p>Copyright &copy; Contax Employee, All Right Reserved.</p>
                </div>
            </div>
        </body>
    </html>';

    $mail->send();
    echo "<script>alert('Enviado con éxito, espera a ser contactado'); document.location.href = 'index.html';</script>";
} catch (Exception $e) {
    echo "Lo sentimos surgio un problema, vuelve a intentarlo: {$mail->ErrorInfo}";
}
?>