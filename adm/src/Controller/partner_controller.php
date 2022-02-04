<?php

error_reporting(E_ALL ^ E_NOTICE);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\CategoryPartner;
use Friweb\CMS\Model\Partner;
use Friweb\CMS\Model\Resize;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;

if ($_POST['name']) {

    try {

        $partner = new Partner($_POST);

        $partner->checkDimensions($_FILES['main_image']['tmp_name']);
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);

        $primaryKeyArray = $partner->insertPartner();
        $primaryKey = $primaryKeyArray[0]['chave_empresa'];
        
        $resize = new Resize($_FILES['main_image']['tmp_name']);
        $resize->resizeTo(227, 150, 'maxWidth');

        $path = '/img/guia/thumbs/' . $primaryKey . '.' . $ext; 
        $resize->saveImage(dirname("../../materia.php").$path);
        
        move_uploaded_file($_FILES['main_image']['tmp_name'], dirname("../../materia.php").'/img/guia/originais/'.$primaryKey.'.'.$ext);

        $partner->insertImageLink($primaryKey.'.'.$ext, $primaryKey);

        header("location: partners_list_controller.php?page=1");

    } catch (AppException $e) {
        $exception = $e;
    }
}


$category = new CategoryPartner();
$category_field = $category->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);

loadView('partner_form', ['AppException' => $exception, 'category_field' => $category_field]);