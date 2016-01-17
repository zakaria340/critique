<?php
function zeropad($num, $lim = 2)
{
   return (strlen($num) >= $lim) ? $num : zeropad("0" . $num);
}
function getHEXRGB($string)
{
    $matches = null;
    $returnValue = preg_match('/rgba?\\(\\s*(?<red>[0-9A-F]{1,3})\\s*,\\s*(?<green>[0-9A-F]{1,3})\\s*,\\s*(?<blue>[0-9A-F]{1,3})/is', $string, $matches);
    if ($returnValue)
    {
        return zeropad(dechex(intval($matches["red"])),2) . zeropad(dechex(intval($matches["green"])),2) . zeropad(dechex(intval($matches["blue"])),2);
    }
    return trim($string, "#");
}
?>

<style>
    #configuration label{
        display: inline-block;
        width:110px;
    }
    .submit-container{
        padding-top: 20px ;
        padding-bottm: 20px ;
    }
    input:disabled
    {
        cursor: help;
    }
    .keybox{
        width: 70%;font-size: 10px;padding: 6px;
    }
</style>
<?php
    $new_user = !isset($data["xrely_config"]["account_type"]) || $data["xrely_config"]["account_type"] == false;
$tab_attr = $new_user ? "onmousedown='return false;'" : "";
?>
<div style="padding-top: 20px"> 
    <h1 style="position: relative">
        <img src="<?php echo $url = XRELY__PLUGIN_URL; ?>_inc/xrely.png" width="100" style="width: 64px;" />
        <div style="position: absolute;left: 64px;bottom: 12px;">
            <a href="<?php echo XRELY_SITE_URL; ?>" style="text-decoration: none;" target="_blank">Xrely Autocomplete</a>
        </div>
    </h1>
    <form method="POST" action="">
        <input type="hidden" name="subpage" value="activate"/>
        <input id="xrely_activate" value="<?php echo $data["xrely_config"]["active"] == "enable"?"Disable":"Enable"; ?>" name="xrely_activate" type="submit" class="button button-primary" />
    </form>
    <div style="width: 100%;padding: 20px 0 40px;">
        <ul class="tabs" data-persist="true"> 
            <li><a href="#view1">API Key</a></li>
            <li><a href="#view2">Configure</a></li>
            <li><a href="#view3">Design</a></li>
            <li><a href="#view5" style="color: darkgreen;font-size: 13px;">Rich Autocomplete</a></li>
        </ul>
        <div class="tabcontents">
            <div id="view1">
                <b>Provide Your Xrely API key</b><span style="color: <?php echo $data["xrely_config"]["account_type"] == 'genaral' ? 'red' : 'blue'; ?>;">
                    <?php
                    if ($new_user)
                    {
                        ?>
                        <p>or <a href="<?php echo XRELY_SERVICE_DOMAIN ?>Account/register" target="_blank">Create account & get API Key</a> </p>
                        <?php
                    }
                    ?>
                <!--(Account type is <?php echo $data["xrely_config"]["account_type"] == 'genaral' ? 'genaral<button class="button button-small" style="font-size:11px;" onclick="return jQuery(' . "'[href=#view4]'" . ')[0].click()">Upgrade</button>' : 'genaral'; ?>)*-->
                </span>
                <form style="margin-top: 20px;" id="xrely_id" method="post" action="">
                    <label>
                        <input type="hidden" name="subpage" value="apikey"/>
                        <input <?php echo $data["xrely_config"]["key"] != "" ? 'style="color:green;border-color:green;" value="' . $data["xrely_config"]["key"] . '"' : "" ?> type="text" name="key" placeholder="API Key" class="keybox" />
                    </label>
                    <div class="submit-container">
                        <input type="submit" class=" button button-primary" />
                    </div>
                </form>
            </div>
            <div id="view2">
                <b>Select the post attributes that you want to have it in drop down</b>
                <div style="margin-top:10px;">
                <?php 
                    if (isset($data["xrely_config"]['response']) && isset($data["xrely_config"]['response']['data_config_response']))
                    {
                        if (isset($data["xrely_config"]['response']['data_config_response']['error']))
                        {
                            echo '<span style="color:red;">' . $data["xrely_config"]['response']['data_config_response']['error'] . ' :(</span>';
                        } elseif ($data["xrely_config"]['response']['data_config_response']['sucess'])
                        {
                            echo '<span style="color:green;">Your Data will shortly get indexed, You will get an email for same on completion </span>';
                        }
                    }
                ?></div>
                <form style="margin-top: 20px;" id="xrely_id" method="post" action="">
                    <input type="hidden" name="subpage" value="config"/>
                    <?php
                    $isPrimium = $data["xrely_config"]["account_type"] == "genaral" ? true : false;
                    $disable = $isPrimium ? "" : " disabled ";
                    ?>


                    <div id="configuration">
                        <fieldset>
                            <label><input type="checkbox" name="title" <?php echo isset($data["xrely_config"]["config"]["title"])?"checked":""; ?>  />Title</label>
                            <label><input type="checkbox" name="url" <?php echo isset($data["xrely_config"]["config"]["url"])?"checked":""; ?> />URL</label>
                            <label title="Upgrade Your Account"><input type="checkbox" name="thumb" <?php echo $disable; echo isset($data["xrely_config"]["config"]["thumb"])?"checked":""; ?>  />Thumbnail</label>
                            <label title="Upgrade Your Account"><input type="checkbox" name="category" <?php echo $disable; echo isset($data["xrely_config"]["config"]["category"])?"checked":""; ?> />Category</label>
                            <label title="Upgrade Your Account"><input type="checkbox" name="author" <?php echo $disable; echo isset($data["xrely_config"]["config"]["author"])?"checked":""; ?> />Author</label>
                            <div style="margin-top: 10px;">
                                <?php
                                if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
                                {
                                    ?>                                <p><b>Woocommerce Product Attrbute</b></p><?php
                                    foreach (wc_get_attribute_taxonomies() as $one_attribute)
                                    {
                                        ?>
                                        <label title="Upgrade Your Account"><input type="checkbox" name="<?php echo $one_attribute->attribute_name ?>" <?php echo isset($data["xrely_config"]["config"][$one_attribute->attribute_name])?"checked":""; ?> <?php echo $isPrimium ? "" : " disabled " ?>  /><?php echo $one_attribute->attribute_label ?></label>

                                    <?php } ?>
                                    <label title="Upgrade Your Account"><input type="checkbox" name="_regular_price" <?php echo $disable ?> />Price</label>
                                <?php }
                                ?>
                            </div>
                        </fieldset>
                    </div>
                    <div class="submit-container">
                        <input type="submit" class="left button button-primary" />
                    </div>
                </form>
            </div>
            <div id="view3">
                <form>

                </form>
                <b>Customize your auto complete by selecting colors</b>
                <div style="clear: both;height: 30px"></div>
                <div id="dropbox" style="width: 30%">
                    <div>
                        <div style="margin-bottom: 10px; ">Try setting design for your auto complete.</div>
                        <?php
                        $html = get_search_form(false);
                        $dom = new DOMDocument();
                        $dom->loadHTML($html);
                        $xpath = new DOMXPath($dom);
                        $nodes = $xpath->query("//input[@name='s']");
                        $submit_button = $xpath->query("//input[@type='submit']");
                        foreach ($submit_button as $submit_node)
                        {
                            $submit_node->parentNode->removeChild($submit_node);
                        }

                        foreach ($nodes as $node)
                        {
                            $node->setAttribute("style", "width:100%;height:35px");
                            $node->removeAttribute('placeholder');
                            $node->setAttribute('placeholder', 'Design your autocomplete');
                            $drop_down_dom = new DOMDocument();
                            $html_str = "";
                            foreach ($data["xrely_config"]["posts"] as $__post)
                            {
                                $html_str .= '<div class="autocomplete-suggestion" data-index="0">' . ($__post->post_title) . '</div>';
                            }
                            @$drop_down_dom->loadHTML('<div id="previewContainer"><div><div class="autocomplete-suggestions">' . $html_str . '</div></div></div>');
                            $drop_down_node = $dom->importNode($drop_down_dom->documentElement, true);
                            $dom->appendChild($drop_down_node);
                            break;
                        }
                        echo $dom->saveHTML();
                        ?>    
                    </div>
                </div>
                <div id="toolBox" class="col-sm-12">
                    <div class="row-fluid color-container">
                        <div class="toolClass" >
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <ul>
                                        <li>
                                            <b>Auto suggest block design</b>
                                        </li>
                                        <li id="textColor">
                                            <div class="col-sm-6"><label for="color">Text Color: </label></div><div class="col-sm-6"><input id="color" type="text" class="picker" placeholder="Select you color" value="<?php echo getHEXRGB($data["xrely_config"]["css"]['.autocomplete-suggestion']["color"]) ?>" /></div><div class="clear"></div>
                                        </li>
                                        <li id="backBroundColor">
                                            <div class="col-sm-6"><label  for="backColor">Background color: </label></div><div class="col-sm-6"><input id="backColor" type="text" class="picker" placeholder="Select you color" value="<?php echo getHEXRGB($data["xrely_config"]["css"]['.autocomplete-suggestion']["background-color"]) ?>"></input></div><div class="clear"></div>
                                        </li>
                                        <li class="clear"></li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                        <div class="toolClass">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <ul>
                                        <li>
                                            <b>Auto suggest block design</b>
                                        </li>
                                        <li id="textColor">
                                            <div class="col-sm-6"><label  for="colorHover">On Hover Color: </label></div><div class="col-sm-6"><input id="colorHover" type="text" class="picker" placeholder="Select you color" value="<?php echo getHEXRGB($data["xrely_config"]["css"]['.autocomplete-suggestion:hover']["color"]) ?>" /></div><div class="clear"></div>
                                        </li>
                                        <li id="backBroundColor">
                                            <div class="col-sm-6"><label for="backColorHover">On Hover Background color: </label></div><div class="col-sm-6"><input id="backColorHover" type="text" class="picker" placeholder="Select you color" value="<?php echo getHEXRGB($data["xrely_config"]["css"]['.autocomplete-suggestion:hover']["background-color"]) ?>"></input></div><div class="clear"></div>
                                        </li>
                                        <li class="clear"></li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>

                    <br style="clear: both;margin: 2px;" />
                    <div class="block-container">
                        <div class="toolClass">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <ul>
                                        <li>
                                            <b>Auto suggest block design</b>
                                        </li>
                                        <li id="textColor">
                                            <div class="sliderContainer">
                                                <label for="paddTop">Padding Top: </label><input id="paddTop" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-top']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-top'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-top']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-top'] : "0")); ?></span>
                                            </div>
                                            <div class="sliderContainer">
                                                <label for="paddRight">Padding Right: </label><input id="paddRight" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-right']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-right'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-right']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-right'] : "0")); ?></span>
                                            </div>
                                            <div class="clear"></div>
                                        </li>
                                        <li id="backBroundColor">
                                            <div class="sliderContainer">
                                                <label for="paddBottom">Padding Bottom: </label><input id="paddBottom" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-bottom']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-bottom'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-bottom']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-bottom'] : "0")); ?></span>
                                            </div>
                                            <div class="sliderContainer">
                                                <label for="paddLeft">Padding Left: </label><input id="paddLeft" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-left']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-left'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-left']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['padding-left'] : "0")); ?></span>
                                            </div>
                                            <div class="clear"></div>
                                        </li>
                                        <li class="clear"></li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                        <div class="toolClass">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <ul>
                                        <li>
                                            <b>Auto suggest block design</b>
                                        </li>
                                        <li id="textColor">
                                            <div class="sliderContainer">
                                                <label for="marTop">Margin Top: </label><input id="marTop" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-top']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-top'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-top']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-top'] : "0")); ?></span>
                                            </div>
                                            <div class="sliderContainer">
                                                <label for="marRight">Margin Right: </label><input id="marRight" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-right']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-right'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-right']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-right'] : "0")); ?></span>
                                            </div>
                                            <div class="clear"></div>
                                        </li>
                                        <li id="backBroundColor">
                                            <div class="sliderContainer">
                                                <label for="marLeft">Margin Left: </label><input id="marLeft" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-left']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-left'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-left']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-left'] : "0")); ?></span>
                                            </div>
                                            <div class="sliderContainer">
                                                <label for="marBottom">Margin: Bottom</label><input id="marBottom" type="text" data-slider="true" value="<?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-bottom']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-bottom'] : "0")); ?>" data-slider-highlight="true" data-slider-range="0,50" data-slider-step="1">
                                                <span class="output"><?php echo intval((isset($data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-bottom']) ? $data["xrely_config"]["css"][".autocomplete-suggestion"]['margin-bottom'] : "0")); ?></span>
                                            </div>  
                                            <div class="clear"></div>
                                        </li>
                                        <li class="clear"></li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>

                    <form method="POST" action="" onsubmit="evaluateFinalStyle('#css')" style="margin-bottom: 10px;">
                        <input type="hidden" name="subpage" value="css-config"/>
                        <input type="hidden" name="account" value="<?php echo $accountId; ?>" />
                        <input type="hidden" name="css" value="" id="css"/>
                        <div class="doneDesign clear"><input class=" button button-primary" value="Save" type="submit" /></div>
                    </form>
                </div>
                <div style="clear: both"></div>
                <hr class="clear">

                <div class="alert alert-info" style="text-align: center;"><b>You can also create your own css & include it on your web page</b></div>

            </div>
            <div id="view5">
                <b>You need to go through <a href="<?php echo XRELY_SERVICE_DOMAIN ?>Documentation" target="_blank">API</a> for this</b>
            </div>
        </div>
    </div>
</div>