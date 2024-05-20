<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h2>Recuperar Contraseña</h2>
        <form action="../Controllers/password_recovery.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        <button type="submit">Enviar enlace de recuperación</button>
    </form>

</body>
</html>