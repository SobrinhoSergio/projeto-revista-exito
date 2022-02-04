<?php

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Sponsor;

$sponsor = new Sponsor($_POST);

try {
    
    $tmp_path = $sponsor->moveImage('anuncios/');
    unlink(dirname("../../materia.php"). '/img/anuncios/'.$_POST['dir'].$_POST['id'].'.jpg');
    $sponsor->renameImg($_POST['id'], $tmp_path, 'jpg', $_POST['dir']);
    unset($_POST);
    exit();

} catch (AppException $e) {
    $exception = $e;
}