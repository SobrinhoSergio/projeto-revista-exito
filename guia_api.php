<?php use Friweb\CMS\Model\Partner; ?>

<?php if ($_POST['category_partner']): ?>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>

    <?php include_once("adm/src/Model/Database.php"); ?>
    <?php include_once("adm/src/Model/Image.php"); ?>
    <?php include_once("adm/src/Model/Model.php"); ?>
    <?php include_once("adm/src/Model/Partner.php"); ?>

    <?php
    $partner = new Partner();
    $partners = $partner->getPartners(intval($_POST['category_partner']));
    ?>

    <?php while ($parceiros = $partners->fetch_assoc()): ?>
        <div class="guia-card-wrapper">
            <div class="guia-card">
                <a data-lightbox="mygallery" data-title="<?=$parceiros['nome_empresa']?>" href="img/guia/originais/<?=$parceiros['imagem_guia']?>"><img src="img/guia/thumbs/<?=$parceiros['imagem_guia']?>" alt="guia"></a>
            </div>
        </div>
    <?php endwhile ?>


<?php endif ?>
