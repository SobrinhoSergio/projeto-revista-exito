<?php error_reporting(E_ALL ^ E_NOTICE); ?>
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
        width: 227px;
    }

    #post_image {
        display: none;
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
                    <label class="form-label" for="partner_name">Nome da Empresa * </label>
                    <input class="form-input" type="text" name="name" id="partner_name" required>
                </div>

                <div class="form-field">
                    <label class="form-label" for="partner_category_category">Categoria da empresa/anúncio</label>
                    <select name="category" id="partner_category_category" class="form-select">
                        <option disabled value selected> -- Selecione uma opção --</option>
                        <?php while ($category = $category_field->fetch_assoc()): ?>
                            <option value="<?=$category['chave_categoria']?>"><?=$category['nome_categoria']?></option>
                        <?php endwhile ?>
                    </select>
                </div>

                <div class="form-field">
                    <label class="form-label" for="partner_category_link">Link do anúncio (caso haja) </label>
                    <input class="form-input" type="text" name="link" id="partner_category_link">
                </div>

                <div class="form-field">
                    <label for="partner_expiration" class="form-label">Vencimento*</label>
                    <select name="expiration" id="partner_expiration" class="form-select" required>
                        <option disabled value> -- Selecione uma opção --</option>
                        <option value="1" class="form-option">1 mês</option>
                        <option value="3" class="form-option">3 meses</option>
                        <option value="6" class="form-option">6 meses</option>
                        <option value="12" class="form-option">1 ano</option>
                    </select>
                </div>

                <div class="form-field form-field-center">
                    <label for="partner_publish"> Publicar </label>
                    <input type="checkbox" id="partner_publish" name="publish" class="form-checkbox" value="1" checked>
                </div>

                <div class="form-field" id="main-img-field" style="position: relative;">
                    <label for="post_image">Anúncio</label>
                    <input class="form-input" type="file" name="main_image" id="post_image" accept="image/*" onchange="readURL(this);" required/>
                    <button class="button-img-input" id='btn-upload-img'>Escolher imagem</button>
                    <img class="img-preview display-none" id="img-preview-main" src="#" alt="imagem">
                </div>

                <div id="submit-button-field" class="form-field">
                    <button class="form-submit" type="submit" style="width: 100%;" onclick="empty();">Enviar</button>
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
                .width('100%');
        };

        reader.readAsDataURL(input.files[0]);

    }
}

</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>

