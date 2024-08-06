<!DOCTYPE html>
<?php


ob_start();
require_once ("includes/config.php");

/* $canonical = $site;  */

 
if (isset($_GET['url_amigavel'])) {
  
    $url_amigavel = mysqli_real_escape_string($conn, $_GET['url_amigavel']);
    
    // Consulta para obter os dados do curso
    $sql_curso = "SELECT id, img, img_secundaria, titulo, inicio, duracao, cidade, instituicao, url_amigavel,descricao 
                  FROM cursos 
                  WHERE url_amigavel = '$url_amigavel'";
    
    $query_curso = mysqli_query($conn, $sql_curso);

    if ($query_curso && mysqli_num_rows($query_curso) > 0) {
        $curso = mysqli_fetch_assoc($query_curso);
        $curso_id = $curso['id']; 
        $vb_descricao_site =   $curso['descricao'];
        $vb_meta_site =  $curso['titulo'];
        $sql_professores = "SELECT cp.coordenador, p.id, p.nome, p.cargo, p.img, p.facebook, p.twitter, p.instagram
                            FROM curso_professores cp
                            INNER JOIN equipe p ON cp.professor_id = p.id
                            WHERE cp.curso_id = $curso_id";
        
        $query_professores = mysqli_query($conn, $sql_professores);
        
      
        if ($query_professores && mysqli_num_rows($query_professores) > 0) {
            $professores = mysqli_fetch_all($query_professores, MYSQLI_ASSOC);
        } else {
            $professores = []; 
        }
          
     
        $vb_titulo_site = "Cursos - " . $curso['titulo'];
        
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["acao"]) && $_POST["acao"] == "matricular") {
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');   
        date_default_timezone_set('America/Sao_Paulo');

        // Coletar dados do formulário e sanitizar
        $nome = strip_tags($_POST['nome_completo']);
        $rg = strip_tags($_POST['rg']);
        $cpf = strip_tags($_POST['cpf']);
        $email = strip_tags($_POST['email']);
        $celular = strip_tags($_POST['celular']);
        $curso_id = strip_tags($_POST['curso_id']);
        
       
        $dominio = str_replace('www.', '', $_SERVER['HTTP_HOST']);
        $data_atual = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $mensagememail = "<strong>Curso:</strong> " . htmlspecialchars($curso['titulo']) . "<br>";
        $mensagememail .= "<strong>Nome:</strong> $nome<br>";
        $mensagememail .= "<strong>RG:</strong> $rg<br>";
        $mensagememail .= "<strong>CPF:</strong> $cpf<br>";
        $mensagememail .= "<strong>E-mail:</strong> $email<br>";
        $mensagememail .= "<strong>Celular:</strong> $celular<br><br>";
        $mensagememail .= '<strong>IP:</strong> '.$_SERVER['REMOTE_ADDR'].'<br>';
        $mensagememail .= '<strong>Endereço IP:</strong> '.gethostbyaddr($_SERVER['REMOTE_ADDR']).'<br>';
        $mensagememail .= ucfirst(IntlDateFormatter::formatObject($data_atual, "eeee, d 'de' MMMM y 'às' HH:mm", 'pt_BR')).'<br>';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $vb_nome . ' <' . $vb_email . '>' . "\r\n";
        $headers .= 'Bcc: Virtua Brasil<contato@virtuabrasil.com.br>' . "\r\n";
        $headers .= 'Bcc: Virtua Brasil<dev@virtuabrasil.com.br>' . "\r\n";
        $headers .= 'Reply-To: ' . $nome . ' <' . $email . '>' . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        $assunto = '* Formulário de Matrícula *';
        $email_to = $vb_nome . '<' . $vb_email . '>';

        // Enviar e-mail
        $successo = mail(iconv("UTF-8", "ISO-8859-1", $email_to), iconv("UTF-8", "ISO-8859-1", $assunto), iconv("UTF-8", "ISO-8859-1", $mensagememail), iconv("UTF-8", "ISO-8859-1", $headers));

        // Inserir dados na tabela duvidas
        if ($successo) {
            // Inserir na tabela duvidas
            $sql = "INSERT INTO matricula (nome, rg, cpf, email, celular, curso_id, data_envio) VALUES ('$nome', '$rg', '$cpf', '$email', '$celular', $curso_id, NOW())";
            
            if (mysqli_query($conn, $sql)) {
                echo '<meta http-equiv="refresh" content="0;URL=obrigado">';
                exit();
            } else {
                echo "<script>alert('Erro ao salvar os dados!');</script>";
            }
        } else {
            echo "<script>alert('Erro ao enviar o e-mail!');</script>";
        }
    }

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
$header_titulo = $curso['titulo'];
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
    <div class="block" id="cursos">
      <div class="container ">
  
        <!-- Sidebar (se necessário) -->

        <!-- Conteúdo principal -->
        <div class="col-md-12 ">
            <div class="row">
                <!-- Detalhes do Curso -->
                <div class="col-md-4 ">
                    <div class="card mb-4 ">
                        <img src="<?= $site . '/assets/img/' . (isset($curso['img']) ? $curso['img'] : 'sem_imagem.jpg') ?>" class="card-img-top w-100 img-fluid" alt="Imagem do Curso">
                        <div class="card-body text-start">
                            <h5 class="card-title"><?= htmlspecialchars($curso['titulo']) ?></h5>
                            <p class="card-text"><i class="bi bi-calendar"></i> <strong>Início:</strong> <?= htmlspecialchars($curso['inicio']) ?></p>
                            <p class="card-text"><i class="bi bi-geo-alt"></i> <strong>Cidade:</strong> <?= htmlspecialchars($curso['cidade']) ?></p>
                            <p class="card-text"><i class="bi bi-clock"></i> <strong>Duração:</strong> <?= htmlspecialchars($curso['duracao']) ?></p>
                            <p class="card-text"><i class="bi bi-building"></i> <strong>Instituição:</strong> <?= htmlspecialchars($curso['instituicao']) ?></p>
                           
                        </div>
                       
                    </div>
                 
                    <h2  style="color: rgb(212, 170, 80);">Nossos Professores:</h2>
                       
                        <div class="owl-carousel owl-theme" id="matricula-carousel">
                    <?php if (!empty($professores)) { ?>
                        <?php foreach ($professores as $professor) {
                            
                            // Verifica se o professor não é coordenador
                            if ($professor['coordenador'] == 0) {
                                $img = $site . '/assets/img/equipe/' . (isset($professor['img']) ? $professor['img'] : 'sem_imagem.jpg');
                        ?>
                       
                           
                                <a href="#" title="Professor">
                                    <img src="<?= htmlspecialchars($img); ?>" alt="Professor" class="img-fluid w-100" style="border-radius: 50%; width: 100%; ">
                                </a>
                           
                        <?php 
                            } 
                        } ?>
                    <?php } else { ?>
                        <p>Não há professores para exibir.</p>
                    <?php } ?>
               
                   
                </div>
                </div>

                <!-- Formulário de Matrícula -->
                <div class="col-md-8">
                <h2 class="titulo-matricula" style="color: rgb(212, 170, 80);">Sobre o Curso</h2>
                <p class="card-text"><?= htmlspecialchars($curso['descricao']) ?></p>

                <h2 class="titulo-matricula" style="color: rgb(212, 170, 80);">Nossos Coordenadores:</h2>
                        <div class="coordenadores">
                    <?php if (!empty($professores)) { ?>
                        <?php foreach ($professores as $professor) {
                            
                            // Verifica se o professor não é coordenador
                            if ($professor['coordenador'] == 1) {
                                $img = $site . '/assets/img/equipe/' . (isset($professor['img']) ? $professor['img'] : 'sem_imagem.jpg');
                        ?>
                       
                           
                                <a href="#" class="img-professor" title="Professor">
                                    <img src="<?= htmlspecialchars($img); ?>" alt="Professor" class="img-fluid w-100" style="border-radius: 50%; width: 200px; margin:5px;">
                                </a>
                           
                        <?php 
                            } 
                        } ?>
                    <?php } else { ?>
                        <p>Não há professores para exibir.</p>
                    <?php } ?>

                </div>
                <form id="matricula-form" method="POST" novalidate>
           <input type="hidden" name="curso_id" value="<?= htmlspecialchars($curso['id']) ?>">
               <div class="row">
        <div class="col-12">
             <div class="section divider divider-gray mb-4"></div>
           </div>
           <div class="col-md-12 mb-4">
            <h2 class="titulo-matricula" style="color: rgb(212, 170, 80);" class="mb-1">Matricule-se</h2>
            <div class="form-group">
                <i class="bi bi-person-fill"></i>
                <input type="text" name="nome_completo" class="form-control" placeholder="Nome Completo" id="nome" autocomplete="off" >
              
            </div>
           </div>
              <div class="col-md-6 mt-4">
            <div class="form-group">
                <i class="bi bi-credit-card-2-front-fill"></i>
                <input type="text" name="rg" class="form-control" placeholder="RG" id="rg" autocomplete="off">
            
            </div>
            </div>
             <div class="col-md-6 mt-4">
            <div class="form-group">
                <i class="bi bi-file-earmark-person"></i>
                <input type="text" name="cpf" class="form-control" placeholder="CPF" id="cpf" autocomplete="off">
              
            </div>
             </div>
            <div class="col-md-6 mt-4">
            <div class="form-group">
                <i class="bi bi-envelope-fill"></i>
                <input type="email" name="email" class="form-control" placeholder="E-MAIL" id="email" autocomplete="off">
          
            </div>
             </div>
              <div class="col-md-6 mt-4">
            <div class="form-group">
                <i class="bi bi-phone-fill"></i>
                <input type="tel" name="celular" class="form-control celular" placeholder="WHATSAPP"  autocomplete="off">
               
            </div>
              </div>
              <div class="col-12 pt-5 text-right"> <!-- Adiciona a classe text-right aqui -->
            <button type="submit" name="acao" value="matricular"  style="background-color: #000; color: #fff; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease, transform 0.2s ease;" onmouseover="this.style.backgroundColor='#333'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#000'; this.style.transform='scale(1.0)';" onfocus="this.style.outline='none'; this.style.boxShadow='none';" onblur="this.style.outline=''; this.style.boxShadow='';"class="btn btn-dark-primary">Enviar <i class="bi bi-arrow-right ml-2"></i></button>
             </div>
        </div>
        </form>
                </div>
            </div>

            <!-- Botão Voltar -->
            <div  style="margin-top: 10px !important">
            <button title="Voltar" class="btn btn-dark back-button" onclick="window.history.back();" style="background-color: #000; color: #fff; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease, transform 0.2s ease;" onmouseover="this.style.backgroundColor='#333'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#000'; this.style.transform='scale(1.0)';" onfocus="this.style.outline='none'; this.style.boxShadow='none';" onblur="this.style.outline=''; this.style.boxShadow='';">Voltar</button>
            </div>
        </div>
    </div>  
 

           
            <!--end block-->

        </div>
        <!--end page-content-->
        <?php

include_once 'includes/contato.php';

?>
    
    <?php

include_once 'includes/footer.php';

?>   <!--end page-footer-->

    </div>
    <!--end page-wrapper-->


 

</body>


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
    <script >
        $(document).ready(function() {
    // Aplicando a máscara para o campo de celular
   
    
    // Aplicando a máscara para o campo de CPF
    $('#cpf').mask('000.000.000-00')
     
    // Aplicando a máscara para o campo de RG
    $('#rg').mask('00.000.000-0')
    $("#matricula-form").validate({
        rules: {
            nome_completo: {
                required: true,
                minlength: 3
            },
            rg: {
                required: true,
                minlength: 9,
                maxlength: 12
            },
            cpf: {
                required: true,
                cpfBR: true // Você pode adicionar uma validação CPF personalizada se necessário
            },
            email: {
                required: true,
                email: true
            },
            celular: {
                required: true,
                minlength: 14 // Para o formato (00) 00000-0000
            }
        },
        messages: {
            nome_completo: {
                required: "Por favor, insira seu nome completo.",
                minlength: "O nome completo deve ter pelo menos 3 caracteres."
            },
            rg: {
                required: "Por favor, insira o RG.",
                minlength: "O RG deve ter pelo menos 9 caracteres.",
                maxlength: "O RG não pode ter mais de 12 caracteres."
            },
            cpf: {
                required: "Por favor, insira o CPF.",
                cpfBR: "Por favor, insira um CPF válido." // Se precisar de validação personalizada
            },
            email: {
                required: "Por favor, insira seu e-mail.",
                email: "Por favor, insira um e-mail válido."
            },
            celular: {
                required: "Por favor, insira seu número de celular.",
                minlength: "O número de celular deve ter pelo menos 14 caracteres."
            }
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function(element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element) {
            $(element).removeClass("is-invalid");
        }
    });

    $.validator.addMethod("cpfBR", function(value, element) {
    // Remove todos os caracteres não numéricos
    value = value.replace(/[^\d]+/g, '');

    // Verifica se o CPF tem 11 dígitos e não é uma sequência repetitiva
    if (value.length !== 11 || /^(\d)\1{10}$/.test(value)) {
        return false;
    }

    let sum = 0;
    let remainder;

    // Valida o primeiro dígito verificador
    for (let i = 1; i <= 9; i++) {
        sum += parseInt(value.charAt(i - 1)) * (11 - i);
    }
    remainder = (sum * 10) % 11;
    if (remainder === 10 || remainder === 11) {
        remainder = 0;
    }
    if (remainder !== parseInt(value.charAt(9))) {
        return false;
    }

    sum = 0;

    // Valida o segundo dígito verificador
    for (let i = 1; i <= 10; i++) {
        sum += parseInt(value.charAt(i - 1)) * (12 - i);
    }
    remainder = (sum * 10) % 11;
    if (remainder === 10 || remainder === 11) {
        remainder = 0;
    }
    if (remainder !== parseInt(value.charAt(10))) {
        return false;
    }

    return true;
}, "Por favor, insira um CPF válido.");
   
});

    </script>