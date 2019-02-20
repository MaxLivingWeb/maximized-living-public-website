<!-- Google Tag Manager -->
<script>
    <?php
    get_template_part('template-parts/header-data-layer');
    ?>
    (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-<?php echo env("GTM_KEY");?>');
</script>
<!-- End Google Tag Manager -->

<script type="text/javascript">
    (function (a, e, c, f, g, h, b, d) {
        var k = {ak: "844113212", cl: "djXJCJC5gHsQvMrAkgM"};
        a[c] = a[c] || function () {
            (a[c].q = a[c].q || []).push(arguments)
        };
        a[g] || (a[g] = k.ak);
        b = e.createElement(h);
        b.async = 1;
        b.src = "//www.gstatic.com/wcm/loader.js";
        d = e.getElementsByTagName(h)[0];
        d.parentNode.insertBefore(b, d);
        a[f] = function (b, d, e) {
            a[c](2, b, k, d, null, new Date, e)
        };
        a[f]()
    })(window, document, "_googWcmImpl", "_googWcmGet", "_googWcmAk", "script");
</script>

<!-- Start Visual Website Optimizer Asynchronous Code -->
<script type='text/javascript'>
    var _vwo_code = (function () {

        var account_id = 321838,
            settings_tolerance = 2000,
            library_tolerance = 2500,
            use_existing_jquery = false,
            /* DO NOT EDIT BELOW THIS LINE */
            f = false, d = document;
        return {
            use_existing_jquery: function () {
                return use_existing_jquery;
            }, library_tolerance: function () {
                return library_tolerance;
            }, finish: function () {
                if (!f) {
                    f = true;
                    var a = d.getElementById('_vis_opt_path_hides');
                    if (a) a.parentNode.removeChild(a);
                }
            }, finished: function () {
                return f;
            }, load: function (a) {
                var b = d.createElement('script');
                b.src = a;
                b.type = 'text/javascript';
                b.innerText;
                b.onerror = function () {
                    _vwo_code.finish();
                };
                d.getElementsByTagName('head')[0].appendChild(b);
            }, init: function () {
                settings_timer = setTimeout('_vwo_code.finish()', settings_tolerance);
                var a = d.createElement('style'),
                    b = 'body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}',
                    h = d.getElementsByTagName('head')[0];
                a.setAttribute('id', '_vis_opt_path_hides');
                a.setAttribute('type', 'text/css');
                if (a.styleSheet) a.styleSheet.cssText = b; else a.appendChild(d.createTextNode(b));
                h.appendChild(a);
                this.load('https://dev.visualwebsiteoptimizer.com/j.php?a=' + account_id + '&u=' + encodeURIComponent(d.URL) + '&r=' + Math.random());
                return settings_timer;
            }
        };
    }());
    _vwo_settings_timer = _vwo_code.init();
</script>
<!-- End Visual Website Optimizer Asynchronous Code -->
