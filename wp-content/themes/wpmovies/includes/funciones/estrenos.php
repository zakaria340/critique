<div id="owl-demo2" class="owl-carousel owl-theme">
<?php $estrenos = get_option('estrenos_cat');  $rand_posts = get_posts('numberposts=20&cat='.$estrenos.'&orderby=rand'); foreach( $rand_posts as $post ) : ?>
<?php   if (has_post_thumbnail()) {
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
 if (trim($img) == '') {
                $imgsrc = '';
            } else {
                $imgsrc = $img[0];
            }
} ?>
        <?php if ($imgsrc != ''): ?>

<div class="item">
  <a href="<?php the_permalink() ?>">
  <div class="imgss">
  <img src="<?php echo $imgsrc; $imgsrc = ''; ?>" alt="<?php the_title(); ?>" width="100%" height="100%" />
  <?php $post_ratings_data = get_post_custom($post->ID);
	$post_ratings_average = is_array($post_ratings_data) && array_key_exists('ratings_average', $post_ratings_data) ? floatval($post_ratings_data['ratings_average'][0]) : 0;
	 ?><div class="imdb"><span class="icon-grade"></span> <?php echo $post_ratings_average; ?></div>
  </div>
  </a>

 <span class="ttps"><?php the_title(); ?></span>
 <?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, ''.$year_estreno.'' ))) {  ?><span class="ytps"><?php echo $mostrar; ?></span><?php } ?>
</div>
     <?php endif; ?>
<?php endforeach; ?>
</div>