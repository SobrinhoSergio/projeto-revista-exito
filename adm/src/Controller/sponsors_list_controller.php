<?php

error_reporting(E_ALL ^ E_NOTICE);

use Friweb\CMS\Model\Database;
use Friweb\CMS\Model\Sponsor;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$sponsors = new Sponsor();

if (isset($_GET['type'])) {
    $type_sponsor = filter_input(INPUT_GET, 'type', FILTER_VALIDATE_INT);
}
// $queryFull = $sponsors->getResultFromSelect(['ativo' => 1]);

$sql_full = "SELECT * FROM tabela_anuncios WHERE ativo = 1";

if ($_GET['type']) {
    $sql_full .= " AND tipo_anuncio = ${type_sponsor}";
}

$queryFull = Database::getResultFromQuery($sql_full);

if ($queryFull->num_rows == 0) {
    echo "Não foi encontado nenhum anúncio nessa categoria<br><br>";
    echo "<a href='sponsors_list_controller.php?page=1'>Voltar para listagem principal</a>";
    exit();
}


$maxRows = 10;

// $queryPaginated = $sponsors->getPaginator($maxRows);


$sql_paginated = "SELECT * FROM tabela_anuncios WHERE ativo = 1";

if ($_GET['type']) {
    $sql_paginated .= " AND tipo_anuncio = ${type_sponsor}";
}

//$sql_paginated .= "ORDER BY data_ultima_renovacao DESC LIMIT ${maxRows}";

$sql_paginated .= "ORDER BY chave_anuncio DESC LIMIT ${maxRows}";


$queryPaginated = Database::getResultFromQuery($sql_paginated);



$pages = ceil($queryFull->num_rows / $maxRows);


$redirect = "location: sponsors_list_controller.php?page=1";

if (isset($_GET['type'])) {
    $redirect .= "&type=".$_GET['type'];
}

if (is_null($_GET['page'])) {
    header($redirect);
}

if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header($redirect);
    }
    $offset = $_GET['page'] * 10 - 10;

    // $queryPaginated = $sponsors->getPaginator($maxRows,$offset);
    // $queryPaginated = Database::getResultFromQuery("SELECT * FROM tabela_anuncios WHERE ativo = 1 ORDER BY chave_anuncio DESC LIMIT ${maxRows} OFFSET ${offset}");


    $sql_paginated = "SELECT * FROM tabela_anuncios WHERE ativo = 1";

    if ($_GET['type']) {
        $sql_paginated .= " AND tipo_anuncio = ${type_sponsor}";
    }

    //$sql_paginated .= " ORDER BY data_ultima_renovacao DESC LIMIT ${maxRows} OFFSET ${offset}";

    $sql_paginated .= " ORDER BY chave_anuncio DESC LIMIT ${maxRows} OFFSET ${offset}";


    $queryPaginated = Database::getResultFromQuery($sql_paginated);


    if (isset($_GET['type'])) {
        $sql_sponsor_type = "SELECT t.descricao_anuncio FROM tabela_anuncios an JOIN tabela_tipos_anuncios t ON (an.tipo_anuncio = t.tipo_anuncio) WHERE an.tipo_anuncio = $type_sponsor";
        $type_sponsor = Database::getResultFromQuery($sql_sponsor_type)->fetch_assoc();
    }

}

loadView('sponsors_list', ['pages' => $pages, 'queryPaginated' => $queryPaginated, $_GET, 'type_sponsor_name' => $type_sponsor['descricao_anuncio']]);