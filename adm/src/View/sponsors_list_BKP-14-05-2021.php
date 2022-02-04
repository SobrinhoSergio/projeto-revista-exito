<?php include(TEMPLATE_PATH . "/header.php");
$pagina = $_GET['page']; ?>

<style>
    .cms-table-item {
        width: auto;
        padding: 25px 16px;
    }

    .dropdown-table-content a {
        margin-top: 0;
    }

    .dropdown-table-content a:first-child {
        margin-top: 1em;
    }

    .cms-table-list {
        align-items: initial;
    }
</style>

<div class="users-list-table">

    <?= $type_sponsor_name ?>
    <?php if ($type_sponsor_name == "") {
        echo "Listando todos os anúncios";
    } ?>

    <div class="cms-table">
        <ul class="cms-table-list">
            <li class="cms-table-item">
                <div class="cms-dropdown-btn"> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Categorias </div>

                <div class="dropdown-table-content">
                    <a href="sponsors_list_controller.php?type=1&page=1">Banner Grande (Home)</a>
                    <a href="sponsors_list_controller.php?type=2&page=1">Banner Grande (Matérias)</a>
                    <a href="sponsors_list_controller.php?type=5&page=1">Retângulo (Matérias Jornalísticas)</a>
                    <a href="sponsors_list_controller.php?type=6&page=1">Retângulo (Matérias Imóveis)</a>
                    <a href="sponsors_list_controller.php?type=7&page=1">Pop-up Modal</a>
                    <a href="sponsors_list_controller.php?type=9&page=1">Carrossel de Logos (Home)</a>
                    <a href="sponsors_list_controller.php?type=10&page=1">Carrossel de Logos (Matérias Imóveis)</a>
                    <a href="sponsors_list_controller.php?type=11&page=1">Capa (Full Banner)</a>
                    <a href="sponsors_list_controller.php?type=12&page=1">Card de Imóvel Superior</a>
                    <a href="sponsors_list_controller.php?type=13&page=1">Card de Imóvel Inferior</a>
                    <a href="sponsors_list_controller.php?type=15&page=1">Slideshow</a>
                </div>
            </li>
        </ul>
    </div>

    <table>
        <!-- campos da tabela -->
        <tr>
            <th class="table-th">Imagem</th>
            <th class="table-th">Titulo</th>
            <th class="table-th th-desktop">Publicado</th>
            <th class="table-th">Ações</th>
        </tr>

        <!-- valores da tabela -->
        <?php while ($result = $queryPaginated->fetch_assoc()) : ?>

            <tr>

                <td>
                    <div class="td-div img-post-list-div">
                        <img class="img-post-list" src="<?php echo dirname("../materia.php") . $result['imagem_anuncio']; ?>" alt="Logo">
                    </div>
                </td>

                <td style="word-wrap: break-word">
                    <div class="td-div">
                        <?= $result['descricao_anuncio'] ?>
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
                        <a href="sponsor_edit_controller.php?sponsor_id=<?php echo $result['chave_anuncio']; ?>&page=<?php echo $pagina ?>">Editar</a>
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
        echo "<a href='sponsors_list_controller.php?page=$previousPage";
        if (isset($_GET['type'])) {
            echo "&type=" . $_GET['type'];
        }
        echo "' class='list-arrow-anchor'> &#x2039; </a>";
    }
    if ($_GET['page'] <= 3) {

        echo "<a href='sponsors_list_controller.php?page=1";
        if (isset($_GET['type'])) {
            echo "&type=" . $_GET['type'];
        }
        echo "' class='list-page-anchor ";
        if ($_GET['page'] == 1) {
            echo 'list-current-page';
        }
        echo "'> 1</a>";

        if ($pages >= 2) {
            echo "<a href='sponsors_list_controller.php?page=2";
            if (isset($_GET['type'])) {
                echo "&type=" . $_GET['type'];
            }
            echo "' class='list-page-anchor ";
            if ($_GET['page'] == 2) {
                echo 'list-current-page';
            }
            echo "'> 2</a>";
        }
        if ($pages >= 3) {
            echo "<a href='sponsors_list_controller.php?page=3";
            if (isset($_GET['type'])) {
                echo "&type=" . $_GET['type'];
            }
            echo "' class='list-page-anchor ";
            if ($_GET['page'] == 3) {
                echo 'list-current-page';
            }
            echo "'> 3</a>";
        }
    } else {
        echo "<a href='sponsors_list_controller.php?page=$beforePreviousPage";
        if (isset($_GET['type'])) {
            echo "&type=" . $_GET['type'];
        }
        echo "' class='list-page-anchor'> $beforePreviousPage </a>";
        echo "<a href='sponsors_list_controller.php?page=$previousPage";
        if (isset($_GET['type'])) {
            echo "&type=" . $_GET['type'];
        }
        echo "' class='list-page-anchor'> $previousPage </a>";
        echo "<a href='sponsors_list_controller.php?page=$currentPage";
        if (isset($_GET['type'])) {
            echo "&type=" . $_GET['type'];
        }
        echo "' class='list-page-anchor list-current-page'> $currentPage </a>";
    }

    // ao chegar na última página, não mostrar o botão 'próximo'
    if (@$_GET['page'] < $pages) {
        if (@$_GET['page'] >= 3) {
            echo "<a href='sponsors_list_controller.php?page=$nextPage";
            if (isset($_GET['type'])) {
                echo "&type=" . $_GET['type'];
            }
            echo "' class='list-page-anchor'> $nextPage </a>";
        }
        echo "<a href='sponsors_list_controller.php?page=$nextPage";
        if (isset($_GET['type'])) {
            echo "&type=" . $_GET['type'];
        }
        echo "' class='list-arrow-anchor'> &#x203A; </a>";
    }
    echo "<select class='form-select' name='pages' id='link'>";
    echo "<option value=''>Selecione</option>";
    for ($i = 1; $i <= $pages; $i++) {
        echo "<option value='sponsors_list_controller.php?page=$i'>$i</option>";
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