<?php

include_once("adm/src/Model/Sponsor.php");

use Friweb\CMS\Model\Sponsor;

$sponsor = new Sponsor();

$card = $sponsor->getResultFromSelect(['tipo_anuncio' => 5, 'ativo' => 1, 'publicar' => 1]);

//$banner = $sponsor->getRandom(4, ['tipo_anuncio' => 1]);

// materias especiais (últimas inseridas)

$date = new DateTime('now');
$currentDate = $date->format('Y-m-d');
?>

<div class="news-list-highlights">
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
    <div class="legenda-sponsors" style="margin-top: 80px">
        <!--<h2>Publicidade</h2>-->
    </div>
    <?php while ($cardHome = $card->fetch_assoc()) : ?>
        <?php if ($cardHome['vencimento_anuncio'] > $currentDate) : ?>
            <div class="propaganda-listagem">
                <div class="slideCard" value="<?= $cardHome['chave_anuncio'] ?>" id="anuncio" onclick="window.open('<?= $cardHome['link_anuncio'] ?>', '_blank');validation()" style="cursor:pointer;">
                    <img class="displayed" style="padding-bottom:20px" src=" .<?= $cardHome['imagem_anuncio'] ?>" alt="<?= $cardHome['descricao_anuncio'] ?>">
                </div>
            </div>
        <?php endif ?>

    <?php endwhile ?>

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

        // var anuncio = document.getElementById("anuncio").getAttribute("value");
        // console.log(anuncio);
        function validation() {
            var elemento = document.getElementsByClassName("slideCard");
            for (var i = 0; i < elemento.length; i++) {
                if (elemento[i].style.display == "grid") {
                    increment(elemento[i].getAttribute("value"));
                } else {
                    console.log("")
                }
            }
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
</div>