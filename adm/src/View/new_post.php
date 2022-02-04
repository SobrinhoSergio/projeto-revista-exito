<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include(TEMPLATE_PATH . "/header.php"); ?>

<!-- WYSIWYG editor (post text) -->
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(function() {
        new nicEditor({fullPanel : true}).panelInstance('post_main');
    });
</script>

<!--WYSIWYG editor (post service card) -->
<script src="https://cdn.tiny.cloud/1/juxuijd8aixagki32ntumvpwvbuhol6z0vbqd8vzhm0oh4dq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({selector:'#post_service_text'});</script>


<style>
    #post_image {
        display: none;
    }

    #post_service_img {
        display: none;
    }

    textarea {
        height: 350px;
        max-width: 100%;
    }
    #post_service_text {
        height: initial;
    }

</style>

<div class="container">
    <div class="content content-form">

        <div class="exceptions">
            <?php include(TEMPLATE_PATH . '/errors.php') ?>
        </div>

        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-container">

                <div class="form-field">
                    <label for="post_title">Título da Matéria *</label>
                    <input class="form-input" type="text" name="title" id="post_title" value="<?=$title?>" required>
                </div>

                <div class="form-field">
                    <label for="post_subtitle">Subtítulo (opcional)</label>
                    <input class="form-input" type="text" name="subtitle" id="post_subtitle" value="<?=$subtitle?>">
                </div>

                <div class="form-field form-field-post-type">
                    <label for="post_layout">Tipo da matéria *</label>
                    <select class="form-select" name="type" id="post_layout" required>
                        <option disabled selected value> -- Selecione uma opção -- </option>
                        <?php if ($_SESSION['type_user'] == 1): ?>
                            <option value="1">Matéria jornalística</option>
                            <option value="2">Matéria paga (especial)</option>
                            <option value="3">Matéria relacionada a Imóveis</option>
                        <?php endif ?>
                        <option value="4">Coluna</option>
                    </select>
                </div>

                <div class="form-field form-field-post-subject">
                    <label for="post_subject">Tema*</label>
                    <input class="form-input" type="text" name="subject" id="post_subject" maxlength="20" value="<?=$subject?>">
                </div>

                <?php if ($_SESSION['type_user'] == 1): ?>

                <div class="form-field" id="post_author_field">
                    <label for="post_author">Autor*</label>
                    <input class="form-input" type="text" name="writer" id="post_author" value="<?=$writer?>">
                </div>

                <?php endif ?>

                <div class="form-field form-field-post-intro">
                    <label for="post_intro">Introdução da Matéria*</label>
                    <textarea name="intro" id="post_intro"></textarea>
                </div>

                <div class="form-field form-field-post-main">
                    <label for="post_main">Texto da Matéria*</label>
                    <textarea name="main" id="post_main"></textarea>
                </div>

                <div class="form-field category-field">
                    <label for="post_category">Categoria especial</label>
                    <select class="form-select" name="category" id="post_category">
                        <option disabled selected value> -- Selecione uma opção -- </option>
                        <option value="1">Onde Dormir</option>
                        <option value="2">Onde Comer</option>
                        <option value="3">Onde Ir</option>
                        <option value="4">Onde Comprar</option>
                    </select>
                </div>

                <div class="form-field expiration-field">
                    <label for="post_expiration">Vencimento *</label>
                    <select name="expiration" id="post_expiration" class="form-select">
                        <option selected disabled value> -- Selecione uma opção --</option>
                        <option value="1" class="form-option">1 mês</option>
                        <option value="3" class="form-option">3 meses</option>
                        <option value="6" class="form-option">6 meses</option>
                        <option value="12" class="form-option">1 ano</option>
                    </select>
                </div>

                <div class="form-field column-field">
                    <label for="post_column">Categoria da coluna</label>
                    <select class="form-select" name="column" id="post_column">
                        <option disabled selected value> -- Selecione uma opção -- </option>
                        <?php while($categoria = $writers->fetch_assoc()): ?>
                            <option value='<?=$categoria['chave_colunista']?>'> <?= $categoria['categoria_colunista'] ?></option>
                        <?php endwhile ?>
                    </select>
                </div>


                <div class="form-field" style="align-items: center;">
                    <label for="post_publish"> Publicar </label>
                        <input type="checkbox" id="post_publish" name="publish" class="form-checkbox" value="1" checked>
                </div>

                <div class="form-field">
                    <div class="post-service-content">

                        <div class="form-field" style="align-items: center;">
                            <label for="post_service_check">Inserir um card de serviços?</label>
                            <input class="form-checkbox" type="checkbox" id="post_service_check" name="service_check" value='Yes'>
                        </div>

                        <div class="post-service-card-content form-container">

                            <div class="form-field" id="service-text-field">
                                <label for="post_service_text">Texto de serviço</label>
                                <textarea name="service_text" id="post_service_text"></textarea>
                            </div>



                            <div class="form-field">
                                <label for="post_service_img">Logo do anunciante</label>
                                <input class="form-input" type="file" name="service_img" id="post_service_img" accept="image/*" onchange="readURL(this);">
                                <button class="button-img-input" id='btn-upload-service-img' style="background: #85bb65;">Escolher imagem</button>
                                <img class="img-preview display-none" id="img-preview-service" src="#" alt="imagem">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-field" id="main-img-field" style="position: relative;">
                    <label for="post_image">Imagem principal (miniatura/capa)*</label>
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

<script src="js/new_post.js"></script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>




