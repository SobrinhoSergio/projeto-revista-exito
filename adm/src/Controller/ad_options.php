<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
isSessionValid();

?>

<?php include(TEMPLATE_PATH . "/header.php"); ?>

<div class="container">
    <div class="content">
        <div class="ads-options">
        <div class="ads-img-subtitle"> Anúncio inserido com sucesso! Deseja personalizar o recorte da imagem?</div>
            <div class="ads-options-header <?= $_GET['type'] < 3 || $_GET['type'] == 15 ? 'ads-zoom-out' : ''; ?>">
            
                <img class="ads-img" src="<?=$_GET['path']?>" onerror="this.onerror=null;this.src='<?=dirname('../materia.php').'/img/anuncios/'.$_GET['dir'].$_GET['img']?>';" alt="anuncio">
            </div>

            <div class="ads-options-body">

                <a href="ads-auto-crop.php?id=<?=$_GET['id']?>&img=<?=$_GET['img']?>&dir=<?=$_GET['dir']?>&w=<?=$_GET['w']?>&h=<?=$_GET['h']?>"><button class="ad-option">Recortar automaticamente</button></a>
                <a href="ads-cropper_controller.php"><button class="ad-option">Personalizar recorte</button></a>

            </div>
        </div>
    </div>
</div>
<?php include(TEMPLATE_PATH . "/footer.php"); ?>