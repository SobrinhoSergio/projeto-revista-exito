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

                <input type="hidden" id="post_category_active" name="active" class="form-checkbox" value="<?=$ativo?>">


                <div class="form-field">
                    <label class="form-label" for="post_category_name">Categoria</label>
                    <input class="form-input" type="text" name="name" id="post_category_name" value="<?=$nome_categoria ?>">
                </div>

                <div class="form-field form-field-center">
                    <label for="post_category_publish"> Publicar </label>
                    <input type="checkbox" id="post_category_publish" name="publish" class="form-checkbox" value="<?=$link_guia?>">
                </div>

                <div class="form-field form-field-center">
                    <label for="post_category_publish"> Publicar </label>
                    <input type="checkbox" id="post_category_publish" name="publish" class="form-checkbox" value="<?=$publicar?>">
                </div>

                <div id="submit-button-field" class="form-field">
                    <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="width: 100%;">
                </div>

            </div>
        </form>

        <div class="form-container">
            <div class="form-field" style="padding-top: 5em;">
                <button id="open-modal" class="button-cancel">Excluir categoria</button>
            </div>
        </div>

    </div>
</div>


<div id="form-modal" class="form-delete-modal">
    <div class="form-modal-content">
        <span class="form-modal-close-btn">&times;</span>
        <p>Tem certeza que deseja excluir esta categoria? Todos os anúncios ligados a ela não serão mais exibidos no site.</p>
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
        $('#post_category_active').val(0);
        console.log($('#post_category_active').val());
        $('#main-submit-input').click();
    });

</script>

<script>
    $(document).ready(function() {
        if ($('#post_category_publish').val() == 1) {
            $('#post_category_publish').attr("checked", "checked");
        }
    });

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
