<?php

error_reporting(E_ALL ^ E_NOTICE);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\User;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

if ($_POST['update-submit']) {
    try {
        // se ativo desmarcado
        if (!$_POST['active']) {
            $_POST['active'] = 0;
        }

        // se publicar desmarcado
        if (!$_POST['publish']) {
            $_POST['publish'] = 0;
        }

        $update = new User($_POST);

        // atualiza senha separadamente
        if ($_POST['password']) {
//            $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $update->update($_SESSION['update_user_id'], ['senha_usuario' => $_POST['password']]);
        }

        // atualiza form
        $update->update($_SESSION['update_user_id']);

        unset($_SESSION['update_user_id']);

        // redireciona
        header("location: users_list_controller.php");

    } catch (AppException $e) {
        $exception = $e;
    }
}

$exception = null;

try {
    $user = new User($_GET);
    $rows = $user->getResultFromSelect(['chave_usuario' => $_GET['user_id']]);
    if (!$rows) {header("location: users_list_controller.php");}
    $fields = $rows->fetch_assoc();
    $_SESSION['update_user_id'] = $_GET['user_id'];

} catch (AppException $e) {
    $exception = $e;
}

loadView('user_edit', ['AppException' => $exception] + $fields);