<?php

namespace Karenina\HelperLightForPageSpeed\Admin;

defined('ABSPATH') or exit('No direct script access allowed');
defined('HLFP_FILE') or exit('HLFP_FILE is not defined for helper-lite-for-pagespeed plugin');

/**
 * class AdminManager
 *
 * @package Karenina\HelperLightForPageSpeed\Admin
 */
class AdminManager
{
    /**
     * Flag Codes
     *
     * @var array
     */
    protected $flags = array(
        'uk' => '&#127468;&#127463;',
        'usa' => '&#127482;&#127480;',
        'ru' => '&#127479;&#127482;',
        'ua' => '&#127482;&#127462;',
        'pl' => '&#127477;&#127473;',
    );
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
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
        add_action('admin_init', array($this, 'setup_fields'), 9, 0);
        add_filter('plugin_action_links_' . plugin_basename(HLFP_FILE), array($this, 'setup_extra_links'), 10, 1);
        add_filter('plugin_row_meta', array($this, 'setup_meta_links'), 10, 2);
    }

    /**
     * Load plugin's text domain
     */
    public function load_plugin_textdomain() 
    {
        load_plugin_textdomain('helper-lite-for-pagespeed', false, basename(dirname(HLFP_FILE)) . '/languages/');
    }
    
    /**
     * WP filter hook,
     * Creates "Settings" and "Author" links
     * on plugins page
     *
     * @param array $links initial WP links
     *
     * @return array populated links
     */
    public function setup_extra_links($links)
    {
        $extra_links = array(
            '<a href="options-general.php?page=hlfp-settings.php">' . __('Settings', 'helper-lite-for-pagespeed') . '</a>',
            '<a href="https://t.me/wp_booster" target="_blank">' . __('Author', 'helper-lite-for-pagespeed') . '</a>',
        );

        return array_merge($links, $extra_links);
    }

    /**
     * WP filter hook
     * Adds meta links to the plugin's footer
     *
     * @param array $links initial WP links
     * @param string $file current plugin filename
     *
     * @return array populated links
     */
    public function setup_meta_links($links, $file)
    {
        // if not current plugin, return default links
        if (plugin_basename(HLFP_FILE) !== $file)
        {
            return $links;
        }

        $meta_links = array(
            '<a href="https://wordpress.org/plugins/helper-lite-for-pagespeed/#%0Awhat%20does%20the%20plugin%20do%3F%0A" target="_blank">' . __('FAQ', 'helper-lite-for-pagespeed') . '</a>',
        );

        return array_merge($links, $meta_links);
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
                'desc' => __("Filter - use default Wordpress filters. Will not filter all images on page.<br />Buffer - use PHP buffer. Filter all images on page. Might cause problems on some servers.", 'helper-lite-for-pagespeed'),
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
                'desc' => __("Attribute \"loading\" for &lt;image&gt;", 'helper-lite-for-pagespeed'),
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
                'desc' => __("Attribute \"decoding\" for &lt;image&gt;", 'helper-lite-for-pagespeed'),
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
                'id' => 'hlfp_help',
                'title' => __('Help', 'helper-lite-for-pagespeed'),
            )
        );

        $this->hlfp_osa->add_field(
            'hlfp_help',
            array(
                'id' => 'faq',
                'type' => 'html',
                'name' => '<h2>' . __('FAQ', 'helper-lite-for-pagespeed') . '</h2>',
                'desc' => '<h4>' . __('Filters or Buffer?', 'helper-lite-for-pagespeed') . '</h4>'
                . '<ul>'
                . '<li>'
                . __("<b>Filters</b> — will not filter all images on page. Affects only post/page content and thumbnails. Uses Wordpress standard filters. Safe to use on any site.", 'helper-lite-for-pagespeed')
                . '</li>'

                . '<li>'
                . __("<b>Buffer</b> — will filter all images on page. Uses PHP buffer.
                     Might cause problems on some sites due to server's configuration or conflicts with other plugins that use buffer.<br />
                     Use this filter type if you want plugin affect to all images on your site. If you see any problems with site loading or post/page saving with Buffer enabled, use Filters type instead.", 'helper-lite-for-pagespeed')
                . '</li>'
                . '</ul>'

                . '<h4>' . __('What attributes should I use?', 'helper-lite-for-pagespeed') . '</h4>'
                . '<p>' . __("It has been experimentally proven that combination of attributes <code>loading=\"lazy\"</code> and <code>decoding=\"async\"</code> on <code>&lt;img&gt;</code>
                speeds up page loading by 0.1-0.2 seconds and increases Your Google PageSpeed Insights Score. We recommend You to use this attributes combination. 
                You can also turn off attribute at all, if You, for example, use third-party lazy loading.<br />
                <code>loading=\"lazy\"</code> for <code>&lt;iframe&gt;</code> also speeds up page loading.", 'helper-lite-for-pagespeed') . '</p><br />'
                . '<b style="font-style:normal;">' . __('For more information visit our <a href="https://wordpress.org/plugins/helper-lite-for-pagespeed/#%0Awhat%20does%20the%20plugin%20do%3F%0A" target="_blank">FAQ</a>.', 'helper-lite-for-pagespeed') . '</b>',
            )
        );

        // Contact us 
        $this->hlfp_osa->add_field(
            'hlfp_help',
            array(
                'id' => 'telegram',
                'type' => 'html',
                'name' => '<h2>' . __('Support', 'helper-lite-for-pagespeed') . '</h2>',
                'desc' => '<b style="font-style:normal;color:#444;">' . __('- Contact us at Telegram chat') . ' <a href="https://t.me/wp_booster" target="_blank">WP Boost</a></b> <br/>'
                . sprintf(__('We speak %s languages.', 'helper-lite-for-pagespeed'), '<span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">' . $this->get_flags(array('uk', 'usa', 'ru', 'ua', 'pl')) . '</span>')
				. '<br/><b style="font-style:normal;color:#444;">' . __('- Contact us at') . ' <a href="https://wordpress.org/support/plugin/helper-lite-for-pagespeed/" target="_blank">Support Page on WordPress.org</a></b> <br/>',
            )
        );
		
		
		// Developers text
		        $this->hlfp_osa->add_field(
            'hlfp_help',
            array(
                'id' => 'developers',
                'type' => 'html',
                'name' => '<h2>' . __('Developers', 'helper-lite-for-pagespeed') . '</h2>',
                'desc' => '<div style="display:flex;flex-direction:column;">'
                . '<div>'
                . '<h4>' . __('Eugen Kalinsky', 'helper-lite-for-pagespeed') . '</h4>'
                . '<img src="' . HLFP_URL . 'img/seojacky.jpeg' . '" style="border-radius:100%;float:left;">'
                . '<p style="float:left;margin-left:2rem;">' . __('Web-Master, SEO specialist, SEO optimization + PageSpeed for Wordpress sites', 'helper-lite-for-pagespeed') . '<br />'
                . __('Languages', 'helper-lite-for-pagespeed') . ' <span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">' . $this->get_flags(array('uk', 'usa', 'ru', 'ua')) . '</span>' . '<br />'
                . '<b>' . __('Telegram profile ', 'helper-lite-for-pagespeed') . '<a href="https://t.me/big_jacky" target="_blank">@big_jacky</a>' . '</b>' . '</p>'
                . '</div>'

                . '<hr style="border-top: 1px solid gray;width:50%;margin:1.5rem 0;">'

                . '<div>'
                . '<h4>' . __('Karenina', 'helper-lite-for-pagespeed') . '</h4>'
                . '<img src="' . HLFP_URL . 'img/karenina.png' . '" style="border-radius:100%;float:left;">'
                . '<p style="float:left;margin-left:2rem;">' . __('PHP & JavaScript (NodeJS) programmer, Wordpress themes and plugins developer', 'helper-lite-for-pagespeed') . '<br />'
                . __('Languages', 'helper-lite-for-pagespeed') . ' <span style="background-color: #cecece;padding: 2px 5px;border-radius: 10px;">' . $this->get_flags(array('uk', 'usa', 'ru', 'ua', 'pl')) . '</span>' . '<br />'
                . '<b>' . __('Telegram profile ', 'helper-lite-for-pagespeed') . '<a href="https://t.me/kar_enina" target="_blank">@kar_enina</a>' . '</b>' . '</p>'
                . '</div>'
                . '</div>',
            )
        );
    }

    /**
     * Returns flag codes with delimiters
     *
     * @param array $flags array of country codes
     * @param string $delim delimiter
     *
     * @return string flag codes
     */
    public function get_flags($flags, $delim = ' ')
    {
        $result = '';

        foreach ($flags as $flag)
        {
            if (isset($this->flags[$flag]))
            {
                $result .= $this->flags[$flag] . $delim;
            }
        }

        return $result;
    }
}
