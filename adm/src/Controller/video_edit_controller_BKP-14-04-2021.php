<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Video;

error_reporting(E_ALL ^ E_NOTICE);

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;

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

        $update = new Video($_POST);
        $update->update($_SESSION['video_id']);
        unset($_SESSION['video_id']);
        header("location: videos_list_controller.php");

    } catch (AppException $e) {
        $exception = $e;
    }
}

try {
    $video = new Video($_GET);
    $rows = $video->getResultFromSelect(['chave_video' => $_GET['video_id']]);
    if (!$rows) { header("location: videos_list_controller.php"); }
    $fields = $rows->fetch_assoc();
    $_SESSION['video_id'] = $_GET['video_id'];

} catch (AppException $e) {
    $exception = $e;
}

loadView('video_edit', ['AppException' => $exception] + $fields);