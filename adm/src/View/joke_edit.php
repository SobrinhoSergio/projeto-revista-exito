<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<?php include(TEMPLATE_PATH . "/header.php"); ?>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(function() {
            // new nicEditor({fullPanel : true}).panelInstance('joke_main');
            new nicEditor({buttonList : ['html']}).panelInstance('joke_main');
        });
    </script>

    <style>
        textarea {
            height: 160px;
        }
        #post_image {
            display: none;
        }
    </style>

    <div class="container">
        <div class="content content-form">

            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-container">

                    <div class="exceptions">
                        <?php //erros
                        include(TEMPLATE_PATH . '/errors.php') ?>
                    </div>

                    <input type="hidden" id="joke_active" name="active" class="form-checkbox" value="<?=$ativo?>">

                    <div class="form-field">
                        <label class="form-label" for="joke_title">Título*</label>
                        <input class="form-input" id="joke_title" type="text" name="title" value="<?=$titulo_piada?>">
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="joke_main">Texto*</label>
                        <textarea name="main" id="joke_main" maxlength="500"> <?=$texto_piada?> </textarea>
                    </div>

                    <div class="form-field" id="main-img-field" style="position: relative;">
                        <label for="post_image">Imagem</label>
                        <input class="form-input" type="file" name="main_image" id="post_image" accept="image/*" onchange="readURL(this);"/>
                        <button class="button-img-input" id='btn-upload-img' style="background: #85bb65;">Alterar imagem</button>
                        <img class="img-preview" id="img-preview-main" src="<?=dirname("../materia.php")?><?=$imagem_piada?>" alt="imagem">
                        <input type="hidden" id="update_main_img" name="change_img" value="0">
                    </div>

                    <div class="form-field" style="align-items: center;">
                        <label for="joke_publish"> Publicar </label>
                        <input type="checkbox" id="joke_publish" name="publish" class="form-checkbox" value="<?=$publicar?>">
                    </div>

                    <button class="form-submit" id="main-submit-input" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>

        <div class="form-container">
        <div class="form-field" style="padding-top: 5em;">
            <button id="open-modal" class="button-cancel">Excluir piada</button>
        </div>
        </div>

        <div id="form-modal" class="form-delete-modal">
            <div class="form-modal-content">
                <span class="form-modal-close-btn">&times;</span>
                <p>Tem certeza que deseja excluir essa piada da página de Diversão?</p>
                <div class="modal-options">
                    <button id="confirm-exclusion" class="button-cancel" style="text-align: center;">Excluir</button>
                </div>
            </div>
        </div>
    </div>



    <script src="js/jquery.min.js"></script>


    <script>
        // mostra imagens quando inseridas
        function readURL(input) {

            if (input.files && input.files[0]) {
                let reader = new FileReader();
                // let id =  $('.img-preview').attr('id');
                if ($(input, this).attr("id") == 'post_image') {
                    var id = 'img-preview-main';
                } else {
                    var id = 'img-preview-service';
                }
                document.getElementById(id).className = ' display-block';
                $('#update_main_img').val(1);

                reader.onload = function (e) {
                    $('#'+ id)
                        .attr('src', e.target.result)
                        .width('100%');
                };

                reader.readAsDataURL(input.files[0]);

            }
        }

        $(function(){
            $('#btn-upload-img').click(function(e){
                e.preventDefault();
                $('#post_image').click();}
            );
        });
    </script>

<script>

    // se matéria publicada, manter checked
    if ($('#joke_publish').val() == 1) {
        $('#joke_publish').attr("checked", "checked");
    }

    // exclusão do adm
    $('#form-modal').hide();

    $('#open-modal').click(function() {
        $('#form-modal').show();
    });

    $('.form-modal-close-btn').click(function(){
        $('#form-modal').hide();
    });

    $('#confirm-exclusion').click(function(){
        $('#joke_active').val(0);
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

<?php include(TEMPLATE_PATH . "/footer.php"); ?>