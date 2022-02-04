<?php use Friweb\CMS\Model\User;

error_reporting(E_ALL ^ E_NOTICE); ?>

<?php include(TEMPLATE_PATH . "/header.php"); ?>

<style>
    textarea {
        height: 160px;
    }
</style>

<div class="container">
    <div class="content content-form">

        <form action="sign_up_register.php" method="post" enctype="multipart/form-data">
            <div class="form-container">

                <div class="form-field">
                    <label class="form-label" for="user_name">Nome</label>
                    <input class="form-input" id="user_name" type="text" name="name" value="<?= $name ?>" required >
                </div>

                <div class="form-field">
                    <label class="form-label" for="user_email">E-mail</label>
                    <input class="form-input" id="user_email" type="email" name="email" value="<?= $email ?>" required >
                </div>

                <div class="form-field">
                    <label for="new_password">Senha</label>
                    <input class="form-input" type="password" name="password" id="new_password" onChange="checkPasswordMatch();" required>
                </div>

                <div class="form-field">
                    <label for="confirm_new_password">Confirmar senha</label>
                    <input class="form-input" type="password" name="confirm-password" id="confirm_new_password" onChange="checkPasswordMatch();" required>
                </div>

                <div class="form-field">
                    <div class="registrationFormAlert" id="divCheckPasswordMatch">
                    </div>

<!--                <div class="form-field">-->
<!--                    <label class="form-label" for="user_type"> Tipo de Usuário </label>-->
<!--                    <select class="form-select" id="user_type" name='type' required>-->
<!--                        <option disabled selected value> -- Escolha o nível do usuário -- </option>-->
<!--                        <option value="1">Administrador</option>-->
<!--                        <option value="2">Colunista</option>-->
<!--                    </select>-->
<!--                </div>-->

<!--                <div class="form-field">-->
<!--                    <label class="form-label" for="user_name">Bio</label>-->
<!--                    <textarea name="bio" id="user_bio"> --><?//=$bio?><!-- </textarea>-->
<!--                </div>-->

                <div class="form-field" style="align-items: center;">
                    <label for="user_publish"> Publicar </label>
                    <input type="checkbox" id="user_publish" name="publish" class="form-checkbox" value="1" checked>
                </div>

                <button class="form-submit" type="submit">Cadastrar</button>
            </div>
        </form>
    </div>
</div>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>

<script src="js/jquery.min.js"></script>

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
