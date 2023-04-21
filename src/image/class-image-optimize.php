<?php
/**
 * Class ImageOptimize
 *
 * @package helper-lite-for-pagespeed
 */

namespace Karenina\HelperLightForPageSpeed\Image;

use Karenina\HelperLightForPageSpeed\Admin\HLFP_OSA;
use WP_Post;

/**
 * Class ImageOptimize
 *
 * @package Karenina\HelperLightForPageSpeed\Filter
 */
class ImageOptimize {
	/**
	 * Options section name
	 *
	 * @var string
	 */
	protected $section = 'hlfp_images';

	/**
	 * Admin Settings wrap instance
	 *
	 * @var HLFP_OSA
	 */
	protected $hlfp_osa;

	/**
	 * LightFilter constructor
	 *
	 * @param HLFP_OSA $hlfp_osa HLFP_OSA instance.
	 */
	public function __construct( HLFP_OSA $hlfp_osa ) {
		$this->hlfp_osa = $hlfp_osa;
	}

	/**
	 * Enable image hooks
	 */
	public function hooks() {
		add_action( 'wp', array( $this, 'add_filters' ) );
	}

	/**
	 * WP action,
	 * Add filters and actions on singular pages
	 */
	public function add_filters() {
		if ( ! is_singular() ) {
			return;
		}

		$option = $this->get_option( 'hlfp_lqip' );

		if ( $option === 'dnone' ) {
			$this->display_none_hooks();
		} elseif ( $option === 'lqip' ) {
			$this->lqip_hooks();
		}
	}

	/**
	 * Set hooks for hiding image on mobile
	 */
	public function display_none_hooks() {
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'hide_attachment_on_mobile' ), 10, 2 );
		add_action( 'wp_head', array( $this, 'style_hide_on_mobile' ), 10 );
	}

	/**
	 * Set hooks for lqip
	 */
	public function lqip_hooks() {
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'change_attachment_srcset' ), 10, 2 );
		add_action( 'wp_footer', array( $this, 'script_change_attachment_srcset' ), 10 );
		add_action( 'wp_head', array( $this, 'style_change_attachment_srcset' ), 10 );
	}

	/**
	 * WP filter: add hiding class for post thumbnail
	 *
	 * @param array   $attr Attributes.
	 * @param WP_Post $attachment Attachment.
	 */
	public function hide_attachment_on_mobile( $attr, $attachment ) {
		global $post;

		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );

		if ( $post_thumbnail_id === $attachment->ID ) {
			$attr['class'] .= ' hide-on-mobile';
		}

		return $attr;
	}

	/**
	 * WP filter: add srcset, lazy and lqip class
	 *
	 * @param array   $attr Attributes.
	 * @param WP_Post $attachment Attachment.
	 */
	public function change_attachment_srcset( $attr, $attachment ) {
		global $post;

		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );

		// Check if this post thumbnail (not logo).
		if ( $post_thumbnail_id !== $attachment->ID ) {
			return $attr;
		}

		$thumbnail = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );

		if ( $thumbnail === false ) {
			return $attr;
		}

		$srcset = wp_get_attachment_image_srcset( $attachment->ID, 'full' );

		if ( $srcset === false ) {
			return $attr;
		}

		$attr['srcset']      = $thumbnail . ' 300w';
		$attr['data-srcset'] = $srcset;
		$attr['data-type']   = 'lazy';
		$attr['class']      .= ' class-lqip';

		return $attr;
	}

	/**
	 * WP actionAdd hiding styles
	 */
	public function style_hide_on_mobile() {
		?>
		<style>
			/* max width for mobile: 480px */
			@media (max-width: 480px) {
				img.hide-on-mobile {
					display: none !important;
				}
			}
		</style>
		<?php
	}

	/**
	 * WP action,
	 * Add image background styles
	 */
	public function style_change_attachment_srcset() {
		global $post;

		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );

		if ( $post_thumbnail_id === false ) {
			return;
		}

		$meta = wp_get_attachment_metadata( $post_thumbnail_id );

		if ( $meta === false || empty( $meta ) || empty( $meta['width'] ) || empty( $meta['height'] ) ) {
			return;
		}

		$width  = $meta['width'];
		$height = $meta['height'];
		?>
		<style>
			.class-lqip {
				background-color: grey;
				-moz-height: calc(50vw *<?php echo (int) $height; ?> /<?php echo (int) $width; ?>) !important;
				aspect-ratio: <?php echo (int) $width; ?> /<?php echo (int) $height; ?>;
				object-fit: cover;
			}

			@media (max-width: 480px) {
				.class-lqip {
					-moz-height: calc(100vw *<?php echo (int) $height; ?> /<?php echo (int) $width; ?>) !important;
					aspect-ratio: <?php echo (int) $width; ?> /<?php echo (int) $height; ?>;
				}
			}
		</style>
		<?php
	}

	/**
	 * WP action,
	 * Add image loader script
	 */
	public function script_change_attachment_srcset() {
		?>
		<script>
			(function () {
				var HLFP_loadImagesTimer = setTimeout(HLFP_loadImages, 3 * 1000);
				var HLFP_userInteractionEvents = ["mouseover", "keydown", "touchmove", "touchstart"];

				HLFP_userInteractionEvents.forEach(function (event) {
					window.addEventListener(event, HLFP_triggerImageLoader, {passive: true});
				});

				function HLFP_triggerImageLoader() {
					HLFP_loadImages();
					clearTimeout(HLFP_loadImagesTimer);
					HLFP_userInteractionEvents.forEach(function (event) {
						window.removeEventListener(event, HLFP_triggerImageLoader, {passive: true});
					});
				}

				function HLFP_loadImages() {
					document.querySelectorAll("img[data-type='lazy'], source").forEach(function (elem) {
						elem.setAttribute("srcset", elem.getAttribute("data-srcset"));
					});
				}
			})();
		</script>
		<?php
	}

	/**
	 * Get option from local HLFP_OSA instance
	 *
	 * @param string       $option  Aption's name.
	 * @param string|mixed $default Default value to return if option doesn't exist.
	 *
	 * @return string|mixed option value or default value
	 */
	protected function get_option( $option, $default = '' ) {
		return $this->hlfp_osa->get_option( $option, $this->section, $default );
	}
}
