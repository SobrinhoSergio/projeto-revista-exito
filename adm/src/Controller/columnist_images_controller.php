<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Friweb\CMS\Model\Columnist;

session_start();
isSessionValid();

if ($_POST['image']) {

    $newColumnist = new Columnist($_POST);

    $tmp_path = $newColumnist->moveImage('colunistas/');

    $primaryKeyArray = $newColumnist->insertColumnist();
    
    $key = $primaryKeyArray[0]['chave_colunista'];

    $path = $newColumnist->renameImg($key, $tmp_path, $_POST['ext'], '');
    $newColumnist->insertImageLink($path, $key);
}
?>

<script>
    console.log('<?= $_POST['name'] ?>');
</script>

<?php

loadView('columnist_image');