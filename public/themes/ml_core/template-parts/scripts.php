<script>
    WebFontConfig = {
        custom: {
            families: ['Gilroy', 'Glyphter'],
            urls: ['<?php echo get_template_directory_uri(); ?>/styles/fonts.css']
        }
    };

    (function (d) {
        var s = d.scripts[0];

        //Webfont loader
        var wf = d.createElement('script');
        wf.src = 'https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js';
        wf.integrity = 'sha256-4O4pS1SH31ZqrSO2A/2QJTVjTPqVe+jnYgOWUVr7EEc=';
        wf.crossOrigin = 'anonymous';
        wf.async = true;
        s.parentNode.insertBefore(wf, s);

        //Flexibility Polyfill
        var fl = d.createElement('script');
        fl.src = 'https://cdnjs.cloudflare.com/ajax/libs/flexibility/2.0.1/flexibility.js';
        fl.integrity = 'sha256-ETXu4iIohKzvSucuk6Bv0DCdqiqaTTGeMsjZ72szPzM=';
        fl.crossOrigin = 'anonymous';
        fl.async = true;
        s.parentNode.insertBefore(fl, s);

        //Outdated Browser
        var ob = d.createElement('script');
        ob.src = 'https://cdnjs.cloudflare.com/ajax/libs/outdated-browser/1.1.5/outdatedbrowser.min.js';
        ob.integrity = 'sha256-yV0saZESxHBqfSfNncH044y3GHbsxLZJbQQmuxrXv90=';
        ob.crossOrigin = 'anonymous';
        ob.async = true;
        s.parentNode.insertBefore(ob, s);
    })(document);

    //Outdated Browser - Event listener: DOM ready
    function addLoadEvent(func) {
        var oldonload = window.onload;
        if (typeof window.onload != 'function') {
            window.onload = func;
        } else {
            window.onload = function () {
                if (oldonload) {
                    oldonload();
                }
                func();
            }
        }
    }

    //Outdated Browser - Call plugin function after DOM ready
    addLoadEvent(function () {
        outdatedBrowser({
            bgColor: '#f25648',
            color: '#ffffff',
            lowerThan: 'borderImage',
            languagePath: '<?php echo get_template_directory_uri(); ?>/inc/outdatedbrowser/lang/en.html'
        })
    });
</script>
<?php
global $mapScripts;
if ($mapScripts === true || get_query_var('mapScripts') === true): ?>
    <script>
        var THEME_PATH = "<?php echo get_template_directory_uri(); ?>";
    </script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places&region=USA&key=<?php echo getenv('GOOGLE_MAP_KEY', 'AIzaSyBGzqEjQmUGsUSREamvB0xfAMndf7s8Tpw'); ?>"
            async="async"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/map.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif;
global $faqScripts;
if ($faqScripts === true): ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/faq.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif;
global $contactFormScripts;
if ($contactFormScripts === true): ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/validation.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif;
global $categorySortScripts;
if ($categorySortScripts === true): ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/category.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif; ?>
<?php
global $locationHoursScripts;
if ($locationHoursScripts === true): ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/locationHours.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif; ?>
<?php
global $smoothScrollScripts;
if ($smoothScrollScripts === true): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/12.1.5/js/smooth-scroll.polyfills.min.js" integrity="sha256-+Dm1njwBSVm4pvYvs4IgJ+RTCwX51sCGZNy3ZO0XZI4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/smoothScroll.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif; ?>
<?php
global $youtubeScripts;
if ($youtubeScripts === true): ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/youtube.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif; ?>
<?php
global $promoScripts;
if ($promoScripts === true): ?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/promo.js?v=9may2018'; ?>"
            async="async"></script>
<?php
endif; ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri().'/scripts/app.js?v=9may2018'; ?>" async="async"></script>
