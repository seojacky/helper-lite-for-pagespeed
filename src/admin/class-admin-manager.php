<?php

namespace Karenina\HelperLightForPageSpeed\Admin;

defined('ABSPATH') or exit('No direct script access allowed');

/**
 * class AdminManager
 *
 * @package Karenina\HelperLightForPageSpeed\Admin
 */
class AdminManager
{
    /**
     * Admin Settings wrap instance
     *
     * @var HLFP_OSA
     */
    protected $hlfp_osa;

    /**
     * AdminManager constructor
     *
     * @param HLFP_OSA $hlfp_osa HLFP_OSA instance
     */
    public function __construct(HLFP_OSA $hlfp_osa)
    {
        $this->hlfp_osa = $hlfp_osa;
    }

    /**
     * Enable Admins hooks
     */
    public function hooks()
    {
        add_action('admin_init', array($this, 'setup_fields'), 9, 0);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'setup_extra_links'), 10, 1);
        add_filter('plugin_row_meta', array($this, 'setup_meta_links'), 10, 2);
    }

    /**
     * WP action hook,
     * Creates "Settings" and "Author" links
     * on plugins page
     *
     * @param array $links initial WP links
     *
     * @return array populated links
     */
    public function setup_extra_links($links)
    {
        $settings_link = '<a href="options-general.php?page=hlfp-settings.php">' . __('Settings', 'helper-lite-for-pagespeed') . '</a>';
        $author_link = '<a href="https://t.me/wp_booster">' . __('Author', 'helper-lite-for-pagespeed') . '</a>';

        array_unshift($links, $settings_link);
        array_push($links, $author_link);

        return $links;
    }

    public function setup_meta_links($links, $file)
    {  
        if (plugin_basename(HLFP_FILE) !== $file)
        {
            return $links;
        }

        $extra_links = array(
            '<a href="https://t.me/wp_booster">' . __('Contact Us', 'helper-lite-for-pagespeed') . '</a>',
            '<a href="https://wp-booster.com/">' . __('Premium Version', 'helper-lite-for-pagespeed') . '</a>',
        );

        return array_merge($links, $extra_links);
    }

    /**
     * Configure setting fields
     */
    public function setup_fields()
    {
        // ======================== SETTINGS ========================

        // Settings section
        $this->hlfp_osa->add_section(
            array(
                'id' => 'hlfp_settings',
                'title' => __('Settings', 'helper-lite-for-pagespeed'),
            )
        );

        // Filter type selection field
        $this->hlfp_osa->add_field(
            'hlfp_settings',
            array(
                'id' => 'filter_type',
                'type' => 'select',
                'name' => __('Select filter type', 'helper-lite-for-pagespeed'),
                'desc' => __("Filter - use default Wordpress filters. Will not filter all images on page.
                <br />
                Buffer - use PHP buffer. Filter all images on page. Might cause problems on some servers.", 'helper-lite-for-pagespeed'),
                'options' => array(
                    'filter' => 'Filters',
                    'buffering' => 'Buffer',
                ),
            )
        );

        // loading type selection field
        $this->hlfp_osa->add_field(
            'hlfp_settings',
            array(
                'id' => 'loading_type',
                'type' => 'select',
                'name' => __('loading', 'helper-lite-for-pagespeed'),
                'options' => array(
                    'lazy' => 'lazy',
                    'eager' => 'eager',
                    'auto' => 'auto',
                    'none' => '-',
                ),
            )
        );

        // decoding type selection field
        $this->hlfp_osa->add_field(
            'hlfp_settings',
            array(
                'id' => 'decoding_type',
                'type' => 'select',
                'name' => __('decoding', 'helper-lite-for-pagespeed'),
                'options' => array(
                    'async' => 'async',
                    'sync' => 'sync',
                    'auto' => 'auto',
                    'none' => '-',
                ),
            )
        );

        // iframe loading type selection field
        $this->hlfp_osa->add_field(
            'hlfp_settings',
            array(
                'id' => 'iframe_loading_type',
                'type' => 'select',
                'name' => __('iframe loading', 'helper-lite-for-pagespeed'),
                'desc' => __("Attribute \"loading\" for &lt;iframe&gt;", 'helper-lite-for-pagespeed'),
                'options' => array(
                    'lazy' => 'lazy',
                    'eager' => 'eager',
                    'auto' => 'auto',
                    'none' => '-',
                ),
            )
        );

        // ======================== SCRIPTS ========================

        // Scripts section
        $this->hlfp_osa->add_section(
            array(
                'id' => 'hlfp_scripts',
                'title' => __('Scripts', 'helper-lite-for-pagespeed'),
            )
        );

        // Passive event checkbox
        $this->hlfp_osa->add_field(
            'hlfp_scripts',
            array(
                'id' => 'passive_events',
                'type' => 'checkbox',
                'name' => __('Use passive events', 'helper-lite-for-pagespeed'),
                'desc' => __('Events with attribute passive perform better for touch and wheel', 'helper-lite-for-pagespeed'),
            )
        );

        // ======================== CONTACTS ========================

        // Contacts section
        $this->hlfp_osa->add_section(
            array(
                'id' => 'hlfp_contacts',
                'title' => __('Contacts', 'helper-lite-for-pagespeed'),
            )
        );

        // Contact us at Telegram chat text
        $this->hlfp_osa->add_field(
            'hlfp_contacts',
            array(
                'id' => 'contacts',
                'type' => 'html',
                'name' => '<h2>' . __('Telegram', 'helper-lite-for-pagespeed') . '</h2>',
                'desc' => __('Contact us at telegram chat') . ' <a href="https://t.me/wp_booster" target="_blank">WP Boost</a>'
                . __('<br/>We speak <span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">&#127468;&#127463; &#127482;&#127480; &#127479;&#127482; &#127482;&#127462; &#127477;&#127473;</span> languages.'),
            )
        );
    }
}
