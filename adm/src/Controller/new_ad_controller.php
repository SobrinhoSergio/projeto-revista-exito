<?php

session_start();
isSessionValid();

$exception = null;

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Database;
use Friweb\CMS\Model\Resize;

if ($_POST['description']) {

    try {
        // instancia objeto na classe de anuncios
        $ad = new Sponsor($_POST);

        // checa dimensões máximas e mínimas
        $ad->checkDimensions($_FILES['img']['tmp_name']);

        // insere dados do formulário na database
        $key = $ad->insertSponsor();

        // pega as dimensões correspondentes ao tipo de anúncio inserido no formulário
        $dimensions = $ad->getDimensionsByType();

        // nome do arquivo em si
        $filename = $key.'.jpg';

        // pega o diretório dentro de anúncios a ser salva, pelo tipo de anúncio inserido no formulário
        $dir = $ad->getDirectoryByType();

        // insere o nome do arquivo no banco de dados
        $ad->insertImageLink('/img/anuncios/'.$dir.$filename, $key);


        if ($_POST['type'] == 9 || $_POST['type'] == 10) {
            $resize = new Resize($_FILES['img']['tmp_name']);
            $resize->resizeTo(150, 150, 'maxHeight');
            $resize->saveImage(dirname("../../materia.php").'/img/anuncios/'.$dir.$filename);
            move_uploaded_file($_FILES['img']['tmp_name'], dirname("../../materia.php").'/img/anuncios/originais/'.$filename);
            header("Location: sponsors_list_controller.php?page=1");
            exit();

        }
        
        /*else if($_POST['type'] == 11){
    
            $resize = new Resize($_FILES['img']['tmp_name']);
            $resize->resizeTo(1200, 400, 'maxHeight');
            $resize->saveImage(dirname("../../materia.php").'/img/anuncios/'.$dir.$filename);
            move_uploaded_file($_FILES['img']['tmp_name'], dirname("../../materia.php").'/img/anuncios/originais/'.$filename);
            header("Location: sponsors_list_controller.php?page=1");
        }*/
        
        else {

            move_uploaded_file($_FILES['img']['tmp_name'], dirname("../../materia.php").'/img/anuncios/originais/'.$filename);
            $tmp_path = '/img/anuncios/'.$dir.$filename;

            $ad->resize_image(dirname("../../materia.php").'/img/anuncios/originais/'.$filename, $tmp_path, $dimensions['width'], $dimensions['height']);

            header("Location: sponsors_list_controller.php?page=1");
        }

    } catch (AppException $e) {
        $exception = $e;
        echo $e;
    }
}

// pega os tipos de anúncio (chave e nome) na db
$types = Database::getResultFromQuery("SELECT * FROM tabela_tipos_anuncios");


// carrega html
loadView('new_ad', ['AppException' => $exception, 'types' => $types]);