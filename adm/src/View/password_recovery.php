<?php ob_start(); ?>
<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<?php include(TEMPLATE_PATH . "/header.php"); ?>

    <div class="container">
        <div class="content content-form">

            <div class="cms-logo">
                <img src="assets/img/friweb_logo.png" alt="Friweb Logo">
            </div>

            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-container">

                    <div class="form-field">
                        Insira o e-mail da conta
                    </div>
                    <div class="form-field">
                        <label for="login_email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="login_email" class="form-input" value="<?= $email ?>" required>
                    </div>

                    <button type="submit" class="form-submit">Enviar</button>
                </div>
            </form>

<!--            <div class="recovery">-->
<!--                <a href="password_recovery_controller.php">Esqueci minha senha</a>-->
<!--            </div>-->

        </div>
    </div>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>