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
        <?php while ($result = $queryPaginated->fetch_assoc()) : ?>
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

<script src="js/jquery.min.js"></script>
<script>
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