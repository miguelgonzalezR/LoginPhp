<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Si el usuario no está autenticado, redirigir a la página de login
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    <form action="logout.php" method="post">
        <button type="submit" name="logout">Cerrar Sesión</button>
    </form>

</body>
</html>