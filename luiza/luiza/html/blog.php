<?php


ob_start();
require_once ("includes/config.php");

/* $canonical = $site;  */
if (!empty($_POST['pesquisa_blog'])) {
    $vb_titulo_site = "Blog - " . $_POST['pesquisa_blog']; 
} else {
    $vb_titulo_site = "Blog - " . $vb_nome;
}

 $header_titulo = "Blog";
 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["acao"]) && $_POST["acao"]=="enviar") {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');   
        date_default_timezone_set('America/Sao_Paulo');
        $dominio = str_replace('www.', '', $_SERVER['HTTP_HOST']);

        $nome = strip_tags($_POST['nome']);
        $whatsapp = strip_tags($_POST['whatsapp']);
        $email = strip_tags($_POST['email']);
        $mensagem = nl2br($_POST['mensagem']);
        
        $data_atual = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$vb_nome.' <'.$vb_email.'>' . "\r\n";
        $headers .= 'Bcc: Virtua Brasil<contato@virtuabrasil.com.br>' . "\r\n";
        $headers .= 'Bcc: Virtua Brasil<dev@virtuabrasil.com.br>' . "\r\n";
        $headers .= 'Reply-To: '.$nome.' <'.$email.'>' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        $mensagememail  = '<strong>Nome:</strong> '.$nome.'<br>';
        $mensagememail .= '<strong>WhatsApp:</strong> '.$whatsapp.'<br>';
        $mensagememail .= '<strong>E-mail:</strong> '.$email.'<br><br>';
        $mensagememail .= '<strong>Mensagem:</strong> '.$mensagem.'<br><br>';

        $mensagememail .= '<strong>IP:</strong> '.$_SERVER['REMOTE_ADDR'].'<br>';
        $mensagememail .= '<strong>Endereço IP:</strong> '.gethostbyaddr($_SERVER['REMOTE_ADDR']).'<br>';
        $mensagememail .= ucfirst(IntlDateFormatter::formatObject($data_atual, "eeee, d 'de' MMMM y 'às' HH:mm", 'pt_BR')).'<br>';

        $assunto = '* Formulário de Contato *';
        $email_to = $vb_nome.'<'.$vb_email.'>';
        
        $successo = mail(iconv("UTF-8", "ISO-8859-1", $email_to), iconv("UTF-8", "ISO-8859-1", $assunto), iconv("UTF-8", "ISO-8859-1", $mensagememail), iconv("UTF-8", "ISO-8859-1", $headers));
   
        if (!$successo) {
            echo "<script>alert('Mensagem não enviada!');</script>";
         
			exit();
        }else{
            echo '<meta http-equiv="refresh" content="0;URL=obrigado">';
			exit();
        }
    }
}
?>  

<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8"/>
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

$blog_sql = "SELECT id, img, titulo, resumo, data_publicacao, categoria, url_amigavel
FROM blog
WHERE status = 'a'
ORDER BY data_publicacao DESC
LIMIT 5";
$blog_recents = mysqli_query($conn, $blog_sql);

if (!$blog_recents) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}


?>
<div class="block" id="blog">
    <div class="container">
        <div class="row">
        <div class="col-md-4 col-sm-12">
    <section id="sidebar">
        <aside id="search">
            <header><h3>Procurar</h3></header>
            
            <form action="" class="custom-form" method="post">
    <input type="text" class="form-control" name="pesquisa_blog" placeholder="Buscar Blog">
    <button class="btn btn-default search" type="submit">
        <i class="fa fa-search"></i>
    </button>
</form>
           
            <h3>Posts Mais Recentes</h3>
        </aside>
        <div class="blog-container">
        <?php while ($blog = mysqli_fetch_assoc($blog_recents)) { 
            $img = $site . '/assets/img/blog/' . (isset($blog['img']) ? $blog['img'] : 'sem_imagem.jpg');
        ?>
        <div class="blog-card">
            <a href="<?php echo htmlspecialchars($blog['url_amigavel']); ?>" class="blog-link">
                <div class="card-blog">
                    <div class="card-blog-img">
                        <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($blog['titulo']); ?>">
                    </div>
                    <div class="card-blog-content">
                        <h5><?php echo htmlspecialchars($blog['titulo']); ?></h5>
                        <small>Leia mais</small>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
        </div>
    </section>
</div>
    <!--end page-header-->
    <?php
// Verificar se uma URL amigável foi fornecida
if (isset($_GET['url_amigavel'])) {
    $url_amigavel = mysqli_real_escape_string($conn, $_GET['url_amigavel']);
    $results_per_page = 6; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start_from = ($page - 1) * $results_per_page; 

if (isset($_POST['pesquisa_blog'])) {
    $_SESSION['pesquisa'] = $_POST['pesquisa_blog'];
    $pesquisa = clean($_POST['pesquisa_blog']);
    if(empty($_SESSION['pesquisa'])) {
        header("Location: http://localhost/luiza/luiza/luiza/html/blog");
        exit();
    } else {
        $pesquisa_url = mb_convert_case(str_replace(' ', '-', $pesquisa), MB_CASE_LOWER);
        echo "<meta http-equiv='refresh' content='0;URL=http://localhost/luiza/luiza/luiza/html/blog/pesquisa/" . $pesquisa_url . "'>";
        exit(); 
    }
}

$keyword = isset($_SESSION['pesquisa']) ? $_SESSION['pesquisa'] : '';

$sql = "SELECT id, img, titulo, resumo, data_publicacao, categoria, url_amigavel 
        FROM blog 
        WHERE (titulo LIKE '%$keyword%' OR resumo LIKE '%$keyword%' OR categoria LIKE '%$keyword%') 
        AND status = 'a' 
        ORDER BY data_publicacao DESC
        LIMIT $start_from, $results_per_page";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

// Consulta para determinar o número total de blogs
$total_sql = "SELECT COUNT(*) FROM blog WHERE (titulo LIKE '%$keyword%' OR resumo LIKE '%$keyword%' OR categoria LIKE '%$keyword%') AND status = 'a'";
$total_query = mysqli_query($conn, $total_sql);

if (!$total_query) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

$total_row = mysqli_fetch_array($total_query);
$total_records = $total_row[0];
$total_pages = ceil($total_records / $results_per_page);

    // Consulta para obter o conteúdo do blog com base na URL amigável
    $blog_sql = "SELECT id, img, titulo, resumo, data_publicacao, categoria, url_amigavel  
                 FROM blog 
                 WHERE url_amigavel = '$url_amigavel' 
                 AND status = 'a'";

    $blog_query = mysqli_query($conn, $blog_sql);

    if ($blog_query && mysqli_num_rows($blog_query) > 0) {
        $blog_data = mysqli_fetch_assoc($blog_query);

        $img = $site . '/assets/img/blog/' . (isset($blog_data['img']) ? $blog_data['img'] : 'sem_imagem.jpg');
        $titulo = isset($blog_data['titulo']) ? htmlspecialchars($blog_data['titulo']) : '';
        $conteudo = isset($blog_data['resumo']) ? htmlspecialchars($blog_data['resumo']) : '';
        $data_publicacao = isset($blog_data['data_publicacao']) ? date('d/m/Y', strtotime($blog_data['data_publicacao'])) : '';
        $categoria = isset($blog_data['categoria']) ? htmlspecialchars($blog_data['categoria']) : '';
        ?>

      
                    <!-- Content -->
                    <div class="col-md-8 col-sm-8">
                        <section id="content">
                            <article class="blog-post">
                                <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                                <header><h2><?= htmlspecialchars($titulo); ?></h2></header>
                                <figure class="meta">
                                    <a href="#" class="link icon"><i class="fa fa-calendar"></i><?= htmlspecialchars($data_publicacao); ?></a>
                                    <a href="#" class="link icon"><i class="fa fa-tag"></i><?= htmlspecialchars($categoria); ?></a>
                                </figure>
                                <p><?= htmlspecialchars($conteudo); ?></p>
                            </article>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        // Se não encontrar o blog, exibe uma mensagem de erro
        echo '<p>Blog não encontrado.</p>';
    }
} else {
    // Se não houver URL amigável, exibe a lista de blogs
    ?>

    <?php
// Verifique se a página acessada é a inicial do blog


$results_per_page = 6; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start_from = ($page - 1) * $results_per_page; 

if (isset($_POST['pesquisa_blog'])) {
    $_SESSION['pesquisa'] = $_POST['pesquisa_blog'];
    $pesquisa = clean($_POST['pesquisa_blog']);
    if(empty($_SESSION['pesquisa'])) {
        header("Location: http://localhost/luiza/luiza/luiza/html/blog");
        exit();
    } else {
        $pesquisa_url = mb_convert_case(str_replace(' ', '-', $pesquisa), MB_CASE_LOWER);
        echo "<meta http-equiv='refresh' content='0;URL=http://localhost/luiza/luiza/luiza/html/blog/pesquisa/" . $pesquisa_url . "'>";
        exit(); 
    }
}

$keyword = isset($_SESSION['pesquisa']) ? $_SESSION['pesquisa'] : '';

$sql = "SELECT id, img, titulo, resumo, data_publicacao, categoria, url_amigavel 
        FROM blog 
        WHERE (titulo LIKE '%$keyword%' OR resumo LIKE '%$keyword%' OR categoria LIKE '%$keyword%') 
        AND status = 'a' 
        ORDER BY data_publicacao DESC
        LIMIT $start_from, $results_per_page";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

// Consulta para determinar o número total de blogs
$total_sql = "SELECT COUNT(*) FROM blog WHERE (titulo LIKE '%$keyword%' OR resumo LIKE '%$keyword%' OR categoria LIKE '%$keyword%') AND status = 'a'";
$total_query = mysqli_query($conn, $total_sql);

if (!$total_query) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

$total_row = mysqli_fetch_array($total_query);
$total_records = $total_row[0];
$total_pages = ceil($total_records / $results_per_page);

// Consulta para obter todas as categorias distintas

?>




            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <?php
                    if ($query && mysqli_num_rows($query) > 0) {
                        if (!empty($_SESSION['pesquisa'])) {
                             
                            echo '<p style="text-align: center; font-weight: bold; margin-bottom: 30px;">Resultados encontrados para <strong>' . htmlspecialchars($_SESSION['pesquisa']) . '</strong>.</p>';
                            unset($_SESSION['pesquisa']);
                        }
                     

                     
                    
                        while ($dados = mysqli_fetch_assoc($query)) {
                            $id = isset($dados['id']) ? $dados['id'] : '';
                            $img = $site .'/assets/img/blog/' . (isset($dados['img']) ? $dados['img'] : 'sem_imagem.jpg');
                            $titulo = isset($dados['titulo']) ? htmlspecialchars($dados['titulo']) : '';
                            $resumo = isset($dados['resumo']) ? htmlspecialchars($dados['resumo']) : '';
                            $data_publicacao = isset($dados['data_publicacao']) ? date('d/m/Y', strtotime($dados['data_publicacao'])) : '';
                            $categoria = isset($dados['categoria']) ? htmlspecialchars($dados['categoria']) : '';
                            $url_amigavel = isset($dados['url_amigavel']) ? htmlspecialchars($dados['url_amigavel']) : '';

                            $url = isset($site) ? $site . "/blog/" . $url_amigavel : "#";
                    ?>
                        <div class="col-md-6 col-sm-12 blog-item">
                            <a href="<?= htmlspecialchars($url); ?>" class="image" style="display: block; height: 280px;">
                                <div class="bg-transfer">
                                    <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                                </div>
                            </a>
                            <h3><?= htmlspecialchars($titulo); ?></h3>
                            <p>
                                
                                <?= htmlspecialchars($resumo); ?>
                            </p>
                            <div class="text-end">
                        <a href="<?= htmlspecialchars($url); ?>" class="btn btn-rounded btn-primary arrow" style="background-color: rgb(212, 170, 80); border:none;">Leia mais</a>
                        </div>
                            
                        </div>
                    <?php
                 
                        }
                    } else {
                        
                        echo '<div class="col-md-12">';
                        echo '<p style="text-align: center; font-weight: bold;">Nenhum resultado encontrado para <strong>' . htmlspecialchars($_SESSION['pesquisa']) . '</strong>.</p>';
                        
                     unset($_SESSION['pesquisa']);

                        // Consulta para listar outros blogs
                        $other_blogs_sql = "SELECT id, img, titulo, resumo, data_publicacao, categoria, url_amigavel 
                                            FROM blog 
                                            WHERE status = 'a' 
                                            ORDER BY data_publicacao DESC
                                            LIMIT 6";
                        $other_blogs_query = mysqli_query($conn, $other_blogs_sql);

                        if ($other_blogs_query && mysqli_num_rows($other_blogs_query) > 0) {
                            echo '<h4 style="text-align: center; font-weight: bold;">Outros blogs disponíveis:</h4>';
                            while ($other_blog = mysqli_fetch_assoc($other_blogs_query)) {
                                $id = isset($other_blog['id']) ? $other_blog['id'] : '';
                                $img = $site . '/assets/img/blog/' . (isset($other_blog['img']) ? $other_blog['img'] : 'sem_imagem.jpg');
                                $titulo = isset($other_blog['titulo']) ? $other_blog['titulo'] : '';
                                $resumo = isset($other_blog['resumo']) ? $other_blog['resumo'] : '';
                                $data_publicacao = isset($other_blog['data_publicacao']) ? date('d/m/Y', strtotime($other_blog['data_publicacao'])) : '';
                                $categoria = isset($other_blog['categoria']) ? $other_blog['categoria'] : '';
                                $url_amigavel = isset($other_blog['url_amigavel']) ? $other_blog['url_amigavel'] : '';
                            ?>
                            <div class="col-md-6 col-sm-12 blog-item">
                            <a href="<?= htmlspecialchars($url); ?>" class="image" style="display: block; height: 280px;">
                                <div class="bg-transfer">
                                    <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                                </div>
                            </a>
                            <h3><?= htmlspecialchars($titulo); ?></h3>
                            <p>
                               
                                <?= htmlspecialchars($resumo); ?>
                            </p>
                            <div class="text-end">
                        <a href="<?= htmlspecialchars($url); ?>" class="btn btn-rounded btn-primary arrow" style="background-color: rgb(212, 170, 80); border:none;">Leia mais</a>
                        </div>


                        </div>
                        <?php
                            }
                        } else {
                            echo '<p style="text-align: center;">Nenhum outro blog disponível no momento.</p>';
                        }
                        echo '</div>';
                    }
                    ?>
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
    <!--end page-content-->
    <?php
}
?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/custom.js"></script>




</body>
