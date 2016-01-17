<?php

class Xrely_Admin
{

    private static $initiated = false;
    private static $wsdJson = null;

    public static function init()
    {
        if (!self::$initiated)
        {
            self::init_hooks();
        }
    }

    public static function init_hooks()
    {
        $subpage = isset($_POST["subpage"]) ? $_POST["subpage"] : "";
        switch ($subpage)
        {
            case "activate":
                add_action('admin_menu', array('Xrely_Admin', 'admin_activate'), 5);
                break;
            case "apikey":
                add_action('admin_menu', array('Xrely_Admin', 'admin_key_verify'), 5);
                break;
            case "config":
                add_action('admin_menu', array('Xrely_Admin', 'admin_config_data'), 5);
                break;
            case "css-config":
                add_action('admin_menu', array('Xrely_Admin', 'admin_config_css'), 5);
                break;
            default:
                add_action('admin_menu', array('Xrely_Admin', 'admin_menu'), 5);
                break;
        }

        add_action('admin_enqueue_scripts', array('Xrely_Admin', 'load_resources'));
    }

    public static function load_resources()
    {
        global $hook_suffix;
        wp_register_script('lib.js', XRELY__PLUGIN_URL . '_inc/lib.js', array('jquery'), false, true);
        wp_enqueue_script('lib.js');
        wp_register_script('colpick.js', XRELY__PLUGIN_URL . '_inc/colpick.js', array('jquery'), false, true);
        wp_enqueue_script('colpick.js');
        wp_register_script('simple-slider.min.js', XRELY__PLUGIN_URL . '_inc/simple-slider.min.js', array('jquery'), false, true);
        wp_enqueue_script('simple-slider.min.js');
        wp_register_script('tabcontent.js', XRELY__PLUGIN_URL . '_inc/tabcontent.js', array(), false, true);
        wp_enqueue_script('tabcontent.js');

        wp_register_script('design.js', XRELY__PLUGIN_URL . '_inc/design.js', array('jquery'), false, true);
        wp_enqueue_script('design.js');
        wp_register_script('xrely-autocomplete.js', XRELY__PLUGIN_URL . '_inc/xrely-autocomplete.js', array('jquery'), false, true);
        wp_enqueue_script('xrely-autocomplete.js');

        wp_register_style('tabcontent.css', XRELY__PLUGIN_URL . '_inc/tabcontent.css', array(), XRELY_VERSION);
        wp_enqueue_style('tabcontent.css');
        wp_register_style('autocomplete.css', XRELY__PLUGIN_URL . '_inc/autocomplete.css', array(), XRELY_VERSION);
        wp_enqueue_style('autocomplete.css');
        wp_register_style('colpick.css', XRELY__PLUGIN_URL . '_inc/colpick.css', array(), XRELY_VERSION);
        wp_enqueue_style('colpick.css');
        wp_register_style('simple-slider-volume.css', XRELY__PLUGIN_URL . '_inc/simple-slider-volume.css', array(), XRELY_VERSION);
        wp_enqueue_style('simple-slider-volume.css');
        wp_register_style('simple-slider.css', XRELY__PLUGIN_URL . '_inc/simple-slider.css', array(), XRELY_VERSION);
        wp_enqueue_style('simple-slider.css');
        wp_register_style('style.css', XRELY__PLUGIN_URL . '_inc/style.css', array(), XRELY_VERSION);
        wp_enqueue_style('style.css');
    }

    public static function get_serch_box_selector()
    {
        $search_form = get_search_form();
    }

    public static function admin_menu()
    {
        $hook = add_options_page('Xrely', 'Xrely', 'manage_options', 'xrely-key-config', array('Xrely_Admin', 'display_page'));
    }

    public static function admin_activate()
    {
        $hook = add_options_page('Xrely', 'Xrely', 'manage_options', 'xrely-key-config', array('Xrely_Admin', 'post_activate'));
    }

    public static function admin_key_verify()
    {
        $hook = add_options_page('Xrely', 'Xrely', 'manage_options', 'xrely-key-config', array('Xrely_Admin', 'post_key_veryfy'));
    }

    public static function admin_config_data()
    {
        $hook = add_options_page('Xrely', 'Xrely', 'manage_options', 'xrely-key-config', array('Xrely_Admin', 'post_config_data'));
    }

    public static function admin_config_css()
    {
        $hook = add_options_page('Xrely', 'Xrely', 'manage_options', 'xrely-key-config', array('Xrely_Admin', 'post_config_css'));
    }

    public static function post_activate()
    {
        $enable = strtolower($_POST['xrely_activate']);
        if (!get_site_option("xrely_active"))
        {
            add_site_option("xrely_active", $enable);
        } else
        {
            update_site_option("xrely_active", $enable);
        }
        static::display_start_page();
    }

    public static function post_config_css()
    {
        if (isset($_POST["css"]))
        {
            $_POST["css"] = stripslashes($_POST["css"]);
            $cssArray = json_decode($_POST["css"], TRUE);
            if (json_last_error() == JSON_ERROR_NONE)
            {
                $data["API_KEY"] = get_site_option("xrely_key");
                $data["css"] = $_POST["css"];
                if(!get_site_option("xrely_css"))
                    add_site_option("xrely_css",$_POST["css"]);
                else
                    update_site_option("xrely_css",$_POST["css"]);
                static::css_post(array("data" => $data));
                static::display_start_page();
            }
        }
    }

    public static function post_config_data()
    {
        $apikey = get_site_option("xrely_key");
        $config_option  = $_POST;
        unset($config_option['subpage']);
        
        if ($apikey)
        {
            $args = array(
                'posts_per_page' => 500, 'orderby' => 'post_date',
                'order' => 'DESC', 'post_status' => 'publish', "post_type" => "any");
            $all_posts = new WP_Query($args);
            $post_data = ["client" => "cms", "cmsName" => "wordpress", "wordpressData" => ["totalItems" => count($all_posts), "items" => []]];
            $post_data["API_KEY"] = $apikey;
            $meta_data = &$post_data["wordpressData"]["items"];
            $product_metas = array();
            $wc_get_attribute_taxonomies_func_exist = function_exists("wc_get_attribute_taxonomies");
            if ($all_posts->have_posts()) : while ($all_posts->have_posts()) : $all_posts->the_post();
                    $one_post_data = [];
                    if ($_POST["thumb"])
                    {
                        $attachments = get_posts(array(
                            'post_type' => 'attachment',
                            'numberposts' => -1,
                            'post_status' => 'any',
                            'post_parent' => get_the_ID()
                        ));
                        if ($attachments)
                        {
                            foreach ($attachments as $attachment)
                            {
                                $image = (wp_get_attachment_image_src($attachment->ID, 'thumbnail'));
                                $image = $image[0];
                                $one_post_data["image"] = $image;
                            }
                        }
                    }
                    if ($_POST["title"])
                        $one_post_data["title"] = html_entity_decode(get_the_title(),ENT_QUOTES,'UTF-8');
                    if ($_POST["url"])
                        $one_post_data["url"] = get_the_permalink();
                    $one_post_data["type"] = get_post_type();
                    if (get_post_type() == "product" && $_POST['_regular_price'] == "on")
                    {
                        $one_post_data["price"] = get_post_meta(get_the_ID(), '_regular_price');
                    }
                    if ($wc_get_attribute_taxonomies_func_exist)
                        foreach (wc_get_attribute_taxonomies() as $key => $one_attribute)
                        {
                            if (isset($_POST[$one_attribute->attribute_name]))
                            {
                                $product_attribute_value = wc_get_product_terms(get_the_ID(), "pa_" . $one_attribute->attribute_name);
                                if (is_array($product_attribute_value) && count($product_attribute_value) > 0)
                                {
                                    $attribute_values = array_map(create_function('$o', 'return $o->name;'), $product_attribute_value);
                                    if ($attribute_values == null || $attribute_values[0])
                                    {
                                        $one_post_data[$one_attribute->attribute_name] = $attribute_values;
                                    } elseif (is_array($product_attribute_value) && count($product_attribute_value) > 0)
                                    {
                                        $one_post_data[$one_attribute->attribute_name] = $product_attribute_value;
                                    }
                                }
                            }
                        }

                    $meta_data[] = ["keyword" => $one_post_data["title"], "metaData" => $one_post_data];
                endwhile;
            endif;
            $response = json_decode(static::send_data($post_data), true);
            
            if(isset($response["success"]))
            {
                if(get_option('xrely_data_config'))
                {
                    update_option('xrely_data_config', json_encode($config_option)); 
                }
                else
                {
                    add_option('xrely_data_config', json_encode($config_option));                     
                }
            }
            static::display_start_page(array("data_config_response" => $response));
            return;
        } else
        {
            static::display_start_page(array("data_config_response" => ["error" => "Please Create API Key <a href='javascritp:void(0);' onclick=\"jQuery('[href=#view1]')[0].click()\">click</a>"]));
        }
    }

    public static function post_key_veryfy()
    {
        try
        {
            if (isset($_POST["key"]))
            {
                $activation_status = static::activation_post($_POST["key"]);
                $response = json_decode($activation_status, true);
                if ($response['success'])
                {
                    if ($response['post']["key"] == $_POST["key"])
                    {
                        add_site_option("xrely_key", $_POST["key"]);
                        get_site_option("xrely_key") === FALSE ? add_site_option("xrely_key", $_POST["key"]) : update_site_option("xrely_key", $_POST["key"]);
                        get_site_option("xrely_key_type") === FALSE ? add_site_option("xrely_key_type", $response['accountType']) : update_site_option("xrely_key_type", $response['accountType']);
                    }
                } else
                {
                    delete_site_option("xrely_key");
                    delete_site_option("xrely_key_type");
                }
            }
        } catch (Exception $exc)
        {
            echo $exc->getTraceAsString();
        }
        static::display_start_page();
    }

    public static function display_page()
    {
        static::display_start_page();
    }

    public static function display_start_page($response = array())
    {
        $xrely_config["key"] = get_site_option("xrely_key");
        $xrely_config["active"] = get_site_option("xrely_active");
        $xrely_config["account_type"] = get_site_option("xrely_key_type");
        $xrely_config["css"] = get_site_option("xrely_css");
        if($xrely_config["css"] === FALSE)
        {
            $css_json = json_decode(self::css_get(),true);
            if(is_array($css_json) && isset($css_json['css']))
            {
                $css =  $css_json['css'];
            }
            else
            {
                $css = 'na';
            }
            add_site_option('xrely_css',$css);
            $xrely_config["css"] = $css;
        }
        $xrely_config["css"] = ($xrely_config["css"] === FALSE || $xrely_config["css"] == "na")?FALSE:json_decode($xrely_config["css"],TRUE);
        
        $xrely_config["config"] = json_decode(get_option("xrely_data_config"),TRUE);
        if(is_array($xrely_config["css"]))
            foreach ($xrely_config["css"] as $key => $css)
            {
                $xrely_config["css"][$key] = json_decode($css,true);
            }
        $xrely_config['response'] = $response;
        $args = array(
            'posts_per_page' => 7, 'orderby' => 'post_date',
            'order' => 'DESC', 'post_status' => 'publish');
        $xrely_config["posts"] = get_posts($args);

        Xrely::view('front', compact('xrely_config'));
    }

    private static function send_data($data)
    {
        try
        {
            $wsd = static::discover_services();
            $services = json_decode($wsd, true);
            $post_url = $services["keyword"]["post"]["url"];
            return static::curl_xrely($post_url, ["data" => json_encode($data)]);
        } catch (Exception $exc)
        {
            return false;
        }
    }

    private static function css_post($data)
    {
        try
        {
            $wsd = static::discover_services();
            $services = json_decode($wsd, true);
            $post_url = $services["design"]["post"]["url"];
            return static::curl_xrely($post_url, $data);
        } catch (Exception $exc)
        {
            return false;
        }
    }
    
    private static function css_get()
    {
        $wsd = static::discover_services();
        $services = json_decode($wsd, true);
         $post_url = $services["design"]["get"]["url"];
        $response =  static::curl_xrely($post_url, array(),false);
        return $response;
    }
    private static function activation_post($apikey)
    {
        try
        {
            $wsd = static::discover_services();
            $services = json_decode($wsd, true);
            $post_url = $services["validator"]["post"]["url"];
            return static::curl_xrely($post_url, ["key" => $apikey, 'host' => $_SERVER['HTTP_HOST']]);
        } catch (Exception $exc)
        {
            return false;
        }
    }

    private static function curl_xrely($url, $data, $post = true)
    {
        $ch = curl_init();
        if ($post)
        {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }else
        {
            curl_setopt($ch, CURLOPT_URL, preg_replace("/($|\?)(.*)/is","?domain=".$_SERVER['HTTP_HOST']."&$2",$url));
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        return $server_output;
    }

    private static function discover_services()
    {
        if (self::$wsdJson == null)
        {
            self::$wsdJson = self::curl_xrely(XRELY_WEB_SERVICE_DISCOVERY_URL, [], false);
        }
        return self::$wsdJson;
    }

}
