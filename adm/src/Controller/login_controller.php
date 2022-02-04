<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Friweb\CMS\Model\Login;
use Friweb\CMS\Model\Database;
use Friweb\CMS\AppException\AppException;

session_start();

$exception = null;

if(count($_POST) > 0) {

    $login = new Login($_POST);

    try {
        $user = $login->checkLogin();
        $_SESSION['id'] = $user->chave_usuario;
        $_SESSION['name'] = $user->nome_usuario;
        $_SESSION['password'] = $user->senha_usuario;
        $_SESSION['type_user'] = $user->tipo_usuario;

        Database::getResultFromQuery("UPDATE tabela_guia SET publicar = 0 WHERE vencimento_guia < CURRENT_DATE()");
        Database::getResultFromQuery("UPDATE tabela_anuncios SET publicar = 0 WHERE vencimento_anuncio < CURRENT_DATE()");
        Database::getResultFromQuery("UPDATE tabela_materias SET publicar = 0 WHERE validade_materia < CURRENT_DATE()");

        header("Location: cms_controller.php");

    } catch (AppException $e) {
        $exception = $e;
    }
}

loadView('login', $_POST + ['AppException' => $exception]);