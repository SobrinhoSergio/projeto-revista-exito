<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Post;


try {
    $repost = new Post();
    $repost->repost($_POST['repost_id']);
    header("location: ".$_SERVER['HTTP_REFERER']);
} catch (AppException $e) {
    echo $e;
}

