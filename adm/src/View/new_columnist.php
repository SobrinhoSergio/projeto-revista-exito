<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include(TEMPLATE_PATH . "/header.php"); ?>

<style>
    #post_image {
        display: none;
    }
</style>


<div class="container">
    <div class="content content-form">

        <div class="exceptions">
            <?php include(TEMPLATE_PATH. '/errors.php'); ?>
        </div>

        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-container">

                <div class="form-field">
                    <label for="columnist_name">Nome do colunista*</label>
                    <input class="form-input" type="text" name="name" id="columnist_name" value="<?=$name?>" required>
                </div>

                <div class="form-field">
                    <label for="columnist_bio">Bio do colunista*</label>
                    <textarea class="form-textarea" type="text" name="bio" id="columnist_bio" required style="height: 150px;"></textarea>
                </div>

                <div class="form-field">
                    <label for="columnist_category">Categoria*</label>
                    <input class="form-input" type="text" name="category" id="columnist_category" value="<?=$category?>" required>
                </div>

                <div class="form-field" style="align-items: center;">
                    <label for="columnist_publish"> Publicar </label>
                    <input type="checkbox" id="columnist_publish" name="publish" class="form-checkbox" value="1" checked>
                </div>



                <div class="form-field" id="main-img-field" style="position: relative;">
                    <label for="post_image">Foto de perfil*</label>
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