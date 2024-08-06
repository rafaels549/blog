<?php
ob_start();
require_once ("config.php");
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


<div class="block" id="contato">
                <div class="container">
                    <h2>Contato</h2>
                    <div class="contact map">
                        <div class="row">
                            <div class="col-md-5 col-sm-5" data-scroll-reveal="enter bottom and move 20px">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <h3>Menus</h3>
                                        <p>
                                            <a href="">Home</a><br>
                                            <a href="">Cursos</a><br>
                                            <a href="">Sobre</a><br>
                                            <a href="">Equipe</a><br>
                                            <a href="">Blog</a><br>
                                        </p>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <h3>Redes sociais</h3>
                                        <div class="social">
                                            <a href="https://www.facebook.com/hofteambrazil?mibextid=ZbWKwL&_rdc=1&_rdr"><i class="social_facebook_circle"></i>Facebook</a>
                                            <a href="https://www.instagram.com/hofteambrazil/"><i class="social_instagram_circle"></i>Instagram</a>
                                        </div>
                                        <!--end social-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-7" data-scroll-reveal="enter top and move 20px">
                                <h3>Tire suas dúvidas</h3>
                                <form id="form-contact" method="post" class="clearfix">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="form-contact-name"
                                                    name="nome" placeholder="Nome completo" required>
                                            </div>
                                            <!--end form-group -->
                                        </div>
                                        <!--end col-md-6 col-sm-6 -->
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="tel" class="form-control  celular" id="form-contact-email"
                                                    name="whatsapp"  placeholder="Seu Whatsapp" required>
                                            </div>
                                            <!--end form-group -->
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <input type="email" class="form-control" id="form-contact-email"
                                                    name="email"  placeholder="Seu Email" required>
                                            </div>
                                            <!--end form-group -->
                                        </div>
                                        <!--end col-md-6 col-sm-6 -->
                                    </div>
                                    <!--end row -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" id="form-contact-message" rows="8"
                                                    name="mensagem" placeholder="Sua mensagem" required></textarea>
                                            </div>
                                            <!--end form-group -->
                                        </div>
                                        <!--end col-md-12 -->
                                    </div>
                                    <!--end row -->
                                    <div class="form-group clearfix">
                                        <button name="acao" value="enviar" type="submit" class="btn pull-right btn-primary btn-rounded"
                                            id="form-contact-submit">Enviar</button>
                                    </div>
                                    <!--end form-group -->
                                    <div id="form-contact-status"></div>
                                </form>
                                <!--end form-contact -->
                            </div>
                            <!--end col-md-6-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end contact map-->
                </div>
                <!--end container-->
            </div>