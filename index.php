<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php include_once("adm/src/Model/Video.php"); ?>
<?php include_once("adm/src/Model/Sponsor.php"); ?>
<?php include_once("adm/src/Model/User.php"); ?>
<?php

use Friweb\CMS\Model\Post; ?>
<?php

use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Video;

$date = new DateTime('now');
$currentDate = $date->format('Y-m-d');
?>

<?php error_reporting(0); ?>

<?php include("header.php"); ?>

<script>
    document.head.innerHTML += ` <meta property="og:image" itemprop="image" content="img/imagem_compartilhamento.png"/>  
<meta property="og:title" content="Êxito Rio - Revista Digital"/>  
<meta property="og:description" content="O portal da Serra&Mar"/>  
<meta property="og:type" content="website" />
<meta property="og:url" content="http://exitorio.com.br">`;
</script>



<link rel="stylesheet" href="assets/css/modal.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&display=swap" rel="stylesheet">

<?php

$filtros = ['tipo_materia' => 3];

$post = new Post();
$sponsor = new Sponsor();
$video = new Video();

//$a = $post->getPaginator(4, '', '*', 'DESC', '1', ['tipo_materia' => 3]);

// anúncios
$banner = $sponsor->getRandom(4, ['tipo_anuncio' => 1]);

$modal = $sponsor->getRandom(1, ['tipo_anuncio' => 7]);

$full = $sponsor->getRandom(4, ['tipo_anuncio' => 11]);

$logos = $sponsor->getResultFromSelect(['tipo_anuncio' => 9, 'publicar' => 1, 'ativo' => 1], '*');
$logosOverflow = $sponsor->getResultFromSelect(['tipo_anuncio' => 9, 'publicar' => 1, 'ativo' => 1], '*');

// slideshow
//    $amps = $post->getPaginator(4, '', '*', 'DESC', 1);
$amps = $sponsor->getRandom(4, ['tipo_anuncio' => 15]);

// posts
$posts = $post->getPostsByDate();

//$real_estate = $post->getResultFromSelect(['tipo_materia' => 1, 'publicar' => 1, 'ativo' => 1], '*', 'DESC', 1);

// especiais (turismo)
$tourism = $post->getPostsByDate(['tipo_materia' => 2]);

// vídeos
$videos = $video->getPaginator(1, '', '*', 'DESC', 1);
$videos_recentes = $video->getVideobyDate(2, []);

$list = $sponsor->getRandom(4, ['tipo_anuncio' => 2]);

//Pegar a última publicação de imóveis

$real_estate = $post->getPostsByDate(['tipo_materia' => 3]);
?>

<!-- modal -->
<?php if ($modal->num_rows > 0) : ?>
    <div id="modal-promocao" class="modal-container">
        <div class="modal">
            <button class="fechar">x</button>
            <?php while ($modalHome = $modal->fetch_assoc()) : ?>
                <?php if ($modalHome['vencimento_anuncio'] > $currentDate) : ?>
                    <img class="ads-img" src=".<?= $modalHome['imagem_anuncio'] ?>" alt="<?= $modalHome['descricao_anuncio'] ?>">
                <?php endif ?>
            <?php endwhile ?>
        </div>
    </div>
<?php endif ?>

<script src="js/modal.js"></script>


<!-- banner slideshow -->
<section class="banner-carousel">
    <div class="slideshow-container">
        <?php if ($amps->num_rows > 0) : ?>
            <?php $displayed = [];
            $i = 0; ?>
            <?php while ($amp = $amps->fetch_assoc()) : ?>
                <a href="<?= $amp['link_anuncio'] ?>" style="text-decoration: none; color: inherit;">

                    <div class="mySlides fade" id="anuncio" onclick="validation_slide(<?= $amp['chave_anuncio'] ?>);" style="cursor:pointer;">
                        <div class="fadeout">
                            <img src=".<?= $amp['imagem_anuncio'] ?>" alt="<?= $amp['descricao_anuncio'] ?>">
                            <div class="after"></div>
                            <div class="text" style="letter-spacing: .05em; text-transform: uppercase; display: flex; flex-direction: column; line-height: 1.5em;">
                                <?= substr(strip_tags($amp['descricao_anuncio']), 0, 50) ?>
                                <?php if (strlen($amp['descricao_anuncio']) >= 50) : ?>
                                    (...)
                                <?php endif ?>
                                <button type="button" class="btn-anuncio-home" onclick="window.open('<?= $amp['link_anuncio'] ?>', '_self');validation()">Saiba mais</button>
                            </div>
                        </div>
                    </div>
                    <?php $displayed[$i] = $amp['descricao_anuncio'];
                    $i++; ?>
                </a>
            <?php endwhile ?>
        <?php endif ?>

        <a class="prev" id="previous" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" id="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <script>
        function validation_slide(chave) {
            //console.log(chave);
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
                    //console.log(dados, result);
                    window.open("<?= $amp['link_anuncio'] ?>");
                }
            });
        }
    </script>
    <br>

    <div>
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>

</section>
<!-- main -->
<main>

    <!-- <div class="flex-container"> -->
    <div class="container container-home">
        <!-- anuncio -->
        <?php if ($banner->num_rows > 0) : ?>
            <div class=" propaganda-banner propaganda-banner-2 propaganda-banner-home">
                <div class="legenda-sponsors" style="font-size: .8em; text-align: center; color: #404051;">
                    Publicidade
                </div>

                <div class="propaganda-banner-img">
                    <?php while ($bannerHome = $banner->fetch_assoc()) : ?>
                        <a style="text-decoration: none; color: inherit;">

                            <div class="slideBanner" onclick="validation(<?= $bannerHome['chave_anuncio'] ?>)" style="text-align: center; display: flex; justify-content: center;">
                                <?php if ($bannerHome['vencimento_anuncio'] > $currentDate) : ?>
                                    <img  onclick="window.open('<?= $bannerHome['link_anuncio'] ?>', '_blank');validation()"class="ads-img" src=".<?= $bannerHome['imagem_anuncio'] ?>" style="cursor:pointer;" alt="<?= $bannerHome['descricao_anuncio'] ?>">
                                <?php endif ?>
                            </div>
                        </a>
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
                    setTimeout(sponsorBanner, 3000);
                }

                function validation(chave) {
                    //console.log(chave);
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
                            //console.log(dados, result);
                            window.open("<?= $bannerHome['link_anuncio'] ?>");
                        }
                    });
                }
            </script>
        <?php endif ?>


        <!-- news -->
        <section class="news">
            <!-- main news -->
            <div class="news-content">

                <?php if ($posts->num_rows > 0) : ?>
                    <?php $i = 0; ?>
                    <?php $c = 0; ?>

                    <?php while ($post_home = $posts->fetch_assoc()) : ?>

                        <?php if (
                            $i <= 3 && $post_home['tipo_materia'] != 2 && $post_home['tipo_materia'] != 3 &&
                            ($post_home['titulo_materia'] != $displayed[0] && $post_home['titulo_materia'] != $displayed[1] &&
                                $post_home['titulo_materia'] != $displayed[2]  && $post_home['titulo_materia'] != $displayed[3])
                        ) : ?>

                            <a href="materia.php?post_id=<?= $post_home['chave_materia'] ?>" style="text-decoration: none; color: inherit; margin-top: 30px;">


                                <div class="news-card <?php if ($i == 3) {
                                                            echo 'last-news-card';
                                                        } ?>" onclick="window.location.href='materia.php?post_id=<?= $post_home['chave_materia'] ?>'">
                                    <div class="news-card-subject titulo-padrao">
                                        <h3> <?= $post_home['tema_materia'] ?> </h3>
                                    </div>
                                    <img class="news-card-img" src="img/posts/thumbs/<?= $post_home['chave_materia'] ?>.png" alt="<?= $post_home['titulo_materia'] ?>">
                                    <div class="news-card-body">
                                        <div class="news-card-header">
                                            <h2 class="news-card-title"><?= $post_home['titulo_materia'] ?></h2>
                                        </div>
                                        <div class="news-card-description">
                                            <!--                                                        -->
                                            <? //=substr(strip_tags($post_home['texto_materia']), 0, 190)
                                            ?>
                                            <!-- (...)-->
                                            <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post_home['introducao_materia']), 0, 192)) ?>...
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <?php if ($i == 3) : ?>
                                <div class="imoveis-content">
                                    <!--                                                        <div style="height: 1.48em;"></div>-->
                                <?php endif ?>

                                <?php $i++; ?>
                            <?php endif ?>

                            <?php if ($c == 0 && $i == 4) : ?>
                                <!--                                                --><?php //while($card_imovel = $real_estate->fetch_assoc()): 
                                                                                        ?> 

                                <?php ($card_imovel = $real_estate->fetch_assoc()) ?>
                                
                                <a href="materia.php?post_id=<?= $card_imovel['chave_materia'] ?>" style="text-decoration: none; color: inherit;">
                                    <h3 class="canal-imoveis">CANAL DE IMÓVEIS</h3>
                                    <div class="imoveis-card"  onclick="window.location.href='materia.php?post_id=<?= $card_imovel['chave_materia'] ?>'">
                                        <div class="imoveis-card-header">
                                            <img class="imoveis-card-img" src="img/posts/thumbs/<?= $card_imovel['chave_materia'] ?>.png" alt="Veja imóveis na Êxito Rio">
                                        </div>
                                        <div class="imoveis-card-body">
                                            <div class="imoveis-card-title titulo-padrao" style="font-size: 1.1rem;">
                                                <div class="imoveis-card-subject titulo-padrao"><?= $card_imovel['titulo_materia'] ?></div>
                                            </div>

                                            <div class="imoveis-card-description" style="font-size: 1.0rem; ">
                                                <?= $card_imovel['subtitulo_materia'] ?>
                                            </div>

                                            <div class="imobiliaria" style="display: flex; justify-content: flex-end;">
                                                <!--                                                                Oferecido por: <h3>-->
                                                <? //= $card_imovel['empresa_anuncio'] 
                                                ?>
                                                <!--</h3>-->
                                                <a class="link-imobiliaria" href="imoveis.php?page=1">
                                                   <!-- <h4>Veja aqui</h4>-->
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                            </a>                             
                                <?php $c++; ?>
                                <!--                                                --><?php //endwhile 
                                                                                        ?>
                                <?php
                                $i++;
                                $im = 1;
                                ?>
                            <?php endif ?>

                            <?php if (
                                $i > 4 && $i <= 6 && $post_home['tipo_materia'] != 2 && $im != 1 &&  $post_home['tipo_materia'] != 3 &&
                                ($post_home['titulo_materia'] != $displayed[0] && $post_home['titulo_materia'] != $displayed[1] &&
                                    $post_home['titulo_materia'] != $displayed[2]  && $post_home['titulo_materia'] != $displayed[3])
                            ) : ?>

                                <a href="materia.php?post_id=<?= $post_home['chave_materia'] ?>" style="text-decoration: none; color: inherit;">

                                    <div class="news-card-extra <?php if ($i == 6) {
                                                                    echo 'last-news-card-extra';
                                                                } ?>" style="margin-top: 1em;" onclick="window.location.href='materia.php?post_id=<?= $post_home['chave_materia'] ?>'">

                                        <div class="news-card-extra-subject titulo-padrao">
                                            <h3><?= $post_home['tema_materia'] ?></h3>
                                        </div>
                                        <img class="news-card-extra-img" src="img/posts/thumbs/<?= $post_home['chave_materia'] ?>.png" alt="<?= $post_home['titulo_materia'] ?>">

                                        <div class="news-card-extra-title" style="display:inline">
                                            <?php if (strlen($post_home['titulo_materia']) <= 45) : ?>
                                                <p style="font-weight:bold;">
                                                    <?= $post_home['titulo_materia'] ?>
                                                </p>
                                            <?php else : ?>
                                                <p style="font-weight:bold">
                                                    <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post_home['titulo_materia']), 0, 45)) ?>...
                                                </p>
                                            <?php endif ?>
                                            <!--                                                        -->
                                            <? //=substr(strip_tags($post_home['texto_materia']), 0, 40)
                                            ?>
                                            <!-- (...)-->
                                            <p">
                                                <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post_home['introducao_materia']), 0, 51)) ?>...
                                                </p>
                                        </div>
                                    </div>
                                </a>

                                <?php if ($i == 6) : ?>
                                    <!-- news-content -->
                                </div>
                                <!-- imoveis-content -->
            </div>
            <div class="news-extras">
                <?php $ex = 1; ?>
            <?php endif ?>

            <?php $i++; ?>
        <?php endif ?>


        <?php if (
                            $i > 6 && $i <= 12 && $post_home['tipo_materia'] != 2 && $ex != 1 &&  $post_home['tipo_materia'] != 3 &&
                            ($post_home['titulo_materia'] != $displayed[0] && $post_home['titulo_materia'] != $displayed[1] &&
                                $post_home['titulo_materia'] != $displayed[2]  && $post_home['titulo_materia'] != $displayed[3])
                        ) : ?>

            <a href="materia.php?post_id=<?= $post_home['chave_materia'] ?>" style="text-decoration: none; color: inherit;">

                <div class="news-card-extra" onclick="window.location.href='materia.php?post_id=<?= $post_home['chave_materia'] ?>'">

                    <div class="news-card-extra-subject titulo-padrao">
                        <h3><?= $post_home['tema_materia'] ?></h3>
                    </div>
                    <img class="news-card-extra-img" src="img/posts/thumbs/<?= $post_home['chave_materia'] ?>.png" alt="<?= $post_home['titulo_materia'] ?>">

                    <div class="news-card-extra-title" style="display:inline">
                        <?php if (strlen($post_home['titulo_materia']) <= 45) : ?>
                            <p style="font-weight:bold;">
                                <?= $post_home['titulo_materia'] ?>
                            </p>
                        <?php else : ?>
                            <p style="font-weight:bold">
                                <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post_home['titulo_materia']), 0, 45)) ?>...
                            </p>
                        <?php endif ?>
                        <!--                                                        -->
                        <? //=substr(strip_tags($post_home['texto_materia']), 0, 40)
                        ?>
                        <!-- (...)-->
                        <p">
                            <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($post_home['introducao_materia']), 0, 51)) ?>...
                            </p>
                    </div>
                </div>
            </a>

            <?php if ($i == 12) : ?>
            </div>
        <?php endif ?>

        <?php $i++; ?>
    <?php endif ?>
    <?php $im++; ?>
    <?php if ($i == 7) {
                            $ex++;
                        } ?>
<?php endwhile ?>
<?php endif ?>

<div class="flex-button"><a href="materias.php?page=1"><button>Ver mais notícias</button></a></div>
        </section>


        <?php if ($full->num_rows > 0) : ?>
            <div class="ads-slideshow">
                <?php while ($banner_full = $full->fetch_assoc()) : ?>
                    <?php if ($banner_full['vencimento_anuncio'] > $currentDate) : ?>
                        <div class="slideshow sponsor-banner" <?php if ($banner_full['link_anuncio'] != "") : ?> onclick="validation('<?= $banner_full['chave_anuncio'] ?>');window.open('<?= $banner_full['link_anuncio'] ?>','_blank')" style="cursor: pointer; z-index: 20;" <?php endif ?>>

                            <img alt="anuncio" src=".<?= $banner_full['imagem_anuncio'] ?>" alt="<?= $banner_full['descricao_anuncio'] ?>" class="imagem-capa-full">

                        </div>
                                                
                    <?php endif ?>

                <?php endwhile ?>
            </div>


            <!-- <script src="js/slideshow.js"></script> -->

            <script>
                var indexCard = 0;
                sponsorFull();

                function sponsorFull() {
                    let counterFull;
                    let cardSlides = document.getElementsByClassName("sponsor-banner");
                    for (counterFull = 0; counterFull < cardSlides.length; counterFull++) {
                        cardSlides[counterFull].style.display = "none";
                    }
                    indexCard++;
                    if (indexCard > cardSlides.length) {
                        indexCard = 1
                    }
                    cardSlides[indexCard - 1].style.display = "grid";
                    setTimeout(sponsorFull, 2500);
                }

                function validation(chave) {
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
                            //console.log(dados, result);
                        }
                    });
                }
            </script>
        <?php endif ?>






        <!-- turismo -->
        <div class="turismo-secao padding-bottom-2">
            <?php if ($tourism->num_rows > 0) : ?>

                <?php $i = 1; ?>

                <?php while ($tourism_card =
                    $post->getPaidPostsByDate(['categoria_especial_materia' => $i])->fetch_assoc()
                ) :
                ?>

                    <?php

                    switch ($tourism_card['categoria_especial_materia']) {
                        case 1:
                            $category = 'Onde Dormir';
                            break;
                        case 2:
                            $category = 'Onde Comer';
                            break;
                        case 3:
                            $category = 'Onde Ir';
                            break;
                        case 4:
                            $category = 'Onde Comprar';
                            break;
                    }
                    ?>

                    <a href="materia.php?post_id=<?= $tourism_card['chave_materia'] ?>" style="text-decoration: none; color: inherit;">

                        <div class="news-card" onclick="window.location.href='materia.php?post_id=<?= $tourism_card['chave_materia'] ?>'">
                            <div class="news-card-subject titulo-padrao">
                                <h3><?= $category ?></h3>
                            </div>
                            <img class="news-card-img" src="img/posts/thumbs/<?= $tourism_card['chave_materia'] ?>.png" alt="<?= $tourism_card['titulo_materia'] ?>">
                            <div class="news-card-body">
                                <div class="news-card-header">
                                    <h2 class="news-card-title"><?= $tourism_card['titulo_materia'] ?></h2>
                                </div>
                                <div class="news-card-description">
                                    <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($tourism_card['introducao_materia']), 0, 200)) ?>...
                                </div>
                            </div>
                        </div>
                    </a>

                    <?php $i++; ?>
                    <?php if ($i == 5) {
                        break;
                    } ?>
                <?php endwhile ?>
            <?php endif ?>

            <div class="flex-button" style="padding-top: 1em;"><a href="especiais.php?page=1"><button>Ver mais matérias</button></a></div>
        </div>



        <!-- video gallery -->
        <div class="videos-content padding-bottom-2">
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



        <div class="sponsors sponsors-home" id="sponsors-logos">
            <h3 class="titulo-padrao">Parceiros</h3>
            <div class="sponsors-wrapper">
                <div class="sponsors-slider">
                    <div class="sponsors-slide">
                        <?php while ($partners = $logos->fetch_assoc()) : ?>
                            <?php if ($partners['vencimento_anuncio'] > $currentDate) : ?>
                                <img src=".<?= $partners['imagem_anuncio'] ?>" onclick="validation(<?= $partners['chave_anuncio'] ?>);window.open('<?= $partners['link_anuncio'] ?>', '_blank')" style="cursor:pointer;" alt="<?= $partners['descricao_anuncio'] ?>">
                            <?php endif ?>
                        <?php endwhile ?>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function validation(chave) {
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
                        //console.log(sucess);
                    }
                });
            }
        </script>
    </div>
</main>

<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->

<script>
    $("#sponsors-scroll").click(function() {
        $('html, body').animate({
            scrollTop: $("#sponsors-logos").offset().top
        }, 2000);
    });
</script>

<!--    <script>-->
<!--        $(window).on("load",function(){-->
<!--            $(".loader-wrapper").fadeOut("slow");-->
<!--        });-->
<!--    </script>-->

<?php include("footer.php"); ?>