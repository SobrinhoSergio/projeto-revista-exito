<?php

use Friweb\CMS\Model\Joke;

error_reporting(E_ALL ^ E_NOTICE);


session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

// instancia classe
$jokes = new Joke();

// retorna todas as linhas da tabela de matérias

$queryFull = $jokes->getResultFromSelect(['ativo' => 1]);

// número máximo de usuários por página
$maxRows = 10;

// retorna os usuários com limite máximo estabelecido
$queryPaginated = $jokes->getPaginator($maxRows);

// número de páginas
$pages = ceil($queryFull->num_rows / $maxRows);


// caso retire a pagina da url
if (is_null($_GET['page'])) {
    header("location: jokes_list_controller.php?page=1");
}

// caso o usuário vá para outras páginas
if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header("location: jokes_list_controller.php?page=1");
    }

    // a partir de qual número de linha da tabela
    $offset = $_GET['page'] * 10 - 10;

    // retorna um limite de linhas a partir do número $offset
    $queryPaginated = $jokes->getPaginator($maxRows,$offset);

}

loadView('jokes_list', ['pages' => $pages, 'queryPaginated' => $queryPaginated, $_GET]);

