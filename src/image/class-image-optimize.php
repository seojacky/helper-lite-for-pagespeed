<?php

namespace Karenina\HelperLightForPageSpeed\Image;

use Karenina\HelperLightForPageSpeed\Admin\HLFP_OSA;

defined('ABSPATH') or exit('No direct script access allowed');

/**
 * class ImageOptimize
 *
 * @package Karenina\HelperLightForPageSpeed\Filter
 */
class ImageOptimize
{
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
     * @param HLFP_OSA $hlfp_osa HLFP_OSA instance
     */
    public function __construct(HLFP_OSA $hlfp_osa)
    {
        $this->hlfp_osa = $hlfp_osa;
    }

    /**
     * Enable image hooks
     */
    public function hooks()
    {
        $option = $this->get_option('hlfp_lqip');

        if ($option == 'dnone')
        {
            add_action('init', array($this, 'display_none_hooks'));
        }
        else if ($option == 'lqip')
        {
            add_action('init', array($this, 'lqip_hooks'));
        }
    }

    /**
     * Set hooks for hiding image on mobile
     */
    public function display_none_hooks()
    {
        if (!is_singular())
        {
            return;
        }

        add_filter('wp_get_attachment_image_attributes', array($this, 'hide_attachment_on_mobile'), 10, 2);
        add_action('wp_head', array($this, 'style_hide_on_mobile'), 10);
    }

    /**
     * Set hooks for lqip
     */
    public function lqip_hooks()
    {
        if (!is_singular())
        {
            return;
        }

        add_filter('wp_get_attachment_image_attributes', array($this, 'change_attachment_srcset'), 10, 2);
        add_action('wp_footer', array($this, 'script_change_attachment_srcset'), 10);
        add_action('wp_head', array($this, 'style_change_attachment_srcset'), 10);
    }

    /**
     * WP filter,
     * Add hiding class for post thumbnail
     */
    public function hide_attachment_on_mobile($attr, $attachment)
    {
        global $post;

        $post_thumbnail_id = get_post_thumbnail_id($post->ID);

        if ($post_thumbnail_id === $attachment->ID)
        {
            $attr['class'] .= ' hide-on-mobile';
        }

        return $attr;
    }

    /**
     * WP filter,
     * Add srcset, lazy and lqip class
     */
    public function change_attachment_srcset($attr, $attachment)
    {
        global $post;

        $thumbnail = get_the_post_thumbnail_url($post->ID, 'thumbnail');

        if ($thumbnail === false)
        {
            return $attr;
        }

        $srcset = wp_get_attachment_image_srcset($attachment->ID, 'full');

        if ($srcset === false)
        {
            return $attr;
        }

        $attr['srcset'] = $thumbnail . ' 300w';
        $attr['data-srcset'] = $srcset;
        $attr['data-type'] = 'lazy';
        $attr['class'] .= ' class-lqip';

        return $attr;
    }

    /**
     * WP action,
     * Add hiding styles
     */
    public function style_hide_on_mobile()
    {
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
    public function style_change_attachment_srcset()
    {
    ?>
        <style>
            .class-lqip {
                background-color: grey;
            }
        </style>
    <?php
    }

    /**
     * WP action,
     * Add image loader script
     */
    public function script_change_attachment_srcset()
    {
    ?>
        <script>
            const HLFP_loadImagesTimer = setTimeout(HLFP_loadImages, 5 * 1000);
            const HLFP_userInteractionEvents = ["mouseover", "keydown", "touchmove", "touchstart"];

            HLFP_userInteractionEvents.forEach(function (event) {
                window.addEventListener(event, HLFP_triggerImageLoader, { passive: true });
            });

            function HLFP_triggerImageLoader() {
                loadImages();
                clearTimeout(HLFP_loadImagesTimer);
                HLFP_userInteractionEvents.forEach(function (event) {
                    window.removeEventListener(event, HLFP_triggerImageLoader, { passive: true });
                });
            }

            function HLFP_loadImages() {
                document.querySelectorAll("img[data-type='lazy']").forEach(function (elem) {
                    elem.setAttribute("srcset", elem.getAttribute("data-srcset"));
                });
            }
        </script>
    <?php
    }

    /**
     * Get option from local HLFP_OSA instance
     *
     * @param string $option option's name
     * @param string|mixed $default default value to return if option doesn't exist
     *
     * @return string|mixed option value or default value
     */
    protected function get_option($option, $default = '')
    {
        return $this->hlfp_osa->get_option($option, $this->section, $default);
    }
}
