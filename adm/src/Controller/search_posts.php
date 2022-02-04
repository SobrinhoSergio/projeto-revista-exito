<?php
session_start();
isSessionValid();

use Friweb\CMS\Model\Post;



if (isset($_GET['search-submit'])) {
    
    if(isset($_GET['type']) && $_GET['search'] == ''){
        $searchResult = Post::searchPostsTipo($_GET['type']);
    }else{
        $searchResult = Post::searchPosts(mb_strtoupper($_GET['search']));
    }
    
} else {
    $searchResult = null;
}

loadView('search_posts_view', ['searchResult' => $searchResult]);
