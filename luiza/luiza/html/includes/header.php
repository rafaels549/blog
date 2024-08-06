<?php


ob_start();
require_once ("includes/config.php");

/* $canonical = $site;  */
if (!empty($_POST['pesquisa_blog'])) {
    $vb_titulo_site = "Cursos - " . $_POST['pesquisa_blog']; 
} else {
    $vb_titulo_site = "Cursos - " . $vb_nome;
}

 
 $header_titulo;


?>


<header id="page-header">
      <nav class="navigation background-is-dark">
                <div class="container">
                    <div class="wrapper">
                        <div class="left">
                            <a href="/" class="brand"><img src="<?=$site;?>/assets/img/logo-hof-team-brazil.png" class="animate" style="height: 50px;" alt=""></a>
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
        <div class="hero-section background-is-dark blog-title">
            <div class="wrapper">
                <div class="hero-title">
                    <div class="container">
                        <h1 class="animate" style="color: rgb(212, 170, 80);"><?=$header_titulo?></h1>
                    </div>
                    <!--end container-->
                </div>
                <!--end hero-title-->
            </div>
            <!--end wrapper-->
        </div>
        <!--end hero-section-->
    </header>