<?php

/* FRIWEB CMS
 * Gerenciador de conteúdo para clientes Friweb
 * Para saber como é estruturado o código, leia o arquivo README em adm/README
 */

// carrega autoload
require '../vendor/autoload.php';


// url
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// demais requisições com url tratada

//localhost
$uri2 = str_replace("/exitorio2021/adm", "", $uri);

//servidor real
//$uri2 = str_replace("/adm", "", $uri);

//iuri0138
//$uri2 = str_replace("/~wwwexitoriocom/adm", "", $uri);

//2021
//$uri2 = str_replace("/2021/adm", "", $uri);

if (is_file('../src/Controller'. $uri2)) {
    require('../src/Controller'. $uri2);
}


// requisição inicial

// localhost
if ($uri === '/exitorio2021/adm' || $uri === '/exitorio2021/adm/' || $uri === '/exitorio2021/adm/index.php') {
    $uri = '/cms_controller.php';
}

//servidor real
//if ($uri === '/adm' || $uri === '/adm/' || $uri === '/adm/index.php') {
//    $uri = '/cms_controller.php';
//}

// iuri0138
//if ($uri === '/~wwwexitoriocom/adm' || $uri === '/~wwwexitoriocom/adm/' || $uri === '/~wwwexitoriocom/adm/index.php') {
//    $uri = '/cms_controller.php';
//}

// 2021
//if ($uri === '/2021/adm' || $uri === '/2021/adm/' || $uri === '/2021/adm/index.php') {
//    $uri = '/cms_controller.php';
//}

// se url for um arquivo em Controller, redireciona o usuário a ele
if (is_file('../src/Controller' . $uri)) {
	require_once('../src/Controller'. $uri);
}