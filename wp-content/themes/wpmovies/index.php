<?php get_header(); ?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'sidebar_left.php'; ?>
<div class="items">
<div id="directorio">
<?php include_once 'includes/aviso.php'; ?>
<div class="it_header">
<h1><?php if($tex = get_option('text-9')) { echo $tex; } else { _e('All movies','mundothemes'); } ?></h1>
<div class="buscador">
<?php echo buscador_form(); ?>
</div>
</div>
    
<div class="bloc_homepage">

  <ul class="d-grid">
  
 <span class="title-bloc-homepage">    Car nous croyons à la puissance de la communaité.  Donnez votre avis, faites entendre votre voix! .  </span>
  
			<li class="first-action hint-action" style="">
				<span class="icon-bookmark"></span>
				<span class="hint-action-title">Découvrez</span>
				<p class="hint-action-description">Découvrez des films qui correspondent à vos goûts, et dévouvrez la cinéma marocaine plus que jamais</p>
			</li>
			<li class="second-action hint-action">
				<span class="icon-star2"></span>
				<span class="hint-action-title">Notez</span>
				<p class="hint-action-description">Evaluez les films que vous avez vus. Classez-les selon vos critères et donnez votre avis détaillé dans une critique. 				</p>
			</li>
			<li class="third-action hint-action">
				<span class="icon-plus-circle"></span>
				<span class="hint-action-title">Partagez</span>
				<p class="hint-action-description">Faites découvrir vos critiques et vos notes avec vos amis, conseillez leur ce qu'ils pourront aimer. 				</p>
			</li>
		</ul>
  

</div>
    
<?php function_exists('wp_nav_menu') && has_nav_menu('menu1' ); wp_nav_menu( array( 'theme_location' => 'menu1', 'container' => '',  'menu_class' => 'home_links') ); ?>
<div class="header_slider">
<span class="titulo_2">
<?php $estrenos = get_option('activar-estrenos'); if ($estrenos == "true") { ?> 
<?php if($tex = get_option('text-53')) { echo $tex; } else { _e('New Releases','mundothemes'); } ?> 
<?php } else { ?>
<?php if($tex = get_option('text-54')) { echo $tex; } else { _e('Recommended movies','mundothemes'); } ?> 
<?php } ?>
</span>
<div class="customNavigation">
<a class="btn prev"><b class="icon-chevron-left2"></b></a>
<a class="btn next"><b class="icon-chevron-right2"></b></a>
</div>
</div>
<div class="random">
<?php $estrenos = get_option('activar-estrenos'); if ($estrenos == "true") { include("includes/funciones/estrenos.php"); } else { include("includes/funciones/random.php"); }  ?>
</div>
<div class="header_slider">
<span class="titulo_2"  style="margin-bottom: 15px"><?php if($tex = get_option('text-55')) { echo $tex; } else { _e('Latest movies','mundothemes'); } ?></span>
</div>
<div id="box_movies">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); 

$post_ratings_data = get_post_custom($post->ID);
	$post_ratings_average = is_array($post_ratings_data) && array_key_exists('ratings_average', $post_ratings_data) ? floatval($post_ratings_data['ratings_average'][0]) : 0;
	
if (has_post_thumbnail()) {
$imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'home');
$imgsrc = $imgsrc[0];
} elseif ($postimages = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=0")) {
foreach($postimages as $postimage) {
$imgsrc = wp_get_attachment_image_src($postimage->ID, 'home');
$imgsrc = $imgsrc[0];
}
} elseif (preg_match('/<img [^>]*src=["|\']([^"|\']+)/i', get_the_content(), $match) != FALSE) {
$imgsrc = $match[1];
} else {
$img = get_post_custom_values("poster_url");
$imgsrc = $img[0];
} ?>
<div class="movie">
<div class="imagen">
<img src="<?php echo $imgsrc; $imgsrc = ''; ?>" alt="<?php the_title(); ?>" width="100%" height="100%" />
<a href="<?php the_permalink() ?>"><span class="player"></span></a>
<div class="imdb"><span class="icon-grade"></span> <?php echo $post_ratings_average; ?></div>
</div>
<h2><?php the_title(); ?></h2>
<?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, ''.$year_estreno.'' ))) {  ?><span class="year"><?php echo $mostrar; ?></span><?php } ?>
</div>
<?php endwhile; else : ?>
<div class="no_contenido_home"><?php if($tex = get_option('text-13')) { echo $tex; } else { _e('No content available', 'mundothemes'); } ?></div>
<?php endif; ?>		
</div>
<div id="paginador">
<div class="pages_respo">
<div class="anterior"><?php previous_posts_link( '<span class="icon-caret-left"></span> Anterior ' ); ?></div>
<div class="siguiente"><?php next_posts_link( 'Siguiente <span class="icon-caret-right"></span>' ); ?></div>
</div>
<?php $activar = get_option('activar-is'); if ($activar== "true") { } else { pagination($additional_loop->max_num_pages); } ?>
</div>
<?php drss_plus(); ?>
</div>
</div>
<?php include_once 'sidebar_right.php'; ?>
<?php get_footer(); ?>