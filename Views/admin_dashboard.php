<?php
session_start();
require_once '../Models/User.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['Rol'] != 1) {
    header('Location: MainPage.php');
    exit();
}

$usuario = new Usuario();
$users = $usuario->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Bienvenido Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <form action="logout.php" method="post">
        <button type="submit" name="logout">Cerrar Sesión</button>
    </form>

    <h1>Usuarios</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo $user['is_blocked'] ? 'Blocked' : 'Active'; ?></td>
            <td>
                <?php if ($user['is_blocked']): ?>
                    <button onclick="unblockUser(<?php echo $user['id']; ?>)">Unblock</button>
                <?php else: ?>
                    <button onclick="blockUser(<?php echo $user['id']; ?>)">Block</button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    
    <script>
    function blockUser(userId) {
        fetch('http://localhost/LoginPhp/Controllers/block_user_Controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=block&userId=' + userId
        }).then(response => response.text())
        .then(data => location.reload());
    }

    function unblockUser(userId) {
        fetch('http://localhost/LoginPhp/Controllers/block_user_Controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=unblock&userId=' + userId
        }).then(response => response.text())
        .then(data => location.reload());
    }
    </script>


</body>
</html>
