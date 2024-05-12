<?php
require_once '../Controllers/LoginController.php';

$loginController = new LoginController();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $res = $loginController->login($username, $password);

    if ($res['status'] == 1) {

        session_start();

        $_SESSION['username'] = $username; // Guardar el nombre de usuario en la sesión
        $_SESSION['Rol'] = $res['role'];
        $_SESSION['logged_in'] = true;

        if ($res['role'] == 1) {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: MainPage.php');
        }


    } elseif ($res['status'] == 2){
        echo "Tu usuario a sido bloqueado por un administrador por favor contactemos";
    
    } elseif ($res['status'] == 3){
        echo "tu usuario ha sido bloqueado por intentar iniciar sesión sin éxito. ";

    } elseif ($res['status'] == 4){
        echo "Invalid credentials.";
    } else {
        echo $res['status'];
    }
}

require_once 'Login.php';