<?php

// verifica se a sessão está ativa
function isSessionValid() {
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $password = $_SESSION['password'];
    $type_user = $_SESSION['type_user'];

    if(!isset($id) || !isset($name) || !isset($password) || !isset($type_user)) {
    	// caso não esteja setada, direciona ao Controller de login
        header("Location: login_controller.php");
        exit();
    }
}