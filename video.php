<?php
//error_reporting(0);

include_once("adm/src/Model/Database.php");
include_once("adm/src/Model/Model.php");
include_once("adm/src/Model/Image.php");
include_once("adm/src/Model/Video.php");
include_once("adm/src/Model/Post.php");
include_once("adm/src/Model/Sponsor.php");

use Friweb\CMS\Model\Post;
use Friweb\CMS\Model\Sponsor;
use Friweb\CMS\Model\Video;

$video = new Video();
$sponsor = new Sponsor();
$post = new Post();

// vídeo da página
$result = $video->getResultFromSelect(['chave_video' => $_GET['video_id'], 'ativo' => 1, 'publicar' => 1]);

// videos relacionados
$videos = $video->getPaginator(3, '', '*', 'DESC', '1');

// banner propaganda
// tipo banner grande matéria jornalística
$banner = $sponsor->getResultFromSelect([], '*', ['tipo_anuncio' => 2]);

//anuncio card matéria jornalística
$card = $sponsor->getResultFromSelect([], '*', ['tipo_anuncio' => 5]);

$posts = $post->getPaginator(6, '', '*', 'DESC', '1');

// pega id do vídeo para usar na thumbnail e iframes
function getVideoId($url)
{
    $match = preg_match('/^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/', $url, $matches, PREG_OFFSET_CAPTURE);
    return $matches[2][0];
}

// incrementa 1 visualização no post
$video->incrementViews($_GET['video_id']);
$video_recente = $video->getVideoByDate(2);

$date = new DateTime('now');
$currentDate = $date->format('Y-m-d');

?>

<?php include("header.php"); ?>

<?php while ($fields = $result->fetch_assoc()) : ?>

    <div class="container">
        <div class="content">



            <div class="especiais-info">

                <?php
                // separa data do horário, e substitui '-' na data por '/'
                $post_date = explode(" ", $fields['data_video'], 2);
                $data = str_replace("-", "/", $post_date[0]);
                $horario = $post_date[1];
                ?>
                <!-- data -->
                <p><?= $data ?></p>
                <!-- horário -->
                <p><?= $horario ?></p>

                <div class="share-p">
                    <i class="fa fa-share-alt share-icon"></i>
                </div>
            </div>

            <div class="share-desktop">
                <?php include("share.php"); ?>
            </div>

            <!-- titulo -->
            <div class="especiais-title titulo-padrao">
                <h3 id="tituloPagina"> <?= $fields['titulo_video'] ?> </h3>
            </div>

            <!-- iframe -->
            <div class="especiais-img-full mobile-img-width">
                <iframe class="frame-video" height="500px" src="https://www.youtube.com/embed/<?= getVideoId($fields['link_video']) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>


            <div class="especiais-text">
                <div class="especiais-text-paragraph">

                    <div class="share-mobile">
                        <?php include("share.php"); ?>
                    </div>

                    <!-- texto -->
                    <div class="texto-video">
                        <?= $fields['descricao_video'] ?>
                    </div>

                    <!--cards publicidade-->
                    <div style="display: flex; justify-content: center; clear:both;">
                        <div class="figure-left sponsor-left" style="padding: 20px 0;">
                            <div class="margin-right-20 legenda-sponsors">Publicidade</div>
                            <?php if ($card->num_rows > 0) : ?>
                                <?php while ($cardGeral = $card->fetch_assoc()) : ?>
                                    <?php if ($cardGeral['ativo'] == 1 && $cardGeral['publicar'] == 1 && $cardGeral['vencimento_anuncio'] > $currentDate) : ?>
                                        <img class="especiais-text-img-left slideSponsor" src=".<?= $cardGeral['imagem_anuncio'] ?>" alt="<?= $cardGeral['descricao_anuncio'] ?>">
                                    <?php endif ?>
                                <?php endwhile ?>
                            <?php endif ?>
                        </div>
                    </div>

                    <script>
                        var sIndex = 0;
                        sponsorCarousel();

                        function sponsorCarousel() {
                            var contador;
                            var sSlides = document.getElementsByClassName("slideSponsor");
                            for (contador = 0; contador < sSlides.length; contador++) {
                                sSlides[contador].style.display = "none";
                            }
                            sIndex++;
                            if (sIndex > sSlides.length) {
                                sIndex = 1
                            }
                            sSlides[sIndex - 1].style.display = "block";
                            setTimeout(sponsorCarousel, 2000); // Change image every 2 seconds
                        }
                    </script>

                </div>
            </div>


            <!-- outras matérias/vídeos -->
            <div class="news-extras extras-block" style="border-top: 2px solid rgba(0,0,0,0.3); padding-top: 20px; width: 100%; clear:both;">

                <div class="noticias-relacionadas-header">Últimas matérias</div>

                <?php while ($relatedPosts = $posts->fetch_assoc()) : ?>
                    <a href="materia.php?post_id=<?= $relatedPosts['chave_materia'] ?>" style="text-decoration: none; color: inherit;">

                        <div class="news-card-extra" onclick="window.location.href='materia.php?post_id=<?= $relatedPosts['chave_materia'] ?>'">
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
                    </a>
                <?php endwhile ?>
            </div>


            <div class="flex-button">
                <button onclick="window.location.href='materias.php?page=1'">Veja mais notícias </button>
            </div>

            <div class="videos-content">
                <div class="noticias-relacionadas-header" style="width: 100%; padding-top: 40px; padding-bottom: 20px;">Últimos vídeos postados</div>


                <?php
                // contador para definir card da esquerda e direita
                $i = 0; ?>

                <?php while ($relatedVideos = $video_recente->fetch_assoc()) : ?>

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
                        <div class="video-card video-relacionado mobile-padding-right" onclick="window.location.href='video.php?video_id=<?= $relatedVideos['chave_video'] ?>'" style="cursor:pointer;">
                        <?php else : ?>
                            <!-- card da direita -->
                            <div class="video-card video-relacionado mobile-padding-left" onclick="window.location.href='video.php?video_id=<?= $relatedVideos['chave_video'] ?>'" style="cursor:pointer;">
                            <?php endif ?>

                            <div class="video-card-subject titulo-padrao">
                                <h3><?= $relatedVideos['tema_video'] ?></h3>
                            </div>

                            <a class="video-card-img" href="video.php?video_id=<?= $relatedVideos['chave_video'] ?>" style="text-decoration: none; color: inherit;">
                                <img style="width: 100%; height: 100%;" src="https://img.youtube.com/vi/<?= $video_id ?>/sddefault.jpg" alt="<?= $relatedVideos['titulo_video'] ?>">
                            </a>

                            <div class="video-card-body">
                                <div class="video-card-title">
                                    <?php if (strlen($relatedVideos['titulo_video']) <= 45) : ?>
                                        <?= $relatedVideos['titulo_video'] ?>
                                    <?php else : ?>
                                        <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($relatedVideos['titulo_video']), 0, 45)) ?> (...)
                                    <?php endif ?>
                                </div>
                                <div class="video-card-description">
                                    <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($relatedVideos['descricao_video']), 0, 191)) ?> (...)

                                </div>
                            </div>

                            </div>

                            <?php $i++ ?>

                        <?php endwhile ?>
                        </div>

                        <div class="flex-button" style="padding-top: 2rem;">
                            <button onclick="window.location.href='videos.php?page=1'">Veja mais vídeos </button>
                        </div>

            </div>
        </div>




    <?php endwhile ?>

    <?php include("footer.php"); ?>