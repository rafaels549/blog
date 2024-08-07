<!DOCTYPE html>
<?php


ob_start();
require_once ("includes/config.php");

/* $canonical = $site;  */
if (!empty($_POST['pesquisa_blog'])) {
    $vb_titulo_site = "Cursos - " . $_POST['pesquisa_blog']; 
} else {
    $vb_titulo_site = "Cursos - " . $vb_nome;
}
$header_titulo = "Cursos";
 




?>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ThemeStarz">

    <link href="<?=$site;?>/assets/fonts/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="<?=$site;?>/assets/fonts/elegant-fonts.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?=$site;?>/assets/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="<?=$site;?>/assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="<?=$site;?>/assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?=$site;?>/assets/css/style.css" type="text/css">

    <title><?=$vb_titulo_site;?></title>

</head>

<body class="has-loading-screen links-hover-effect" data-spy="scroll" data-target=".navigation">

    <div class="page-wrapper" id="page-top">
    <?php

include_once 'includes/header.php';

?>
    <?php
// Conexão com o banco de dados (assumindo que $conn já esteja definido)
$results_per_page = 6; // Número de resultados por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página atual
$start_from = ($page - 1) * $results_per_page; // Calcula o deslocamento


// Palavra-chave para pesquisa
if (isset($_POST['pesquisa_blog'])) {
    
    $_SESSION['pesquisa'] = $_POST['pesquisa_blog'];
    $pesquisa = clean($_POST['pesquisa_blog']);
    if(empty($_SESSION['pesquisa'])) {
        header("Location: http://localhost/luiza/luiza/luiza/html/cursos");
    exit();
    } else {
        $pesquisa_url = mb_convert_case(str_replace(' ', '-', $pesquisa), MB_CASE_LOWER);
    echo "<meta http-equiv='refresh' content='0;URL=http://localhost/luiza/luiza/luiza/html/cursos/pesquisa/" . $pesquisa_url . "'>";
    exit(); 
    }
   
   
}
$keyword = isset($_SESSION['pesquisa']) ? $_SESSION['pesquisa'] : '';
$sql = "SELECT id, img, img_secundaria, titulo, inicio, duracao, cidade, instituicao, url_amigavel 
        FROM cursos 
        WHERE (titulo LIKE '%$keyword%' OR cidade LIKE '%$keyword%' OR instituicao LIKE '%$keyword%') 
        AND status = 'a' 
        ORDER BY inicio DESC
        LIMIT $start_from, $results_per_page";


$query = mysqli_query($conn, $sql);

// Consulta para determinar o número total de cursos
$total_sql = "SELECT COUNT(*) FROM cursos WHERE (titulo LIKE '%$keyword%' OR cidade LIKE '%$keyword%' OR instituicao LIKE '%$keyword%') AND status = 'a'";
$total_query = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_array($total_query);
$total_records = $total_row[0];
$total_pages = ceil($total_records / $results_per_page);

// Consulta para obter todas as categorias distintas
$categories_sql = "SELECT DISTINCT categoria FROM cursos WHERE categoria IS NOT NULL AND categoria <> '' ORDER BY categoria";
$categories_query = mysqli_query($conn, $categories_sql);
?>

<div class="block" id="cursos">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <section id="sidebar">
                    <aside id="search">
                        <header><h3>Procurar</h3></header>
                        <form action="" class="custom-form" method="post">
    <input type="text" class="form-control" name="pesquisa_blog" placeholder="Buscar Curso">
    <button class="btn btn-default search" type="submit">
        <i class="fa fa-search"></i>
    </button>
</form>
                        <h3>Categorias</h3>
                       
                    </aside>   
                    <ul class="categories-list">
    <?php
    if ($categories_query && mysqli_num_rows($categories_query) > 0) {
        while ($category = mysqli_fetch_assoc($categories_query)) {
            $category_name = htmlspecialchars($category['categoria']);
            // Formulário para cada categoria
            echo "<li>";
            echo "<form action='' method='post' style='display: inline;'>";
         
            echo "<input type='submit' name='pesquisa_blog' value='" . htmlspecialchars($category_name) ."' style='background: none; border: none; color: inherit; cursor: pointer;'>";
            echo "</form>";
            echo "</li>";
        }
    } else {
        echo '<li>Sem categorias disponíveis</li>';
    }
    ?>
</ul>       
                </section>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="row">
                  
                    <?php
                    if ($query && mysqli_num_rows($query) > 0) {
                        if (!empty($_SESSION['pesquisa'])) {
                             
                            echo '<p style="text-align: center; font-weight: bold; margin-bottom: 30px;">Resultados encontrados para <strong>' . htmlspecialchars($_SESSION['pesquisa']) . '</strong>.</p>';
                            unset($_SESSION['pesquisa']);
                        }
                        
                        while ($dados = mysqli_fetch_assoc($query)) {
                            $id = isset($dados['id']) ? $dados['id'] : '';
                            $img = $site . '/assets/img/' . (isset($dados['img']) ? $dados['img'] : 'sem_imagem.jpg');
                            $img_secundaria =$site . '/assets/img/' . (isset($dados['img_secundaria']) ? $dados['img_secundaria'] : '');

                          

                            $titulo = isset($dados['titulo']) ? htmlspecialchars($dados['titulo']) : '';
                            $inicio = isset($dados['inicio']) ? htmlspecialchars($dados['inicio']) : '';
                            $duracao = isset($dados['duracao']) ? htmlspecialchars($dados['duracao']) : '';
                            $cidade = isset($dados['cidade']) ? htmlspecialchars($dados['cidade']) : '';
                            $instituicao = isset($dados['instituicao']) ? htmlspecialchars($dados['instituicao']) : '';
                            $url_amigavel = isset($dados['url_amigavel']) ? htmlspecialchars($dados['url_amigavel']) : '';

                            $url = isset($site) ? $site . "/cursos/" . $url_amigavel : "#";
                    ?>
                        <div class="col-md-6 col-sm-12 blog-item">
                            <a href="<?= htmlspecialchars($url); ?>" class="image" style="display: block; height: 280px;">
                                <div class="bg-transfer">
                                    <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                                </div>
                            </a>
                            <h3><?= htmlspecialchars($titulo); ?></h3>
                            <p>
                                <strong>Início:</strong> <?= htmlspecialchars($inicio); ?><br>
                                <strong>Duração:</strong> <?= htmlspecialchars($duracao); ?><br>
                                <strong>Cidade:</strong> <?= htmlspecialchars($cidade); ?><br>
                                <strong>Instituição:</strong> <?= htmlspecialchars($instituicao); ?>
                            </p>
                            <div class="text-end">
                            <a href="<?= htmlspecialchars($url); ?>" class="btn btn-rounded btn-primary arrow" style="background-color: rgb(212, 170, 80); border:none; ">
  Saiba Mais
 
</a>
</div>
                        </div>
                    <?php
                        }
                    } else {
                        // Se não houver resultados, exiba a mensagem e liste outros cursos
                     
                        echo '<div class="col-md-12">';
                        echo '<p style="text-align: center; font-weight: bold;">Nenhum resultado encontrado para <strong>' . htmlspecialchars($_SESSION['pesquisa']) . '</strong>.</p>';
                        unset($_SESSION['pesquisa']);

                        // Consulta para listar outros cursos
                        $other_courses_sql = "SELECT id, img, img_secundaria, titulo, inicio, duracao, cidade, instituicao, url_amigavel 
                                              FROM cursos 
                                              WHERE status = 'a' 
                                              ORDER BY inicio DESC
                                              LIMIT 6";
                        $other_courses_query = mysqli_query($conn, $other_courses_sql);

                        if ($other_courses_query && mysqli_num_rows($other_courses_query) > 0) {
                            echo '<h4 style="text-align: center; font-weight: bold;">Outros cursos disponíveis:</h4>';
                            while ($other_course = mysqli_fetch_assoc($other_courses_query)) {
                                $id = isset($other_course['id']) ? $other_course['id'] : '';
                                $img = $site . '/assets/img/' . (isset($other_course['img']) ? $other_course['img'] : 'sem_imagem.jpg');
                                $img_secundaria = 'assets/img/' . (isset($other_course['img_secundaria']) ? $other_course['img_secundaria'] : '');

                               

                                $titulo = isset($other_course['titulo']) ? $other_course['titulo'] : '';
                                $inicio = isset($other_course['inicio']) ? date('d/m/Y', strtotime($other_course['inicio'])) : '';
                                $duracao = isset($other_course['duracao']) ? $other_course['duracao'] : '';
                                $cidade = isset($other_course['cidade']) ? $other_course['cidade'] : '';
                                $instituicao = isset($other_course['instituicao']) ? $other_course['instituicao'] : '';
                                $url_amigavel = isset($other_course['url_amigavel']) ? $other_course['url_amigavel'] : '';
                            ?>
                            <div class="col-md-6 col-sm-12 blog-item">
                            <a href="<?= htmlspecialchars($url); ?>" class="image" style="display: block; height: 280px;">
                                <div class="bg-transfer">
                                    <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                                </div>
                            </a>
                            <h3><?= htmlspecialchars($titulo); ?></h3>
                            <p>
                                <strong>Início:</strong> <?= htmlspecialchars($inicio); ?><br>
                                <strong>Duração:</strong> <?= htmlspecialchars($duracao); ?><br>
                                <strong>Cidade:</strong> <?= htmlspecialchars($cidade); ?><br>
                                <strong>Instituição:</strong> <?= htmlspecialchars($instituicao); ?>
                            </p>
                            <div class="text-end">
                            <a href="<?= htmlspecialchars($url); ?>" class="btn btn-rounded btn-primary arrow" style="background-color: rgb(212, 170, 80); border:none; ">
  Saiba Mais
 
</a>
</div>


                        </div>
                        <?php
                            }
                        } else {
                            echo '<p style="text-align: center;">Nenhum outro curso disponível no momento.</p>';
                        }
                        echo '</div>';
                        
                    }
                  
                     
                      
                    ?>
               
            <div class="col-md-6 col-sm-12 blog-item">
                <a href="<?= htmlspecialchars($url); ?>" class="image" style="display: block; height: 280px;">
                    <div class="bg-transfer">
                        <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                    </div>
                </a>
                <h3><?= htmlspecialchars($titulo); ?></h3>
                <p>
                    <strong>Início:</strong> <?= htmlspecialchars($inicio); ?><br>
                    <strong>Duração:</strong> <?= htmlspecialchars($duracao); ?><br>
                    <strong>Cidade:</strong> <?= htmlspecialchars($cidade); ?><br>
                    <strong>Instituição:</strong> <?= htmlspecialchars($instituicao); ?>
                </p>
                <div class="text-end">
                            <a href="<?= htmlspecialchars($url); ?>" class="btn btn-rounded btn-primary arrow" style="background-color: rgb(212, 170, 80); border:none; ">
  Saiba Mais
 
</a>
</div>
            </div>

                </div>
                <div class="pagination">
                    <?php
                    if ($total_pages > 1) {
                        $prev_page = ($page > 1) ? $page - 1 : 1;
                        $next_page = ($page < $total_pages) ? $page + 1 : $total_pages;

                        echo '<ul>';
                        echo '<li><a href="?page=' . $prev_page . '">&laquo; Anterior</a></li>';
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($i == $page) ? ' class="active"' : '';
                            echo '<li' . $active_class . '><a href="?page=' . $i . '">' . $i . '</a></li>';
                        }
                        echo '<li><a href="?page=' . $next_page . '">Próxima &raquo;</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include_once 'includes/contato.php';

?>
            <!--end block-->

        </div>
        <!--end page-content-->

        <?php

include_once 'includes/contato.php';

?>
    
    <?php

include_once 'includes/footer.php';

?>
        <!--end page-footer-->

    </div>
    <!--end page-wrapper-->


 

</body>


   <!--end outer-wrapper-->
   <script type="text/javascript" src="<?=$site;?>/assets/js/jquery-2.2.1.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/scrollReveal.min.js"></script>
<!--<script type="text/javascript" src="assets/js/jquery.appear.js"></script>-->
<!--<script type="text/javascript" src="assets/js/waypoints.min.js"></script>-->
<script type="text/javascript" src="<?=$site;?>/assets/js/readmore.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/pace.min.js"></script>

<script type="text/javascript" src="<?=$site;?>/assets/js/custom.js"></script>

    <script type="text/javascript">
        var latitude = 34.038405;
        var longitude = -117.946944;
        var markerImage = "assets/img/map-marker-w.png";
        var mapTheme = "dark";
        google.maps.event.addDomListener(window, 'load', simpleMap(latitude, longitude, markerImage, mapTheme));
    </script>