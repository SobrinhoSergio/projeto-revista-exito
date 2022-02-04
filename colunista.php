<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php include_once("adm/src/Model/Columnist.php"); ?>
<?php use Friweb\CMS\Model\Post; ?>
<?php use Friweb\CMS\Model\Columnist; ?>

<?php
$link = 'colunista.php';
$params = 'id='.$_GET['id'];
$filtros = ['coluna_materia' => $_GET['id']];
$post = $type = new Post();

include "paginacao_api.php";

// colunista (card)
$columnist = new Columnist();

?>

<?php include("header.php"); ?>

    <div class="container">
        <div class="content">

            <div class="news-list-container">
                <div class="news-list-main">
                    <div class="news-list-content">

                        <?php
                        $columnists = $columnist->getResultFromSelect(['ativo' => 1, 'publicar' => 1, 'chave_colunista' => $_GET['id']]);
                        ?>
                        
                        <?php while($colunista = $columnists->fetch_assoc()): ?>
                            <?php  $columnWriter = $colunista['nome_colunista']; ?>
                            <div class="service-card colunista-card">
                                <img class="service-card-img colunista-card-img" src=".<?=$colunista['foto_colunista']?>">
                                <div class="service-card-body colunista-card-body">
                                    <div class="service-card-title colunista-card-title" style="text-transform:uppercase;"><?=$colunista['nome_colunista']?></div>

                                    <div class="service-card-description colunista-card-description">
                                        <div class="colunista-card-subtitulo">
                                            <?=$colunista['bio_colunista']?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile ?>

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
                        <?php include "paginacao.php"; ?>

                    </div>
                </div>

                <!-- anúncios -->
                <?php include "anuncios_listagens.php"; ?>

            </div>
        </div>
    </div>







<?php include("footer.php"); ?>