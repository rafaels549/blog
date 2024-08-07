<?php
session_start();
error_reporting(E_ALL);
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

// Atualize as credenciais de conexão com o banco de dados
$conn = mysqli_connect("localhost", "admin", "afklol57", "hof_team_brazil");


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
$dominio = $_SERVER['HTTP_HOST'] .'/blog/luiza/luiza/html';
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
function reverse_clean($string) {
    // Mapeamento dos caracteres especiais com suporte para UTF-8
    $replacements = array(
        'a' => 'à', 'A' => 'À', 'á' => 'á', 'Á' => 'Á', 'ã' => 'ã', 'Ã' => 'Ã',
        'e' => 'è', 'E' => 'È', 'é' => 'é', 'É' => 'É', 'ê' => 'ê', 'Ê' => 'Ê',
        'i' => 'ì', 'I' => 'Ì', 'í' => 'í', 'Í' => 'Í', 'î' => 'î', 'Î' => 'Î',
        'o' => 'ò', 'O' => 'Ò', 'ó' => 'ó', 'Ó' => 'Ó', 'ô' => 'ô', 'Ô' => 'Ô',
        'u' => 'ù', 'U' => 'Ù', 'ú' => 'ú', 'Ú' => 'Ú', 'û' => 'û', 'Û' => 'Û',
        'c' => 'ç', 'C' => 'Ç',
        'n' => 'ñ', 'N' => 'Ñ',
        's' => 'š', 'S' => 'Š',
        'd' => 'đ', 'D' => 'Đ',
        'z' => 'ž', 'Z' => 'Ž',
        'aa' => 'æ', 'AA' => 'Æ',
        'oe' => 'ö', 'OE' => 'Ö',
        'ue' => 'ü', 'UE' => 'Ü',
        'a' => 'å', 'A' => 'Å',
        'o' => 'ø', 'O' => 'Ø'
    );

    // Substituir hífens por espaços
    $string = str_replace('-', ' ', $string);

    // Substituir caracteres especiais usando a tabela de substituição
    foreach ($replacements as $search => $replace) {
        $string = str_replace($search, $replace, $string);
    }

    // Converter a primeira letra de cada palavra para maiúscula
    $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");

    // Retornar a string
    return $string;
}
function decodeUrl($url) {
    // Decodifica a URL e substitui '+' por espaço
    $url = urldecode($url);
    return str_replace('+', ' ', $url);
}

// Função para codificar a URL
function encodeUrl($string) {
    // Substitui espaço por '+'
    $string = str_replace(' ', '+', $string);
    // Codifica a URL
    return $string;
}