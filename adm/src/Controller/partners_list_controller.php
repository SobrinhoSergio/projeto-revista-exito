<?php

error_reporting(E_ALL ^ E_NOTICE);

use Friweb\CMS\Model\Partner;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

// instancia classe
$partners = new Partner();

// retorna todas as linhas da tabela de parceiros
$queryFull = $partners->getResultFromSelect(['ativo' => 1]);

// número máximo de parceiros por página
$maxRows = 10;

// retorna os parceiros com limite máximo estabelecido
$queryPaginated = $partners->getPaginator($maxRows);

// número de páginas
$pages = ceil($queryFull->num_rows / $maxRows);


// caso retire a pagina da url
if (is_null($_GET['page'])) {
    header("location: partners_list_controller.php?page=1");
}

// caso o usuário vá para outras páginas
if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header("location: partners_list_controller.php?page=1");
    }

    // a partir de qual número de linha da tabela
    $offset = $_GET['page'] * 10 - 10;

    // retorna um limite de linhas a partir do número $offset
    $queryPaginated = $partners->getPaginator($maxRows,$offset);
}

loadView('partners_list', ['pages' => $pages, 'queryPaginated' => $queryPaginated, $_GET]);


