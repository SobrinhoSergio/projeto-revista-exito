<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use Friweb\CMS\Model\User;

if (count($_POST) > 0 && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

    // verifica se o e-mail existe no sistema
    $user = new User();
    $userExists = $user->getArraySelect(['email_usuario' => $_POST['email'], 'ativo' => 1, 'publicar' => 1]);
    if (!$userExists) {
        header("Location: login_controller.php");
        exit();
    }

    require  dirname("../composer.json") . "/src/config/Email/Email.php";

    $email = new Email();

    $newPassword = substr(md5(time()),0, 6);

    $primaryKey = $user->getArraySelect(['email_usuario' => $_POST['email']], 'chave_usuario');

    $user->update($primaryKey[0]['chave_usuario'], ['senha_usuario' => $newPassword]);


    $email->add(
        'Recuperação de Senha - Êxito Rio',

        'Você solicitou a recuperação de senha no portal da Administração Êxito Rio' .
        '<br><br> Sua nova senha: ' .
        $newPassword .
        '<br><br>Lembre-se de alterar esta senha novamente no painel da Administração!',

        "Usuário",
        "".$_POST['email']

    )->send("Êxito Rio - Administração");

    if (!$email->error()) {
        $successMail = true;
    } else {
        echo $email->error()->getMessage();
    }
    header("Location: login_controller.php");
}

loadView('password_recovery');