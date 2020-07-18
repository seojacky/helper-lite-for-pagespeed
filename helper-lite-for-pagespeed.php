<?php
/**
 * Plugin name: Helper Lite for PageSpeed
 * Description: A faster your site with image attributes decoding="async" & loading="lazy". Remove problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score. | <a href="https://t.me/big_jacky" target="blank_">Author</a> 
 * Version: 2.5.2
 * Author: @big_jacky 
 * Author URI: https://t.me/big_jacky
 * Plugin URI: https://wordpress.org/plugins/helper-lite-for-pagespeed/
 * GitHub Plugin URI: https://github.com/seojacky/helper-lite-for-pagespeed
 * Text Domain: helper-lite-for-pagespeed
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

define( 'HLPS_URL', plugin_dir_url( __FILE__ ) );
define( 'HLPS_DIR', plugin_dir_path( __FILE__ ) );
/*define( 'HLPS_VERSION', '3.2.1' );
define( 'HLPS_OPTION', 'custom_image_sizes' );*/

//Подгружает перевод плагина из указанной директории
	public static function init_translation() {
		load_plugin_textdomain( 'helper-lite-for-pagespeed', false, basename( rtrim( SIS_DIR, '/' ) ) . '/languages' );
	}
}

add_filter( 'widget_custom_html_content', 'hlps_add_async_and_lazy', 10 );
add_filter( 'widget_text', 'hlps_add_async_and_lazy', 10 );
add_filter( 'the_content','hlps_add_async_and_lazy' );
add_filter( 'wp_get_attachment_image_attributes', 'hlps_add_async_and_lazy_to_attachment_image', 90 );

function hlps_add_async_and_lazy( $content ) {
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
