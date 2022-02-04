<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php include_once("adm/src/Model/Video.php"); ?>
<?php include_once("adm/src/Model/Sponsor.php"); ?>
<?php include_once("adm/src/Model/User.php"); ?>
<?php include_once("adm/src/Model/Columnist.php"); ?>
<?php

use Friweb\CMS\Model\Post; ?>
<?php

use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Video;
use Friweb\CMS\Model\User;
use Friweb\CMS\Model\Columnist;
?>

<?php error_reporting(0); ?>

<?php include("header.php"); ?>


<?php

// colunstas
$columnist = new Columnist();

$post = new Post();

$result = $post->getResultFromSelect(['chave_materia' => $_GET['post_id'], 'ativo' => 1, 'publicar' => 1]);

$related = $post->getPaginator('', '', '*', 'DESC', '1');

$video = new Video();
$videos = $video->getPaginator(1, '', '*', 'DESC', 1);
$videos_recentes = $video->getVideobyDate(2, []);

$sponsor = new Sponsor();

$random_post  = $post->getRandom(8, []);
// anúncios
//$banner = $sponsor->getPaginator('', '', '*', 'DESC', 1, ['tipo_anuncio' => 2]);
$banner = $sponsor->getRandom(4, ['tipo_anuncio' => 2]);

// apenas 1
$modal = $sponsor->getRandom(1, ['tipo_anuncio' => 8]);

/* mostrados mais de 1 anúncio de uma vez */
//anuncios do tipo card (retangulo)
//    $cardRealEstate = $sponsor->getResultFromSelect([], '*', ['tipo_anuncio' => 6]);
$cardRealEstate = $sponsor->getRandom(4, ['tipo_anuncio' => 6]);

//anuncio card matéria jornalística
//    $cardNews = $sponsor->getResultFromSelect([], '*', ['tipo_anuncio' => 5]);
$cardNews = $sponsor->getRandom(4, ['tipo_anuncio' => 5]);


$card = $sponsor->getResultFromSelect(['tipo_anuncio' => 5]);

//$banner = $sponsor->getRandom(4, ['tipo_anuncio' => 1]);

// materias especiais (últimas inseridas)
$stay_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 1]);
$eat_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 2]);
$visit_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 3]);
$shop_special = $post->getPaginator(1, '', '*', 'DESC', '1', ['categoria_especial_materia' => 4]);

// anuncio logos imóveis
$logos = $sponsor->getResultFromSelect(['tipo_anuncio' => 10, 'ativo' => 1, 'publicar' => 1], '*');
$logos2 = $sponsor->getResultFromSelect(['tipo_anuncio' => 10, 'ativo' => 1, 'publicar' => 1], '*');

$logosOverflow = $sponsor->getResultFromSelect(['tipo_anuncio' => 10, 'ativo' => 1, 'publicar' => 1], '*');
$logosOverflow2 = $sponsor->getResultFromSelect(['tipo_anuncio' => 10, 'ativo' => 1, 'publicar' => 1], '*');

//$logos = $sponsor->getRandom(4, ['tipo_anuncio' => 10, 'publicar' => 1, 'ativo' => 1]);

$user = new User();


// incrementa 1 visualização no post
$post->incrementViews($_GET['post_id']);

$date = new DateTime('now');
$currentDate = $date->format('Y-m-d');

?>

<style>
    .texto,
    .texto *,
    .intro,
    .intro * {
        width: 100% !important;
        /*margin: auto !important;*/
        background: white !important;
        line-height: initial !important;
        margin-left: auto !important;
        margin-right: auto !important;
        color: #0f0f0f !important;
    }

    .texto,
    .texto * {
        text-align: left !important;
        font-size: max(20px, 20px) !important;
    }

    .intro,
    .intro * {
        text-align: center !important;
        font-size: max(17px, 17px) !important;
    }

    .texto a {
        white-space: pre !important;
        white-space: pre-wrap !important;
        white-space: pre-line !important;
        white-space: -pre-wrap !important;
        white-space: -o-pre-wrap !important;
        white-space: -moz-pre-wrap !important;
        white-space: -hp-pre-wrap !important;
        word-wrap: break-word !important;
        word-break: break-all;
    }

    .texto .texto-materia>p,
    .texto .texto-materia>span,
    .intro *,
    .texto .texto-materia>font,
    .texto a {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .texto img {
        padding-top: 1em !important;
        width: 100% !important;
    }

    /*.sponsors-slide img {
        max-width: 50% !important;
        padding: 0 5px 0 5px !important;
    }*/

    .especiais-title{
        text-align: left !important;
    }

</style>

<?php while ($fields = $result->fetch_assoc()) : ?>

    <script>
        document.head.innerHTML += ` <meta property="og:image" itemprop="image" content="img/posts/thumbs/<?php echo $fields['chave_materia']; ?>.png"/>  
<meta property="og:title" content="<?= $fields['titulo_materia'] ?>"/>  
<meta property="og:description" content="<?= $fields['introducao_materia'] ?>"/>  
<meta property="og:type" content="website" />
<meta property="og:url" content="http://exitorio.com.br<?= $_SERVER['REQUEST_URI'] ?>">`;
    </script>


    <?php
    // modal apenas em matérias imóveis
    if ($fields['tipo_materia'] == 3 && $modal) : ?>
        <link rel="stylesheet" href="assets/css/modal.css">
    <?php endif ?>


    <div class="container">
        <div class="content" style="width: 100%;">

            <?php if ($banner->num_rows > 0 && ($fields['tipo_materia'] != 2 && $fields['tipo_materia'] != 3)) : ?>
                <div class="propaganda-banner propaganda-banner-2">
                    <div class="legenda-sponsors" style="font-size: .8em; text-align: center; color: #404051;">
                        Publicidade
                    </div>

                    <div class="propaganda-banner-img">
                        <?php while ($bannerHome = $banner->fetch_assoc()) : ?>
                            <div class="slideBanner" style="text-align: center; display: flex; justify-content: center;">
                                <?php if ($bannerHome['vencimento_anuncio'] > $currentDate) : ?>
                                    <img class="ads-img" src=".<?= $bannerHome['imagem_anuncio'] ?>" alt="<?= $bannerHome['descricao_anuncio'] ?>" onclick="window.open('<?= $bannerHome['link_anuncio'] ?>', '_blank')" style="cursor:pointer;">
                                <?php endif ?>
                            </div>
                        <?php endwhile ?>
                    </div>
                </div>

                <script>
                    var indexBanner = 0;
                    sponsorBanner();

                    function sponsorBanner() {
                        let j;
                        let bannerSlides = document.getElementsByClassName("slideBanner");
                        for (j = 0; j < bannerSlides.length; j++) {
                            bannerSlides[j].style.display = "none";
                        }
                        indexBanner++;
                        if (indexBanner > bannerSlides.length) {
                            indexBanner = 1
                        }
                        bannerSlides[indexBanner - 1].style.display = "grid";
                        setTimeout(sponsorBanner, 1000);
                    }
                </script>
            <?php endif ?>


            <!-- card colunista -->
            <?php if ($fields['tipo_materia'] == 4) : ?>

                <?php
                $columnists = $columnist->getResultFromSelect(['ativo' => 1, 'publicar' => 1, 'chave_colunista' => $fields['coluna_materia']]);
                ?>

                <?php while ($colunista = $columnists->fetch_assoc()) : ?>
                    <?php $columnWriter = $colunista['nome_colunista']; ?>
                    <div class="service-card colunista-card">
                        <img class="service-card-img colunista-card-img" src=".<?= $colunista['foto_colunista'] ?>" alt="<?= $colunista['nome_colunista'] ?>">
                        <div class="service-card-body colunista-card-body">
                            <div class="service-card-title colunista-card-title" style="text-transform:uppercase;"><?= $colunista['nome_colunista'] ?></div>

                            <div class="service-card-description colunista-card-description">
                                <div class="colunista-card-subtitulo">
                                    <?= $colunista['bio_colunista'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile ?>
            <?php endif ?>



            <div class="especiais-info">
                <!-- autor -->
                <p>Por:
                    <?php if ($fields['tipo_materia'] == 4) : ?>
                        <?= $columnWriter ?>
                    <?php else : ?>
                        <?= $fields['autor_materia'] ?>
                    <?php endif ?>
                </p>

                <?php
                // separa data do horário, e substitui '-' na data por '/'
                $post_date = explode(" ", $fields['data_materia'], 2);
                $data = str_replace("-", "/", $post_date[0]);
                $horario = $post_date[1];
                ?>
                <!-- data -->
                <p><?= $data ?></p>
                <!-- horário -->
                <p><?= $horario ?></p>

                <!-- botao compartilhar -->
                <div class="share-p">
                    <i class="fa fa-share-alt share-icon"></i>
                </div>

            </div>

            <!-- modal compartilhar -->
            <div class="share-desktop">
                <?php include("share.php"); ?>
            </div>

            <div class="especiais-title titulo-padrao">
                <h3 id="tituloPagina"> <?= $fields['titulo_materia'] ?> </h3>

                <?php if ($fields['subtitulo_materia'] != "") : ?>
                    <div class="subtitulo">
                        <?= $fields['subtitulo_materia'] ?>
                    </div>
                <?php endif ?>

            </div>



            <!-- foto capa -->
            <div class="especiais-img-full mobile-img-width">
                <img src="img/posts/fotos/<?php echo $fields['chave_materia']; ?>.png" alt="<?= $fields['titulo_materia'] ?>">
            </div>


            <div class="especiais-text">

                <div class="especiais-text-paragraph" style="max-width: 100% !important;">

                    <!-- introdução da matéria -->
                    <div class="intro">
                        <div class="especiais-intro">

                            <?= $fields['introducao_materia'] ?>

                        </div>
                    </div>

                    <!-- carrossel de logos -->
                    <?php if ($fields['tipo_materia'] == 3 && $logos->num_rows > 0) : ?>
                        <div style="display: grid; margin-top: 1em;">
                            <div class="sponsors">
                                <h3 class="titulo-padrao">Seu imóvel dos sonhos pode estar aqui</h3>
                                <div class="sponsors-wrapper" style="width: 100%;">
                                    <div class="sponsors-slider">
                                        <div class="sponsors-slide">
                                            <?php while ($logoImoveis = $logos->fetch_assoc()) : ?>
                                                <?php if ($logoImoveis['vencimento_anuncio'] > $currentDate) : ?>
                                                    <img id="anuncio_slide" value="<?= $logoImoveis['chave_anuncio'] ?>" src=".<?= $logoImoveis['imagem_anuncio'] ?>" onclick="window.open('<?= $logoImoveis['link_anuncio'] ?>', '_blank');validation_slide(<?= $logoImoveis['chave_anuncio'] ?>)" style=" cursor:pointer;">
                                                <?php endif ?>
                                            <?php endwhile ?>
                                        </div>
                                        <!--<div class="sponsors-slide">
                                            <?php /*while ($logoImoveisOverflow = $logosOverflow->fetch_assoc()) : ?>
                                                <?php if ($logoImoveisOverflow['vencimento_anuncio'] > $currentDate) : ?>
                                                    <img id="anuncio_slide" value="<?= $logoImoveisOverflow['chave_anuncio']  ?>" src=".<?= $logoImoveisOverflow['imagem_anuncio'] ?>" onclick="window.open('<?= $logoImoveisOverflow['link_anuncio'] ?>', '_blank');validation_slide(<?= $logoImoveisOverflow['chave_anuncio'] ?>)" style="cursor:pointer;">
                                                <?php endif ?>
                                            <?php endwhile*/ ?>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <script type="text/javascript" language="JavaScript">
                        // var anuncio = document.getElementById("anuncio").getAttribute("value");
                        // console.log(anuncio);
                        function validation_slide(chave) {
                            console.log(chave);
                            increment(chave);
                        }

                        function increment(valor) {
                            var dados = {
                                anuncio: valor
                            };
                            $.ajax({
                                type: 'POST',
                                dataType: 'html',
                                url: 'increment.php',
                                data: dados,
                                success: function(result) {
                                    console.log(dados, result);
                                }
                            });
                        }
                    </script>
                    <!-- texto -->
                    <div class="texto">
                        <div class="texto-materia">
                            <?= $fields['texto_materia'] ?>
                        </div>
                    </div>

                    <!-- card de serviço -->
                    <?php if ($fields['servico_materia'] != "") : ?>
                        <div class="service-card">
                            <?php if ($fields['imagem_servico_materia'] != "") : ?>
                                <img class="service-card-img" src=".<?php echo $fields['imagem_servico_materia']; ?>">
                            <?php endif ?>
                            <div class="service-card-body">
                                <div class="service-card-title">SERVIÇO</div>
                                <div class="service-card-description card-servico-especial">
                                    <?= $fields['servico_materia'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                    <!-- Carroussel de logos again -->
                    <!-- Funcionando -->

                    <?php if ($fields['tipo_materia'] == 3 && $logos2->num_rows > 0) : ?>
                        <?php include('anuncio_listagem_imoveis.php') ?>
                    <?php endif ?>

                    <?php if ($fields['tipo_materia'] != 3) : ?>
                        <?php include('anuncio_listagem2.php') ?>
                    <?php else : ?>


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
                                if (sIndex > sSlides.length) {
                                    sIndex = 1
                                }
                                sSlides[sIndex - 1].style.display = "grid";
                                setTimeout(sponsorCarousel, 3000); // Change image every 4 seconds
                            }
                        </script>

                    <?php endif ?>

                    <style>
                        .card-servico-especial *,
                        .card-servico-especial {
                            background-color: white !important;
                            font-size: 0.96em !important;
                            color: #0f0f0f !important;
                        }
                    </style>


                    <!-- compartilhar mobile -->
                    <div class="share-mobile">
                        <?php include("share.php"); ?>
                    </div>
                </div>



            </div>


        <!-- outras matérias/vídeos -->
        <div class="news-extras extras-block" style="border-top: 2px solid rgba(0,0,0,0.3); padding-top: 20px; width: 100%; clear:both;">

            <div class="noticias-relacionadas-header">Relacionadas</div>
            <?php $counter = 0 ?>
            <?php while ($relatedPosts = $related->fetch_assoc()) : ?>
                <?php if ($fields['tipo_materia'] == 2) : ?>
                    <?php if (($relatedPosts['categoria_especial_materia'] == $fields['categoria_especial_materia']) && $counter < 6 && $relatedPosts['chave_materia'] != $fields['chave_materia']) : ?>
                        <a href="materia.php?post_id=<?= $relatedPosts['chave_materia'] ?>" style="text-decoration: none; color: inherit;">

                            <div name="<?= $relatedPosts['categoria_especial_materia'] ?> + <?= $fields['categoria_especial_materia'] ?>" class="news-card-extra" onclick="window.location.href='materia.php?post_id=<?= $relatedPosts['chave_materia'] ?>'">
                                <div class="news-card-extra-subject titulo-padrao">
                                    <h3> <?= $relatedPosts['tema_materia'] ?> </h3>
                                </div>
                                <img class="news-card-extra-img" src="img/posts/thumbs/<?php echo $relatedPosts['chave_materia']; ?>.png" alt="<?= $relatedPosts['titulo_materia'] ?>">

                                <div class="news-card-extra-title">
                                    <h3>
                                        <?php if (strlen($relatedPosts['titulo_materia']) <= 45) : ?>
                                            <?= $relatedPosts['titulo_materia'] ?>
                                        <?php else : ?>
                                            <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($relatedPosts['titulo_materia']), 0, 45)) ?> (...)
                                        <?php endif ?>
                                    </h3>
                                </div>
                            </div>
                            <?php $counter++; ?>
                        </a>
                    <?php endif ?>
                <?php elseif ($fields['tipo_materia'] != 2 ) : ?>
                    <?php if (($relatedPosts['tipo_materia'] == $fields['tipo_materia']) && $counter < 6 && $relatedPosts['chave_materia'] != $fields['chave_materia']) : ?>
                        <a href="materia.php?post_id=<?= $relatedPosts['chave_materia'] ?>" style="text-decoration: none; color: inherit;">
                            <div name="<?= $relatedPosts['tipo_materia'] ?> + <?= $fields['tipo_materia'] ?>" class="news-card-extra" onclick="window.location.href='materia.php?post_id=<?= $relatedPosts['chave_materia'] ?>'">
                                <div class="news-card-extra-subject titulo-padrao">
                                    <h3> <?= $relatedPosts['tema_materia'] ?> </h3>
                                </div>
                                <img class="news-card-extra-img" src="img/posts/thumbs/<?php echo $relatedPosts['chave_materia']; ?>.png" alt="<?= $relatedPosts['titulo_materia'] ?>">
                                <div class="news-card-extra-title">
                                    <h3>
                                        <?php if (strlen($relatedPosts['titulo_materia']) <= 45) : ?>
                                            <?= $relatedPosts['titulo_materia'] ?>
                                        <?php else : ?>
                                            <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($relatedPosts['titulo_materia']), 0, 45)) ?> (...)
                                        <?php endif ?>
                                    </h3>
                                </div>
                            </div>
                            <?php $counter++ ?>
                        </a>
                    <?php endif ?>
                <?php endif ?>
            <?php endwhile ?>
        </div>


            <div class="flex-button">
                <button onclick="window.location.href='materias.php?page=1'">Ver mais </button>
            </div>

        <div class="videos-content padding-bottom-2" style="margin-top: 40px">
            <?php
            // contador para definir card da esquerda e direita
            $i = 0; ?>

            <?php while ($relatedVideos = $videos_recentes->fetch_assoc()) : ?>
                <!-- <a href="video.php?video_id=<?= $relatedVideos['chave_video'] ?>" style="text-decoration: none; color: inherit;"> -->


                <?php
                // pega id do vídeo para usar na thumbnail
                $match = preg_match(
                    '/^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/',
                    $relatedVideos['link_video'],
                    $matches,
                    PREG_OFFSET_CAPTURE
                );
                $video_id = $matches[2][0];
                ?>

                <?php if ($i == 0) : ?>

                    <!-- card da esquerda -->
                    <div class="video-card" onclick="window.location.href='video.php?video_id=<?= $relatedVideos['chave_video'] ?>'" style="cursor:pointer;">
                    <?php else : ?>
                        <!-- card da direita -->
                        <div class="video-card padding-bottom-2" onclick="window.location.href='video.php?video_id=<?= $relatedVideos['chave_video'] ?>'" style="cursor:pointer;">
                        <?php endif ?>

                        <div class="video-card-subject titulo-padrao">
                            <h3><?= $relatedVideos['tema_video'] ?></h3>
                        </div>

                        <a class="video-card-img" href="video.php?video_id=<?= $relatedVideos['chave_video'] ?>" style="text-decoration: none; color: inherit;">
                            <img style="width: 100%;" src="https://img.youtube.com/vi/<?= $video_id ?>/sddefault.jpg" alt="<?= $relatedVideos['titulo_video'] ?>">
                        </a>

                        <!--                            <a class="playbutton" href="#"></a>-->
                        <div class="video-card-body">
                            <div class="video-card-title">
                                <?= $relatedVideos['titulo_video'] ?>
                            </div>
                            <div class="video-card-description">
                                <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($relatedVideos['descricao_video']), 0, 200)) ?>...
                            </div>
                        </div>
                        </div>
                        </a>

                        <?php $i++ ?>
                        <!-- </a> -->
                    <?php endwhile ?>
                    <div class="flex-button padding-bottom-2"><a href="videos.php?page=1"><button>Ver mais vídeos</button></a></div>
                    </div>
        </div>
        </div>

        <?php
        // modal apenas em matérias imóveis
        if ($fields['tipo_materia'] == 3 && $modal->num_rows > 0) : ?>
            <div id="modal-promocao" class="modal-container">
                <div class="modal">
                    <button class="fechar">x</button>
                    <?php if ($modal->num_rows > 0) : ?>
                        <?php while ($modalImoveis = $modal->fetch_assoc()) : ?>
                            <?php if ($modalImoveis['vencimento_anuncio'] > $currentDate) : ?>
                                <img class="ads-img" src=".<?= $modalImoveis['imagem_anuncio'] ?>" alt="<?= $modalImoveis['descricao_anuncio'] ?>">
                            <?php endif ?>
                        <?php endwhile ?>
                    <?php endif ?>
                </div>
            </div>

            <script src="js/modal.js"></script>
        <?php endif ?>



    <?php endwhile ?>

    <?php include("footer.php"); ?>