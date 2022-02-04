<?php use Friweb\CMS\Model\CategoryPartner;
use Friweb\CMS\Model\Partner;

error_reporting(0);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL); ?>


<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Partner.php"); ?>
<?php include_once("adm/src/Model/CategoryPartner.php"); ?>

<?php

$partner = new Partner();
$partners = $partner->getPartners(1);


$categories = new CategoryPartner();
$category = $categories->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);

?>

<link rel="stylesheet" type="text/css" href="assets/css/lightbox.min.css">
<?php include("header.php"); ?>



<div class="container">
    <div class="content">

        <div class="guia">
            <div class="guia-header">

                <div class="guia-intro">Guia Empresarial</div>
                <div class="guia-selection">
                    <label for="partner_category" class="guia-label">Opções</label>
                    <select name="category" id="partner_category" class="guia-select">
                        <?php while ($categorias = $category->fetch_assoc()): ?>
                            <option value="<?=$categorias['chave_categoria']?>"><?= $categorias['nome_categoria']?></option>
                        <?php endwhile ?>
                    </select>
                </div>

            </div>

            <div class="guia-main">
                <div class="guia-main-category"> </div>

                <div class="guia-main-cards">
                    <?php while ($parceiros = $partners->fetch_assoc()): ?>
                        <div class="guia-card-wrapper">
                            <div class="guia-card">
                            <a data-lightbox="mygallery" data-title="<?=$parceiros['nome_empresa']?>" href="img/guia/originais/<?=$parceiros['imagem_guia']?>"><img src="img/guia/thumbs/<?=$parceiros['imagem_guia']?>" alt="guia"></a>
                            </div>
                        </div>
                    <?php endwhile ?>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    document.title = "Produtos e Serviços";
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/lightbox-plus-jquery.min.js"></script>

<script>
    $(document).ready(function() {
       var categoria = $("select option:selected").text();
       $('.guia-main-category').html(categoria);
    });

    $("#partner_category").change(function(){

        $.post("guia_api.php", {
            category_partner : $("select option:selected").val()
        }, function(msg) {
            $(".guia-main-cards").html(msg);
            $('.guia-main-category').html($("select option:selected").text());
        })

    });

</script>

<?php include("footer.php"); ?>
