<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include(TEMPLATE_PATH . "/header.php"); ?>

<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() {
        new nicEditor({
            fullPanel: true
        }).panelInstance('post_main');
    });
</script>


<script src="https://cdn.tiny.cloud/1/juxuijd8aixagki32ntumvpwvbuhol6z0vbqd8vzhm0oh4dq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: '#post_service_text'
    });
</script>


<style>
    #post_image {
        display: none;
    }

    #post_service_img {
        display: none;
    }

    .img-preview {
        border-radius: 5px;
        width: 100%;
        height: auto;
        margin-bottom: 2px;
    }

    textarea {
        height: 350px;
    }

    .slideshow-anchor {
        text-decoration: none;
    }

    .add-slideshow {
        color: forestgreen;
    }

    .remove-slideshow {
        color: firebrick;
    }
</style>

<div class="container">
    <div class="content content-form">

        <div class="exceptions">
            <?php include(TEMPLATE_PATH . '/errors.php') ?>
        </div>

        <form action="" method="post" enctype="multipart/form-data" id="form-edition-post">
            <div class="form-container">

                <input type="hidden" id="post_active" name="active" class="form-checkbox" value="<?= $ativo ?>">

                <input type="hidden" value="<?= strip_tags($servico_materia) ?>" id="hidden-service">

                <div class="form-field">

                    <?php
                    $slide = 0;
                    while ($anuncio = $sponsors->fetch_assoc()) : ?>
                        <?php if (explode('=', $anuncio['link_anuncio']) == $_GET['post_id']) : ?>
                            <a class="slideshow-anchor remove-slideshow" href="remove_slideshow.php?sponsor_id=<?= $anuncio['chave_anuncio'] ?>">
                                Remover do slideshow
                            </a>
                            <?php
                            $slide = 1;
                            break;
                            ?>
                        <?php endif ?>
                    <?php endwhile; ?>

                    <?php
                    if ($slide != 1 && new DateTime($validade_materia) >= new DateTime("now")) : ?>
                        <a class="slideshow-anchor add-slideshow" href="add_slideshow.php?post_id=<?=$chave_materia?>&description=<?= filter_var($titulo_materia, FILTER_SANITIZE_STRING) ?><?php if ($tipo_materia == 2) {
                                                                                                                                                                                                echo "&expiration=" . date("Y-m-d", strtotime($validade_materia));
                                                                                                                                                                                            } ?>">
                            Exportar ao slideshow
                        </a>
                    <?php endif ?>

                </div>

                <div class="form-field">
                    <label for="post_title">Título da Matéria *</label>
                    <input class="form-input" type="text" name="title" id="post_title" value="<?= filter_var($titulo_materia, FILTER_SANITIZE_STRING) ?>" required>
                </div>

                <div class="form-field">
                    <label for="post_subtitle">Subtítulo</label>
                    <input class="form-input" type="text" name="subtitle" id="post_subtitle" value="<?= $subtitulo_materia ?>">
                </div>

                <div class="form-field">
                    <label for="post_layout">Tipo da matéria *</label>
                    <select class="form-select" name="type" id="post_layout">
                        <option disabled value> -- Selecione uma opção -- </option>
                        <?php if ($_SESSION['type_user'] == 1) : ?>
                            <option class="form-option" id="option-1" value="1">Matéria jornalística</option>
                            <option class="form-option" id="option-2" value="2">Matéria paga (especial)</option>
                            <option class="form-option" id="option-3" value="3">Matéria relacionada a Imóveis</option>
                        <?php endif ?>
                        <option class="form-option" id="option-4" value="4">Coluna</option>
                    </select>
                </div>

                <div class="form-field">
                    <label for="post_subject">Tema</label>
                    <input class="form-input" type="text" name="subject" id="post_subject" maxlength="20" value="<?= $tema_materia ?>">
                </div>

                <div class="form-field" id="post_author_field">
                    <label for="post_author">Autor</label>
                    <input class="form-input" type="text" name="writer" id="post_author" value="<?= $autor_materia ?>">
                </div>

                <div class="form-field">
                    <label for="post_intro">Introdução da Matéria</label>
                    <textarea name="intro" id="post_intro"><?= $introducao_materia ?></textarea>
                </div>

                <div class="form-field form-field-post-main">
                    <label for="post_main">Texto da Matéria*</label>
                    <textarea name="main" id="post_main"> <?= $texto_materia ?> </textarea>
                </div>

                <div class="form-field category-field">
                    <label for="post_category">Categoria especial</label>
                    <select class="form-select" name="category" id="post_category">
                        <option id="option-category-0" disabled value> -- Selecione uma opção -- </option>
                        <option value="1" id="option-category-1">Onde Dormir</option>
                        <option value="2" id="option-category-2">Onde Comer</option>
                        <option value="3" id="option-category-3">Onde Ir</option>
                        <option value="4" id="option-category-4">Onde Comprar</option>
                    </select>
                </div>

                <div class="form-field column-field">
                    <label for="post_column">Categoria da coluna</label>
                    <select class="form-select" name="column" id="post_column">
                        <option disabled value id="option-column-0"> -- Selecione uma opção -- </option>


                        <?php while ($categoria = $writers->fetch_assoc()) : ?>
                            <option <?php if ($categoria['chave_colunista'] == $coluna_materia) {
                                        echo "id='option-column-" . $coluna_materia . "'";
                                    } ?> value='<?= $categoria['chave_colunista'] ?>'>
                                <?= $categoria['categoria_colunista'] ?>
                            </option>
                        <?php endwhile ?>
                    </select>
                </div>

                <?php if (new DateTime($validade_materia) >= new DateTime("now")) : ?>
                    <div class="form-field" style="align-items: center;">
                        <label for="post_publish"> Publicar </label>
                        <input type="checkbox" id="post_publish" name="publish" class="form-checkbox" value="<?= $publicar ?>">
                    </div>
                <?php endif ?>


                <div class="form-field">
                    <div class="post-service-content">

                        <div class="form-field" style="align-items: center;">
                            <label for="post_service_check">Card de serviços</label>
                            <input class="form-checkbox" type="checkbox" id="post_service_check" name="service_check">
                        </div>

                        <div class="post-service-card-content form-container">

                            <div class="form-field" id="service-text-field">
                                <label for="post_service_text">Texto de serviço</label>
                                <textarea name="service_text" id="post_service_text"><?= $servico_materia ?></textarea>
                            </div>

                            <div class="form-field">
                                <label for="post_service_img">Logo do anunciante</label>
                                <input class="form-input" type="file" name="service_img" id="post_service_img" accept="image/*" onchange="readURL(this);">
                                <img class="img-preview" id="img-preview-service" src="<?php
                                                                                        echo dirname("../materia.php") . $imagem_servico_materia ?>" alt="imagem">
                                <button class="button-img-input" id='btn-upload-service-img' style="background: #85bb65;">Alterar imagem</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (new DateTime($validade_materia) < new DateTime("now")) : ?>
                    <div class="form-field">
                        <label for="post_expiration" class="form-label">Renovar</label>
                        <select name="expiration" id="post_expiration" class="form-select">
                            <option selected disabled value> -- Selecione uma opção --</option>
                            <option value="1" class="form-option">+1 mês</option>
                            <option value="3" class="form-option">+3 meses</option>
                            <option value="6" class="form-option">+6 meses</option>
                            <option value="12" class="form-option">+1 ano</option>
                        </select>
                    </div>
                <?php endif ?>

                <?php $var = rand(1,100);
                    if ($tipo_materia == 2) :
                    $date_exp = new DateTime($validade_materia);
                    echo 'Vencimento: ' . $date_exp->format('d/m/Y');
                endif ?>

                <div class="form-field" id="main-img-field" style="position: relative;">
                    <label for="post_image">Imagem principal (miniatura/capa)</label>
                    <input class="form-input" type="file" name="main_image" id="post_image" accept="image/*" onchange="readURL(this);">
                    <img class="img-preview" id="img-preview-main" src="<? echo dirname("../materia.php") ?>/img/posts/thumbs/<? echo $chave_materia ?>.png?var=<?php echo $var ?>" alt="imagem">
                    <button class="button-img-input" id='btn-upload-img'>Alterar imagem</button>
                    <input type="hidden" id="update_main_img" name="change_img" value="0">
                </div>





                <div id="submit-button-field" class="form-field">
                    <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="width: 100%;">
                </div>
            </div>
        </form>


        <div class="form-container">
            <div class="form-field" style="padding-top: 5em;">
                <button id="open-modal" class="button-cancel">Excluir Matéria</button>
            </div>
        </div>
    </div>
</div>

<div id="form-modal" class="form-delete-modal">
    <div class="form-modal-content">
        <span class="form-modal-close-btn">&times;</span>
        <p>Tem certeza que deseja excluir essa matéria?</p>
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

    $('.form-modal-close-btn').click(function() {
        $('#form-modal').hide();
    });

    $('#confirm-exclusion').click(function() {
        $('#post_active').val(0);
        console.log($('#post_active').val());
        $('#main-submit-input').click();
    });
</script>

<script>
    $(document).ready(function() {

        // mantém o select no tipo de matéria e em categoria (se houver)
        var optionid = '<?= $tipo_materia ?>';
        $('#option-' + optionid).attr('selected', true);

        var option_category_id = '<?= $categoria_especial_materia ?>';
        if (option_category_id != '') {
            $('#option-category-' + option_category_id).attr('selected', true);
        } else {
            $('#option-category-0').attr('selected', true);
        }

        var option_column_id = '<?= $coluna_materia ?>';
        if (option_column_id != '' && option_column_id != 0) {
            $('#option-column-' + option_column_id).attr('selected', true);
        } else {
            $('#option-column-0').attr('selected', true);
        }


        // se matéria publicada, manter checked
        if ($('#post_publish').val() == 1) {
            $('#post_publish').attr("checked", "checked");
        }

        if ($('#hidden-service').val().length > 2) {
            $('#post_service_check').attr("checked", true);
            // mostra conteúdo
            $('.post-service-card-content').show();
            $('.post-service-content').show();
            $('.category-field').show();
        }


    });
</script>

<script>
    var tipo_materia = '<?= $tipo_materia ?>';
    if (tipo_materia != 2) {
        $('.post-service-content').hide();
        $('.category-field').hide();

    }

    if (tipo_materia != 4) {
        $('.column-field').hide();
        $('.writer-field').hide();
    } else {
        $('#post_author_field').hide();
    }

    // campo de serviço hidden por padrão
    $('.post-service-card-content').hide();

    // caso mude de/para matéria especial, mostra conteúdo de serviço
    $('#post_layout').change(function() {
        if ($(this).val() == 2) {
            $('.post-service-content').show();
            $('.category-field').show();
            $('#post_subject').prop('disabled', true);
            $('#post_subject').val("Turismo");
        } else {
            $('.post-service-content').hide();
            $('.category-field').hide();
            $('#post_subject').prop('disabled', false);
            $('#post_subject').val("<?= $tema_materia ?>");
        }
    });

    // caso seja selecionado coluna, mostra select respectivo
    $('#post_layout').change(function() {
        if ($(this).val() == 4) {
            $('.column-field').show();
            $('.writer-field').show();
            $('#post_author_field').hide();
            $('#post_author').val("");
        } else {
            $('.column-field').hide();
            $('.writer-field').hide();
            $('#post_author_field').show();
            $('#post_writer').val("");
        }
    });


    // caso desmarque checkbox de serviços, limpa seus inputs
    $('input:checkbox[name="service_check"]').change(
        function() {
            if ($(this).is(':checked')) {
                $('.post-service-card-content').show();
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#service-text-field").offset().top
                }, 2000);
            } else {
                $('.post-service-card-content').hide();
                $('#post_service_text').val("");
                $('#post_service_img').val("");
            }
        });
</script>

<script>
    $('input:checkbox[name="publish"]').change(
        function() {
            if ($(this).is(':checked')) {
                $(this).val(1);
                console.log($(this).val());
            } else {
                $(this).val(0);
                console.log($(this).val());
            }
        });
</script>

<script>
    // aciona o input de img quando clica no botão
    $(function() {
        $('#btn-upload-img').click(function(e) {
            e.preventDefault();
            $('#post_image').click();
        });
    });

    // aciona o input de img (serviços) quando clica no botão
    $(function() {
        $('#btn-upload-service-img').click(function(e) {
            e.preventDefault();
            $('#post_service_img').click();
        });
    });
</script>

<script>
    // mostra imagens quando inseridas
    function readURL(input) {

        if (input.files && input.files[0]) {
            let reader = new FileReader();

            // caso mude a imagem principal, seta input hidden para 1
            if ($(input, this).attr("id") == 'post_image') {
                var id = 'img-preview-main';
                $('#update_main_img').val(1);
                console.log($('#update_main_img').val());
            } else {
                var id = 'img-preview-service';
                $('#update_main_img').val(2);
            }
            // document.getElementById(id).classList.add("display-block");

            //carrega imagem
            reader.onload = function(e) {
                $('#' + id)
                    .attr('src', "")
                    .attr('src', e.target.result)
                    .width('100%');
            };

            reader.readAsDataURL(input.files[0]);

        }
    }
</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>