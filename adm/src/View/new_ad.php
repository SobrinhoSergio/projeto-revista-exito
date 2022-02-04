<?php include(TEMPLATE_PATH . "/header.php"); ?>

<style>
    textarea {
        height: 160px;
    }

    .thumb-partner-form {
        width: 227px;
    }

    .thumb-container {
        text-align: center;
    }

    .img-preview {
        max-width: 100%;
    }

    #post_image {
        display: none;
    }

    @media screen and (min-width: 768px) {
        #main-img-field {
            width: auto;
        }   
    }

</style>

<div class="container">
    <div class="content content-form">

        <form action="#" method="POST" enctype="multipart/form-data" id="form_dados">
            <div class="form-container">
                
                <div class="exceptions">
                    <?php //erros
                    include(TEMPLATE_PATH . '/errors.php') ?>
                </div>

                <div class="form-field">
                    <label for="sponsor_type" class="form-label">Tipo de anúncio*</label>
                    <select name="type" id="sponsor_type" class="form-select" required>
                        <option disabled value> -- Selecione uma opção --</option>
                        <?php while ($type = $types->fetch_assoc()): ?>
                            <option value="<?=utf8_decode($type['tipo_anuncio'])?>" class="form-option"><?=$type['descricao_anuncio']?></option>
                        <?php endwhile ?>
                    </select>
                </div>

                <div class="form-field">
                    <label class="form-label" for="sponsor_description">Título do anúncio* </label>
                    <input class="form-input" type="text" name="description" id="sponsor_description" required>
                </div>

                <div class="form-field">
                    <label class="form-label" for="sponsor_link">Link do anúncio (caso haja) </label>
                    <input class="form-input" type="text" name="link" id="sponsor_link_ad">
                </div>

                <div class="form-field">
                    <label for="sponsor_expiration" class="form-label">Vencimento*</label>
                    <select name="expiration" id="sponsor_expiration" class="form-select" required>
                        <option disabled value> -- Selecione uma opção --</option>
                        <option value="1" class="form-option">1 mês</option>
                        <option value="3" class="form-option">3 meses</option>
                        <option value="6" class="form-option">6 meses</option>
                        <option value="12" class="form-option">1 ano</option>
                    </select>
                </div>

                <div class="form-field form-field-center">
                    <label class="form-label" for="sponsor_publish"> Publicar </label>
                    <input class="form-checkbox" type="checkbox" id="sponsor_publish" name="publish"  value="1" checked>
                </div>

                <div class="form-field" id="main-img-field" style="position: relative;">
                    <label for="post_image">Imagem</label>
                    <input class="form-input" type="file" name="img" id="post_image" accept="image/*" onchange="readURL(this);" required/>
                    <button class="button-img-input" id='btn-upload-img'>Escolher imagem</button>
                    <img class="img-preview display-none" id="img-preview-main" src="#" alt="imagem">
                </div>

                <div id="submit-button-field" class="form-field">
                    <button class="form-submit" type="submit" onclick="empty();">Enviar</button>
                </div>

            </div>
        </form>
    </div>
</div>

<script src="js/jquery.min.js"></script>

<script>

// botão de enviar escondido por padrão
$('.form-submit').hide();

// esconde botão de imagem principal e mostra o de enviar ao inserir principal
$('#post_image').change(function() {
    if ( $(this).val() ) {
        $('#btn-upload-img').hide();
        $('.form-submit').show();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#submit-button-field").offset().top
        }, 2000);
    }
});

// aciona o input quando clica no botão
$(function(){
    $('#btn-upload-img').click(function(e){
        e.preventDefault();
        $('#post_image').click();}
    );
});

// ao tentar enviar sem uma imagem, emite alerta
function empty() {
    let x;
    x = document.getElementById("post_image").value;
    if (x == "") {
        alert("Selecione uma imagem");
        return false;
    }
}

// mostra imagens quando inseridas
function readURL(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();
        document.getElementById('img-preview-main').className = ' display-block';

        reader.onload = function (e) {
            $('#img-preview-main')
                .attr('src', e.target.result)
                .attr('style', 'display: block !important');
                // .width('100%')
                // .css('display', 'block !important');
        };

        reader.readAsDataURL(input.files[0]);

    }
}

</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>
