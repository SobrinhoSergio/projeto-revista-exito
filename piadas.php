<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Post.php"); ?>
<?php include_once("adm/src/Model/Joke.php"); ?>
<?php use Friweb\CMS\Model\Joke;
use Friweb\CMS\Model\Post; ?>

<?php

$link = 'piadas.php';
$filtros = [];
$type = new Joke();
$post = new Post();

//include "paginacao_api.php";

$listFull = $type->getResultFromSelect(['ativo' => 1, 'publicar' => 1] + $filtros);
$list = $type->getPaginator(2, '', '*', 'DESC', 1, $filtros);

$pages = ceil($listFull->num_rows / 2 );

if (is_null($_GET['page'])) {
    header("location: $link?page=1");
}

if (isset($_GET['page'])) {

    if ($_GET['page'] > $pages || $_GET['page'] == 0) {
        header("location: $link?page=1");
    }

    // a partir de qual número de linha da tabela
    $offset = $_GET['page'] * 2 - 2;

    // retorna um limite de linhas a partir do número $offset
    $list = $type->getPaginator(2, $offset, '*', 'DESC', 1, $filtros);
}

?>

<style>

    .jokes-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
        justify-content: center;
    }
    @media screen and (min-width: 1200px) {
        .jokes-content {
            margin: 0 5rem;
        }
    }


    .texto-piada, .texto-piada * {
        font-size: 1em !important;
        font-weight: normal !important;
        color: #0f0f0f !important;
        font-family: 'Raleway', sans-serif !important;
    }

    .texto-piada {
        padding: 1.5em 1em !important;
    }

    .titulo-piada {
        margin: .8em;
    }
</style>

<?php include("header.php"); ?>

<div class="container">
    <div class="content">


        <div class="news-list-container">
            <div class="news-list-main">
                <div class="jokes-content">

                    <?php while ($fields = $list->fetch_assoc()): ?>

                        <div style="display: grid; margin-bottom: 4em; border: 2px solid rgba(122,122,122,0.6);
                                 background: white; grid-template-rows: 350px 10px auto;"
                                class="joke-card">

                            <div style="background-image: url('.<?=$fields['imagem_piada']?>'); background-size: 100% 100%; background-repeat: no-repeat;"></div>

                            <h3 style="padding: .2em;" class="titulo-piada"><?=$fields['titulo_piada'] ?></h3>

                            <div style="text-align:justify; padding: .2em; font-size: 1em !important; font-weight: normal !important;" class="texto-piada">
                                <p> <?= $fields['texto_piada'] ?></p>
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

