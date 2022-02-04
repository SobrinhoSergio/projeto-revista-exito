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

                <input type="hidden" id="columnist_active" name="active" class="form-checkbox" value="<?=$ativo?>">

                <div class="form-field">
                    <label for="columnist_name">Nome do colunista</label>
                    <input class="form-input" type="text" name="name" id="columnist_name" value="<?=$nome_colunista?>">
                </div>

                <div class="form-field">
                    <label for="columnist_bio">Bio do colunista</label>
                    <textarea class="form-textarea" type="text" name="bio" id="columnist_bio" style="height: 150px;"><?=$bio_colunista?></textarea>
                </div>

                <div class="form-field">
                    <label for="columnist_category">Categoria</label>
                    <input class="form-input" type="text" name="category" id="columnist_category" value="<?=$categoria_colunista?>">
                </div>

                <div class="form-field" style="align-items: center;">
                    <label for="columnist_publish"> Publicar </label>
                    <input type="checkbox" id="columnist_publish" name="publish" class="form-checkbox" value="<?=$publicar?>">
                </div>



                <div class="form-field" id="main-img-field" style="position: relative; align-items:center;">
                    <label for="post_image" style="margin-bottom: .6em;">Foto de perfil</label>
                    <input class="form-input" type="file" name="main_img" id="post_image" accept="image/*" onchange="readURL(this);">
                    <img class="img-preview" id="img-preview-main" src="<?=dirname("../materia.php").$foto_colunista?>" alt="imagem" style="width: 180px;">
                    <button class="button-img-input" id='btn-upload-img' style="margin-top: .2em;">Alterar imagem</button>
                    <input type="hidden" id="update_main_img" name="change_img" value="0">
                </div>

                <div class="form-field">
                    <a href="columnist_edit_image_controller.php?columnist_id=<?=$_GET['columnist_id']?>&original_img=<?=dirname("../materia.php")?>/img/colunistas/originais/<?=$_GET['columnist_id']?>.jpg">
                        Editar recorte da imagem
                    </a>
                </div>

                <div id="submit-button-field" class="form-field">
                    <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="width: 100%;">
                </div>

            </div>
        </form>

        <div class="form-container">
            <div class="form-field" style="padding-top: 5em;">
                <button id="open-modal" class="button-cancel">Excluir Colunista</button>
            </div>
        </div>

    </div>
</div>

<!-- modal -->
<div id="form-modal" class="form-delete-modal">
    <div class="form-modal-content">
        <span class="form-modal-close-btn">&times;</span>
        <p>Tem certeza que deseja excluir este colunista?</p>
        <div class="modal-options">
            <button id="confirm-exclusion" class="button-cancel" style="text-align: center;">Excluir</button>
        </div>
    </div>
</div>


<script src="js/jquery.min.js"></script>

<script>
    // exclusão do adm
    $('#form-modal').hide();

    $('#open-modal').click(function() {
       $('#form-modal').show();
    });

    $('.form-modal-close-btn').click(function(){
        $('#form-modal').hide();
    });

    $('#confirm-exclusion').click(function(){
       $('#columnist_active').val(0);
       console.log($('#columnist_active').val());
       $('#main-submit-input').click();
    });


</script>

    <script>
        $('input:checkbox[name="publish"]').change(
            function() {
                if ( $(this).is(':checked')) {
                    $(this).val(1);
                    console.log($(this).val());
                } else {
                    $(this).val(0);
                    console.log($(this).val());
                }
            });
    </script>

<script>

// se publicado, manter checked
if ($('#columnist_publish').val() == 1) {
    $('#columnist_publish').attr("checked", "checked");
}

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


// mostra imagens quando inseridas
function readURL(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();
        // document.getElementById('img-preview-main').className = ' display-block';
        $('#update_main_img').val(1);

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