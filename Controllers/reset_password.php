<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token']) && isset($_POST['password'])) {
    require_once '../Models/User.php';
    $usuario = new Usuario();
    
    if ($usuario->isValidToken($_POST['token'])) {
        $newPassword = $_POST['password'];
        $usuario->updatePassword($_POST['token'], $newPassword);
        echo "Tu contraseña ha sido actualizada.";
    } else {
        echo "El enlace para restablecer la contraseña no es válido o ha expirado.";
    }
}
?>