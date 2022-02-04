<?php

error_reporting(E_ALL ^ E_NOTICE);

use Friweb\CMS\Model\Post;

session_start();
isSessionValid();


// instancia classe
$posts = new Post();

// retorna todas as linhas da tabela de matérias

$queryFull = $posts->getResultFromSelect(['ativo' => 1]);

// número máximo de usuários por página
$maxRows = 10;

// retorna os usuários com limite máximo estabelecido
$queryPaginated = $posts->getPaginator($maxRows);

// número de páginas
$pages = ceil($queryFull->num_rows / $maxRows);

$a = $_GET['page'];
//echo $a;

// caso retire a pagina da url
if (is_null($_GET['page'])) {
    header("location: posts_list_controller.php?page=1");
}

// caso o usuário vá para outras páginas
if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header("location: posts_list_controller.php?page=1");
    }

    // a partir de qual número de linha da tabela
    $offset = $_GET['page'] * 10 - 10;

    // retorna um limite de linhas a partir do número $offset
    $queryPaginated = $posts->getPaginator($maxRows,$offset);

}


loadView('posts_list', ['pages' => $pages, 'queryPaginated' => $queryPaginated, $_GET]);
