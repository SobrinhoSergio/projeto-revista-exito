<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Post;

session_start();
isSessionValid();


// AJAX
if (isset($_POST['image'])) {

    $postImg = new Post($_POST);

    try {
        
        $tmp_path = $postImg->moveImage('posts/');

        if (!$_SESSION['tmp_path_thumb']) {
            $_SESSION['tmp_path_thumb'] = $tmp_path['tmp_name'];
        } else {
            $_SESSION['tmp_path_photo'] = $tmp_path['tmp_name'];
        }

        unset($_POST);

    } catch (AppException $e) {
        $exception = $e;
    }
}



loadView('post_images');