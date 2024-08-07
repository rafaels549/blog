<!DOCTYPE html>
<?php


ob_start();
require_once ("includes/config.php");

/* $canonical = $site;  */
 $vb_titulo_site = $vb_nome ; 


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
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ThemeStarz">

    <link href="assets/fonts/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="assets/fonts/elegant-fonts.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">


    <title>HOF Team Brazil</title>

</head>

<body class="has-loading-screen links-hover-effect" data-spy="scroll" data-target=".navigation">

    <div class="page-wrapper" id="page-top">
        <header id="page-header">
            <nav class="navigation background-is-dark">
                <div class="container">
                    <div class="wrapper">
                        <div class="left">
                            <a href="/" class="brand"><img src="assets/img/logo-c.png" class="animate" style="height: 50px;" alt=""></a>
                        </div>
                        <!--end left-->
                        <div class="right">
                            <ul class="nav navigation-links animate">
                                <li><a href="#page-top" class="scroll">Home</a></li>
                                <li><a href="#cursos" class="scroll">Cursos</a></li>
                                <li><a href="#sobre" class="scroll">Sobre</a></li>
                                <li><a href="#equipe" class="scroll">Equipe</a></li>
                                <li><a href="#blog" class="scroll">Blog</a></li>
                                <li><a href="#contato" class="scroll">Contato</a></li>
                            </ul>
                            <div class="nav-btn">
                                <figure></figure>
                                <figure></figure>
                                <figure></figure>
                            </div>
                        </div>
                        <!--end right-->
                    </div>
                </div>
                <!--end container-->
            </nav>
            <!--end navigation-->
            <div class="hero-section background-is-dark">
                <div class="wrapper">
                    <div class="hero-title">
                        <div class="container">
                           
                            <h1 class="animate" style="color: rgb(212, 170, 80);">Harmonização<br>Orofacial</h1>
                            <div class="animate">
                                <p class="width-50">
                                    Torne-se um especialista em aprimorar a beleza e a saúde facial. Inscreva-se agora e
                                    destaque-se na área da Harmonização Orofacial!
                                </p>
                            </div>
                            <div class="animate btn-custom ">
                                <a href="#cursos" class="btn  btn-rounded btn-default scroll">NOSSOS CURSOS</a>
                                <a href="#contato" class="btn  btn-rounded btn-default btn-framed scroll">Entre em Contato</a>
                            </div>
                        </div>
                        <!--end container-->
                    </div>
                    <!--end hero-title-->
                </div>
                <!--end wrapper-->
                <div class="owl-carousel" id="carouselHero">
                    <div class="hero-slide">
                      <div class="bg-transfer"><img src="assets/img/slide-09.jpg" alt=""></div>
                       </div>
                    <div class="hero-slide">
                      <div class="bg-transfer"><img src="assets/img/slide-02.jpg" alt=""></div>
                       </div>
                    <div class="hero-slide">
                      <div class="bg-transfer"><img src="assets/img/slide-03.jpg" alt=""></div>
                       </div>
                  </div>
              
                </div>

                
            <!--end hero-section-->
        </header>
        <!--end page-header-->

        <?php
$sql = "SELECT id, img, img_secundaria, titulo, inicio, duracao, cidade, instituicao, url_amigavel 
        FROM cursos 
        WHERE status = 'a' 
        ORDER BY ordem ASC 
        LIMIT 6";

$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
?> 
    <div class="block" id="cursos">
        <div class="container">
            <h2 style="color: rgb(212, 170, 80);">Nossos Cursos</h2>
            <div class="owl-carousel owl-theme " id="curso-carousel">
                <?php
                while ($dados = mysqli_fetch_assoc($query)) {
                    $id = isset($dados['id']) ? $dados['id'] : '';
                    $img = 'assets/img/' . (isset($dados['img']) ? $dados['img'] : 'sem_imagem.jpg');
                    $img_secundaria = 'assets/img/cursos/' . (isset($dados['img_secundaria']) ? $dados['img_secundaria'] : '');
                    
                    if (!file_exists($img) || empty($dados['img'])) {
                        $img = 'assets/img/sem_imagem.jpg';
                    }
                    
                    $titulo = isset($dados['titulo']) ? htmlspecialchars($dados['titulo']) : '';
                    $inicio = isset($dados['inicio']) ? htmlspecialchars($dados['inicio']) : '';
                    $duracao = isset($dados['duracao']) ? htmlspecialchars($dados['duracao']) : '';
                    $cidade = isset($dados['cidade']) ? htmlspecialchars($dados['cidade']) : '';
                    $instituicao = isset($dados['instituicao']) ? htmlspecialchars($dados['instituicao']) : '';
                    $url_amigavel = isset($dados['url_amigavel']) ? htmlspecialchars($dados['url_amigavel']) : '';
                    
                    $url = isset($site) ? $site . "/cursos/" . $url_amigavel : "#";
                ?>
                    
                        <div class="blog-item" data-scroll-reveal="enter left and move 20px">
                            <a href="<?= htmlspecialchars($url); ?>" class="image" style="display: block; height: 280px;">
                                <div class="bg-transfer" >
                                    <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                                </div>
                            </a>
                            <!--end image-->
                            <h3><?= htmlspecialchars($titulo); ?></h3>
                            <p>
                                <strong><i class="bi bi-calendar mr-2"></i>  Início:</strong> <?= htmlspecialchars($inicio); ?><br>
                                <strong><i class="bi bi-clock mr-2"></i> Duração:</strong> <?= htmlspecialchars($duracao); ?><br>
                                <strong><i class="bi bi-geo-alt mr-2"></i> Cidade:</strong> <?= htmlspecialchars($cidade); ?><br>
                                <strong><i class="bi bi-building mr-2"></i> Instituição:</strong> <?= htmlspecialchars($instituicao); ?>
                            </p>
                            <div class="text-end">
                            <a   href="<?= htmlspecialchars($url); ?>" class="btn btn-rounded btn-primary arrow text-end" style="background-color: rgb(212, 170, 80); border:none;magin-left:100px; ">
                                Saiba Mais
                                
                                </a>
                            </div>
                        </div>
                        <!--end blog-item-->
                           
                <?php } ?> 
                
            </div>
               
            <div class="text-center" style="margin-top: 3rem;">
                <a href="<?=$site;?>/cursos" class="btn btn-rounded btn-primary arrow text-center" style="background-color: rgb(212, 170, 80); border:none;padding:15px;padding-right: 35px; padding-left: 35px; position: relative;" >Conheça os nossos Cursos </a>
            </div>
         </div>
    </div>
<?php } ?>
            <!--end block-->

            <div class="block background-is-dark" id="sobre">
                <div class="container d-flex justify-content-center align-items-center">
                    <h2 style="color: rgb(212, 170, 80);">Sobre Nós</h2>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-md-6 col-sm-6 d-flex justify-content-center align-items-center">
                            <h3>Conheça nossa história</h3>
                            <p>Nam in sodales massa. Donec at ullamcorper diam. Pellentesque habitant morbi tristique
                                senectus et netus et malesuada fames ac turpis egestas. Vivamus et ornare leo,
                                a commodo tellus. Suspendisse potenti. Ut posuere viverra lectus non scelerisque.
                            </p>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading1">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#feature1" aria-expanded="true" aria-controls="feature1">Certificado</a>
                                        </h4>
                                    </div>
                                    <div id="feature1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
                                        <div class="panel-body">
                                            <p>Nunc vel erat eget dolor lobortis venenatis eget in nulla. Aliquam sodales
                                                elit in augue finibus, at sagittis enim vestibulum.
                                                Vivamus varius, velit sollicitudin interdum cursus, augue purus dignissim
                                                quam, dictum commodo lorem ante quis neque. Etiam massa erat, tristique
                                                id semper ac, placerat ac magna.
                                            </p>
                                        </div>
                                        <!--/ .panel-body-->
                                    </div>
                                    <!--/ .panel-collapse-->
                                </div>
                                <!--/ .panel-->
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading2">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#feature2" aria-expanded="true" aria-controls="feature2">Professores qualificados</a>
                                        </h4>
                                    </div>
                                    <div id="feature2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                                        <div class="panel-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dapibus
                                                elit nibh, id scelerisque tortor ornare at. Maecenas finibus purus id massa
                                                viverra, a commodo enim imperdiet. Donec ac magna non nisi hendrerit facilisis.
                                                In a nisl mi. Fusce vulputate sodales laoreet. Phasellus et urna risus.
                                            </p>
                                        </div>
                                        <!--/ .panel-body-->
                                    </div>
                                    <!--/ .panel-collapse-->
                                </div>
                                <!--/ .panel-->
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading3">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#feature3" aria-expanded="true" aria-controls="feature3">Aulas práticas</a>
                                        </h4>
                                    </div>
                                    <div id="feature3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                                        <div class="panel-body">
                                            <p>Donec ut pellentesque nunc. Maecenas malesuada et eros sed tristique. Cras
                                                condimentum in ligula ac efficitur. Vestibulum tempor leo nec molestie bibendum.
                                                Maecenas molestie ligula id efficitur venenatis. Maecenas venenatis mauris
                                                in erat imperdiet, et suscipit ipsum pretium.
                                            </p>
                                        </div>
                                        <!--/ .panel-body-->
                                    </div>
                                    <!--/ .panel-collapse-->
                                </div>
                                <!--/ .panel-->
                            </div>
                            <!--/ .panel-group-->
                        </div>
                        <!--end col-md-6-->
                        <div class="col-md-6 col-sm-6 d-flex justify-content-center align-items-center">
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/MTxUOL2xj54?si=LLnRUPvDcS9WifuO" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <!--end one-item-carousel-->
                        </div>
                        <!--end col-md-6-->
                    </div>
                    <!--end row-->
                </div>
                <!--end container-->
                <div class="background-wrapper">
                    <div class="background-color background-color-black"></div>
                </div>
                <!--end background-wrapper-->
            </div>
            <!--end block-->

            <?php
$sql = "SELECT id, img, titulo, url_amigavel 
        FROM patrocinadores 
        WHERE status = 'a' 
        ORDER BY ordem ASC";

$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
?> 
    <div class="block">
        <div class="container">
            <div class="logos">
                <div class="owl-carousel" id="patrocinador" data-owl-nav="1" data-owl-dots="0" data-owl-items="5">
                    <?php
                    while ($dados = mysqli_fetch_assoc($query)) {
                        $id = isset($dados['id']) ? $dados['id'] : '';
                        $img = 'assets/img/' . (isset($dados['img']) ? $dados['img'] : 'sem_imagem.jpg');
                        
                        if (!file_exists($img) || empty($dados['img'])) {
                            $img = 'assets/img/sem_imagem.jpg';
                        }

                        $titulo = isset($dados['titulo']) ? htmlspecialchars($dados['titulo']) : '';
                        $url_amigavel = isset($dados['url_amigavel']) ? htmlspecialchars($dados['url_amigavel']) : '';
                        $url =  $url_amigavel ;
                    ?>
                        <div class="logo">
                            <a href="<?= htmlspecialchars($url); ?>" title="<?= htmlspecialchars($titulo); ?>">
                                <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!--end logos-->
        </div>
        <!--end container-->
    </div>
<?php } ?>

            <!--end block-->
            <?php
$sql = "SELECT id, nome, cargo, img, facebook, twitter, instagram 
        FROM equipe 
        WHERE status = 'a' 
        ORDER BY ordem ASC";

$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
?> 
    <div class="block" id="equipe">
        <div class="container position-relative">
            <h2 style="color: rgb(212, 170, 80); margin-bottom: 50px;">Equipe</h2>
            <div class="owl-carousel owl-theme" id="team-carousel">
                <?php
                while ($dados = mysqli_fetch_assoc($query)) {
                    $id = isset($dados['id']) ? $dados['id'] : '';
                    $nome = isset($dados['nome']) ? htmlspecialchars($dados['nome']) : '';
                    $cargo = isset($dados['cargo']) ? htmlspecialchars($dados['cargo']) : '';
                    $img = 'assets/img/equipe/' . (isset($dados['img']) ? $dados['img'] : 'sem_imagem.jpg');
                    
                    if (!file_exists($img) || empty($dados['img'])) {
                        $img = 'assets/img/sem_imagem.jpg';
                    }
                    
                    $facebook = isset($dados['facebook']) ? htmlspecialchars($dados['facebook']) : '';
                    $twitter = isset($dados['twitter']) ? htmlspecialchars($dados['twitter']) : '';
                    $instagram = isset($dados['instagram']) ? htmlspecialchars($dados['instagram']) : '';
                ?>
                    <div class="item">
                        <div class="person center framed">
                            <div class="image">
                                <div class="bg-transfer">
                                    <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($nome); ?>">
                                </div>
                            </div>
                            <h3><?= htmlspecialchars($nome); ?></h3>
                            <h4><?= htmlspecialchars($cargo); ?></h4>
                            <div class="social">
                            <?php if (!empty($facebook)): ?>
                    <a href="<?= htmlspecialchars($facebook); ?>"><i class="social_facebook_circle"></i></a>
                <?php endif; ?>
                
                <?php if (!empty($twitter)): ?>
                    <a href="<?= htmlspecialchars($twitter); ?>"><i class="social_twitter_circle"></i></a>
                <?php endif; ?>
                
                <?php if (!empty($instagram)): ?>
                    <a href="<?= htmlspecialchars($instagram); ?>"><i class="social_instagram_circle"></i></a>
                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

          
        </div>
        <div class="text-center" style="margin-top: 3rem;">
                <a href="<?=$site;?>/equipe" class="btn btn-rounded btn-primary arrow text-center" style="background-color: rgb(212, 170, 80); border:none;padding:15px;padding-right: 35px; padding-left: 35px; position: relative;" >Conheça os nossa equipe </a>
            </div>
    </div>
<?php } ?>

<?php
$sql = "SELECT id, titulo, resumo, img, url_amigavel 
        FROM blog 
        WHERE status = 'a' 
        ORDER BY data_publicacao DESC";

$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
?> 
    <div class="block" id="blog">
        <div class="container">
            <h2 style="color: rgb(212, 170, 80); margin-bottom: 50px;">Blog</h2>
            <div class="owl-carousel owl-theme " id="blogCarousel">
                <?php
                while ($dados = mysqli_fetch_assoc($query)) {
                    $id = isset($dados['id']) ? $dados['id'] : '';
                    $titulo = isset($dados['titulo']) ? htmlspecialchars($dados['titulo']) : '';
                    $resumo = isset($dados['resumo']) ? htmlspecialchars($dados['resumo']) : '';
                    $img = 'assets/img/blog/' . (isset($dados['img']) ? $dados['img'] : 'sem_imagem.jpg');
                    
                    if (!file_exists($img) || empty($dados['img'])) {
                        $img = 'assets/img/sem_imagem.jpg';
                    }
                    
                    $url_amigavel = isset($dados['url_amigavel']) ? htmlspecialchars($dados['url_amigavel']) : '';
                    $url = isset($site) ? $site . "/blog/" . $url_amigavel : '#';
                ?>
                    <div class="blog-item" data-scroll-reveal="enter left and move 20px">
                        <a href="<?= htmlspecialchars($url); ?>" class="image" style="height: 280px;">
                            <div class="bg-transfer">
                                <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($titulo); ?>" >
                            </div>
                        </a>
                        <h3><?= htmlspecialchars($titulo); ?></h3>
                        <p><?= htmlspecialchars($resumo); ?></p>
                         <div class="text-end">
                        <a href="<?= htmlspecialchars($url); ?>" class="btn btn-rounded btn-primary arrow" style="background-color: rgb(212, 170, 80); border:none;">Leia mais</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!--end owl-carousel-->
        </div>
        <div class="text-center" style="margin-top: 3rem;">
                <a href="<?=$site;?>/blog" class="btn btn-rounded btn-primary arrow text-center" style="background-color: rgb(212, 170, 80); border:none;padding:15px;padding-right: 35px; padding-left: 35px; position: relative;" >Conheça os nosso blog </a>
            </div>
        <!--end container-->
    </div>
<?php } ?>
            <!--end block-->


            <div class="container">
                <hr>
            </div>
            <!--end container-->



            <?php

include_once 'includes/contato.php';

?>
            <!--end block-->

        </div>
        <!--end page-content-->

      
        <!--end page-footer-->

    </div>
    <!--end page-wrapper-->


    <?php

include_once 'includes/footer.php';

?>

</body>


   <!--end outer-wrapper-->
    <!--end outer-wrapper-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<script src="https://cdn.es.gov.br/scripts/jquery/jquery-mask/1.7.7/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?=$site;?>/assets/js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>