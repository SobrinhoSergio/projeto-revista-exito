<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include(TEMPLATE_PATH . "/header.php"); ?>


<div class="container">
    <div class="content content-form">

        <form action="#" method="POST" enctype="multipart/form-data" id="form_dados">
            <div class="form-container">

                <div class="exceptions">
                    <?php //erros
                    include(TEMPLATE_PATH . '/errors.php') ?>
                </div>

                <div class="form-field">
                    <label class="form-label" for="novo_tema">Nova Categoria</label>
                    <input class="form-input" type="text" name="name" id="tema_noticia" required>
                </div>


                <div class="form-field form-field-center">
                    <label for="tema_noticia_publish"> Publicar </label>
                    <input type="checkbox" id="tema_noticia_publish" name="publish" class="form-checkbox" value="1" checked>
                </div>

                <button class="form-submit" type="submit" href="tema_noticia_controller.php">Enviar</button>

            </div>
        </form>
    </div>
</div>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>