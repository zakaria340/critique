<?php
function get_the_term_list_mine( $id, $taxonomy, $before = '', $sep = '', $after = '') {
    $terms = get_the_terms( $id, $taxonomy );

	if ( is_wp_error( $terms ) )
		return $terms;

	if ( empty( $terms ) )
		return false;

	foreach ( $terms as $term ) {
		$link = get_term_link( $term, $taxonomy );
		if ( is_wp_error( $link ) )
			return $link;
		$term_links[] = '<span itemprop="name"><a href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a></span>';
	}

	/**
	 * Filter the term links for a given taxonomy.
	 *
	 * The dynamic portion of the filter name, `$taxonomy`, refers
	 * to the taxonomy slug.
	 *
	 * @since 2.5.0
	 *
	 * @param array $term_links An array of term links.
	 */
	$term_links = apply_filters( "term_links-$taxonomy", $term_links );

	return $before . join( $sep, $term_links ) . $after;
}

if (current_user_can('update_core')) { ?>
<div class="menu-admin">
<ul>
<?php edit_post_link( __( 'Edit post', 'mundothemes' ), '<li><b>', '</b></li>' ); ?>
</ul>
</div> 
<?php } ?>



<div itemscope itemtype="http://schema.org/Movie">
<div class="headingder">
<div class="cover"<?php if($values = get_post_custom_values("cover_url")) { ?> style="background-image: url(<?php echo $values[0]; ?>);"<?php } else { ?> style="background-image: url(<?php echo $imgsrc; $imgsrc = ''; ?>);"<?php } ?> ></div>
<div class="datos" style="background: transparent;margin-bottom: 0;">
<?php if (has_post_thumbnail()) {
$imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'original');
$imgsrc = $imgsrc[0];
} elseif ($postimages = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=0")) {
foreach($postimages as $postimage) {
$imgsrc = wp_get_attachment_image_src($postimage->ID, 'original');
$imgsrc = $imgsrc[0];
}
} elseif (preg_match('/<img [^>]*src=["|\']([^"|\']+)/i', get_the_content(), $match) != FALSE) {
$imgsrc = $match[1];
} else {
$img = get_post_custom_values("poster_url");
$imgsrc = $img[0];
}
?>
<div class="imgs tsll"><a href="#dato-2"><img itemprop="image" src="<?php echo $imgsrc; $imgsrc = ''; ?>" alt="<?php the_title(); ?>" /></a></div><!-- imgs -->
<div class="dataplus">
<h1 itemprop="name"><?php the_title(); ?></h1>
<?php if($values = get_post_custom_values("Title")) { ?><span class="original"><?php echo $values[0]; ?></span><?php } ?>
<div id="dato-1" class="data-content">
<p>
<?php if($values = get_post_custom_values("Rated")) { ?><span class="<?php echo $values[0]; ?>"><?php echo $values[0]; ?></span><?php } ?>
<?php
if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, ''.$year_estreno.'' ))) {  ?><span>
<?php echo get_the_term_list($post->ID, ''.$year_estreno.'', '', '', ''); ?> 
</span><?php } ?>
<?php if($values = get_post_custom_values("Runtime")) { ?><span><b class="icon-query-builder"></b> <?php echo $values[0]; ?></span><?php } ?>  
<?php the_category(',&nbsp;',''); ?>
</p>
<div class="score">

<?php  if(function_exists('the_ratings')) { the_ratings(); } ?> 
 <?php do_action( 'wordpress_social_login' ); ?> 

</div>
<div class="xmll"><p itemprop="director" itemscope itemtype="http://schema.org/Person" class="xcsd"><span itemprop="name"><?php echo get_the_term_list($post->ID, ''.$director.'', '<b class="icon-bullhorn"></b> &nbsp;', ', ', ''); ?></span></p></div>
<div class="xmll"><p itemprop="actor" itemscope itemtype="http://schema.org/Person" class="xcsd"><?php echo get_the_term_list_mine($post->ID, ''.$actor.'', '<b class="icon-star"></b> &nbsp;', ', ', ''); ?> </p></div>
<?php if($values = get_post_custom_values("Released")) { ?><div class="xmll"><p class="xcsd"><b class="icon-check"></b> <?php echo $values[0]; ?></p></div><?php } ?> 
<?php if($values = get_post_custom_values("Awards")) { ?><div class="xmll"><p class="xcsd"><b class="icon-trophy"></b> <?php echo $values[0]; ?></p></div><?php } ?> 
<div class="xmll"><p class="tsll xcsd"><b class="icon-info-circle"></b> <a href="#dato-2"><?php if($tex = get_option('text-28')) { echo $tex; } else { _e('Synopsis','mundothemes'); } ?></a></p></div>
<div class="xmll watchlists"><p class="tsll xcsd"><b class="icon-bookmark"></b><?php wpfp_link() ?></p></div>
</div>
<div id="dato-2" class="data-content tsll">
<h2><?php _e('Synopsis','mundothemes'); ?></h2>
<span itemprop="description"><?php the_content(); ?></span>
<div class="tsll">
<a class="regresar" href="#dato-1"><b class="icon-chevron-left2"></b> <?php if($tex = get_option('text-50')) { echo $tex; } else { _e('Go back','mundothemes'); } ?></a>
</div>
</div>
</div><!-- dataplus -->
</div>
</div><!-- headingder -->
</div>