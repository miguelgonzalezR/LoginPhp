<?php
require_once '../Connection/DB.php';

class Usuario extends DB {
    public function checkLogin($username, $password) {
        // Modificar la consulta para traer también los intentos de acceso
        $sql = "SELECT password, Attempts, Role, is_blocked FROM users WHERE username = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $newAttempts2 = 5;
                $sql3 = "UPDATE users SET Attempts = ? WHERE username = ?";
                $stmt3 = $this->connect()->prepare($sql3);
                $stmt3->execute([$newAttempts2, $username]);
                

                if($user['is_blocked'] == 0 ){
                    return ['status' => "1", 'role' => $user['Role']];
                } else{
                    return ['status' => "2", 'role' => null];
                }

            } else {
                // Actualizar los intentos de acceso si la contraseña es incorrecta
                if ($user['Attempts'] > 0) {
                    $newAttempts = $user['Attempts'] - 1; // Decrementar el contador de intentos
                    $sql2 = "UPDATE users SET Attempts = ? WHERE username = ?";
                    $stmt2 = $this->connect()->prepare($sql2);
                    $stmt2->execute([$newAttempts, $username]);
                    return ['status' => "$newAttempts intentos", 'role' => null];
                } else{
                    return ['status' => "3", 'role' => null]; // limite de intentos
                }
                
            }
        } else {
            return ['status' => "4", 'role' => null]; // Usuario no encontrado
        }
    }



    public function getAllUsers() {
        $sql = "SELECT id, username, is_blocked FROM users where Role = 2";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function blockUser($id) {
        $sql = "UPDATE users SET is_blocked = 1 WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    public function unblockUser($id) {
        $sql = "UPDATE users SET is_blocked = 0 WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$id]);
    }


    public function existsEmail($email) {
        // Asegúrate de que la conexión a la base de datos esté establecida
        $conn = $this->connect();
        
        // Prepara una declaración SQL para evitar inyecciones SQL
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE correo = ?");
        
        // Ejecuta la declaración con el email proporcionado
        $stmt->execute([$email]);
        
        // Recupera el resultado de la consulta
        $count = $stmt->fetchColumn();
        
        // Retorna true si hay al menos un registro con ese email
        return $count > 0;
    }


    public function storeToken($email, $token) {
        $conn = $this->connect();
        
        // Calcula la fecha/hora de expiración del token, p. ej., 24 horas desde ahora
        $expiration = new DateTime(); // Fecha y hora actual
        $expiration->add(new DateInterval('PT24H')); // Añade 24 horas
        
        // Prepara una declaración SQL para actualizar el token y la expiración
        $stmt = $conn->prepare("UPDATE users SET password_reset_token = ?, token_expiration = ? WHERE correo = ?");
        
        // Ejecuta la declaración con el token, la expiración y el email
        return $stmt->execute([$token, $expiration->format('Y-m-d H:i:s'), $email]);
    }

    public function isValidToken($token) {
        $conn = $this->connect();

        // Prepara una declaración SQL para verificar el token y su expiración
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE password_reset_token = ? AND token_expiration > NOW()");
        $stmt->execute([$token]);

        // Recupera el resultado de la consulta
        $count = $stmt->fetchColumn();

        // Retorna true si el token es válido (existe y no ha expirado)
        return $count > 0;
    }

    public function updatePassword($token, $newPassword) {
        $conn = $this->connect();

        // Hashear la nueva contraseña
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepara una declaración SQL para actualizar la contraseña del usuario
        $stmt = $conn->prepare("UPDATE users SET password = ?, password_reset_token = NULL, token_expiration = NULL WHERE password_reset_token = ?");

        // Ejecuta la declaración con la nueva contraseña hasheada y el token
        $success = $stmt->execute([$hashedPassword, $token]);

        // Retorna true si la contraseña fue actualizada correctamente
        return $success;
    }


}
