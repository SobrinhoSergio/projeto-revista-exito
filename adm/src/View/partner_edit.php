<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include(TEMPLATE_PATH . "/header.php"); ?>


<style>
    .img-preview {
    border-radius: 5px;
    width: 227px;
    margin-bottom: 2px;
    }

    #logo_img {
        display: none;
    }

    textarea {
        height: 160px;
    }

    .thumb-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

</style>
    <div class="container">
        <div class="content content-form">

            <form action="#" method="POST" enctype="multipart/form-data" id="form_dados">
                <div class="form-container">

                    <div class="exceptions">
                        <?php //erros
                        include(TEMPLATE_PATH . '/errors.php') ?>
                    </div>

                    <input type="hidden" id="partner_active" name="active" class="form-checkbox" value="<?=$ativo?>">


                    <div class="form-field">
                        <label class="form-label" for="partner_name">Nome da Empresa</label>
                        <input class="form-input" type="text" name="name" id="partner_name" value="<?= $nome_empresa ?>">
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="partner_category_link">Link do anúncio</label>
                        <input class="form-input" type="text" name="link" id="partner_category_link" value="<?= $link_guia ?>">
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="partner_category_category">Categoria da empresa/anúncio</label>
                        <select name="category" id="partner_category_category" class="form-select">
                            <option disabled value> -- Selecione uma opção --</option>
                            <?php while ($category = $category_field->fetch_assoc()): ?>
                                <option id="<?=$category['chave_categoria']?>" value="<?=$category['chave_categoria']?>"><?=$category['nome_categoria']?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                    
                    <?php if (new DateTime($vencimento_guia) >= new DateTime("now")): ?>
                        <div class="form-field form-field-center">
                            <label for="partner_publish"> Publicar </label>
                            <input type="checkbox" id="partner_publish" name="publish" class="form-checkbox" value="<?=$publicar?>">
                        </div>
                    <?php endif ?>


                    <?php if (new DateTime($vencimento_guia) < new DateTime("now")): ?>
                    <div class="form-field">
                        <label for="partner_expiration" class="form-label">Renovar</label>
                        <select name="expiration" id="partner_expiration" class="form-select">
                            <option selected disabled value> -- Selecione uma opção --</option>
                            <option value="1" class="form-option">+1 mês</option>
                            <option value="3" class="form-option">+3 meses</option>
                            <option value="6" class="form-option">+6 meses</option>
                            <option value="12" class="form-option">+1 ano</option>
                        </select>
                    </div>
                    <?php endif ?>

                    <?php
                        $date_exp = new DateTime($vencimento_guia);
                        echo 'Vencimento: ' . $date_exp->format('d/m/Y');
                    ?>

                    <div class="form-field thumb-container">
                        <label for="post_service_img">Anúncio</label>
                        <input class="form-input" type="file" name="img" id="logo_img" accept="image/*" onchange="readURL(this);">
                        <img class="img-preview" id="img-preview-logo" src="<?=dirname("../materia.php").'/img/guia/thumbs/'.$imagem_guia?>" alt="imagem">
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
                    <button id="open-modal" class="button-cancel">Excluir empresa</button>
                </div>
            </div>

        </div>
    </div>


    <div id="form-modal" class="form-delete-modal">
        <div class="form-modal-content">
            <span class="form-modal-close-btn">&times;</span>
            <p>Tem certeza que deseja excluir essa empresa?</p>
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
        $('#partner_active').val(0);
        console.log($('#partner_active').val());
        $('#main-submit-input').click();
    });
</script>

<script>
    // loop pelos inputs de mídias sociais; se estiverem com valor setado do DB, mostrá-los marcados e respectivo conteúdo
    $(document).ready(function() {

        // se matéria publicada, manter checked
        if ($('#partner_publish').val() == 1) {
            $('#partner_publish').attr("checked", "checked");
        }

        //manter categoria marcada
        var partner_category = '<?=$chave_categoria?>';
        $("select option").each(function() {
           if ($(this).val() == partner_category) {
               $(this).attr("selected","selected");
           }
        });
    });
</script>

<script>
    // aciona o input de img quando clica no botão
    $(function(){
        $('#btn-upload-logo-img').click(function(e){
            e.preventDefault();
            $('#logo_img').click();}
        );
    });
</script>

<script>
// mostra imagens quando inseridas
function readURL(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();

        var id = 'img-preview-logo';
        $('#update_logo').val(1);

        //carrega imagem
        reader.onload = function (e) {
            $('#'+ id)
            .attr('src', "")
            .attr('src', e.target.result)
            .width('227px');
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