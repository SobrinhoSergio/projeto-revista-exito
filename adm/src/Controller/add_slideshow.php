<?php 
session_start();
isSessionValid();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Database;

$_POST['type'] = 15;
$_POST['description'] = $_GET['description'];
$_POST['link'] = "materia.php?post_id=".$_GET['post_id'];

if (isset($_GET['expiration'])) {
    $_POST['expiration'] = $_GET['expiration'];
} else {
    $_POST['expiration'] = 1;
}

$sponsor = new Sponsor($_POST);

$sponsorExists = $sponsor->getResultFromSelect(['link_anuncio' => 'materia.php?post_id='.$_GET['post_id']]);

if ($sponsorExists->num_rows > 0) {
    try {
        $link_anuncio = "materia.php?post_id=".$_GET['post_id'];
        Sponsor::republishSlideshow($link_anuncio);
        header("Location: sponsors_list_controller.php?page=1");
        exit();
    } catch (AppException $e) {
        echo $e;
    }
}

$key = $sponsor->insertSponsor();

$original_post = dirname("../../materia.php").'/img/posts/originais/'.$_GET['post_id'].'.png';

$filename = $key.'.png';

$path_sponsor_original = dirname("../../materia.php").'/img/anuncios/originais/'.$filename;

copy($original_post, $path_sponsor_original);

$tmp_path = '/img/anuncios/slide/'.$filename;

$sponsor->resize_image($path_sponsor_original, $tmp_path, 1580, 645);

$sponsor->insertImageLink('/img/anuncios/slide/'.$filename, $key);

header("Location: sponsors_list_controller.php?page=1");