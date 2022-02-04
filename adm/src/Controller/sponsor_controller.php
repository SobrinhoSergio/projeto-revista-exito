<?php

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;
unset($_SESSION['type_sponsor']);

if (isset($_GET['type'])) {

    // seta o tipo de anúncio a uma variável de sessão
    $_SESSION['type_sponsor'] = $_GET['type'];


    // redireciona
    header("location: cropper_controller.php?type=".$_GET['type']);
}

loadView('type_sponsor');