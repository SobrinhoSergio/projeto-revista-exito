<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Joke;

session_start();
isSessionValid();

$pagina = $_GET['page'];
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;

if (isset($_POST['title'])) {
    try {
        // se ativo desmarcado
        if (!$_POST['active']) {
            $_POST['active'] = 0;
        }

        // se publicar desmarcado
        if (!$_POST['publish']) {
            $_POST['publish'] = 0;
        }

        $update = new Joke($_POST);


        // atualiza form
        $update->update($_SESSION['update_joke_id']);

        if ($_POST['change_img'] != 0) {
            $update->checkDimensions($_FILES['main_image']['tmp_name']);
            $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
            $update->renameImg($_SESSION['update_joke_id'], $_FILES['main_image']['tmp_name'], $ext, '');
        }

        unset($_SESSION['update_joke_id']);

        // redireciona
        header("location: jokes_list_controller.php?page=".$pagina);

    } catch (AppException $e) {
        $exception = $e;
    }
}

$joke = new Joke($_GET);
$rows = $joke->getResultFromSelect(['chave_piada' => $_GET['joke_id']]);
if (!$rows) {header("location: jokes_list_controller.php");}
$fields = $rows->fetch_assoc();

$_SESSION['update_joke_id'] = $_GET['joke_id'];


loadView('joke_edit', $_POST + ['AppException' => $exception] + $fields);