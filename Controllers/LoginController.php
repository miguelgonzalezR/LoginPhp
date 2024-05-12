<?php
require_once '../Models/User.php';

class LoginController {
    public function login($username, $password) {
        $usuario = new Usuario();
        return $usuario->checkLogin($username, $password);
    }
}