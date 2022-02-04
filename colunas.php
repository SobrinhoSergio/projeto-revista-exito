<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php include_once("adm/src/Model/Columnist.php"); ?>
<?php use Friweb\CMS\Model\Post; ?>
<?php use Friweb\CMS\Model\Columnist; ?>

<?php

$link = 'colunas.php';
$filtros = ['tipo_materia' => 4];
$post = $type = new Post();

include "paginacao_api.php";

// colunistas
$columnist = new Columnist();

?>

<?php include("header.php"); ?>

<!--<style>-->
<!--    .select-columnist-mobile {-->
<!--        display: none;-->
<!--    }-->
<!--    @media screen and (max-width: 1200px) {-->
<!---->
<!--        .select-columnist-mobile {-->
<!--            display: block;-->
<!--        }-->
<!---->
<!--        .columnists-header {-->
<!--            border-bottom: 1px solid gray;-->
<!--            text-transform: uppercase;-->
<!--            margin-bottom: .6em;-->
<!--            text-align: center;-->
<!--            padding: 1em;-->
<!--            font-weight: 600;-->
<!--        }-->
<!---->
<!--        .colunista-card {-->
<!--            grid-template-columns: 1fr 1fr;-->
<!--            grid-template-areas: "service-card-img service-card-body";-->
<!---->
<!--        }-->
<!---->
<!--        .colunista-card-body {-->
<!--            align-content: center;-->
<!--            padding-top: 0;-->
<!--        }-->
<!---->
<!--        .colunista-card-img {-->
<!--            width: 120px;-->
<!---->
<!--        }-->
<!--        .colunista-card-title {-->
<!--            margin-top: 0;-->
<!--            border-bottom: 0;-->
<!--        }-->
<!--    }-->
<!--</style>-->

<div class="container">
    <div class="content">

<!--        <div class="select-columnist-mobile">-->

<!--            <div class="columnists-header">-->
<!--                Colunistas-->
<!--            </div>-->

<!--            --><?php
//            $columnists = $columnist->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);
//            ?>

<!--            --><?php //while($colunista = $columnists->fetch_assoc()): ?>
<!--                --><?php // $columnWriter = $colunista['nome_colunista']; ?>
<!--                <div class="service-card colunista-card" onclick="window.location.href='colunista.php?id=$colunista['chave_colunista']&page=1'">-->
<!--                    <img class="service-card-img colunista-card-img" src=".$colunista['foto_colunista']">-->
<!--                    <div class="service-card-body colunista-card-body">-->
<!--                        <div class="service-card-title colunista-card-title" style="text-transform:uppercase;">=$colunista['nome_colunista']</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            --><?php //endwhile ?>
<!--        </div>-->


        <div class="news-list-container">
            <div class="news-list-main">
                <div class="news-list-content">

                    <?php while ($fields = $list->fetch_assoc()): ?>
                        <div class="news-list-card" onclick="window.location.href='materia.php?post_id=<?=$fields['chave_materia']?>'" style="cursor:pointer;">
                            
                            <img class="news-list-card-img" src="img/posts/thumbs/<?=$fields['chave_materia']?>.png">
                            <div class="news-list-card-body">
                                <div class="news-list-card-subject titulo-padrao"> <?=$fields['tema_materia']?> </div>
                                <h4><?=$fields['titulo_materia']?></h4>
                                <br>
                                <?= preg_replace('/\s+?(\S+)?$/', '', substr(strip_tags($fields['texto_materia']), 0, 222)) ?> (...)

                            </div>
                        </div>
                    <?php endwhile ?>



                    <!-- paginação -->
                    <?php include "paginacao.php"; ?>

                </div>
            </div>

            <!-- anúncios -->
            <?php include "anuncios_listagens.php"; ?>

        </div>
    </div>
</div>

<?php include("footer.php"); ?>
