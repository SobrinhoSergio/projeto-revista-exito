<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<?php include(TEMPLATE_PATH . "/header.php"); ?>

<div class="container">
    <div class="content content-form">
        <div class="layout-header">
            Selecione as demais fotos da matéria
        </div>

        <div class="post-form-images-container">

            <div class="exceptions">
                <?php //erros
                include(TEMPLATE_PATH . '/errors.php') ?>
            </div>


            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-container post-form-desktop">

                    <label class="img-label button-img-input" for="img-1" id="img-1-label">Escolha a segunda foto</label>
                    <input class="form-images-input" type='file' accept="image/*" name="image-1"  id="img-1" required onchange="readURL(this);" />
                    <img class="img-preview display-none" id="img-preview-1" src="#" alt="imagem"
                         style="margin: 2em 0; box-shadow: 0 35px 53px -30px rgba(0,0,0,0.75);"  />
                    <div class="subtitle-field display-none" id="subtitle-field-1" style="flex-direction: column; padding-bottom: 1em;">
                        <label class="form-label" for="legenda-img-1">Legenda (opcional)</label>
                        <input class="form-input" id="legenda-img-1" name="subtitle-photo-1" type="text" maxlength="100">
                    </div>

                    <?php if ($_SESSION['post_layout'] >= 6): ?>
                    <label class="img-label display-none button-img-input" for="img-2" id="img-2-label">Escolha a terceira foto</label>
                    <input class="img-input display-none form-images-input" name="image-2" id="img-2" type='file' accept="image/*" onchange="readURL(this);" />
                    <img class="img-preview display-none" id="img-preview-2" src="#" alt="imagem"
                         style="margin: 2em 0; box-shadow: 0 35px 53px -30px rgba(0,0,0,0.75);" />
                        <div class="subtitle-field display-none" id="subtitle-field-2" style="flex-direction: column; padding-bottom: 1em;">
                            <label class="form-label" for="legenda-img-2">Legenda (opcional)</label>
                            <input class="form-input" id="legenda-img-2" name="subtitle-photo-2" type="text" maxlength="100">
                        </div>
                    <?php endif ?>

                    <?php if ($_SESSION['post_layout'] == 8): ?>
                    <label class="img-label display-none button-img-input" for="img-3" id="img-3-label">Escolha a quarta foto</label>
                    <input class="img-input display-none form-images-input" name="image-3" id="img-3" type='file' accept="image/*"   onchange="readURL(this);" />
                        <img class="img-preview display-none" id="img-preview-3" src="#" alt="imagem"
                             style="margin: 2em 0; box-shadow: 0 35px 53px -30px rgba(0,0,0,0.75);" />
                    <?php endif ?>

            <!--        <button type="submit" class="submit-images display-none" id="submit-btn" name="submit">Enviar</button>-->
                    <input type="submit" class="submit-images display-none form-submit"  id="submit-btn" name="submit" value="Enviar">

                </div>
            </form>
        </div>
    </div>
</div>


<script src="js/jquery.min.js"></script>

<script>


    // mostra imagem inserida
    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            let id =  $('.img-preview').attr('id');
            document.getElementById(id).className = ' display-block';

            loadLabel();
            hideInput();
            loadButton();

            reader.onload = function (e) {
                $('#'+id)
                    .attr('src', e.target.result)
                    .width('100%');
            };

            reader.readAsDataURL(input.files[0]);

        }
    }
</script>

<script>
     function loadForm(id) {

        // se id == 3 (duas fotos pequenas), id == 4 (uma foto grande, uma pequena) ou id == 5 (duas fotos grandes)
        if (id == 3 || id == 4 || id == 5) {
            document.getElementById("img-2").className = ' display-none';
            document.getElementById("img-preview-2").className = ' display-none';

            document.getElementById("img-3").className = ' display-none';
            document.getElementById("img-preview-3").className = ' display-none';

            // retira atributo required dos inputs de fotos
            $("#img-3").prop('required',false);
            $("#img-2").prop('required',false);

        }

        // se id == 6 (uma foto grande, duas pequenas) ou id == 7 (duas fotos grandes, uma pequena)
        if (id == 6 || id == 7) {
            // display none para inputs de fotos
            document.getElementById("img-2").className = ' display-block';

            document.getElementById("img-3").className = ' display-none';
            document.getElementById("img-preview-3").className = ' display-none';

            // retira atributo required dos inputs de fotos

            $("#img-2").prop('required', true);
            $("#img-3").prop('required', false);
        }
        // se id == 8 (duas fotos grandes, duas pequenas)
        if (id == 8) {

            document.getElementById("img-2").className = ' display-block';
            document.getElementById("img-3").className = ' display-block';

            $("#img-2").prop('required', true);
            $("#img-3").prop('required', true);
        }
    }
    loadForm('<?= $_SESSION['post_layout']?>');

</script>

<script>
    let post_layout = '<?= $_SESSION['post_layout'] ?>';

    // a depender do layout, caso o input de imagem esteja preenchido, torna o próximo input visível
    function loadLabel() {

        if (post_layout >= 3) {
            $("#img-1-label").removeClass("display-none");
            $("#subtitle-field-1").removeClass("display-none");
            $("#subtitle-field-1").css("display", "flex");

        }
        if (post_layout >= 6 && $('#img-1').val() ) {
            $("#img-2-label").removeClass("display-none");
            if ($('#img-2').val()) {
                $("#subtitle-field-2").removeClass("display-none");
                $("#subtitle-field-2").css("display", "flex");
            }
        }
        if (post_layout == 8 && $('#img-2').val()) {
            $("#img-3-label").removeClass("display-none");
        }
    }

    // a depender do layout, caso input de imagem esteja preenchido, torna o botão de enviar visível
    function loadButton() {
        if (post_layout >= 3 && post_layout <= 5 && $('#img-1').val() ) {
            $("#submit-btn").removeClass("display-none");
        }

        if (post_layout >= 6 && post_layout <= 7 && $('#img-2').val() ) {
            $("#submit-btn").removeClass("display-none");
        }

        if (post_layout >= 8 && $('#img-3').val() ) {
            $("#submit-btn").removeClass("display-none");
        }
    }

    // uma vez imagem enviada no input, esconde o mesmo e scrolla pra imagem
    function hideInput() {
        if ( $('#img-1').val() ) {
            $("#img-1-label").addClass("display-none");
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#img-preview-1").offset().top
            }, 2000);
        }
        if ( $('#img-2').val() ) {
            $("#img-2-label").addClass("display-none");
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#img-preview-2").offset().top
            }, 2000);
        }
        if ( $('#img-3').val() ) {
            $("#img-3-label").addClass("display-none");
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#img-preview-3").offset().top
            }, 2000);
        }
    }

</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>