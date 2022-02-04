<?php
include_once("adm/src/Model/Database.php");
include_once("adm/src/Model/Image.php");
include_once("adm/src/Model/Model.php");
include_once("./adm/src/Model/Sponsor.php");

use Friweb\CMS\Model\Sponsor;

$sponsor = new Sponsor();
$key = $_POST;
$incrementar = $sponsor->incrementViews(intval($key['anuncio']));
var_dump($incrementar);
