<?php


session_start();
isSessionValid();

if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

loadView('signup', $_POST);
