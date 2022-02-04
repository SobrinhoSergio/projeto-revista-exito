<?php
error_reporting(E_ALL ^ E_NOTICE);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Partner;
use Friweb\CMS\Model\CategoryPartner;
use Friweb\CMS\Model\Resize;


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

        // atualiza form
        $update = new Partner($_POST);
        $update->update($_SESSION['update_partner_id']);

        // atualiza imagem logo
        if ($_POST['change_img'] == 1) {

            $updateLogo = new Partner($_FILES);
            $updateLogo->checkDimensions($_FILES['img']['tmp_name']);
            $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
  
            $resize = new Resize($_FILES['img']['tmp_name']);
            $resize->resizeTo(227, 150, 'maxWidth');

            $path = '/img/guia/thumbs/' . $_SESSION['update_partner_id'] . '.' . $ext; 
            $resize->saveImage(dirname("../../materia.php").$path);

            move_uploaded_file($_FILES['img']['tmp_name'], dirname("../../materia.php").'/img/guia/originais/'.$_SESSION['update_partner_id'].'.'.$ext);

            $update->insertImageLink($_SESSION['update_partner_id'].'.'.$ext, $_SESSION['update_partner_id']);
        }

        unset($_SESSION['update_partner_id']);
        header("location: partners_list_controller.php?page=".$pagina);


    } catch (AppException $e) {
        $exception = $e;
    }
}


$exception = null;

try {
    $partner = new Partner($_GET);
    $rows = $partner->getResultFromSelect(['chave_empresa' => $_GET['partner_id']]);
    if (!$rows) {header("location: partners_list_controller.php");}
    $fields = $rows->fetch_assoc();

    $_SESSION['update_partner_id'] = $_GET['partner_id'];

    $category = new CategoryPartner();
    $category_field = $category->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);

} catch (AppException $e) {
    $exception = $e;
}

loadView('partner_edit', ['AppException' => $exception] + $fields + ['category_field' => $category_field]);