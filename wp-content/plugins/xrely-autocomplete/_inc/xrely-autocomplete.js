var xfindSelect = "INPUT[name='s']";
jQuery(document).ready(function () {
    (function () {
        var s = document.createElement("script");
        s.type = "text/javascript";
        s.src = "//autocomplete.xrely.com/js/autocomplete/autoScript.js?_=" + document.location.host + "&no=1";
        var x = document.getElementsByTagName("head")[0];
        x.appendChild(s);
    })();
});
