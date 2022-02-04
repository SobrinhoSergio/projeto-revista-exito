<?php

error_reporting(E_ALL ^ E_NOTICE);

//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Columnist;
use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Post;

session_start();
isSessionValid();

$writer = new Columnist();
$writers = $writer->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);

$sponsor = new Sponsor();
$sponsors = $sponsor->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);



if ($_POST['update-submit']) {

    try {
        if (!$_POST['active']) {
            $_POST['active'] = 0;
        }

        if (!$_POST['publish']) {
            $_POST['publish'] = 0;
        }

        if (!$_POST['service_check']) {
            $_POST['service_text'] = '';
            unlink($_SESSION['logo_path']);
            unset($_SESSION['logo_path']);
        }

        if ($_POST['subject'] == "") {
            $_POST['subject'] = "Produtos & Serviços";
        }

        if ($_POST['type'] != 2) {
            $_POST['category'] = "";
        }

        if ($_POST['type'] != 4) {
            $_POST['column'] = "";
        }

        if ($_POST['expiration'] == "") {
            $_POST['expiration'] = 0;
        } else {
            $_POST['publish'] = 1;
        }

        $update = new Post($_POST);
        $update->update($_SESSION['update_post_id']);


        // atualiza imagem logo
        if ($_POST['change_img'] == 2) {
            $update->checkDimensions($_FILES['service_img']['tmp_name']);
            $ext_logo = pathinfo($_FILES['service_img']['name'], PATHINFO_EXTENSION);
            $tmp_logo_dest = 'assets/img/posts/logo_' . uniqid() . '.' . $ext_logo;
            move_uploaded_file($_FILES['service_img']['tmp_name'], $tmp_logo_dest);

            $nn = $update->renameImg($_SESSION['update_post_id'], $tmp_logo_dest, $ext_logo, "logos/", 5);
            chmod($nn, 0644);
        }


        // atualiza imagem principal
        if ($_POST['change_img'] == 1) {
            $updateMainImg = new Post($_FILES);
            $updateMainImg->checkDimensions($_FILES['main_image']['tmp_name']);
            $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
            $dest = 'assets/img/posts/';
            $name = 'original_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['main_image']['tmp_name'], $dest.$name);

            $_SESSION['post_main_original_image'] = $dest.$name;
            $_SESSION['cropper_counter'] = 0;

            header("location: update_post_img_controller.php");
            exit();
        }

        unset($_SESSION['update_post_id']);
        header("location: posts_list_controller.php");


    } catch (AppException $e) {
        $exception = $e;
    }
}

$exception = null;

try {
    $post = new Post($_GET);
    $rows = $post->getResultFromSelect(['chave_materia' => $_GET['post_id']]);
    if (!$rows) {header("location: posts_list_controller.php");}
    $fields = $rows->fetch_assoc();

    $_SESSION['update_post_id'] = $_GET['post_id'];

} catch (AppException $e) {
    $exception = $e;
}



loadView('post_edit', ['AppException' => $exception] + $fields + ['writers' => $writers] + ['sponsors' => $sponsors]);