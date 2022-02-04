<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php use Friweb\CMS\Model\Post; ?>

<?php
$link = 'onde_ir.php';
$post = $type = new Post();
$filtros = ['categoria_especial_materia' => 3];
include "paginacao_api.php";
?>

<?php include("header.php"); ?>

<div class="container">
    <div class="content">
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
                                <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($fields['introducao_materia']), 0, 222)) ?>...
                            </div>
                        </div>
                        </a>
                    <?php endwhile ?>

                    <!-- paginação -->
                    <?php include "paginacao.php" ?>

                </div>
            </div>

            <!-- anúncios -->
            <?php include "anuncios_listagens.php"; ?>

        </div>
    </div>
</div>

<?php include("footer.php"); ?>

