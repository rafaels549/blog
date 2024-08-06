<?php

if (!isset($titulo_site) || $titulo_site=='') { $titulo_site = $vb_titulo_site; }
if (!isset($descricao_site) || $descricao_site=='') { $descricao_site = $vb_descricao_site; }
if (!isset($meta_site) || $meta_site=='') { $meta_site = $vb_meta_site; }


?>


<title><?=$vb_titulo_site;?></title>

<meta charset="utf-8">
<meta name="description" content="<?=$vb_descricao_site;?>">
<meta name="keywords" content="<?=$vb_meta_site;?>">
<meta rel="canonical" href="<?=$canonical;?>">
<meta name="subject" content="Business">
<meta name="category" content="<?=$vb_tipo;?>">
<meta name="Classification" content="Business">
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<meta name="bingbot" content="index, follow" />
<meta name="msnbot" content="index, follow" />
<meta name="slurp" content="index, follow" />
<meta name="rating" content="general">  
<meta name="resource-type" content="document">
<meta name="audience" content="all">
<meta name="coverage" content="Worldwide">
<meta name="distribution" content="Global">
<meta name="abstract" content="industry">
<meta name="topic" content="industry">
<meta name="summary" content="<?=$vb_sessao;?>">
<meta name="directory" content="submission">
<meta name="referrer" content="never">
<link rel="owner" content="<?=$vb_nome;?> - <?=$_SERVER['HTTP_HOST']?>">
<link rel="publisher" content="Virtua Brasil - www.virtuabrasil.com.br">
<link rel="author" content="Virtua Brasil, www.virtuabrasil.com.br">
<meta name="copyright" content="<?=$vb_nome;?>">
<link rel="designer" content="Virtua Brasil">
<meta name="email" content="<?=$vb_email;?>">
<meta name="url" content="https://www.virtuabrasil.com.br">
<meta name="identifier-URL" content="https://www.virtuabrasil.com.br">
<meta name="site" content="https://www.virtuabrasil.com.br"/>
<meta name="geo.country" content="Brasil" />
<meta name="dc.language" content="pt-br" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />


<meta property="og:url" content="<?=$canonical;?>"/>
<meta property="og:image" content="<?=$vb_img_og;?>"/>
<meta property="og:image:secure_url" content="<?=$vb_img_og;?>"/>
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?=$vb_titulo_site;?>"/>
<meta property="og:updated_time" content="<?=date("Y-m-d");?>T<?=date("H:i:s");?>"/>

<!---Facebook---->
<meta property="fb:pages" content="">
<meta property="ia:markup_url" content="<?=$canonical;?>">
<meta property="ia:rules_url" content="<?=$canonical;?>">

<!--Twitter Card-->
<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?=$canonical;?>">
<meta name="twitter:title" content="<?=$vb_titulo_site;?>">
<meta name="twitter:description" content="<?=$vb_descricao_site;?>">
<meta name="twitter:image" content="https://<?=$_SERVER['HTTP_HOST'];?><?=$vb_img_og;?>">
    
<!---Google---->
<meta itemprop="name" content="<?=$vb_titulo_site;?>" />
<meta itemprop="description" content="<?=$vb_descricao_site;?>">
<meta itemprop="image" content="<?=$vb_img_og;?>">
<link rel="canonical" href="<?=$canonical;?>"/>

<!--Open Graph-->
<meta property="og:locale" content="pt_br"/>
<meta property="og:type" content="website"/>
<meta property="og:title" content="<?=$vb_titulo_site;?>"/>
<meta property="og:site_name" content="<?=$vb_nome;?>"/>
<meta property="og:description" content="<?=$vb_descricao_site;?>"/>