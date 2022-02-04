<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Post;

session_start();
isSessionValid();

$_POST['title'] = $_SESSION['post_title'];
$_POST['subtitle'] = $_SESSION['post_subtitle'];
$_POST['writer'] = $_SESSION['post_writer'];
$_POST['intro'] = $_SESSION['post_intro'];
$_POST['main'] = $_SESSION['post_main'];
$_POST['type'] = $_SESSION['post_type'];
$_POST['subject'] = $_SESSION['post_subject'];
$_POST['publish'] = $_SESSION['post_publish'];
$_POST['thumb'] = $_SESSION['tmp_path_thumb'];
$_POST['photo'] = $_SESSION['tmp_path_photo'];
$_POST['amp'] = $_SESSION['tmp_path_amp'];
$_POST['original'] = $_SESSION['post_main_original_image'];
$_POST['service_text'] = $_SESSION['service_text'];
$_POST['logo_image'] = $_SESSION['post_logo_image'];

$_POST['category'] = $_SESSION['post_category'];
$_POST['column'] = $_SESSION['post_column'];
$_POST['expiration'] = $_SESSION['post_expiration'];

$postForm = new Post($_POST);

try {

    $primaryKeyArray = $postForm->insertPost();
    $primaryKey = $primaryKeyArray[0]['chave_materia'];

    $postForm->renameImg($primaryKey, $_SESSION['tmp_path_thumb'], 'png', "thumbs/");
    $postForm->renameImg($primaryKey, $_SESSION['tmp_path_photo'], 'png', "fotos/");
    $postForm->renameImg($primaryKey, $_SESSION['tmp_path_amp'], 'png', "amp/");
    $postForm->renameImg($primaryKey, $_SESSION['post_main_original_image'], 'png', "originais/");

    if (($_SESSION['post_logo_image']) != '') {
        $logo_path = $postForm->renameImg($primaryKey, $_SESSION['post_logo_image'], $_SESSION['ext_logo'], "logos/", 5);
        chmod($logo_path, 0644);
    }

    header("location: posts_list_controller.php");
    exit();

} catch (AppException $e) {
    $exception = $e;
}