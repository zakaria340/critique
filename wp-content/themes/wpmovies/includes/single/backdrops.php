<?php if($values = get_post_custom_values("imagenes")) { ?>
<div id="owl-demo" class="hhhhhhhhhhhhhhhhh owl-carousel">
<?php $img = get_post_meta($post->ID, "imagenes", $single = true); backdrops ($img); ?>
</div>
<?php } ?>