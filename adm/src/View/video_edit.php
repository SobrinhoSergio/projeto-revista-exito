<?php include(TEMPLATE_PATH . "/header.php"); ?>

    <!-- WYSIWYG editor -->
    <script src="https://cdn.tiny.cloud/1/juxuijd8aixagki32ntumvpwvbuhol6z0vbqd8vzhm0oh4dq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea', height: '250', custom_colors: false,
            toolbar: 'undo redo | bold italic', menubar: 'edit'});</script>

    <div class="container">
        <div class="content content-form">

            <div class="exceptions">
                <?php //erros
                include(TEMPLATE_PATH . '/errors.php') ?>
            </div>

            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-container">

                    <input type="hidden" id="video_active" name="active" class="form-checkbox" value="<?=$ativo?>">

                    <div class="form-field">
                        <label for="video_title">Título</label>
                        <input class="form-input" type="text" name="title" id="video_title" value="<?=$titulo_video?>">
                    </div>

                    <div class="form-field">
                        <label for="video_description">Descrição</label>
                        <textarea name="description" id="video_description">
                            <?= $descricao_video ?>
                        </textarea>
                    </div>

                    <div class="form-field">
                        <label for="video_subject">Tema</label>
                        <input class="form-input" type="text" name="subject" id="video_subject" value="<?=$tema_video?>">
                    </div>

                    <div class="form-field">
                        <label for="video_link">Link</label>
                        <input class="form-input" type="text" name="link" id="video_link" value="<?=$link_video?>">
                    </div>

                    <div class="form-field" style="align-items: center;">
                        <label for="video_publish"> Publicar </label>
                        <input type="checkbox" id="video_publish" name="publish" class="form-checkbox" value="<?=$publicar?>">
                    </div>

                    <div id="submit-button-field" class="form-field">
                        <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="width: 100%;">
                    </div>
                </div>
            </form>

            <div class="form-container">
                <div class="form-field" style="padding-top: 5em;">
                    <button id="open-modal" class="button-cancel">Excluir Vídeo</button>
                </div>
            </div>
        </div>
    </div>

<div id="form-modal" class="form-delete-modal">
    <div class="form-modal-content">
        <span class="form-modal-close-btn">&times;</span>
        <p>Tem certeza que deseja excluir este vídeo?</p>
        <div class="modal-options">
            <button id="confirm-exclusion" class="button-cancel" style="text-align: center;">Excluir</button>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>

<script>
    // se matéria publicada, manter checked
    if ($('#video_publish').val() == 1) {
        $('#video_publish').attr("checked", "checked");
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
        $('#video_active').val(0);
        console.log($('#video_active').val());
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

