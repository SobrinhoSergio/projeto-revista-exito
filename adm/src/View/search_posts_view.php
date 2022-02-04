<?php include(TEMPLATE_PATH . "/header.php"); ?>


<div class="search-field" style="margin: 2em; display: flex; flex-direction: column;">
    <form action="search_posts.php" method="get">
        <input  name="search" type="text" class="form-input" placeholder="Pesquise por título, autor ou introdução" >
        <select class="form-select" name="type" id="post_layout">
            <option disabled="" value="" selected="selected"> -- Selecione uma opção de busca -- </option>
            <option class="form-option" id="option-1" value="1">Matéria jornalística</option>
            <option class="form-option" id="option-2" value="2">Matéria paga (especial)</option>
            <option class="form-option" id="option-3" value="3">Matéria relacionada a Imóveis</option>
            <option class="form-option" id="option-4" value="4">Coluna</option>
        </select>
        <input name="search-submit" type="submit" style="height: 100%;">
    </form>

    <a style="margin-top: .5em; text-decoration: none; color: inherit;" href="posts_list_controller.php?page=1">Voltar a listagem completa</a>
</div>

<?php if ($searchResult) : ?>
    <div class="users-list-table">
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
            <?php while ($result = $searchResult->fetch_assoc()) : ?>
                <tr>
                    <td>
                        <div class="td-div img-post-list-div">
                            <img class="img-post-list" src="<?= dirname("../materia.php") ?>/img/posts/thumbs/<?php echo $result['chave_materia']; ?>.png" alt="Miniatura da matéria">
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
                        <?php if ($result['publicar'] == 1) : ?>
                            <div class="td-div" style="color: lawngreen">Sim</div>
                        <?php else : ?>
                            <div class="td-div" style="color: crimson">Não</div>
                        <?php endif ?>
                    </td>


                    <td>
                        <div class="td-div">
                            <?php if (($_SESSION['type_user'] != 1 && $result['tipo_materia'] >= 4) || ($_SESSION['type_user'] == 1)) : ?>
                                <a href="post_edit_controller.php?post_id=<?php echo $result['chave_materia']; ?>">Editar</a>
                            <?php endif ?>
                            <div>
                                <a target="_blank" href="<?= dirname("../materia.php") ?>/materia.php?post_id=<?php echo $result['chave_materia']; ?>">Ver</a>
                            </div>

                            <div class="form-container">
                                <form id="repost-form" action="post_repost_controller.php" method="post">
                                    <button id="<?= $result['chave_materia'] ?>&<?= $result['titulo_materia'] ?>" class="modal-open button-confirm" style="margin: .6em 0; padding: .5em .3em; border: none; outline: none;">Repostar</button>
                                </form>
                            </div>

                        </div>
                    </td>
                </tr>

            <?php endwhile ?>
        </table>
    </div>
<?php endif ?>



<div id="form-modal" class="form-delete-modal">
    <div class="form-modal-content">
        <span class="form-modal-close-btn" style="cursor:pointer;">&times;</span>
        <div class="confirma-repost" style="text-align: center;"> </div>
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
        $('.confirma-repost').html("<p> A matéria " + info[1] + " será repostada com a data de hoje </p>");

        $('#repost-form').append("<input name='repost_id' type='hidden' value='" + info[0] + "'>");
        $('#repost-form').append(' <input id="main-submit-input" name="update-submit" type="submit" class="form-submit" style="display: none;"> ');

        $('#form-modal').show();
    });


    $('.form-modal-close-btn').click(function() {
        $('#form-modal').hide();
    });

    $('#confirm-exclusion').click(function() {
        $('#main-submit-input').click();
    });
</script>

<?php include(TEMPLATE_PATH . "/footer.php"); ?>