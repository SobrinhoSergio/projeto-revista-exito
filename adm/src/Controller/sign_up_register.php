<?php


use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\User;

session_start();
isSessionValid();

//formulário
if ($_POST > 0) {

    $register = new User($_POST);

    try {
        $newUser = $register->createUser();
        header("location: users_list_controller.php");

    } catch (AppException $e) {
        $exception = $e;
        loadView('signup', ['AppException' => $exception]);
    }
}

