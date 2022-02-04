<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Database;
use Friweb\CMS\Model\Sponsor;

session_start();
isSessionValid();


$sponsors = new Sponsor();

$queryFull = Database::getResultFromQuery("SELECT * FROM tabela_anuncios WHERE ativo = 1 AND CURRENT_DATE() > vencimento_anuncio");

$maxRows = 10;


$queryPaginated = Database::getResultFromQuery("SELECT * FROM tabela_anuncios WHERE ativo = 1 AND CURRENT_DATE() > vencimento_anuncio ORDER BY chave_anuncio DESC LIMIT ${maxRows}");

if ($queryPaginated->num_rows == 0) {
    echo "Não há nenhum anúncio vencido";
    echo '<a href="cms_controller.php">Voltar a página inicial</a>';
    exit();
}


$pages = ceil($queryFull->num_rows / $maxRows);


if (is_null($_GET['page'])) {
    header("location: expired_sponsors_list_controller.php?page=1");
}

if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header("location: expired_sponsors_list_controller.php?page=1");
    }

    $offset = $_GET['page'] * 10 - 10;

    $queryPaginated = Database::getResultFromQuery("SELECT * FROM tabela_anuncios WHERE ativo = 1 AND CURRENT_DATE() > vencimento_anuncio ORDER BY chave_anuncio DESC LIMIT ${maxRows} OFFSET ${offset}");

}


loadView('sponsors_list', ['pages' => $pages, 'queryPaginated' => $queryPaginated, $_GET]);