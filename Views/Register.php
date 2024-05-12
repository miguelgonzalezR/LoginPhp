<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>

    <h1>Registro de Usuario</h1>
    <form action="../Controllers/RegisterController.php" method="post">

        <label for="Name">Nombres:</label>
        <input type="text" id="name" name="name" required>

        <label for="Name">Apellidos:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="username">User Name:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" name="register">Registrar</button>
    </form>

</body>
</html>