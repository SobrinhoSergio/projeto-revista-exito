<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<?php include(TEMPLATE_PATH . "/header.php"); ?>

<style>
    textarea {
        height: 160px;
    }
</style>

<div class="container">
    <div class="content content-form">

        <div class="exceptions">
            <?php //erros
            include(TEMPLATE_PATH . '/errors.php') ?>
        </div>

<!--        <div style="text-align:center;">-->
<!--            <img  src="--><?//=dirname("../materia.php")?><!--/img/colunistas/--><?//=$chave_usuario?><!--.png" alt="foto de perfil" style="border: 2px solid gray;">-->
<!--            <br>-->
<!--            <button class="button-img-input" style="margin-top: .5em; margin-bottom: 2em;" onclick="window.location.href='user_edit_image_controller.php?user_id=--><?//=$chave_usuario?>
<!--        '">Alterar imagem</button>-->
<!--        </div>-->

        <form action="#" method="post" enctype="multipart/form-data" id="form-edition-post">
            <div class="form-container">

                <input type="hidden" id="user_active" name="active" class="form-checkbox" value="<?=$ativo?>">

                <div class="form-field">
                    <label for="user_name">Nome</label>
                    <input class="form-input" type="text" name="name" id="user_name" value="<?=$nome_usuario?>">
                </div>

                <div class="form-field">
                    <label for="user_email">E-mail</label>
                    <input class="form-input" type="email" name="email" id="user_email" value="<?=$email_usuario?>">
                </div>

                <div class="form-field">
                    <label for="new_password">Alterar senha</label>
                    <input class="form-input" type="password" name="password" id="new_password" onChange="checkPasswordMatch();" >
                </div>

                <div class="form-field">
                    <label for="confirm_new_password">Confirmar nova senha</label>
                    <input class="form-input" type="password" name="confirm-password" id="confirm_new_password" onChange="checkPasswordMatch();">
                </div>

                <div class="form-field">
                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                </div>

<!--                <div class="form-field">-->
<!--                        <label class="form-label" for="user_type"> Tipo de Usuário </label>-->
<!--                        <select class="form-select" id="user_type" name='type' required>-->
<!--                            <option disabled value> -- Escolha o nível do usuário -- </option>-->
<!--                            <option class="form-option" id="option-1" value="1">Administrador</option>-->
<!--                            <option class="form-option" id="option-2" value="2">Colunista</option>-->
<!--                        </select>-->
<!--                </div>-->

<!--                    <div class="form-field">-->
<!--                        <label class="form-label" for="user_name">Bio</label>-->
<!--                        <textarea name="bio" id="user_bio"> --><?//=$bio_usuario?><!-- </textarea>-->
<!--                    </div>-->

                    <div class="form-field" style="align-items: center;">
                        <label for="user_publish"> Publicar </label>
                        <input type="checkbox" id="user_publish" name="publish" class="form-checkbox" value="<?=$publicar?>">
                    </div>

                <div id="submit-button-field">
                    <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="width: 100%;">
                </div>

            </div>
        </form>
    </div>
</div>

    <div class="form-container">
        <div class="form-field" style="padding-top: 5em;">
            <button id="open-modal" class="button-cancel">Excluir Usuário</button>
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

    // se matéria publicada, manter checked
    if ($('#user_publish').val() == 1) {
        $('#user_publish').attr("checked", "checked");
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
        $('#user_active').val(0);
        console.log($('#user_active').val());
        $('#main-submit-input').click();
    });

</script>

<script>
    $(document).ready(function() {
        // mantém o select no tipo de usuario
        var optionid = '<?=$tipo_usuario?>';
        $('#option-' + optionid).attr('selected', true);
    });
</script>

<script>
    $(".form-submit").click(function() {
        if ($("#new_password").val() != $("#confirm_new_password").val()) {
            $([document.documentElement, document.body]).animate({
                scrollTop: $('#divCheckPasswordMatch').offset().top
            }, 2000);
            return false;
        }
    });
</script>

<script>
    function checkPasswordMatch() {
        var password = $("#new_password").val();
        var confirmPassword = $("#confirm_new_password").val();

        if (password != confirmPassword) {
            $("#divCheckPasswordMatch").removeClass("new-pwd-success");
            $("#divCheckPasswordMatch").addClass("exceptions");
            $("#divCheckPasswordMatch").html("Senhas não conferem");
        } else {
            $("#divCheckPasswordMatch").removeClass("exceptions");
            $("#divCheckPasswordMatch").addClass("new-pwd-success");
            $("#divCheckPasswordMatch").html("Senhas conferem");

        }
    }

    $(document).ready(function () {
        $("#txtNewPassword, #txtConfirmPassword").keyup(checkPasswordMatch);
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