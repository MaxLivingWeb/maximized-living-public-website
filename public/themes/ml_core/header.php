<?php
/**
 * The header for our theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MaxLiving
 */
global $blog_id;
global $affiliate_id;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta http-equiv="Expires" content="1">

    <?php
    if (get_query_var('isLocationPage') === true) {//Location Header Meta data for /locations/*
        get_template_part('template-parts/locationHeader');
    }
    wp_head();
    ?>

    <link href="<?php echo get_template_directory_uri() . '/styles/theme.css'; ?>" rel="stylesheet"
          type="text/css">

    <!--  Print Styles  -->
    <link rel="stylesheet" type="text/css" media="print"
          href="<?php echo get_template_directory_uri() . '/styles/print.css'; ?>"/>

    <?php
    // White Label Theme Overrides
    if (get_stylesheet() === 'ml_whitelabel') {
        get_template_part('template-parts/white-label-styles');
    }
    ?>

    <!-- Outdated Browser Service CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/outdated-browser/1.1.5/outdatedbrowser.min.css"
          integrity="sha256-KNfTksp/+PcmJJ0owdo8yBLi/SVMQrH/PNPm25nR/pI=" crossorigin="anonymous"/>
    <!-- End Outdated Browser Service CSS -->

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180"
          href="<?php echo get_template_directory_uri() . '/favicons/apple-touch-icon.png'; ?>">
    <link rel="icon" type="image/png" sizes="32x32"
          href="<?php echo get_template_directory_uri() . '/favicons/favicon-32x32.png'; ?>">
    <link rel="icon" type="image/png" sizes="16x16"
          href="<?php echo get_template_directory_uri() . '/favicons/favicon-16x16.png'; ?>">
    <link rel="manifest" href="<?php echo get_template_directory_uri() . '/favicons/manifest.json'; ?>">
    <link rel="mask-icon" href="<?php echo get_template_directory_uri() . '/favicons/safari-pinned-tab.svg'; ?>"
          color="#7890a2">
    <meta name="theme-color" content="#ffffff">
    <!-- End Favicons -->

    <?php
    get_template_part('template-parts/header-scripts');
    ?>

</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BPQSKF" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<a class="invisible skip-link screen-reader-text"
   href="#main-content"><?php esc_html_e('Skip to content', 'maxliving'); ?></a>

<header id="masthead" class="site-header">
    <?php get_template_part('template-parts/navigation'); ?>
</header>

<main id="main-content"> <?php // Start of main tag - closed in footer -- do not delete! ?>
