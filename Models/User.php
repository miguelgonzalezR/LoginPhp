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

}