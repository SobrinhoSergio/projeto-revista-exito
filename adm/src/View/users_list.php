<?php include(TEMPLATE_PATH . "/header.php") ?>

        <div class="users-list-table">
            <table>
                <!-- campos da tabela -->
                <tr>
                    <th class="table-th">Nome</th>
                    <th class="table-th">E-mail</th>
<!--                    <th class="table-th th-desktop">Tipo</th>-->
                    <th class="table-th th-desktop">Publicado</th>
                    <th class="table-th">Ações</th>

                </tr>

                <!-- valores da tabela -->
                <?php while($result = $queryPaginated->fetch_assoc()): ?>
                    <?php $name = explode(" ", $result['nome_usuario']); ?>
                    <tr>
                        <td>
                            <div class="td-div"><?= substr($name[0], 0, 20); ?></div>
                        </td>
                        <td style="word-wrap: break-word">
                            <div class="td-div"><?= $result['email_usuario'] ?></div>
                        </td>

<!--                        <td class="td-desktop">-->
<!--                            --><?php //if ($result['tipo_usuario'] == 1): ?>
<!--                                <div class="td-div">Administrador</div>-->
<!--                            --><?php //else: ?>
<!--                                <div class="td-div">Colunista</div>-->
<!--                            --><?php //endif ?>
<!--                        </td>-->

                        <td class="td-desktop">
                            <?php if($result['publicar'] == 1): ?>
                                <div class="td-div" style="color: lawngreen">Sim</div>
                            <?php else: ?>
                                <div class="td-div" style="color: crimson">Não</div>
                            <?php endif ?>
                        </td>

                        <td>
                            <div class="td-div">
                                <a href="user_edit_controller.php?user_id=<?php echo $result['chave_usuario'];?>">Editar</a>
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
                echo "<a href='users_list_controller.php?page=$previousPage' class='list-arrow-anchor'> &#x2039; </a>";
            }
            if ($_GET['page'] <=3) {

                echo "<a href='users_list_controller.php?page=1' class='list-page-anchor ";
                if ($_GET['page'] == 1) {echo 'list-current-page';}
                echo "'> 1</a>";

                if ($pages >= 2) {
                    echo "<a href='users_list_controller.php?page=2' class='list-page-anchor ";
                    if ($_GET['page'] == 2) {echo 'list-current-page';}
                    echo "'> 2</a>";
                }
                if ($pages >= 3) {
                    echo "<a href='users_list_controller.php?page=3' class='list-page-anchor ";
                    if ($_GET['page'] == 3) {echo 'list-current-page';}
                    echo "'> 3</a>";
                }
            } else {
                echo "<a href='users_list_controller.php?page=$beforePreviousPage' class='list-page-anchor'> $beforePreviousPage </a>";
                echo "<a href='users_list_controller.php?page=$previousPage' class='list-page-anchor'> $previousPage </a>";
                echo "<a href='users_list_controller.php?page=$currentPage' class='list-page-anchor list-current-page'> $currentPage </a>";
            }

            // ao chegar na última página, não mostrar o botão 'próximo'
            if (@$_GET['page'] < $pages) {
                if (@$_GET['page'] >= 3) {
                    echo "<a href='users_list_controller.php?page=$nextPage' class='list-page-anchor'> $nextPage </a>";
                }
                echo "<a href='users_list_controller.php?page=$nextPage' class='list-arrow-anchor'> &#x203A; </a>";
            }
            ?>
        </div>

<?php include(TEMPLATE_PATH . "/footer.php") ?>