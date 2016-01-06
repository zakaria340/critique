<div class="links">
<h3>Top des films sur Critique</h3>
<ul class="scrolling lista">
<?php $numerado = 1; { query_posts( array( 'meta_key' => 'ratings_average', 'orderby' => 'meta_value_num', 'order' => 'DESC' ) );
while ( have_posts() ) : the_post(); 
$imdbRating = get_post_meta($post->ID, "imdbRating", $single = true); ?>
<li class="number-<?php echo $numerado; ?>">
<b><?php echo $numerado; ?></b> 
<a href="<?php the_permalink() ?>"><?php the_title(); ?></a> 
<?php
$temp = stripslashes(get_option('postratings_template_highestrated'));
?>
<span><?php
$post_ratings_average = floatval($post->ratings_average);echo $post_ratings_average; ?></span> 
<?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, ''.$year_estreno.'' ))) {  ?><i><?php echo $mostrar; ?></i><?php } ?>
</li>
<?php $numerado++; ?>
<?php endwhile; wp_reset_query(); ?>
<?php } ?>
</ul>
</div>
