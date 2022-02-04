<?php include(TEMPLATE_PATH . "/header.php"); ?>

<style>
    textarea {
        height: 250px;
    }
</style>

<div class="container">
    <div class="content content-form">

        <div class="form-container">
            <img src="<?=$_SESSION['tmp_path']?>" class="img-thumbnail thumb-sponsor-form" alt="Logo"/>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" id="form_dados">
            <div class="form-container">
                <div class="exceptions">
                    <?php //erros
                    include(TEMPLATE_PATH . '/errors.php') ?>
                </div>

                <div class="form-field">
                    <label class="form-label" for="sponsor_description">Título do anúncio * </label>
                    <input class="form-input" type="text" name="description" id="sponsor_description" required>
                </div>

<!--                <div class="form-field">-->
<!--                    <label class="form-label" for="sponsor_description">Descrição do anúncio * </label>-->
<!--                    <textarea class="form-textarea" type="text" name="description" id="sponsor_description" required></textarea>-->
<!--                </div>-->

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

                <button class="form-submit" type="submit">Enviar</button>
            </div>
        </form>
    </div>
</div>
<?php include(TEMPLATE_PATH . "/footer.php"); ?>