<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php use Friweb\CMS\Model\Post; ?>

<?php

// paginação
$link = 'especiais.php';
$filtros = ['tipo_materia' => 2];
$post = $type =  new Post();

include "paginacao_api.php";

//$listFull = $post->getResultFromSelect(['ativo' => 1, 'publicar' => 1, 'tipo_materia' => 2]);
//$list = $post->getPaginator(4, '', '*', 'DESC', 1, ['tipo_materia' => 2]);
//
//$pages = ceil($listFull->num_rows / 4 );
//
//if (is_null($_GET['page'])) {
//    header("location: especiais.php?page=1");
//}
//
//if (isset($_GET['page'])) {
//
//    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
//        header("location: especiais.php?page=1");
//    }
//
//    // a partir de qual número de linha da tabela
//    $offset = $_GET['page'] * 4 - 4;
//
//    // retorna um limite de linhas a partir do número $offset
//    $list = $post->getPaginator(4, $offset, '*', 'DESC', 1, ['tipo_materia' => 2]);
//}

?>

<?php include("header.php"); ?>

<div class="container">
    <div class="content">


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
<!--                                --><?//= substr(strip_tags($fields['texto_materia']), 0, 120) ?><!--(...)-->
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
