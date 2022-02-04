<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use Friweb\CMS\AppException\AppException;
use Friweb\CMS\Model\Sponsor;

session_start();
isSessionValid();
if ($_SESSION['type_user'] != 1) { header("Location: cms_controller.php"); }

$exception = null;

// se o formulário estiver preenchido
if (isset($_POST['name'])) {

    // atribui o tipo de anúncio a POST
    $_POST['type'] = $_SESSION['type_sponsor'];

    // libera a var de sessão
    // unset($_SESSION['type_sponsor']);

    // instancia novo objeto
    $sponsor = new Sponsor($_POST);

    try {
        //insere dados no banco, retorna primary key onde nome na tabela = nome inserido no form
        $primaryKeySponsor = $sponsor->insertSponsor();

        // renomeia imagem temporária, passando primary key e caminho da imagem temporária
        $path = $sponsor->renameImg($primaryKeySponsor[0]['chave_anuncio'], $_SESSION['tmp_path'], 'png');

        // insere link da imagem no db
        $sponsor->insertImageLink($path, $primaryKeySponsor[0]['chave_anuncio']);

        // libera var de sessão
        // unset($_SESSION['tmp_path']);

        // redireciona a página inicial
        header("location: sponsors_list_controller.php");

    } catch (AppException $e) {
        $exception = $e;
    }
} else {
    $_SESSION['tmp_path'] = $_GET['tmp_path'];
}

loadView('sponsor_form', ['AppException' => $exception]);