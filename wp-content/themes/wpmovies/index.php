<?php

//include(ABSPATH . 'simple_html_dom.php');
//// get DOM from URL or file
//$html = file_get_html('http://www.africultures.com/php/index.php?nav=rubrique&no_pays=135&sr=2&recherche=films&lettres=TOUS');
//// remove all image
//$i = 0;
//foreach ($html->find('#actu a.liendetail') as $element) {
//
//    $i++;
//
//    if ($i > 900) {
//        $href = str_replace('&amp;', '&', $element->href);
//        $urlMovie = 'http://www.africultures.com/php/' . $href;
//        $director = utf8_encode($element->find('.cartoucheh1', 0)->innertext);
//        $title = trim(strip_tags(utf8_encode($element->find('.cartoucheh2', 0)->innertext)));
//        if (empty(wp_exist_post_by_title(wp_specialchars($data['titre'])))) {
//
//
//            $htmlMovie = file_get_html($urlMovie);
//            $img = $syn = $anne = $trailer = $cast = '';
//            if ($htmlMovie->find('.agrandissement img', 0)) {
//                $img = $htmlMovie->find('.agrandissement img', 0)->src;
//            }
//
//            if ($htmlMovie->find('#actu .cartouchep', 0)) {
//                $syn = $htmlMovie->find('#actu .cartouchep', 0)->innertext;
//                $syn = strip_tags($syn, '<br>');
//                $syn = utf8_encode($syn);
//            }
//            if ($htmlMovie->find('#actu .titre1', 0)) {
//                $anne = $htmlMovie->find('#actu .titre1', 0)->innertext;
//                $anne = explode('|', $anne);
//                $anne = trim(end($anne));
//            }
//            if ($htmlMovie->find('#actu .cartouchep', 0)) {
//                $trailer = $htmlMovie->find('#actu .cartouchep', 0)->innertext;
//                $trailer = strip_tags($trailer, '<embed>');
//                preg_match_all('/<embed (.*?)>/', $trailer, $matches);
//                $trailer = $matches[0];
//                if (!empty($trailer)) {
//                    $trailer = $trailer[0];
//                }
//            }
//
//            if ($htmlMovie->find('#actu .cartouchep', 0)) {
//                $cast = $htmlMovie->find('#actu table', 0)->innertext;
//                $cast = strip_tags($cast);
//                preg_match_all('/Avec :(.*?):/', $cast, $matches);
//                $cast = $matches[1];
//                if (!empty($cast)) {
//                    $cast = $cast[0];
//                }
//                $cast = str_replace('Production', '', $cast);
//                $cast = trim($cast);
//                $cast = explode(',', $cast);
//            }
//            if ($htmlMovie->find('#actu .cartouchep', 0)) {
//                $genre = $htmlMovie->find('#actu table', 0)->innertext;
//                $genre = strip_tags($genre);
//                preg_match_all('/Genre :(.*?):/', $genre, $matches);
//                $genre = $matches[1];
//                if (!empty($genre)) {
//                    $genre = $genre[0];
//                }
//                $genre = str_replace('Type', '', $genre);
//                $genre = ucfirst(trim($genre));
//            }
//
//            if (is_array($trailer)) {
//                $trailer = '';
//            }
//            if (is_array($img)) {
//                $img = '';
//            }
//            $filmInfo = array(
//                'titre' => $title,
//                'image' => $img,
//                'real' => $director,
//                'cast' => $cast,
//                'genre' => $genre,
//                'annee' => trim($anne),
//                'duree' => '1h38min',
//                'synopsis' => $syn,
//                'trailer' => $trailer,
//            );
//            saveMovie($filmInfo);
//        }
//    }
//}

function saveMovie($data) {
    $my_post = array(
      'post_title' => wp_specialchars($data['titre']),
      'post_content' => $data['synopsis'],
      'post_status' => 'publish',
      'post_author' => 1,
    );

    if (empty(wp_exist_post_by_title(wp_specialchars($data['titre'])))) {
        //Insert the post into the database
        $postId = wp_insert_post($my_post);
        wp_set_object_terms($postId, array($data['real']), 'director');
        wp_set_object_terms($postId, array($data['real']), 'escritor');
        wp_set_object_terms($postId, array($data['cast']), 'actor');
        wp_set_object_terms($postId, array($data['genre']), 'category');
        wp_set_object_terms($postId, array($data['annee']), 'year');

        $image = my_attach_external_image($data['image'], $postId);
        update_post_meta($postId, 'poster_url', $image);
        if ($data['trailer'] != '') {
            update_post_meta($postId, 'embed_pelicula', $data['trailer']);
            update_post_meta($postId, 'titulo_repro1', 'Bande annonce');
        }
        update_post_meta($postId, 'Title', $data['titre']);
        update_post_meta($postId, 'Released', $data['annee']);
        update_post_meta($postId, 'Runtime', $data['duree']);
        update_post_meta($postId, 'Country', 'Maroc');
    }
}

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

get_header();
?>
<?php include_once 'includes/header.php'; ?>
<?php include_once 'sidebar_left.php'; ?>
<div class="items">
    <div style="clear: both"></div>
    <div class="hint-hero">
        <div class="d-grid">
            <div class="hint-hero-title">Critique.ma - Critiques Cinéma</div>
            <span class="d-grid hint-hero-subtitle">Découvrez, notez et partagez avec vos amis</span>

            <a class="hint-facebookButton d-facebookButton" href="/oauthapi/facebook?version=2&amp;block=elementHero">
                <span class="hint-startNowBig"></span>
            </a>
        </div>

        <div class="hint-popular-products">
            <a style="left: 720px" class="hint-popular-product" href="http://www.critique.ma/director/hicham-lasri/">
                <img width="120" height="163" title="Les films Hicham Lasri réalisateur" alt="Les films Hicham Lasri réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/hicham-lasri1.jpg">
            </a>
            <a style="left: 840px" class="hint-popular-product" href="http://www.critique.ma/director/abdeslam-kelai/">
                <img width="120" height="163" title="Les films de Abdeslma Kelai réalisateur" alt="Les films de Abdeslma Kelai réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Abdeslma-Kelai.jpg">
            </a>
            <a style="left: 960px" class="hint-popular-product" href="http://www.critique.ma/director/mohamed-zineddaine/">
                <img width="120" height="163" title="Les films Mohamed Zineddaine réalisateur" alt="Les films Mohamed Zineddaine réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Mohamed-Zineddaine.jpg">
            </a>
            <a style="left: 1080px" class="hint-popular-product" href="http://www.critique.ma/director/mohamed-mouftakir/">
                <img width="120" height="160" title="Les films Mohamed Mouftakir réalisateur" alt="Les films Mohamed Mouftakir réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Mohamed-Mouftakir.jpg">
            </a>
            <a style="left: 1200px" class="hint-popular-product" href="http://www.critique.ma/director/mohamed-abderrahman-tazi/">
                <img width="120" height="163" title="Les films Mohamed abderrahman tazi réalisateur" alt="Les films Mohamed abderrahman tazi réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/mohamed-abderrahman-tazi.jpg">
            </a>
            <a style="left: 1320px" class="hint-popular-product" href="http://www.critique.ma/director/mohamed-abderrahman-tazi/">
                <img width="120" height="162" title="Les films Nour-Eddine Lakhmari réalisateur" alt="Les films Nour-Eddine Lakhmari réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Nour-Eddine_Lakhmari.jpg">
            </a>
            <a style="left: 1440px" class="hint-popular-product" href="http://www.critique.ma/director/narjiss-nejjar/">
                <img width="120" height="158" title="Les films Narjiss Nejjar réalisateur" alt="Les films Narjiss Nejjar réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Narjiss-Nejjar.jpg">
            </a>
            <a style="left: 1560px" class="hint-popular-product" href="http://www.critique.ma/director/ahmed-boulane/">
                <img width="120" height="160" title="Les films Ahmed boulane réalisateur" alt="Les films Ahmed boulane réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Ahmed-boulane.jpg">
            </a>
            <a style="left: 1680px" class="hint-popular-product" href="http://www.critique.ma/director/abdelillah-zirat/">
                <img width="120" height="163" title="Les films Abdelillah zirat réalisateur" alt="Les films Abdelillah zirat réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Zirat_Abdelillah5.jpg">
            </a>
            <a style="left: 1800px" class="hint-popular-product" href="www.critique.ma/director/rachid-ferchiou/">
                <img width="120" height="163" title="Les films Rachid Ferchiou réalisateur" alt="Les films Rachid Ferchiou réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/ferchiou.jpg">
            </a>
            <a style="left: 1920px" class="hint-popular-product" href="www.critique.ma/director/anouar-moatassim/">
                <img width="120" height="160" title="Les films Anouar Moatassim réalisateur" alt="Les films Anouar Moatassim réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/MOATASSIM_Anouar_2012.jpg">
            </a>
            <a style="left: 2040px" class="hint-popular-product" href="www.critique.ma/director/hakim-noury/">
                <img width="120" height="163" title="Les films Hakim noury réalisateur" alt="Les films Hakim noury réalisateur" src="http://www.critique.ma/wp-content/uploads/2016/01/Hakim-Noury.jpg">
            </a>
            <a style="left: 2160px" class="hint-popular-product" href="http://www.critique.ma/wp-content/uploads/2016/01/hicham-lasri1.jpg">
                <img width="120" height="163" title="Les films Hicham Lasri réalisateur" alt="Les films Hicham Lasri réalisateur" src="http://media.senscritique.com/media/000012222742/120/Retour_vers_le_futur.jpg">
            </a>
        </div>
    </div>
    <div id="directorio">
        <?php include_once 'includes/aviso.php'; ?>
        <div class="it_header">
            <h1><?php
                if ($tex = get_option('text-9')) {
                    echo $tex;
                } else {
                    _e('All movies', 'mundothemes');
                }
                ?></h1>
            <div class="buscador">
                <?php echo buscador_form(); ?>
            </div>
        </div>


        <?php
        // function_exists('wp_nav_menu') && has_nav_menu('menu1');
        //wp_nav_menu(array('theme_location' => 'menu1', 'container' => '', 'menu_class' => 'home_links'));
        ?>
        <div class="header_slider">
            <span class="titulo_2">
                <?php
                $estrenos = get_option('activar-estrenos');
                if ($estrenos == "true") {
                    ?> 
                    <?php
                    if ($tex = get_option('text-53')) {
                        echo $tex;
                    } else {
                        _e('New Releases', 'mundothemes');
                    }
                    ?> 
                <?php } else { ?>
                    <?php
                    if ($tex = get_option('text-54')) {
                        echo $tex;
                    } else {
                        _e('Recommended movies', 'mundothemes');
                    }
                    ?> 
                <?php } ?>
            </span>
            <div class="customNavigation">
                <a class="btn prev"><b class="icon-chevron-left2"></b></a>
                <a class="btn next"><b class="icon-chevron-right2"></b></a>
            </div>
        </div>
        <div class="random">
            <?php
            $estrenos = get_option('activar-estrenos');
            if ($estrenos == "true") {
                include("includes/funciones/estrenos.php");
            } else {
                include("includes/funciones/random.php");
            }
            ?>
        </div>
        <div class="header_slider">
            <span class="titulo_2"  style="margin-bottom: 15px"><?php
                if ($tex = get_option('text-55')) {
                    echo $tex;
                } else {
                    _e('Latest movies', 'mundothemes');
                }
                ?></span>
        </div>
        <div id="box_movies">
            <?php
            add_filter('posts_groupby', 'geotag_search_groupby');

            function geotag_search_groupby($groupby) {
                global $wpdb;
                // we need to group on post ID
                $mygroupby = "{$wpdb->posts}.ID";
                if (preg_match("/$mygroupby/", $groupby)) {
                    // grouping we need is already there
                    return $groupby;
                }
                if (!strlen(trim($groupby))) {
                    // groupby was empty, use ours
                    return $mygroupby;
                }
                // wasn't empty, append ours
                return $groupby . ", " . $mygroupby;
            }

            if (have_posts()) :
                ?>
                <?php
                while (have_posts()) : the_post();

                    $post_ratings_data = get_post_custom($post->ID);
                    $post_ratings_average = is_array($post_ratings_data) && array_key_exists('ratings_average', $post_ratings_data) ? floatval($post_ratings_data['ratings_average'][0]) : 0;

                    if (has_post_thumbnail()) {
                        $imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'original');
                        $imgsrc = $imgsrc[0];
                    } elseif ($postimages = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=0")) {
                        foreach ($postimages as $postimage) {
                            $imgsrc = wp_get_attachment_image_src($postimage->ID, 'original');
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
                    }
                    ?>
                    <?php if ($imgsrc != ''): ?>
                        <div class="movie">
                            <div class="imagen">
                                <img src="<?php
                                echo $imgsrc;
                                $imgsrc = '';
                                ?>" alt="<?php the_title(); ?>" width="100%" height="100%" />
                                <a href="<?php the_permalink() ?>"><span class="player"></span></a>
                                <div class="imdb"><span class="icon-grade"></span> <?php echo $post_ratings_average; ?></div>
                            </div>
                            <h2><?php the_title(); ?></h2>
                            <?php if ($mostrar = $terms = strip_tags($terms = get_the_term_list($post->ID, '' . $year_estreno . ''))) { ?><span class="year"><?php echo $mostrar; ?></span><?php } ?>
                        </div>
                    <?php endif; ?>
                    <?php
                endwhile;
            else :
                ?>
                <div class="no_contenido_home"><?php
                    if ($tex = get_option('text-13')) {
                        echo $tex;
                    } else {
                        _e('No content available', 'mundothemes');
                    }
                    ?></div>
            <?php endif; ?>		
        </div>
        <div id="paginador">
            <div class="pages_respo">
                <div class="anterior"><?php previous_posts_link('<span class="icon-caret-left"></span> Anterior '); ?></div>
                <div class="siguiente"><?php next_posts_link('Siguiente <span class="icon-caret-right"></span>'); ?></div>
            </div>
            <?php
            $activar = get_option('activar-is');
            if ($activar == "true") {
                
            } else {
                pagination($additional_loop->max_num_pages);
            }
            ?>
        </div>
        <?php drss_plus(); ?>
    </div>
</div>
<?php include_once 'sidebar_right.php'; ?>
<?php get_footer(); ?>


<?php ?>
