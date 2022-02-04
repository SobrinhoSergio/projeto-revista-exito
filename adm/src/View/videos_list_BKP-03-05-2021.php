<?php include(TEMPLATE_PATH . "/header.php");
$pagina = $_GET['page']; ?>
<div class="users-list-table">
    <table>
        <!-- campos da tabela -->
        <tr>
            <th class="table-th">Título</th>
            <th class="table-th">Link</th>
            <th class="table-th">Acessos</th>
            <th class="table-th th-desktop">Publicado</th>
            <th class="table-th">Ações</th>
        </tr>

        <!-- valores da tabela -->
        <?php while ($result = $datas->fetch_assoc()) : ?>
            <tr>

                <td style="word-wrap: break-word">
                    <div class="td-div">
                        <?= $result['titulo_video'] ?>
                    </div>
                </td>

                <td style="word-wrap: break-word">
                    <div class="td-div">
                        <a target="_blank" href="<?= $result['link_video'] ?>"><?= substr($result['link_video'], 12, 22) ?>(...)</a>
                    </div>
                </td>

                <td style="word-wrap: break-word">
                    <div class="td-div">
                        <?= $result['acessos_video'] ?>
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
                        <a href="video_edit_controller.php?video_id=<?= $result['chave_video'] ?>&page=<?php echo $pagina ?>">Editar</a>
                        <div>
                            <a target="_blank" href="<?= dirname("../materia.php") ?>/video.php?video_id=<?php echo $result['chave_video']; ?>">Ver</a>
                        </div>
                        <div class="form-container">
                            <form id="repost-form" action="video_repost_controller.php" method="post">
                                <button id="<?= $result['chave_video'] ?>&<?= $result['titulo_video'] ?>" class="modal-open button-confirm" style="margin: .6em 0; padding: .5em .3em; border: none; outline: none;">Repostar</button>
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
        echo "<a href='videos_list_controller.php?page=$previousPage' class='list-arrow-anchor'> &#x2039; </a>";
    }
    if ($_GET['page'] <= 3) {

        echo "<a href='videos_list_controller.php?page=1' class='list-page-anchor ";
        if ($_GET['page'] == 1) {
            echo 'list-current-page';
        }
        echo "'> 1</a>";

        if ($pages >= 2) {
            echo "<a href='videos_list_controller.php?page=2' class='list-page-anchor ";
            if ($_GET['page'] == 2) {
                echo 'list-current-page';
            }
            echo "'> 2</a>";
        }
        if ($pages >= 3) {
            echo "<a href='videos_list_controller.php?page=3' class='list-page-anchor ";
            if ($_GET['page'] == 3) {
                echo 'list-current-page';
            }
            echo "'> 3</a>";
        }
    } else {
        echo "<a href='videos_list_controller.php?page=$beforePreviousPage' class='list-page-anchor'> $beforePreviousPage </a>";
        echo "<a href='videos_list_controller.php?page=$previousPage' class='list-page-anchor'> $previousPage </a>";
        echo "<a href='videos_list_controller.php?page=$currentPage' class='list-page-anchor list-current-page'> $currentPage </a>";
    }

    // ao chegar na última página, não mostrar o botão 'próximo'
    if (@$_GET['page'] < $pages) {
        if (@$_GET['page'] >= 3) {
            echo "<a href='videos_list_controller.php?page=$nextPage' class='list-page-anchor'> $nextPage </a>";
        }
        echo "<a href='videos_list_controller.php?page=$nextPage' class='list-arrow-anchor'> &#x203A; </a>";
    }

    echo "<select class='form-select' name='pages' id='link'>";
    echo "<option value=''>Selecione</option>";
    for ($i = 1; $i <= $pages; $i++) {
        echo "<option value='videos_list_controller.php?page=$i'>$i</option>";
    }
    echo "</select>";

    ?>

</div>

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
    $('#form-modal').hide();

    $('.modal-open').click(function(e) {
        e.preventDefault();
        var info = this.id.split("&");
        $('.confirma-repost').html("<p> O video " + info[1] + " será repostada com a data de hoje </p>");

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

    $(document).ready(function() {

        $('#link').on('change', function() {
            var url = $(this).val();
            if (url) {
                window.open(url, '_self');
            }
            return false;
        });
    });
</script>
<?php include(TEMPLATE_PATH . "/footer.php"); ?>