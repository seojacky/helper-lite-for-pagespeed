=== Helper Lite for PageSpeed ===
Contributors: seojacky, karenka
Tags: seo-friendly, seo, pagespeed, lighthouse, perfomance, optimaze, optimization, lazy load, image, optimaze images
Requires at least: 5.0
Tested up to: 5.5
Requires PHP: 5.6.20
Stable tag: 3.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Speed up your site with attributes decoding="async" & loading="lazy" for &lt;img&gt; and &lt;iframe&gt;. Removes problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score.
The main development is all going on GitHub.

== Installation ==
= From your WordPress dashboard =
1. Visit 'Plugins > Add New'
2. Search for 'Helper Lite for PageSpeed'
3. Activate Helper Lite for PageSpeed from your Plugins page.
4. [Optional] Configure plugin in 'WP Booster > PageSpeed Helper'.

= From WordPress.org =
1. Download Helper Lite for PageSpeed.
2. Upload the 'helper-lite-for-pagespeed' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate Helper Lite for PageSpeed from your Plugins page.
4. [Optional] Configure plugin in 'WP Booster > PageSpeed Helper'.

== Frequently Asked Questions ==
= What does the plugin do? = 
* Adds decoding="async" & loading="lazy" attributes to all images on the page. It has been experimentally proven that the combination of these attributes speeds up page load by 0.1-0.2 seconds and increases Your Google PageSpeed Insights Score.
* Adds loading="lazy" attributes to all &lt;iframe&gt; on the page.
* You can include a script that removes the Google PageSpeed Insights remark "Does not use passive listeners to improve scrolling performance"

= Where are the plugin settings? =
The settings are located at the section of the admin panel WP Booster > PageSpeed Helper

= How to set up? =
1. In the first tab ‘Settings’ you can choose how to add attributes.

* The first method ‘Filters’ is safe, but does not apply attributes to all images.
* The second method ‘Buffer’ will add attributes to all images, but may cause problems on some sites.
* You can choose what values set to attributes or turn off them at all.

2. At the second tab ‘Scripts’ you can turn on a script,
which removes the Google PageSpeed Insights remark “Does not use passive listeners to improve scrolling performance”.

= What is 'Does not use passive listeners to improve scrolling performance' ???? =
This PSI note, for example, may appear on pages where the comment-reply.min.js script is loaded. Several other scripts can also lead to this remark.

= I installed the plugin but my Google PageSpeed Insights score did not increase =
* Clear cache on your site
* The maximum effect will be on page with images. No images - no result
* Plugin does not affect images added to background via css, for the simple reason that it is impossible to add decoding="async" and loading="lazy" attributes to them. The plugin only works with images added via the &lt;img&gt; tag.

== Screenshots ==
1. Before activating the plugin
2. After activating the plugin

== Changelog ==
= 3.0.2 =
* Added "Rate us" link on plugins page
* Settings was moved under "WP Booster" page in the Dashboard

= 3.0.2 =
* Fixed bug with translations

= 3.0.1 =
* Fixed bugs

= 3.0 =
* Plugin structure fully rewritten 
* Fix bug with double slash in script URL
* "Contacts" tab changed to "Help" tab
* Added little FAQ
* Added More contacts information

= 2.5.8 =
* Fixed incompatibility with plugin's pro version
* Fixed WordPress Coding Standards
* Added new icon and cover

= 2.5.7 =
* Fixed bugs

= 2.5.6 =
* Added support attribute loading="lazy" for iframe
* Added "iframe loading" on "Settings" page

= 2.5.4 =
* Plugin works only with GET requests due to Gutenberg's issues
* Buffer doesn't get clean after plugin's work
* It's possible now to select attributes value or turn off attribute at all
* Added "Settings" and "Author" links on plugins page

= 2.5.3 =
* Fixed unescaped double quotes in AJAX calls
* Passive events are applying only on "touchstart", "scroll" and "wheel" events
* Fixed "undefined offset" warning

= 2.5.2  =
* Fixed problem "Does not use passive listeners to improve scrolling performance"
* Add Russian adn English language support

= 2.5.1  =
* Fixed WordPress Coding Standards

= 2.3.8 (17.07.2020) =
* Fixed WordPress Coding Standards

= 2.3.7 =
* Fixed bugs

= 2.3.3 =
* Fixed bugs

= 2.2 =
* Fixed bugs

= 2.1 =
* Fixed bugs

= 2.0 (10.07.2020) =
* Fixed bugs
