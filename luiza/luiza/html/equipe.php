<?php
ob_start();
require_once ("includes/config.php");
?>

<!DOCTYPE html>
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
$header_titulo = 'Equipe';
include_once 'includes/header.php';

?>
<?php
ob_start();
require_once ("includes/config.php");
$sql = "SELECT id, nome, cargo, img, facebook, twitter, instagram 
        FROM equipe 
        WHERE status = 'a' 
        ORDER BY ordem ASC";

$query = mysqli_query($conn, $sql);

if ($query && mysqli_num_rows($query) > 0) {
?> 
    <div class="block" id="equipe">
        <div class="container position-relative">
       
            <div class="d-flex" >
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
                    <div class="item col-md-4">
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
       
    </div>
    <?php } ?>
    <?php

include_once 'includes/contato.php';

?>
    
    <?php

include_once 'includes/footer.php';

?>   <!--end page-footer-->

    </div>
    <!--end page-wrapper-->

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
 

</body>
