<?php
session_start();

// Conectar a la base de datos
require_once '../Connection/DB.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $lastname = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {
        // Crear conexión
        $db = new DB();
        $conn = $db->connect();

        // Comprobar si el nombre de usuario ya existe
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            echo "El nombre de usuario ya existe.";
        } else {
            // Hash de la contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario
            $stmt = $conn->prepare("INSERT INTO users (name, lastName, username, password, Attempts, Role, is_blocked) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([ $name, $lastname, $username, $passwordHash, 5, 2, 0]);
            header('Location: ../Views/Login.php');
        }
    } else {
        echo "Las contraseñas no coinciden.";
    }
}
?>