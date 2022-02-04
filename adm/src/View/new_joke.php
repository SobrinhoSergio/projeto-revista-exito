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

                    <div class="form-field">
                        <label class="form-label" for="joke_title">Título*</label>
                        <input class="form-input" id="joke_title" type="text" name="title" val="<?=$title?>" required>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="joke_main">Texto*</label>
                        <textarea name="main" id="joke_main" maxlength="500" required> <?=$main?> </textarea>
                    </div>

                    <div class="form-field" id="main-img-field" style="position: relative;">
                        <label for="post_image">Imagem</label>
                        <input class="form-input" type="file" name="main_image" id="post_image" accept="image/*" onchange="readURL(this);" required/>
                        <button class="button-img-input" id='btn-upload-img'>Escolher imagem</button>
                        <img class="img-preview display-none" id="img-preview-main" src="#" alt="imagem">
                    </div>

                    <div class="form-field" style="align-items: center;">
                        <label for="joke_publish"> Publicar </label>
                        <input type="checkbox" id="joke_publish" name="publish" class="form-checkbox" value="1" checked>
                    </div>



                    <button class="form-submit" type="submit">Cadastrar</button>
                </div>
            </form>
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

<?php include(TEMPLATE_PATH . "/footer.php"); ?>


