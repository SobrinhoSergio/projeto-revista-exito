<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Columnist;

session_start();
isSessionValid();

$exception = null;

if (count($_POST) > 0) {

    try {

        $columnist = new Columnist($_POST);

        // verifica dimensoes
        $columnist->checkDimensions($_FILES['main_image']['tmp_name']);

        // pega extensao
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);

        // insere o colunista na db e salva sua PK
        $key = $columnist->insertColumnist();

        // copia para originais
        copy($_FILES['main_image']['tmp_name'], dirname("../../materia.php").'/img/colunistas/originais/'.$key.'.jpg');

        // recorta automaticamente para thumbs
        $tmp_path = '/img/colunistas/thumbs/'.$key.'.jpg';
        $columnist->resize_image($_FILES['main_image']['tmp_name'], $tmp_path);

        // renomeia e move ao diretório thumbs
        $path = $columnist->renameImg($key, $tmp_path, 'jpg', 'thumbs/');

        // salva caminho (thumbs) da imagem na db
        $columnist->insertImageLink($path, $key);

        header("Location: columnists_list_controller.php?page=1");

    } catch (AppException $e) {
        $exception = $e;
    }

}

loadView('new_columnist', $_POST + ['AppException' => $exception]);