<?php include(TEMPLATE_PATH . "/header.php"); ?>

<div class="container">
    <div class="content">
        <div class="cms-header">
            Bem vindo, <?= $nome_usuario ?>
            <a href="logout_controller.php">Sair</a>
        </div>


        <div class="cms-table">
            <ul class="cms-table-list">
                <li class="cms-table-item">
                    <div class="cms-dropdown-btn"> <i class="fa fa-newspaper-o" aria-hidden="true"></i> Matérias </div>
                    <div class="dropdown-table-content">
                        <a href="posts_list_controller.php">Ver todas</a>
                        <a href="post_controller.php">Inserir nova</a>
                        <a href="expired_posts_list_controller.php" style="margin-top: 1rem;">Especiais vencidas</a>

                    </div>
                </li>

                <li class="cms-table-item">
                    <div class="cms-dropdown-btn"> <i class="fa fa-pencil" aria-hidden="true"></i> Colunistas </div>
                    <div class="dropdown-table-content">
                        <a href="columnists_list_controller.php">Ver todos</a>
                        <a href="columnist_controller.php">Inserir novo</a>
                    </div>
                </li>

                <?php if ($_SESSION['type_user'] == 1): ?>

                <li class="cms-table-item">
                    <div class="cms-dropdown-btn"> <i class="fa fa-smile-o" aria-hidden="true"></i> Diversão </div>
                    <div class="dropdown-table-content">
                        <a href="jokes_list_controller.php">Ver todas</a>
                        <a href="joke_controller.php">Inserir nova</a>
                    </div>
                </li>


                    <li class="cms-table-item">
                        <div class="cms-dropdown-btn"> <i class="fa fa-users" aria-hidden="true"></i> Usuários </div>
                        <div class="dropdown-table-content">
                            <a href="users_list_controller.php?page=1">Ver todos</a>
                            <a href="sign_up_controller.php">Cadastrar novo</a>
                        </div>
                    </li>

                    <li class="cms-table-item">
                        <div class="cms-dropdown-btn"> <i class="fa fa-map-o" aria-hidden="true"></i> Guia Empresarial </div>
                        <div class="dropdown-table-content">
                            <a href="partners_list_controller.php?page=1">Ver anúncios</a>
                            <a href="partner_controller.php" style="margin-top: 0;">Inserir novo anúncio</a>
                            <a href="partner_category_controller.php">Inserir nova categoria</a>
                            <a href="partners_categories_list_controller.php?page=1">Ver categorias</a>
                            <a href="expired_partners_list_controller.php" style="margin-top: 1rem;">Vencidos</a>
                        </div>
                    </li>

                    <li class="cms-table-item">
                        <div class="cms-dropdown-btn"> <i class="fa fa-bullhorn" aria-hidden="true"></i> Anúncios </div>
                        <div class="dropdown-table-content">
                            <a href="sponsors_list_controller.php?page=1">Ver todos</a>
                            <a href="new_ad_controller.php">Inserir novo</a>
                            <a href="expired_sponsors_list_controller.php" style="margin-top: 1rem;">Vencidos</a>
                        </div>
                    </li>

                    <li class="cms-table-item">
                        <div class="cms-dropdown-btn"> <i class="fa fa-video-camera" aria-hidden="true"></i> Vídeos </div>
                        <div class="dropdown-table-content">
                            <a href="videos_list_controller.php">Ver todos</a>
                            <a href="video_controller.php">Inserir novo</a>
                        </div>
                    </li>

                <?php endif ?>

            </ul>
        </div>
    </div>
</div>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>

<script>
    $(".cms-table-item").click(function() {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(this).offset().top
        }, 2000);
    });
</script>

