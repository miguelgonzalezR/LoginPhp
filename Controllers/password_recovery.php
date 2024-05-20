<?php
require_once '../Models/User.php';
$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    if ($usuario->existsEmail($email)) {
        $token = bin2hex(random_bytes(16)); // Genera un token seguro
        $usuario->storeToken($email, $token); // Almacena el token en la base de datos
        
        $resetLink = "http://localhost/LoginPhp/Views/reset_password.php?token=" . $token;

        // Preparar el correo electrónico
        $to = $email;
        $subject = "Recuperar Contraseña";
        $message = "Por favor, haz clic en el siguiente enlace para recuperar tu contraseña: " . $resetLink;
        $headers = "From: noreply@tuempresa.com\r\n";
        $headers .= "Reply-To: noreply@tuempresa.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        

        // Enviar el correo
        if (mail($to, $subject, $message, $headers)) {
            echo "Te hemos enviado un enlace de recuperación a tu correo electrónico.";
        } else {
            echo "Error al enviar el correo.";
        }
    } else {
        echo "Este correo electrónico no está registrado.";
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
}
?>
