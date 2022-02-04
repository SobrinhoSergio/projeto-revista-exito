<?php
session_start();
isSessionValid();

use Friweb\CMS\Model\Post;

if ($_GET['search-submit']) {
    $searchResult = Post::searchPosts(mb_strtoupper($_GET['search']));
} else {
    $searchResult = null;
}

loadView('search_posts_view', ['searchResult' => $searchResult]);

