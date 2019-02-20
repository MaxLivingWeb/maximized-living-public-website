<?php
/**
 * Created by jamiesonroberts
 * Date: 2017-04-08
 */

/**
 * Removes the P tag that is always inserted to wrap an IMG tag.
 * @param $p
 * @return mixed
 */
function img_unautop($p)
{
    $p = preg_replace('/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '$1', $p);
    return $p;
}

add_filter('the_content', 'img_unautop', 30);