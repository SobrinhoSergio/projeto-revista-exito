<?php
error_reporting(E_ALL ^E_NOTICE);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Video;

session_start();
isSessionValid();

$exception = null;

if (isset($_POST['link'])) {

    $video = new Video($_POST);

    try {
        $primaryKey = $video->insertVideo();
        header("Location: videos_list_controller.php");

    } catch (AppException $e) {
        $exception = $e;
    }
}


loadView('new_video', $_POST + ['AppException' => $exception]);