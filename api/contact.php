<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email   = filter_var(trim($_POST["email"] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone   = htmlspecialchars(trim($_POST["phone"] ?? ''));
    $company = htmlspecialchars(trim($_POST["company"] ?? ''));
    $dates   = htmlspecialchars(trim($_POST["dates"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    $to      = "waltadeu@gmail.com"; //hello@zetripchina.com //zetrip.china@gmail.com
    $subject = "ZeTrip 🇨🇳 | Inquire Form";
    
    // Corpo em HTML
    $body = "
        <html>
        <head>
            <title>Formulário de Contato</title>
        </head>
        <body>
            <h2>📩 Form ZeTrip</h2>
            <hr>

            <h3>🧾 Information</h3>
            <p><strong>Nome:</strong> {$name}</p>
            <p><strong>E-mail:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Company:</strong> {$company}</p>
            <p><strong>Dates:</strong> {$dates}</p>
            <p><strong>Message:</strong> {$message}</p>
            <hr>

        </html>
    ";

    // Cabeçalhos para envio em HTML
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ZeTrip <hello@zetripchina.com>\r\n";//$headers .= "From: {$email}" . "\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "
    <script>
        alert('Message sent successfully!');
        window.location.href = 'index.html';
    </script>
    ";

} else {

    // Erro
    echo "
    <script>
        alert('Error sending message!');
        history.back();
    </script>
    ";
}
    exit;
}