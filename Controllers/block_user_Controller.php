<?php

require_once '../Models/User.php';  // Ajusta la ruta según la estructura de tu proyecto
$usuario = new Usuario();

// Asegurarte de que el script sólo responda a solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['userId'])) {
        $userId = $_POST['userId'];  // Asumiendo que 'userId' es un entero
        if ($_POST['action'] == 'block') {
            $result = $usuario->blockUser($userId);
        } elseif ($_POST['action'] == 'unblock') {
            $result = $usuario->unblockUser($userId);
        } else {
            // Manejar cualquier otra acción o un error en la acción
            $result = false;
        }

        // Respuesta al cliente
        if ($result) {
            echo "Success";
        } else {
            echo "Error";
        }
    } else {
        echo "Invalid request";
    }
} else {
    // Método no permitido
    header('HTTP/1.1 405 Method Not Allowed');
    echo "Method not allowed";
}


