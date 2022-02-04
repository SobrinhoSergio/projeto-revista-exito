<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Video;


try {
    $repost = new Video();
    $repost->repost($_POST['repost_id']);
    header("location: videos_list_controller.php");
} catch (AppException $e) {
    echo $e;
}
