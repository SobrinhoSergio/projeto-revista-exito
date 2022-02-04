<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Post;

session_start();
isSessionValid();


// ajax
if (isset($_POST['image'])) {

    $postImg = new Post($_POST);

    try {

        // salva caminho da imagem temporária em posts
        $tmp_path = $postImg->moveImage('posts/');

        // salva imagem recortada (thumb)
        if ($_SESSION['cropper_counter'] === 0) {
            $_SESSION['tmp_path_thumb'] = $tmp_path['tmp_name'];
            $_SESSION['cropper_counter'] = 1;
            goto view;
        }

        if ($_SESSION['cropper_counter'] === 1)  {
            // fotos
            $_SESSION['tmp_path_photo'] = $tmp_path['tmp_name'];
            $_SESSION['cropper_counter'] = 2;
            goto view;

        }
//        if ($_SESSION['cropper_counter'] === 2) {
//            $_SESSION['tmp_path_amp'] = $tmp_path['tmp_name'];
//            $_SESSION['cropper_counter'] = 3;
//            goto view;
//        }

        unset($_POST);

    } catch (AppException $e) {
        $exception = $e;
    }
}


view:

// recortes concluídos
if ($_SESSION['cropper_counter'] === 2) {

    $_POST['thumb'] = $_SESSION['tmp_path_thumb'];
    $_POST['photo'] = $_SESSION['tmp_path_photo'];
//    $_POST['amp'] = $_SESSION['tmp_path_amp'];
    $_POST['original'] = $_SESSION['post_main_original_image'];

    $postUpdate = new Post($_POST);

    $postUpdate->renameImg($_SESSION['update_post_id'], $_SESSION['tmp_path_thumb'], 'png', 'thumbs/');
    $postUpdate->renameImg($_SESSION['update_post_id'], $_SESSION['tmp_path_photo'], 'png', 'fotos/');
//    $postUpdate->renameImg($_SESSION['update_post_id'], $_SESSION['tmp_path_amp'], 'png', 'amp/');
    $postUpdate->renameImg($_SESSION['update_post_id'], $_SESSION['post_main_original_image'], 'png', 'originais/');
    unset($_SESSION['update_post_id']);
    unset($_SESSION['tmp_path_thumb']);
    unset($_SESSION['tmp_path_photo']);
//    unset($_SESSION['tmp_path_amp']);
    unset($_SESSION['post_main_original_image']);

    header("location: posts_list_controller.php");
    exit();
}

loadView('update_post_image');