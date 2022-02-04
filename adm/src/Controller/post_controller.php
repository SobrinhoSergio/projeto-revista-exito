<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Columnist;
use Friweb\CMS\Model\Post;

session_start();
isSessionValid();

unset($_SESSION['tmp_path_thumb']);
unset($_SESSION['tmp_path_photo']);
unset($_SESSION['tmp_path_amp']);
unset($_SESSION['ext_logo']);
unset($_SESSION['post_logo_image']);

$exception = null;

$writer = new Columnist();
$writers = $writer->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);

if (count($_POST) > 0) {

    $_SESSION['post_title'] = $_POST['title'];
    $_SESSION['post_subtitle'] = $_POST['subtitle'];
    $_SESSION['post_writer'] = $_POST['writer'];
    $_SESSION['post_intro'] = $_POST['intro'];
    $_SESSION['post_main'] = $_POST['main'];
    $_SESSION['post_type'] = $_POST['type'];
    $_SESSION['post_subject'] = $_POST['subject'];

    $_SESSION['post_publish'] = $_POST['publish'];

    if (isset($_POST['expiration'])) {
        $_SESSION['post_expiration'] = $_POST['expiration'];
    }

    if (isset($_POST['service_text'])) {
        $_SESSION['service_text'] = $_POST['service_text'];
    }
    if (isset($_POST['category'])) {
        $_SESSION['post_category'] = $_POST['category'];
    }
    if (isset($_POST['column']) && $_POST['column'] != "") {
        $_SESSION['post_column'] = $_POST['column'];
        $author = $writer->getResultFromSelect(['ativo' => 1, 'publicar' => 1, 'chave_colunista' => $_POST['column']]);
        $post_author = $author->fetch_assoc();
        $_SESSION['post_writer'] = $post_author['nome_colunista'];
    }

    if ($_POST['subject'] == "" || $_POST['subject'] == "Turismo") {
        $_SESSION['post_subject'] = "Turismo";
    }

    try {
        Post::postTitleIsUnique($_POST['title']);

        $post = new Post($_FILES);

        $post->checkDimensions($_FILES['main_image']['tmp_name']);

        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $dest = 'assets/img/posts/';
        $name = 'original_' . uniqid() . '.' . $ext;

        move_uploaded_file($_FILES['main_image']['tmp_name'], $dest.$name);
        $_SESSION['post_main_original_image'] = $dest.$name;

        // logo
        if (($_FILES['service_img']['name'] != '')) {
            $post->checkDimensions($_FILES['service_img']['tmp_name']);

            $ext_logo = pathinfo($_FILES['service_img']['name'], PATHINFO_EXTENSION);

            $tmp_logo_dest = 'assets/img/posts/logo_' . uniqid() . '.' . $ext_logo;
            $_SESSION['ext_logo'] = $ext_logo;

            move_uploaded_file($_FILES['service_img']['tmp_name'], $tmp_logo_dest);
            $_SESSION['post_logo_image'] = $tmp_logo_dest;
        }

        header("location: post_images_controller.php");

    } catch (AppException $e) {
        $exception = $e;
    }

}

loadView('new_post', $_POST + ['AppException' => $exception] + ['writers' => $writers]);

