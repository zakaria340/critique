function makeItCssColor(value)
{
    var rexForColor = /[0-9A-Fa-f]{6}/g;
    if (rexForColor.test(value))
    {
        return  "#" + value;
    }
    return  value;
}
var selectItem = jQuery(".autocomplete-suggestion");
var inputToStyleMapper = {
};
var inputToHoverStyleMapper = {
};
jQuery(document).ready(function () {
    inputToStyleMapper = {
        "#color": {"element": jQuery(".autocomplete-suggestion"), "prop": "color", "hoverInput": "#colorHover", "type": "color", "valueCallback": makeItCssColor, "unit": "","prefix":"#"},
        "#backColor": {"element": jQuery(".autocomplete-suggestion"), "prop": "background-color", "hoverInput": "#backColorHover", "type": "color", "valueCallback": makeItCssColor, "unit": "","prefix":"#"},
        "#paddTop": {"element": jQuery(".autocomplete-suggestion"), "prop": "padding-top", "unit": "px","prefix":""},
        "#paddRight": {"element": jQuery(".autocomplete-suggestion"), "prop": "padding-right", "unit": "px","prefix":""},
        "#paddLeft": {"element": jQuery(".autocomplete-suggestion"), "prop": "padding-left", "unit": "px","prefix":""},
        "#paddBottom": {"element": jQuery(".autocomplete-suggestion"), "prop": "padding-bottom", "unit": "px","prefix":""},
        "#marTop": {"element": jQuery(".autocomplete-suggestion"), "prop": "margin-top", "unit": "px","prefix":""},
        "#marRight": {"element": jQuery(".autocomplete-suggestion"), "prop": "margin-right", "unit": "px","prefix":""},
        "#marLeft": {"element": jQuery(".autocomplete-suggestion"), "prop": "margin-left", "unit": "px","prefix":""},
        "#marBottom": {"element": jQuery(".autocomplete-suggestion"), "prop": "margin-bottom", "unit": "px","prefix":""}

    };
    jQuery('.picker').each(function () {
        jQuery(this).colpick({
            layout: 'hex',
            submit: 0,
            color: jQuery(this).val(),
            colorScheme: 'dark',
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                jQuery(el).css('border-color', '#' + hex);
                // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.

                if (!bySetColor)
                    jQuery(el).val(hex);
                cssAdaptor(jQuery(this));

            }
        }).keyup(function () {
            jQuery(this).colpickSetColor(this.value);
        }).css('border-color', '#' + jQuery(this).val());
    });
    jQuery(".autocomplete-suggestion").hover(function () {
        for (var prop in inputToStyleMapper) {
            if (inputToStyleMapper.hasOwnProperty(prop) && inputToStyleMapper[prop].hasOwnProperty("hoverInput")) {
                jQuery(this).css(inputToStyleMapper[prop]["prop"], "#" + jQuery(inputToStyleMapper[prop]["hoverInput"]).val());
            }
        }
        return false;
    }, function () {
        for (var prop in inputToStyleMapper) {
            if (inputToStyleMapper.hasOwnProperty(prop) && inputToStyleMapper[prop].hasOwnProperty("hoverInput")) {
                jQuery(this).css(inputToStyleMapper[prop]["prop"], "#" + jQuery(prop).val());
            }
        }
        return false;
    });
});
jQuery("[data-slider]").bind("slider:ready slider:changed", function (event, data) {
                jQuery(this)
                        .siblings(".output")
                        .html(data.value+" px");
                cssAdaptor(jQuery(this));
            });
function cssAdaptor()
{
    for (var prop in inputToStyleMapper) {
        if (inputToStyleMapper.hasOwnProperty(prop)) {
            inputToStyleMapper[prop]["element"].css(inputToStyleMapper[prop]["prop"],inputToStyleMapper[prop]["prefix"] +jQuery(prop).val() + inputToStyleMapper[prop]["unit"]);
        }
    }
}
function evaluateFinalStyle(_input)
{
    z = {};
    y = {};
    for (var x in inputToStyleMapper)
    {

        if (inputToStyleMapper.hasOwnProperty(x) && inputToStyleMapper[x].hasOwnProperty("valueCallback"))
            z[inputToStyleMapper[x]["prop"]] = inputToStyleMapper[x]["valueCallback"].call(this, inputToStyleMapper[x]["element"].css(inputToStyleMapper[x]["prop"]));
        else
            z[inputToStyleMapper[x]["prop"]] = inputToStyleMapper[x]["element"].css(inputToStyleMapper[x]["prop"]);

        if (inputToStyleMapper.hasOwnProperty(x) && inputToStyleMapper[x].hasOwnProperty("hoverInput"))
        {
            if (inputToStyleMapper.hasOwnProperty(x) && inputToStyleMapper[x].hasOwnProperty("valueCallback"))
                y[inputToStyleMapper[x]["prop"]] = inputToStyleMapper[x]["valueCallback"].call(this, jQuery(inputToStyleMapper[x]["hoverInput"]).val());
            else
                y[inputToStyleMapper[x]["prop"]] = jQuery(inputToStyleMapper[x]["hoverInput"]).val();
        }
    }
    if (_input && jQuery(_input))
        jQuery(_input).val(JSON.stringify({".autocomplete-suggestion": JSON.stringify(z), ".autocomplete-selected": JSON.stringify(y),".autocomplete-suggestion:hover": JSON.stringify(y),".autocomplete-suggestions":"{\"background-color\":\"rgb(255, 255, 255)\"}"}));
    else
        return JSON.stringify({".autocomplete-suggestion": JSON.stringify(z), ".autocomplete-selected": JSON.stringify(y), ".autocomplete-suggestion:hover": JSON.stringify(y),".autocomplete-suggestions":"{\"background-color\":\"rgb(255, 255, 255)\"}"});
}