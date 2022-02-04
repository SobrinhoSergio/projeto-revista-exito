<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Database;
use Friweb\CMS\Model\Sponsor;

session_start();
isSessionValid();

if ($_POST['image']) {

    $ext = explode(".",$_SESSION['img'])[1];

    $ad = new Sponsor($_POST);

        $image_array_1 = explode(";", $_REQUEST['image']);
        $image_array_2 = explode(",", $image_array_1[1]);
        $img = base64_decode($image_array_2[1]);

        file_put_contents(dirname("../materia.php"). "/img/anuncios/".$_SESSION['dir'].$_SESSION['img'], $img);

    try {

        $ad->insertImageLink($_SESSION['img'], $_SESSION['id_ad']);

        $sql = "UPDATE tabela_anuncios SET publicar = (?) WHERE chave_anuncio = ".$_SESSION['id_ad'];
        $cnn = Database::getConnection();
        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['publicar']);
        $stmt->execute();
        
        // header("Location: sponsors_list_controller.php");

    } catch (AppException $e) {
        $exception = $e;
    }

}

$org = dirname("../materia.php"). "/img/anuncios/originais/".$_GET['img'];

loadView('ad_cropper', ['dir' => $_GET['dir'], 'w' => $_GET['w'], 'h' => $_GET['h'], 'img' => $_GET['img'], 'publicar' => $_GET['publicar'], 'org' => $org, 'id' => $_GET['id']]);