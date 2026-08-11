<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method Not Allowed");
}

$name = htmlspecialchars(
    trim($_POST["name"] ?? ''),
    ENT_QUOTES,
    'UTF-8'
);

$email = filter_var(
    trim($_POST["email"] ?? ''),
    FILTER_VALIDATE_EMAIL
);

$phone = htmlspecialchars(
    trim($_POST["phone"] ?? ''),
    ENT_QUOTES,
    'UTF-8'
);

$company = htmlspecialchars(
    trim($_POST["company"] ?? ''),
    ENT_QUOTES,
    'UTF-8'
);

$dates = htmlspecialchars(
    trim($_POST["dates"] ?? ''),
    ENT_QUOTES,
    'UTF-8'
);

$message = htmlspecialchars(
    trim($_POST["message"] ?? ''),
    ENT_QUOTES,
    'UTF-8'
);

if (!$email) {
    http_response_code(400);
    exit("Invalid email");
}

$to = "waltadeu@gmail.com";
$subject = "ZeTrip 🇨🇳 | Inquire Form";

$body = "
<html>
<head>
    <meta charset='UTF-8'>
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

</body>
</html>
";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: ZeTrip <hello@zetripchina.com>\r\n";
$headers .= "Reply-To: {$email}\r\n";

if (mail($to, $subject, $body, $headers)) {

    echo "
    <script>
        alert('Message sent successfully!');
        window.location.href = '/index.html';
    </script>
    ";

} else {

    http_response_code(500);

    echo "
    <script>
        alert('Error sending message!');
        history.back();
    </script>
    ";
}

exit;
