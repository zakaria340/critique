<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title><?php wp_title( '-', true, 'right' ); ?> <?php bloginfo('name'); ?></title>
  <?php $favicon = get_option('general-favicon'); if (!empty($favicon)) { ?>
  <link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
  <?php } ?>
  <base href="<?php bloginfo('url'); ?>"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/reset.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/mt.min.css"/>
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
  <link href='https://www.google.com/fonts/specimen/Work+Sans' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Quicksand:700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/responsive.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/icons.css"/>
    <link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/qtip2/2.2.1/jquery.qtip.min.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <?php $activar = get_option('activar-is'); if ($activar== "true") { ?>
  <script src="<?php echo get_template_directory_uri(); ?>/js/paginador.js" type="text/javascript"></script>
  <?php } ?>
  <script src="<?php echo get_template_directory_uri(); ?>/js/js.min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/semantic/index.js"></script>
  <script src="http://cdn.jsdelivr.net/qtip2/2.2.1/jquery.qtip.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <?php wp_head(); ?>
  <?php $gwebmasters = get_option('analitica'); if (!empty($gwebmasters)) echo stripslashes(get_option('analitica')); ?>
  <?php javascript_theme(); ?>
<script>
$(function()
{

$('.scrolling').jScrollPane({
    height: 400
});
});
</script>
<?php css_theme(); ?>

</head>
<body>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71666370-1', 'auto');
  ga('send', 'pageview');

</script>
<div class="toper"><div id="sec1"></div></div>
<div id="contenedor">