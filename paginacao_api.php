<?php

$listFull = $type->getResultFromSelect(['ativo' => 1, 'publicar' => 1] + $filtros);
$list = $type->getPaginator(4, '', '*', 'DESC', 1, $filtros);

$pages = ceil($listFull->num_rows / 4 );

if (is_null($_GET['page'])) {
    header("location: $link?page=1");
}

if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header("location: $link?page=1");
    }

    // a partir de qual número de linha da tabela
    $offset = $_GET['page'] * 4 - 4;

    // retorna um limite de linhas a partir do número $offset
    $list = $type->getPaginator(4, $offset, '*', 'DESC', 1, $filtros);
}
