<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include(TEMPLATE_PATH . "/header.php"); ?>

    <style>
        .img-preview {
            border-radius: 5px;
            width: 100%;
            height: auto;
            margin-bottom: 2px;
        }

        #logo_img {
            display: none;
        }

        textarea {
            height: 250px;
        }

    </style>
    
    <div class="container">
        <div class="content content-form">

            <form action="#" method="POST" enctype="multipart/form-data" id="form_dados">
                <div class="form-container">

                    <div class="exceptions">
                        <?php include(TEMPLATE_PATH . '/errors.php') ?>
                    </div>

                    <input type="hidden" id="sponsor_active" name="active" class="form-checkbox" value="<?=$ativo?>">

                    <div class="form-field">
                        <?= $type_sponsor['descricao_anuncio'] ?>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="sponsor_description">Título do anúncio * </label>
                        <input class="form-input" type="text" name="description" id="sponsor_description" value="<?=$descricao_anuncio ?>">
                    </div>


                    <?php if (new DateTime($vencimento_anuncio) > new DateTime("now")): ?>
                        <div class="form-field form-field-center">
                            <label for="sponsor_publish"> Publicar </label>
                            <input type="checkbox" id="sponsor_publish" name="publish" class="form-checkbox" value="<?=$publicar?>">
                        </div>
                    <?php endif ?>

                    <div class="form-field" style="display:none;">
                        <label class="form-label" for="sponsor_type">Tipo de anúncio</label>
                        <select class="form-select" name="type" id="sponsor_type" style="margin-bottom: 2em;" required>
                            <option disabled  value> -- Selecione uma opção -- </option>
                            <option class="form-option" id="option-15" value="15">Slideshow</option>
                            <option class="form-option" id="option-1" value="1">Banner Grande (Home)</option>
                            <option class="form-option" id="option-2" value="2">Banner Grande (Matérias Jornalísticas)</option>
                            <option class="form-option" id="option-5" value="5">Retângulo (Matérias Jornalísticas)</option>
                            <option class="form-option" id="option-6" value="6">Retângulo (Matérias Imóveis)</option>
                            <option class="form-option" id="option-7" value="7">Pop-up Modal (Home)</option>
                            <option class="form-option" id="option-9" value="9">Carrosel de Logos (Home)</option>
                            <option class="form-option" id="option-10" value="10">Carrossel de Logos (Matérias Imóveis)</option>
                            <option class="form-option" id="option-11" value="11">Full Banner (Home)</option>
                            <option class="form-option" id="option-12" value="12">Card de imóvel</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="sponsor_link">Link do anúncio (caso haja) </label>
                        <input class="form-input" type="text" name="link" id="sponsor_link_ad" value="<?=$link_anuncio?>">
                    </div>

                    <?php
                        $date_exp = new DateTime($vencimento_anuncio);
                        echo 'Vencimento: ' . $date_exp->format('d-m-Y');
                    ?>

                    <?php if (new DateTime($vencimento_anuncio) < new DateTime("now")): ?>
                        <div class="form-field">
                            <label for="sponsor_expiration" class="form-label">Renovar</label>
                            <select name="expiration" id="sponsor_expiration" class="form-select">
                                <option selected disabled value> -- Selecione uma opção --</option>
                                <option value="1" class="form-option">+1 mês</option>
                                <option value="3" class="form-option">+3 meses</option>
                                <option value="6" class="form-option">+6 meses</option>
                                <option value="12" class="form-option">+1 ano</option>
                            </select>
                        </div>
                    <?php endif ?>

                    <input type="hidden" id="sponsor_insertion" name="insertion" class="form-checkbox" value="<?=$insercao_anuncio?>">

                    <div class="form-field">
                        <a href="ad_image_edit_controller.php?sponsor_id=<?=$chave_anuncio?>&vw=<?=$width?>&vh=<?=$height?>&bw=<?=$width+40?>&bh=<?=$height+40?>&dir=<?=$directory?>&original_img=<?=dirname("../materia.php")?>/img/anuncios/originais/<?=$chave_anuncio?>.jpg&type=<?=$tipo_anuncio?>">Editar recorte</a>
                        <label for="logo_img">Imagem</label>
                        <input class="form-input" type="file" name="img" id="logo_img" accept="image/*" onchange="readURL(this);">
                        <img class="img-preview" id="img-preview-logo" src="<?=dirname("../materia.php").$imagem_anuncio?>" alt="imagem">
                        <button class="button-img-input" id='btn-upload-logo-img' style="background: #85bb65;">Alterar imagem</button>
                        
                        <input type="hidden" id="update_logo" name="change_img" value="0">
                    </div>


                    <div id="submit-button-field" class="form-field">
                        <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="width: 100%;">
                    </div>

                </div>
            </form>

            <div class="form-container">
                <div class="form-field" style="padding-top: 5em;">
                    <button id="open-modal" class="button-cancel">Excluir anúncio</button>
                </div>
            </div>

        </div>
    </div>


    <div id="form-modal" class="form-delete-modal">
        <div class="form-modal-content">
            <span class="form-modal-close-btn">&times;</span>
            <p>Tem certeza que deseja excluir este anúncio?</p>
            <div class="modal-options">
                <button id="confirm-exclusion" class="button-cancel" style="text-align: center;">Excluir</button>
            </div>
        </div>
    </div>



<script src="js/jquery.min.js"></script>


<script>
    $(document).ready(function(){
        // mantém o select no tipo de matéria
        var optionid = '<?=$tipo_anuncio?>';
        $('#option-'+optionid).attr('selected', true);

    });
</script>

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
            $('#sponsor_active').val(0);
            console.log($('#sponsor_active').val());
            $('#main-submit-input').click();
        });

    </script>

    <script>

        if ($('#sponsor_publish').val() == 1) {
            $('#sponsor_publish').attr("checked", "checked");
        }

        // aciona o input de img quando clica no botão
        $(function(){
            $('#btn-upload-logo-img').click(function(e){
                e.preventDefault();
                $('#logo_img').click();}
            );
        });

        // muda tipo de matéria, vai pra corte de img
        $('#sponsor_type').change(function() {
            $('#update_logo').val(2);
        });
    </script>


    <script>
        // mostra imagens quando inseridas
        function readURL(input) {

            if (input.files && input.files[0]) {
                let reader = new FileReader();

                var id = 'img-preview-logo';
                $('#update_logo').val(1);

                reader.onload = function (e) {
                    $('#'+ id)
                        .attr('src', "")
                        .attr('src', e.target.result)
                        .width('100%');
                };

                reader.readAsDataURL(input.files[0]);

            }
        }
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