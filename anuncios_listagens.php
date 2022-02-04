<style>

.turismo-secao2{
    margin-bottom: 50px;
}

</style>



<?php

include_once("adm/src/Model/Sponsor.php");

use Friweb\CMS\Model\Sponsor;

$sponsor = new Sponsor();

$card = $sponsor->getRandom(4, ['tipo_anuncio' => 5]);

//$banner = $sponsor->getRandom(4, ['tipo_anuncio' => 1]);

// especiais (turismo)
$tourism = $post->getPostsByDate(['tipo_materia' => 2]);

$date = new DateTime('now');
$currentDate = $date->format('Y-m-d');
?>

<div class="news-list-highlights" style="display:inline-block">

    <!--<div class="highlight-post">
        <h3>Destaque</h3>
    </div>-->

    <!-- turismo -->
    <div class="turismo-secao2 secao">

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
                    }
                    ?>

                    <a class="materia-especial-anuncios slideSponsor2" href="materia.php?post_id=<?= $tourism_card['chave_materia'] ?>" style="text-decoration: none; color: inherit;">

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
                    <?php if ($i == 3) {
                        break;
                    } ?>
                <?php endwhile ?>
            <?php endif ?>

        </div>

    <script>
        var sIndex2 = 0;
        sponsorCarousel2();

        function sponsorCarousel2() {
            let contador;
            let sSlides = document.getElementsByClassName("slideSponsor2");
            for (contador = 0; contador < sSlides.length; contador++) {
                sSlides[contador].style.display = "none";
            }
            sIndex2++;
            if (sIndex2 > sSlides.length) {
                sIndex2 = 1
            }
            sSlides[sIndex2 - 1].style.display = "grid";
            setTimeout(sponsorCarousel2, 3000); // Change image every 4 seconds
        }
    </script>

    
    <div class="propaganda-listagem" style="margin-bottom: 60px;">
        <?php if ($card->num_rows > 0) : ?>
            <div class="legenda-sponsors">
                <h2>Publicidade</h2>
            </div>
            <?php while ($cardHome = $card->fetch_assoc()) : ?>
                <div class="slideCard" onclick="validation(<?= $cardHome['chave_anuncio'] ?>);window.open('<?= $cardHome['link_anuncio'] ?>', '_blank')" style="cursor:pointer;">
                    <?php if ($cardHome['vencimento_anuncio'] > $currentDate) : ?>
                        <img class="displayed" src=".<?= $cardHome['imagem_anuncio'] ?>" alt="<?= $cardHome['descricao_anuncio'] ?>">
                    <?php endif ?>
                </div>
            <?php endwhile ?>
        <?php endif ?>
    </div>


    <div class="turismo-secao2">

            <?php if ($tourism->num_rows > 0) : ?>

                <?php $i = 3; ?>

                <?php while ($tourism_card =
                    $post->getPaidPostsByDate(['categoria_especial_materia' => $i])->fetch_assoc()
                ) :
                ?>

                    <?php

                    switch ($tourism_card['categoria_especial_materia']) {
                        case 3:
                            $category = 'Onde Ir';
                            break;
                        case 4:
                            $category = 'Onde Comprar';
                            break;
                    }
                    ?>

                    <a class="materia-especial-anuncios slideSponsor" href="materia.php?post_id=<?= $tourism_card['chave_materia'] ?>" style="text-decoration: none; color: inherit;">

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
            if (indexCard > cardSlides.length) {
                indexCard = 1
            }
            cardSlides[indexCard - 1].style.display = "grid";
            setTimeout(sponsorCard, 3000);
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
                    console.log(result);
                }
            });
        }
    </script>
    
    <!--<div class="highlight-post" style="padding-top: 2em;">
        <h3>Destaque</h3>
    </div>-->

    


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

</div>