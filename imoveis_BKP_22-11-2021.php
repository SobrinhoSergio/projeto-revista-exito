<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php include_once("adm/src/Model/Sponsor.php"); ?>
<?php use Friweb\CMS\Model\Post; ?>
<?php use Friweb\CMS\Model\Sponsor; ?>
<?php use Friweb\CMS\Model\Database; ?>

<?php
$link = 'imoveis.php';
$filtros = ['tipo_materia' => 3];
$post = $type = new Post();
include "paginacao_api.php";


// anúncios
$sponsor = new Sponsor();

//anuncio banner home
$banner = $sponsor->getPaginator('', '', '*', 'DESC', '1', ['tipo_anuncio' => 3]);

// anuncio card
$card = $sponsor->getRandom(4, ['tipo_anuncio' => 6, 'publicar' => 1, 'ativo' => 1]);

/* especiais */

$stay_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 1]);

$eat_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 2]);

$visit_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 3]);

$shop_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 4]);


/*  anuncios imóveis */ 
$realEstateAd = $sponsor->getRandom(4, ['tipo_anuncio' => 12]);
// $realEstateAd2 = $sponsor->getRandom(4, ['tipo_anuncio' => 12]);



//$logos = $sponsor->getRandom(7, ['tipo_anuncio' => 10, 'publicar' => 1, 'ativo' => 1]);

$logos = $sponsor->getResultFromSelect(['tipo_anuncio' => 10, 'ativo' => 1, 'publicar' => 1], '*');
$logosOverflow = $sponsor->getResultFromSelect(['tipo_anuncio' => 10, 'ativo' => 1, 'publicar' => 1], '*');

$date = new DateTime('now');
$currentDate = $date->format('Y-m-d');

?>

<style>
    
.highlight-card {
    grid-template-rows: 25px 300px 120px !important;
}

.highlight-card-body {
    grid-template-rows: 10px 150px !important;
}

</style>

<?php include("header.php"); ?>

<div class="container">
    <div class="content">
        <div class="propaganda-banner">
            <?php if ($logos->num_rows > 0): ?>
                <div style="display: grid;">
                    <div class="sponsors2">
                        <h3 class="titulo-padrao">O imóvel dos seus sonhos pode estar aqui!</h3>
                        <div class="sponsors-wrapper" style="width: 100%;">
                            <div class="sponsors-slider">
                                <div class="sponsors-slide">
                                    <?php while ($logoImoveis = $logos->fetch_assoc()): ?>
                                        <?php if ($logoImoveis['vencimento_anuncio'] > $currentDate): ?>
                                            <img data-anime="top" src=".<?=$logoImoveis['imagem_anuncio']?>" onclick="window.open('<?=$logoImoveis['link_anuncio']?>', '_blank')" style="cursor:pointer;">
                                        <?php endif ?>
                                    <?php endwhile ?>
                                </div>
                            <!--<div class="sponsors-slide">
                                    <?php /*while ($logoImoveisOverflow = $logosOverflow->fetch_assoc()): ?>
                                        <?php if ($logoImoveisOverflow['vencimento_anuncio'] > $currentDate): ?>
                                            <img src=".<?=$logoImoveisOverflow['imagem_anuncio']?>" onclick="window.open('<?=$logoImoveisOverflow['link_anuncio']?>', '_blank')" style="cursor:pointer;">
                                        <?php endif ?>
                                    <?php endwhile*/ ?>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <div class="news-list-container">
            <div class="news-list-main">
                <div class="news-list-content">

                    <?php while ($fields = $list->fetch_assoc()): ?>
                        
                        <a href="materia.php?post_id=<?=$fields['chave_materia']?>" style="text-decoration: none; color: inherit;">

                        <div class="news-list-card" onclick="window.location.href='materia.php?post_id=<?=$fields['chave_materia']?>'" style="cursor:pointer;">
                            <img class="news-list-card-img" src="img/posts/thumbs/<?=$fields['chave_materia']?>.png">
                            <div class="news-list-card-body">
                                <div class="news-list-card-subject titulo-padrao"> <?=$fields['tema_materia']?> </div>
                                <h4><?=$fields['titulo_materia']?></h4>
                                <br>
                                <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($fields['texto_materia']), 0, 222)) ?> (...)
                            </div>
                        </div>
                        </a>
                    <?php endwhile ?>

                    <!-- paginação -->
                    <?php include "paginacao.php"; ?>

                </div>
            </div>


            <div class="news-list-highlights">

                <div class="highlight-post"> <h3>Destaque</h3></div>

                <?php if ($realEstateAd->num_rows > 0): ?>
                    <?php while($imovelAd = $realEstateAd->fetch_assoc()): ?>
                        <?php if ($imovelAd['vencimento_anuncio'] > $currentDate): ?>
                            <div class="highlight-card slideSponsor" onclick="window.open('<?=$imovelAd['link_anuncio']?>', '_blank')">

                                <!--<div class="news-card-subject titulo-padrao">
                                    <h3>Imóveis</h3>
                                </div>-->

                                <div class="highlight-card-img-div">
                                    <img class="highlight-card-img" src=".<?=$imovelAd['imagem_anuncio']?>">
                                </div>

                                <div class="highlight-card-body">

                                    <!-- <div class="highlight-card-title">
                                        <h2 class="news-card-title"><?=$imovelAd['empresa_anuncio']?></h2>
                                    </div> -->

                                    <div class="highlight-card-description">
        <!--                                --><?//= substr(strip_tags($imovelAd['descricao_anuncio']), 0, 200) ?><!--(...)-->
                                        <?= substr($imovelAd['descricao_anuncio'], 0, 200) ?>...
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endwhile ?>
                <?php endif ?>

                <script>
                    var sIndex = 0;
                    sponsorCarousel();

                    function sponsorCarousel() {
                        let contador;
                        let sSlides = document.getElementsByClassName("slideSponsor");
                        for (contador = 0; contador < sSlides.length; contador++) {
                            sSlides[contador].style.display = "none";
                        }
                        sIndex++;
                        if (sIndex > sSlides.length) {sIndex = 1}
                        sSlides[sIndex-1].style.display = "grid";
                        setTimeout(sponsorCarousel, 2000); // Change image every 4 seconds
                    }
                </script>

                <div class="propaganda-listagem">
                    <?php if ($card->num_rows > 0): ?>
                        <div class="legenda-sponsors">
                            Publicidade
                        </div>
                        <?php while ($cardHome = $card->fetch_assoc()): ?>
                            <div class="slideCard" onclick="window.open('<?=$cardHome['link_anuncio']?>', '_blank')" style="cursor:pointer;">
                                <?php if($cardHome['vencimento_anuncio'] > $currentDate): ?>
                                    <img src=".<?=$cardHome['imagem_anuncio']?>">
                                <?php endif ?>
                            </div>
                        <?php endwhile ?>
                    <?php endif ?>
                </div>

                <script>
                    var indexCard = 0;
                   sponsorCard();

                    function sponsorCard() {
                        let j;
                        let cardSlides = document.getElementsByClassName("slideCard");
                        for (j = 0; j < cardSlides.length; j++) {
                            cardSlides[j].style.display = "none";
                        }
                        indexCard++;
                        if (indexCard > cardSlides.length) {indexCard = 1}
                        cardSlides[indexCard-1].style.display = "grid";
                        setTimeout(sponsorCard, 2000);
                    }
                </script>



                <?php
                    $random2 = "SELECT * FROM tabela_anuncios WHERE tipo_anuncio = 13 AND publicar = 1 AND ativo = 1 ORDER BY chave_anuncio LIMIT 4";
        
                    $realEstateAd2 = Database::getResultFromQuery($random2);
                ?>
                <?php if ($realEstateAd2->num_rows > 0): ?>
                    <div class="highlight-post" style="margin-top: 2em;"> <h3>Destaque</h3></div>

                    <?php while($imovelAd2 = $realEstateAd2->fetch_assoc()): ?>

                        <?php
                            
                            $used = array();

                            if($imovelAd2['vencimento_anuncio'] > $currentDate && !in_array($imovelAd2['chave_anuncio'], $used)): ?>
                            <div class="highlight-card slideSponsor2" onclick="window.open('<?=$imovelAd2['link_anuncio']?>', '_blank')">

                                <!--<div class="news-card-subject titulo-padrao">
                                    <h3>Imóveis</h3>
                                </div>-->

                                <div class="highlight-card-img-div">
                                    <img class="highlight-card-img" src=".<?=$imovelAd2['imagem_anuncio']?>">
                                </div>

                                <div class="highlight-card-body">

                                    <!-- <div class="highlight-card-title">
                                        <h2 class="news-card-title"><?=$imovelAd2['empresa_anuncio']?></h2>
                                    </div> -->

                                    <div class="highlight-card-description">
                                        <?= substr($imovelAd2['descricao_anuncio'], 0, 200) ?>...
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endwhile ?>
                <?php endif ?>

                <script>
                    var sIndex2 = 0;
                    sponsorCarousel2();

                    function sponsorCarousel2() {
                        let contador2;
                        let sSlides2 = document.getElementsByClassName("slideSponsor2");
                        for (contador2 = 0; contador2 < sSlides2.length; contador2++) {
                            sSlides2[contador2].style.display = "none";
                        }
                        sIndex2++;
                        if (sIndex2 > sSlides2.length) {sIndex2 = 1}
                        sSlides2[sIndex2-1].style.display = "grid";
                        setTimeout(sponsorCarousel2, 2000); // Change image every 4 seconds
                    }
                </script>


            </div>

        </div>

    </div>
</div>







<?php include("footer.php"); ?>
