<?php get_header(); ?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'sidebar_left.php'; ?>
<div class="items">
    <div id="directorio">
        <?php include_once 'includes/aviso.php'; ?>
        <div class="it_header">
            <h1><?php if ($tex = get_option('text-9')) {
            echo $tex;
        } else {
            _e('All movies', 'mundothemes');
        } ?></h1>
            <div class="buscador">
<?php echo buscador_form(); ?>
            </div>
        </div>

        <div class="bloc_homepage">

            <ul class="d-grid">

                <span class="title-bloc-homepage">    Nous croyons à la puissance de la communaité.  Donnez votre avis, faites entendre votre voix! .  </span>

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

                <?php function_exists('wp_nav_menu') && has_nav_menu('menu1');
                wp_nav_menu(array('theme_location' => 'menu1', 'container' => '', 'menu_class' => 'home_links')); ?>
        <div class="header_slider">
            <span class="titulo_2">
<?php $estrenos = get_option('activar-estrenos');
if ($estrenos == "true") { ?> 
    <?php if ($tex = get_option('text-53')) {
        echo $tex;
    } else {
        _e('New Releases', 'mundothemes');
    } ?> 
            <?php } else { ?>
    <?php if ($tex = get_option('text-54')) {
        echo $tex;
    } else {
        _e('Recommended movies', 'mundothemes');
    } ?> 
            <?php } ?>
            </span>
            <div class="customNavigation">
                <a class="btn prev"><b class="icon-chevron-left2"></b></a>
                <a class="btn next"><b class="icon-chevron-right2"></b></a>
            </div>
        </div>
        <div class="random">
            <?php $estrenos = get_option('activar-estrenos');
            if ($estrenos == "true") {
                include("includes/funciones/estrenos.php");
            } else {
                include("includes/funciones/random.php");
            } ?>
        </div>
        <div class="header_slider">
            <span class="titulo_2"  style="margin-bottom: 15px"><?php if ($tex = get_option('text-55')) {
                echo $tex;
            } else {
                _e('Latest movies', 'mundothemes');
            } ?></span>
        </div>
        <div id="box_movies">
<?php if (have_posts()) : ?>
    <?php
    while (have_posts()) : the_post();

        $post_ratings_data = get_post_custom($post->ID);
        $post_ratings_average = is_array($post_ratings_data) && array_key_exists('ratings_average', $post_ratings_data) ? floatval($post_ratings_data['ratings_average'][0]) : 0;

        if (has_post_thumbnail()) {
            $imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'home');
            $imgsrc = $imgsrc[0];
        } elseif ($postimages = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=0")) {
            foreach ($postimages as $postimage) {
                $imgsrc = wp_get_attachment_image_src($postimage->ID, 'home');
                $imgsrc = $imgsrc[0];
            }
        } elseif (preg_match('/<img [^>]*src=["|\']([^"|\']+)/i', get_the_content(), $match) != FALSE) {
            $imgsrc = $match[1];
        } else {
            $img = get_post_custom_values("poster_url");
            $imgsrc = $img[0];
        }
        ?>
                    <div class="movie">
                        <div class="imagen">
                            <img src="<?php echo $imgsrc;
        $imgsrc = ''; ?>" alt="<?php the_title(); ?>" width="100%" height="100%" />
                            <a href="<?php the_permalink() ?>"><span class="player"></span></a>
                            <div class="imdb"><span class="icon-grade"></span> <?php echo $post_ratings_average; ?></div>
                        </div>
                        <h2><?php the_title(); ?></h2>
        <?php if ($mostrar = $terms = strip_tags($terms = get_the_term_list($post->ID, '' . $year_estreno . ''))) { ?><span class="year"><?php echo $mostrar; ?></span><?php } ?>
                    </div>
    <?php endwhile;
else : ?>
                <div class="no_contenido_home"><?php if ($tex = get_option('text-13')) {
        echo $tex;
    } else {
        _e('No content available', 'mundothemes');
    } ?></div>
<?php endif; ?>		
        </div>
        <div id="paginador">
            <div class="pages_respo">
                <div class="anterior"><?php previous_posts_link('<span class="icon-caret-left"></span> Anterior '); ?></div>
                <div class="siguiente"><?php next_posts_link('Siguiente <span class="icon-caret-right"></span>'); ?></div>
            </div>
<?php $activar = get_option('activar-is');
if ($activar == "true") {
    
} else {
    pagination($additional_loop->max_num_pages);
} ?>
        </div>
<?php drss_plus(); ?>
    </div>
</div>
<?php include_once 'sidebar_right.php'; ?>
<?php get_footer(); ?>


<?php
// example of how to modify HTML contents
include(ABSPATH . 'simple_html_dom.php');
//
//// get DOM from URL or file
$html = file_get_html('http://www.cinetrafic.fr/liste-film/7920/2/les-meilleurs-films-marocains');
//
//// remove all image
foreach ($html->find('#liste_film .liste_item_titre a.classic_link') as $element) {
    $urlMovie = 'http://www.cinetrafic.fr' . $element->href;
    $htmlMovie = file_get_html($urlMovie);
    $cast = array();
    foreach ($htmlMovie->find('#film_cast_name a') as $cas) {
        $cast[] = $cas->innertext;
    }
    if ($htmlMovie) {
        $genre = array();
        if ($htmlMovie->find('#adn_liste_genre', 0)) {
            foreach ($htmlMovie->find('#adn_liste_genre', 0)->find('a') as $gen) {
                $sq = str_replace('Film', '', $gen->innertext);
                $genre[] = utf8_decode(ucfirst(trim($sq)));
            }
        }
        $title = $htmlMovie->find('h1 strong', 0)->innertext . 'film Bande annonce';
        $title = str_replace(' ', '+', $title);

        $htmlt = file_get_html('http://www.youtube.com/results?search_query=' . $title);

        $liBandeAnnonce = $htmlt->find('#results .yt-lockup', 0);
        $urlBandeAnnonce = '';
        if ($liBandeAnnonce) {


            $urlBandeAnnonce = 'http://www.youtube.com' . $liBandeAnnonce->find('a', 0)->href;
            $urlBandeAnnonce = '<iframe width="560" height="315" src="' . $urlBandeAnnonce . '" frameborder="0" allowfullscreen></iframe>';
        }
        $anne = $htmlMovie->find('.detail_film_info_value a', 1)->innertext;
        $anne = str_replace('film', '', $anne);
        $anne = str_replace('<strong>', '', $anne);
        $anne = str_replace('</strong>', '', $anne);
        $filmInfo = array(
          'titre' => wp_specialchars(trim($htmlMovie->find('h1 strong', 0)->innertext)),
          'image' => 'http://www.cinetrafic.fr' . $htmlMovie->find('.affiche_film', 0)->src,
          'real' => $htmlMovie->find('#film_real_name a', 0)->innertext,
          'cast' => $cast,
          'genre' => $genre,
          'annee' => trim($anne),
          'duree' => $htmlMovie->find('.detail_film_info_value', 3)->innertext,
          'synopsis' => utf8_decode(trim($htmlMovie->find('#bloc_content_synopsis', 0)->innertext)),
          'trailer' => $urlBandeAnnonce,
        );
        saveMovie($filmInfo);
    }
}

function saveMovie($data) {
    $my_post = array(
      'post_title' => $data['titre'],
      'post_content' => $data['synopsis'],
      'post_status' => 'publish',
      'post_author' => 1,
    );

    if (empty(wp_exist_post_by_title($data['title']))) {
        //Insert the post into the database
        $postId = wp_insert_post($my_post);
        wp_set_object_terms($postId, array($data['real']), 'director');
        wp_set_object_terms($postId, array($data['real']), 'escritor');
        wp_set_object_terms($postId, array($data['cast']), 'actor');
        wp_set_object_terms($postId, array($data['genre']), 'category');
        wp_set_object_terms($postId, array($data['annee']), 'year');

        $image = my_attach_external_image($data['image'], $postId);
        update_post_meta($postId, 'poster_url', $image);
        update_post_meta($postId, 'embed_pelicula', $data['trailer']);
        update_post_meta($postId, 'titulo_repro1', 'Bande annonce');

        update_post_meta($postId, 'Title', $data['titre']);
        update_post_meta($postId, 'Released', $data['annee']);
        update_post_meta($postId, 'Runtime', $data['duree']);
        update_post_meta($postId, 'Country', 'Maroc');
    }
}

//$title = $title . 'film Bande annonce';
//$title = str_replace(' ', '+', $title);
//$html = file_get_html('http://www.youtube.com/results?search_query=' . $title);
//$liBandeAnnonce = $html->find('#results li.yt-lockup', 0);
//$urlBandeAnnonce = 'http://www.youtube.com' . $liBandeAnnonce->find('a', 0)->href;



function wp_exist_post_by_title($title_str) {
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM wp_posts WHERE post_title = '" . $title_str . "'", 'ARRAY_A');
}

function my_attach_external_image($url = null, $post_id = null, $post_data = array()) {
    if (!$url || !$post_id)
        return new WP_Error('missing', "Need a valid URL and post ID...");
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    // Download file to temp location, returns full server path to temp file, ex; /home/user/public_html/mysite/wp-content/26192277_640.tmp
    $tmp = download_url($url);

    // If error storing temporarily, unlink
    if (is_wp_error($tmp)) {
        @unlink($file_array['tmp_name']);   // clean up
        $file_array['tmp_name'] = '';
        return $tmp; // output wp_error
    }

    preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $url, $matches);    // fix file filename for query strings
    $url_filename = basename($matches[0]);                                                  // extract filename from url for title
    $url_type = wp_check_filetype($url_filename);                                           // determine file type (ext and mime/type)
    // assemble file data (should be built like $_FILES since wp_handle_sideload() will be using)
    $file_array['tmp_name'] = $tmp;                                                         // full server path to temp file

    $file_array['name'] = $url_filename;

    // set additional wp_posts columns
    if (empty($post_data['post_title'])) {
        $post_data['post_title'] = basename($url_filename, "." . $url_type['ext']);         // just use the original filename (no extension)
    }

    // make sure gets tied to parent
    if (empty($post_data['post_parent'])) {
        $post_data['post_parent'] = $post_id;
    }

    // required libraries for media_handle_sideload
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // do the validation and storage stuff
    $att_id = media_handle_sideload($file_array, $post_id, null, $post_data);             // $post_data can override the items saved to wp_posts table, like post_mime_type, guid, post_parent, post_title, post_content, post_status

    $filei = get_attached_file($att_id);
    return 'http://www.critique.ma/wp-content/uploads/' . _wp_relative_upload_path($filei);
    // If error storing permanently, unlink
    if (is_wp_error($att_id)) {
        @unlink($file_array['tmp_name']);   // clean up
        return $att_id; // output wp_error
    }

    // set as post thumbnail if desired
    set_post_thumbnail($post_id, $att_id);
    return $att_id;
}
?>