<?php
session_start();
error_reporting(E_ALL);
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

// Atualize as credenciais de conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "", "hof_team_brazil");


// Verifique se a conexão foi bem-sucedida
if (mysqli_connect_errno()) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Defina o conjunto de caracteres da conexão para UTF-8
mysqli_set_charset($conn, "utf8");

$vb_nome = "HOF Team Brazil"; 
$vb_titulo_site = "HOF Team Brazil"; 
$vb_descricao_site = "HOF Team Brazil, cursos de harmonização orofacial e estética avançada, ministrados por profissionais qualificados, em várias cidades do Brasil."; 
$vb_meta_site = "cursos, harmonização orofacial, estética avançada, HOF Team Brazil, Taubaté, Campinas, Pindamonhangaba, Rio de Janeiro, especialização";
$vb_email = "contato@hofteambrazil.com.br";
$vb_email_site = "mailto:$vb_email";
$dominio = $_SERVER['HTTP_HOST'] .'/luiza/luiza/luiza/html';
$site = "http://$dominio";
$vb_autor_site = "Virtua Brasil";
$vb_sub_site = "HOF Team Brazil";
$vb_img_og =  $site.'/assets/img/logo-hof-team-brazil.png';
$vb_tipo = "educacional";
$vb_idioma = "pt-BR";
$vb_sessao= "hofteambrazil";
$canonical = $site;
// Adicione qualquer outra configuração ou lógica necessária aqui

function clean($string)
{
    $table = array(
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z',
        'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
        'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
        'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
        'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
        'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
        'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '-'=>'',
    );
    // Traduz os caracteres em $string, baseado no vetor $table
    $string = trim($string);
    $string = strtr($string, $table);
    // converte para minúsculo
    $string = strtolower($string);
    // remove caracteres indesejáveis (que não estão no padrão)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    // Remove múltiplas ocorrências de hífens ou espaços
    $string = preg_replace("/[\s-]+/", " ", $string);
    // Transforma espaços e underscores em hífens
    $string = preg_replace("/[\s_]/", "-", $string);
    if (substr($string, -1) == '-') $string = substr($string, 0, -1);

    // retorna a string
    return $string;
}
function reverse_clean($string)
{
    // Mapeamento dos caracteres limpos para seus caracteres originais
    $table = array(
        'S'=>'Š', 's'=>'š', 'Dj'=>'Đ', 'dj'=>'đ', 'Z'=>'Ž',
        'z'=>'ž', 'C'=>'Č', 'c'=>'č', 'C'=>'Ć', 'c'=>'ć',
        'A'=>'À', 'A'=>'Á', 'A'=>'Â', 'A'=>'Ã', 'A'=>'Ä',
        'A'=>'Å', 'A'=>'Æ', 'C'=>'Ç', 'E'=>'È', 'E'=>'É',
        'E'=>'Ê', 'E'=>'Ë', 'I'=>'Ì', 'I'=>'Í', 'I'=>'Î',
        'I'=>'Ï', 'N'=>'Ñ', 'O'=>'Ò', 'O'=>'Ó', 'O'=>'Ô',
        'O'=>'Õ', 'O'=>'Ö', 'O'=>'Ø', 'U'=>'Ù', 'U'=>'Ú',
        'U'=>'Û', 'U'=>'Ü', 'Y'=>'Ý', 'B'=>'Þ', 'Ss'=>'ß',
        'a'=>'à', 'a'=>'á', 'a'=>'â', 'a'=>'ã', 'a'=>'ä',
        'a'=>'å', 'a'=>'æ', 'c'=>'ç', 'e'=>'è', 'e'=>'é',
        'e'=>'ê', 'e'=>'ë', 'i'=>'ì', 'i'=>'í', 'i'=>'î',
        'i'=>'ï', 'o'=>'ð', 'n'=>'ñ', 'o'=>'ò', 'o'=>'ó',
        'o'=>'ô', 'o'=>'õ', 'o'=>'ö', 'o'=>'ø', 'u'=>'ù',
        'u'=>'ú', 'u'=>'û', 'y'=>'ý', 'y'=>'ÿ', 'b'=>'þ',
        'y'=>'ÿ'
    );

    // Converte hífens de volta em espaços
    $string = str_replace('-', ' ', $string);
    // Remove múltiplos espaços
    $string = preg_replace("/\s+/", " ", $string);
    // Converte para maiúsculas e substitui caracteres especiais
    $string = strtoupper($string);

    // Retorna a string com caracteres originais
    return strtr($string, $table);
}