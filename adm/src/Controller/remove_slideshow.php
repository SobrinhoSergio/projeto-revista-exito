<?php

session_start();
isSessionValid();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Database;

$sponsor = new Sponsor();

$sponsor->unpublish($_GET['sponsor_id']);

header("Location: posts_list_controller.php?page=1");