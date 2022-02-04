<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php include_once("adm/src/Model/Video.php"); ?>
<?php use Friweb\CMS\Model\Post; ?>
<?php use Friweb\CMS\Model\Video; ?>

<?php

$link = 'videos.php';
$video = $type =  new Video();
$post = new Post();
$filtros = [];
include "paginacao_api.php";


// pega id do vídeo para usar na thumbnail e iframes
function getVideoId($url) {
    $match = preg_match('/^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/', $url, $matches, PREG_OFFSET_CAPTURE);
    return $matches[2][0];
}

?>

<?php include("header.php"); ?>

<div class="container">
    <div class="content">
        <div class="news-list-container">
            <div class="news-list-main">
                <div class="news-list-content">

                    <?php while ($fields = $list->fetch_assoc()): ?>
                        <a href="video.php?video_id=<?=$fields['chave_video']?>" style="text-decoration: none; color: inherit;">
                        <div class="news-list-card" onclick="window.location.href='video.php?video_id=<?=$fields['chave_video']?>'" style="cursor:pointer;">
                            <div class="news-list-card-subject titulo-padrao"> <?=$fields['tema_video']?> </div>
                            <img class="news-list-card-img" src="https://img.youtube.com/vi/<?=getVideoId($fields['link_video'])?>/sddefault.jpg" alt="thumbnail vídeo">
                            <div class="news-list-card-body">
                                <h4><?=$fields['titulo_video']?></h4>
                                <br>
                                <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($fields['descricao_video']), 0, 222)) ?> (...)

                            </div>
                        </div>
                        </a>
                    <?php endwhile ?>

                    <!-- paginação -->
                    <?php include 'paginacao.php'; ?>

                </div>
            </div>

            <!-- anúncios -->
            <?php include "anuncios_listagens.php"; ?>

        </div>
    </div>
</div>

<?php include("footer.php"); ?>
