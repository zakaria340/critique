<?php

class Xrely
{

    public static function view($view_name, $data)
    {

        $file = XRELY__PLUGIN_DIR . 'view/' . $view_name . '.php';
        include( $file );
    }

    public static function add_xrely_script_tag()
    {
        if (is_admin())
        {
            ?>
            <script>
                function xrely_callback(css)
                {
                    console.log(css);
                }
            </script>
        <?php }
        ?>
        <script>
            var xfindSelect = "INPUT[name='s']";
            (function () {
                var s = document.createElement("script");
                s.type = "text/javascript";
                s.src = "<?php echo XRELY_SERVICE_DOMAIN; ?>js/autocomplete/autoScript.js?_=<?php echo $_SERVER['HTTP_HOST'] ?>&no=1";
                var x = document.getElementsByTagName("head")[0];
                x.appendChild(s);
            })();
        </script>
        <?php
    }

}
