<div class="list-pages">
    <?php
    
    // botões
    $previousPage = $_GET['page'] - 1;
    $nextPage = $_GET['page'] + 1;
    $beforePreviousPage = $_GET['page'] - 2;
    $currentPage = $_GET['page'];

    // só mostra botão 'anterior' se a página não for 1
    if (@$_GET['page'] != 1 && isset($_GET['page'])) {
        echo "<a href='$link?page=$previousPage";
        if($params) {echo "&".$params;}
        echo "' class='list-arrow-anchor'> &#x2039; </a>";
    }
    if ($_GET['page'] <=3) {

        echo "<a href='$link?page=1";
        if($params) {echo "&".$params;}
        echo "' class='list-page-anchor ";
        if ($_GET['page'] == 1) {echo 'list-current-page';}
        echo "'> 1</a>";

        if ($pages >= 2) {
            echo "<a href='$link?page=2";
            if($params) {echo "&".$params;}
            echo "' class='list-page-anchor ";
            if ($_GET['page'] == 2) {echo 'list-current-page';}
            echo "'> 2</a>";
        }
        if ($pages >= 3) {
            echo "<a href='$link?page=3";
            if($params) {echo "&".$params;}
            echo "' class='list-page-anchor ";
            if ($_GET['page'] == 3) {echo 'list-current-page';}
            echo "'> 3</a>";
        }
    } else {
        echo "<a href='$link?page=1";
        if($params) {echo "&".$params;}
        echo "' class='list-page-anchor ";
        if ($_GET['page'] == 1) {echo 'list-current-page';}
        echo "'> 1</a>";

        echo "<a href='$link?page=$beforePreviousPage";
        if($params) {echo "&".$params;}
        echo " 'class='list-page-anchor'> $beforePreviousPage </a>";

        echo "<a href='$link?page=$previousPage";
        if($params) {echo "&".$params;}
        echo "' class='list-page-anchor'> $previousPage </a>";

        echo "<a href='$link?page=$currentPage";
        if($params) {echo "&".$params;}
        echo "' class='list-page-anchor list-current-page'> $currentPage </a>";
    }

    // ao chegar na última página, não mostrar o botão 'próximo'
    if (@$_GET['page'] < $pages) {
        if (@$_GET['page'] >= 3) {
            echo "<a href='$link?page=$nextPage";
            if($params) {echo "&".$params;}
            echo "' class='list-page-anchor'> $nextPage </a>";
        }
        echo "<a href='$link?page=$nextPage";
        if($params) {echo "&".$params;}
        echo "' class='list-arrow-anchor'> &#x203A; </a>";
    }
    ?>

</div>
