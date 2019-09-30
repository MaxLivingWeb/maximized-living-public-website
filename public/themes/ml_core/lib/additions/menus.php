<?php

/**
 * Register menus.
 */
function register_ml_menus()
{
    register_nav_menus(
        array(
            'main-nav' => __('Main Navigation'),
            'secondary-nav' => __('Secondary Navigation'),
            'footer-col1-nav' => __('Footer Column One'),
            'footer-col2-nav' => __('Footer Column Two'),
            'footer-sub-nav' => __('Footer Secondary Navigation')

        )
    );
}

add_action('init', 'register_ml_menus');

/**
 * Only on the specified menu, main-nav, add store button
 */
function main_nav_wrap()
{

    $wrap = '<ul id="%1$s" class="navLinks">';
    $wrap .= '<li class="appointment">
                <a class="navLinkWithIcon" href="' . get_home_url() . '/locations" title="Make An Appointment">
                <span class="icon-outlinedPin"></span>
                <span class="navLinkText">Make An Appointment</span>
                </a>
                </li>';
    $wrap .= '%3$s';
    $wrap .= '<li>';
    $wrap .= '</li>';
    $wrap .= '</ul>';

    return $wrap;
}

function sec_nav_wrap()
{

    $wrap = '<ul id="%1$s" class="navLinks">';
    $wrap .= '%3$s';
    $wrap .= '<li class="mobileMenuButtonContainer">';
    $wrap .= '<button class="mobileMenuButton" title="Menu">
        <span class="line-1"></span>
        <span class="line-2"></span>
        <span class="line-3"></span>
        <span class="invisible">Menu</span>
        </button>';
    $wrap .= '</li>';
    $wrap .= '</ul>';

    return $wrap;
}

class mainNav extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        if ($item->title !== 'Online Store' && $item->menu_item_parent == 0) {
            $output .= "<li><a class='navLink' href='{$item->url}' title='{$item->title}'>{$item->title}</a>";
        } else if ($item->title == 'Online Store') {
            $url = $item->url . utmURL();
            $output .= "<li><span class='divider'></span>
                <a class='navLinkWithIcon' href='{$url}' title='{$item->title}'>
                <span class='icon-cart'></span>
                <span class='navLinkText'>{$item->title}</span></a>";
        } else if ($item->menu_item_parent > 0) {
            $output .= "<li><a href='{$item->url}' title='{$item->title}'>{$item->title}</a>";
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $output .= '</li>';
    }

    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='navDropdown'><ul class=''>";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul><div class='navDropdownShadow'></div></div><button class='navDropdownToggle' title='Toggle Submenu'><span class='invisible'>Toggle Submenu</span></button>\n";
    }
}


class secondaryNav extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        switch (strtolower($item->title)) {
            case 'find a clinic':
                $output .= "<li><a class='navLinkWithIcon navLinkWithIcon-pin' href='{$item->url}' title='{$item->title}'>
                <span class='icon-solidPin'></span><span class='navLinkText'>Find A Clinic</span></span></a>";
                break;
            case 'login':
                $output .= "<li><a class='navLinkWithIcon' href='https://clientstore.maxliving.com/' title='{$item->title}'>
                <span class='icon-account'></span><span class='navLinkText'>Client Login</span></span></a>";
                break;
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $output .= '</li>';
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "<span></span></ul><span></span>\n";
    }
}

class secondaryMobileNav extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        switch (strtolower($item->title)) {
            case 'location':
                $output .= "<li><span class='divider'></span>
                <a class='navLinkWithIcon' href=" . get_home_url() . '/locations' . " title='{$item->title}'>
                <span class='icon-outlinedPin'></span>
                <span class='navLinkText'>{$item->title}</span></a>";
                break;
            case 'login':
                $output .= "<li><a class='navLinkWithIcon' href='https://clientstore.maxliving.com/' title='{$item->title}'>
                <span class='icon-account'></span><span class='navLinkText'>Client Login</span></span></a>";
                break;
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $output .= '</li>';
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "<span></span></ul><span></span>\n";
    }
}
