<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Database;
use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Resize;


error_reporting(E_ALL ^ E_NOTICE);

session_start();
isSessionValid();

$pagina = $_GET['page'];

if ($_POST['update-submit']) {

    try {

        if (!$_POST['active']) {
            $_POST['active'] = 0;
        }

        if (!$_POST['publish']) {
            $_POST['publish'] = 0;
        }

        if ($_POST['expiration'] == "") {
            $_POST['expiration'] = 0;
        } else {
            $_POST['publish'] = 1;
        }

        $update = new Sponsor($_POST);
        $update->update($_SESSION['update_sponsor_id']);


        if ($_POST['change_img'] == 1) {

            $updateLogo = new Sponsor($_POST);
            $updateLogo->checkDimensions($_FILES['img']['tmp_name']);

            $dimensions = $updateLogo->getDimensionsByType();

            $dir = $updateLogo->getDirectoryByType();


            $key = $_SESSION['update_sponsor_id'];
            $filename = $key.'.jpg';

            $tmp_path = '/img/anuncios/'.$dir.$filename;

            if ($_POST['type'] == 9 || $_POST['type'] == 10) {
                $resize = new Resize($_FILES['img']['tmp_name']);
                $resize->resizeTo(150, 150, 'maxHeight');
                $resize->saveImage(dirname("../../materia.php").'/img/anuncios/'.$dir.$filename);
                move_uploaded_file($_FILES['img']['tmp_name'], dirname("../../materia.php").'/img/anuncios/originais/'.$filename);
                header("Location: sponsors_list_controller.php?page=1");
                exit();

            } else {
                move_uploaded_file($_FILES['img']['tmp_name'], dirname("../../materia.php").'/img/anuncios/originais/'.$filename);
                $updateLogo->resize_image(dirname("../../materia.php").'/img/anuncios/originais/'.$filename, $tmp_path, $dimensions['width'], $dimensions['height']);
                $updateLogo->insertImageLink('/img/anuncios/'.$dir.$filename, $key);
                header("location: sponsors_list_controller.php?page=1");
                exit();
            }
            
        }

        unset($_SESSION['update_sponsor_id']);
        header("location: sponsors_list_controller.php?page=".$pagina);


    } catch (AppException $e) {
        $exception = $e;
    }
}


$exception = null;

try {

    $id_sponsor = filter_input(INPUT_GET, 'sponsor_id', FILTER_VALIDATE_INT);

    $sponsor = new Sponsor();

    $rows = $sponsor->getResultFromSelect(['chave_anuncio' => $id_sponsor]);
    if (!$rows) {header("location: sponsors_list_controller.php");}
    
    $fields = $rows->fetch_assoc();

    $dimensions = Sponsor::getSponsorDimensions($fields['tipo_anuncio']);
    $directory = Sponsor::getSponsorDirectory($fields['tipo_anuncio']);

    $sql_sponsor_type = "SELECT t.descricao_anuncio FROM tabela_anuncios an JOIN tabela_tipos_anuncios t ON (an.tipo_anuncio = t.tipo_anuncio) WHERE an.chave_anuncio = $id_sponsor";
    $type_sponsor = Database::getResultFromQuery($sql_sponsor_type)->fetch_assoc();

    $_SESSION['update_sponsor_id'] = $id_sponsor;

    $_SESSION['current_sponsor_img'] = dirname("../materia.php"). $fields['imagem_anuncio'];

} catch (AppException $e) {
    $exception = $e;
}

loadView('sponsor_edit', ['AppException' => $exception] + $fields + $dimensions + ['directory' => $directory] + ['type_sponsor' => $type_sponsor]);
