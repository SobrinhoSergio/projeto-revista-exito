<?php include( TEMPLATE_PATH . "/header.php"); ?>


    

        <div class="users-list-table">
        <div style="margin: 1em 0;">
            <a style="text-decoration: none; color: white; padding: 12px 12px; background-color:#133f32; margin-bottom: 1em;" href="search_posts.php">Refinar busca</a>
        </div>
            <table>
                <!-- campos da tabela -->
                <tr>
                    <th class="table-th">Thumb</th>
                    <th class="table-th">Título</th>
                    <th class="table-th th-desktop">Data</th>
                    <th class="table-th th-desktop">Tema</th>
                    <th class="table-th th-desktop">Acessos</th>
                    <th class="table-th th-desktop">Publicado</th>
                    <th class="table-th">Ações</th>
                    
                </tr>

                <!-- valores da tabela -->
                <?php while($result = $queryPaginated->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="td-div img-post-list-div">
                                <img class="img-post-list" src="<?= dirname("../materia.php") ?>/img/posts/thumbs/<?php echo $result['chave_materia'];?>.png" alt="Miniatura da matéria">
                            </div>
                        </td>

                        <td style="word-wrap: break-word">
                            <div class="td-div titulo-materia">
                            <?= $result['titulo_materia'] ?>
                            </div>
                        </td>


                        <td style="word-wrap: break-word" class="td-desktop">
                            <div class="td-div">
                            <?= $result['data_materia'] ?>
                            </div>
                        </td>

                        <td style="word-wrap: break-word" class="td-desktop">
                            <div class="td-div">
                            <?= $result['tema_materia'] ?>
                            </div>
                        </td>

                        <td style="word-wrap: break-word" class="td-desktop">
                            <div class="td-div">
                                <?= $result['acessos_materia'] ?>
                            </div>
                        </td>

                        <td class="td-desktop">
                            <?php if($result['publicar'] == 1): ?>
                                <div class="td-div" style="color: lawngreen">Sim</div>
                            <?php else: ?>
                                <div class="td-div" style="color: crimson">Não</div>
                            <?php endif ?>
                        </td>


                        <td>
                            <div class="td-div">
                                <?php if ( ($_SESSION['type_user'] != 1 && $result['tipo_materia'] >= 4) || ($_SESSION['type_user'] == 1)): ?>
                                    <a href="post_edit_controller.php?post_id=<?php echo $result['chave_materia']; ?>">Editar</a>
                                <?php endif ?>
                                <div>
                                    <a target="_blank" href="<?= dirname("../materia.php") ?>/materia.php?post_id=<?php echo $result['chave_materia']; ?>">Ver</a>
                                </div>

                                <!-- todo opção repostar (href="post_repost_controller.php?post_id=chave_materia] -->
                                <div class="form-container">
                                    <form id="repost-form" action="post_repost_controller.php" method="post">
                                        <button id="<?=$result['chave_materia']?>&<?=$result['titulo_materia']?>" class="modal-open button-confirm" style="margin: .6em 0; padding: .5em .3em; border: none; outline: none;">Repostar</button>
<!--                                        <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="display: none;">-->
                                    </form>
                                </div>

                            </div>
                        </td>
                    </tr>

                <?php endwhile ?>
            </table>
        </div>

        <div class="list-pages">
            <?php

            // botões
            $previousPage = $_GET['page'] - 1;
            $nextPage = $_GET['page'] + 1;
            $beforePreviousPage = $_GET['page'] - 2;
            $currentPage = $_GET['page'];

            // só mostra botão 'anterior' se a página não for 1
            if (@$_GET['page'] != 1 && isset($_GET['page'])) {
                echo "<a href='posts_list_controller.php?page=$previousPage' class='list-arrow-anchor'> &#x2039; </a>";
            }
            if ($_GET['page'] <=3) {

                echo "<a href='posts_list_controller.php?page=1' class='list-page-anchor ";
                if ($_GET['page'] == 1) {echo 'list-current-page';}
                echo "'> 1</a>";

                if ($pages >= 2) {
                    echo "<a href='posts_list_controller.php?page=2' class='list-page-anchor ";
                    if ($_GET['page'] == 2) {echo 'list-current-page';}
                    echo "'> 2</a>";
                }
                if ($pages >= 3) {
                    echo "<a href='posts_list_controller.php?page=3' class='list-page-anchor ";
                    if ($_GET['page'] == 3) {echo 'list-current-page';}
                    echo "'> 3</a>";
                }
            } else {
                echo "<a href='posts_list_controller.php?page=$beforePreviousPage' class='list-page-anchor'> $beforePreviousPage </a>";
                echo "<a href='posts_list_controller.php?page=$previousPage' class='list-page-anchor'> $previousPage </a>";
                echo "<a href='posts_list_controller.php?page=$currentPage' class='list-page-anchor list-current-page'> $currentPage </a>";
            }

            // ao chegar na última página, não mostrar o botão 'próximo'
            if (@$_GET['page'] < $pages) {
                if (@$_GET['page'] >= 3) {
                    echo "<a href='posts_list_controller.php?page=$nextPage' class='list-page-anchor'> $nextPage </a>";
                }
                echo "<a href='posts_list_controller.php?page=$nextPage' class='list-arrow-anchor'> &#x203A; </a>";
            }

            ?>
        </div>

<div id="form-modal" class="form-delete-modal">
    <div class="form-modal-content">
        <span class="form-modal-close-btn" style="cursor:pointer;">&times;</span>
        <div class="confirma-repost" style="text-align: center;">  </div>
        <div class="modal-options">
            <div class="form-field" style="width: initial; ">
                <button id="confirm-exclusion" class="button-confirm" style="text-align: center; padding: 1em; width: 100%;">Repostar</button>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>

<script>
    // repostagem
    $('#form-modal').hide();

    $('.modal-open').click(function(e) {
        e.preventDefault();
        var info = this.id.split("&");
        $('.confirma-repost').html("<p> A matéria "+info[1]+" será repostada com a data de hoje </p>");

        $('#repost-form').append("<input name='repost_id' type='hidden' value='"+info[0]+"'>");
        $('#repost-form').append(' <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="display: none;"> ');

        $('#form-modal').show();
    });


    $('.form-modal-close-btn').click(function(){
        $('#form-modal').hide();
    });

    $('#confirm-exclusion').click(function(){
        $('#main-submit-input').click();
    });


</script>

<?php include( TEMPLATE_PATH . "/footer.php"); ?>
