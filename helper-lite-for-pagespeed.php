<?php
/**
 * Plugin name: Helper Lite for PageSpeed
 * Description: A faster your site with image attributes decoding="async" & loading="lazy". Help to Up Your Google Page Speed Score. | <a href="https://t.me/big_jacky" target="blank_">Author</a>
 * Version: 2.6
 * Author: @big_jacky
 * Author URI: https://t.me/big_jacky
 * Plugin URI: https://wordpress.org/plugins/helper-lite-for-pagespeed/
 * GitHub Plugin URI: https://github.com/seojacky/helper-lite-for-pagespeed
 */

defined('ABSPATH') or exit('No direct script access allowed');

ob_start();

add_action('shutdown', function ()
{
    if ( is_admin() ) {
        
    return;
        
    $content = '';

    // We need to iterate over each ob level, collecting that buffer's output into the final output.
    while (ob_get_level())
    {
        $content .= ob_get_clean();
    }

    // add async decoding & lazy loading to each image
    $content = str_replace( '<img','<img decoding="async" loading="lazy"', $content );

    // output content
    echo $content;
        }
    
    }, 0);
?>
