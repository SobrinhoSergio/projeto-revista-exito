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
                <div class="form-field">
                    <label for="video_title">Título *</label>
                    <input class="form-input" type="text" name="title" id="video_title" value="<?=$title?>" required>
                </div>

                <div class="form-field">
                    <label for="video_description">Descrição *</label>
                    <textarea name="description" id="video_description"></textarea>
                </div>

                <div class="form-field">
                    <label for="video_subject">Tema *</label>
                    <input class="form-input" type="text" name="subject" id="video_subject" value="<?=$subject?>" required>
                </div>

                <div class="form-field">
                    <label for="video_link">Link *</label>
                    <input class="form-input" type="text" name="link" id="video_link" value="<?=$link?>" required>
                </div>

                <div class="form-field" style="align-items: center;">
                    <label for="video_publish"> Publicar </label>
                    <input type="checkbox" id="video_publish" name="publish" class="form-checkbox" value="1" checked>
                </div>

                <div id="submit-button-field" class="form-field">
                    <button class="form-submit" type="submit" style="width: 100%;">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>