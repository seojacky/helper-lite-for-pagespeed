<?php
/**
 * Plugin name: Helper Lite for PageSpeed
 * Description: A faster your site with image attributes decoding="async" & loading="lazy". Help to Up Your Google Page Speed Score. | <a href="http://https://t.me/big_jacky" target="blank_">Author</a> 
 * Version: 2.3.8
 * Author: @big_jacky 
 * Author URI: https://t.me/big_jacky
 * Plugin URI: https://wordpress.org/plugins/helper-lite-for-pagespeed/
 * GitHub Plugin URI: https://github.com/seojacky/helper-lite-for-pagespeed
*/

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

add_filter( 'widget_custom_html_content', 'hlps_add_async_and_lazy', 10 );
add_filter( 'widget_text', 'hlps_add_async_and_lazy', 10 );
add_filter( 'the_content','hlps_add_async_and_lazy' );
add_filter( 'wp_get_attachment_image_attributes', 'hlps_add_async_and_lazy_to_attachment_image', 90 );

function hlps_add_async_and_lazy($content) {
    $content = str_replace( '<img','<img decoding="async" loading="lazy"', $content );
    return $content;
}

function hlps_add_async_and_lazy_to_attachment_image( $attributes ) {
  $attributes['decoding'] = 'async';
	if ( ! isset( $attributes['loading'] ) || $attributes['loading'] != 'lazy' ) {
		$attributes['loading'] = 'lazy';
	} 
  return $attributes;
}
