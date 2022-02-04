<?php

error_reporting(E_ALL ^ E_NOTICE);

use Friweb\CMS\Model\User;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

// instancia classe
$users = new User();

// retorna todas as linhas da tabela de usuários
$queryFull = $users->getResultFromSelect(['ativo' => 1]);

// número máximo de usuários por página
$maxRows = 10;

// retorna os usuários com limite máximo estabelecido
$queryPaginated = $users->getPaginator($maxRows);

// número de páginas
$pages = ceil($queryFull->num_rows / $maxRows);



// caso retire a pagina da url
if (is_null($_GET['page'])) {
    header("location: users_list_controller.php?page=1");
}

// caso o usuário vá para outras páginas
if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header("location: users_list_controller.php?page=1");
    }

    // a partir de qual número de linha da tabela
    $offset = $_GET['page'] * 10 - 10;

    // retorna um limite de linhas a partir do número $offset
    $queryPaginated = $users->getPaginator($maxRows,$offset);
}

loadView('users_list', ['pages' => $pages, 'queryPaginated' => $queryPaginated, $_GET]);