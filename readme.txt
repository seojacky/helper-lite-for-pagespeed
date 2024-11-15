=== Helper Lite for PageSpeed ===
Contributors: seojacky, mihdan, wdup
Tags: pagespeed, page speed, lazy load, lighthouse, optimization, image, seo, seo-friendly, perfomance, optimaze,  optimaze images
Requires at least: 5.0
Tested up to: 6.2
Requires PHP: 7.4
Stable tag: 3.1.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Speed up your site with attributes decoding="async" & loading="lazy" for &lt;img&gt; and &lt;iframe&gt;. Removes problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score.
The main development is all going on GitHub.

= Translations =
[Help translate Helper Lite for PageSpeed](https://translate.wordpress.org/projects/wp-plugins/helper-lite-for-pagespeed/)

<ul>
	<li>🇷🇺 Русский (Russian) - <a href="https://profiles.wordpress.org/seojacky">seojacky</a></li>
	<li>🇺🇦 Українська (Ukranian) - <a href="https://profiles.wordpress.org/karenka">karenka</a></li>
	<li>🇪🇸 Spanish (Spain) - <a href="https://profiles.wordpress.org/nobnob/">Javier Esteban (nobnob)</a></li>
	<li>🇲🇽 Spanish (Mexico) - <a href="https://profiles.wordpress.org/nobnob/">Javier Esteban (nobnob)</a></li>
	<li>🇻🇪 Spanish (Venezuela) - <a href="https://profiles.wordpress.org/nobnob/">Javier Esteban (nobnob)</a></li>
	<li>🇮🇹 Italiana (Italian)- <a href="https://profiles.wordpress.org/gigaster/">gigaster</a>, <a href="https://profiles.wordpress.org/lidialab/">Lidia Pellizzaro</a></li>
</ul>

= Contribution =

Developing plugins is long and tedious work. If you benefit or enjoy this plugin please take the time to:

* [Donate](https://bit.ly/2RPJ1Wi) to support ongoing development. Your contribution would be greatly appreciated.
* [Rate and Review](https://wordpress.org/support/plugin/helper-lite-for-pagespeed/reviews/#new-post) this plugin.
* Share with us or view the [GitHub Repo](https://github.com/seojacky/helper-lite-for-pagespeed) if you have any ideas or suggestions to make this plugin better.

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

= In WordPress 5.5 and up, images are lazy loaded by default. Why is this plugin needed? =
By default, WordPress add a loading="lazy" attribute to the following images:
* images within post content
* images within post excerpts
* images within text widgets
* avatar images
* template images using wp_get_attachment_image()
But WordPress does not add loading="lazy" for custom images in the header and footer of the site! In this case, our plugin will help you.

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

= Disabling LazyLoad on Specific Images =
If you want to disable LazyLoad on a specific image, you can do so by adding the `skip-lazy` class to the &lt;img&gt; HTML tag.

= What is LQIP? =
LQIP (Low Quality Image Placeholders) - it is function which to enable webpages to load correctly in an orderly manner, displaying ultra small, blurry images while the actual version is loading, which works well with lazy loading in JavaScript. This effectively reduces LCP for mobile and desktop. This method only works for the first image on the page - Post Thumbnail.

= Contribute =
Helper Lite for PageSpeed is now on [GitHub](https://github.com/seojacky/helper-lite-for-pagespeed). Pull Requests welcome.

== Screenshots ==
1. Before activating the plugin
2. After activating the plugin
3. Tab Setting on Plugin Settings Page
4. Tab Script on Plugin Settings Page

== Changelog ==

= 3.1.7 (15.11.2023) =
* Added: Compatibility with WordPress 6.7

= 3.1.6 (22.04.2023) =
* Fixed security issues

= 3.1.5 (20.04.2023) =
* Added support for WordPress 6.2+

= 3.1.4 (30.04.2022) =
* Updated readme

= 3.1.3 (21.11.2021) =
* Fixed bugs

= 3.1.2  =
* Added compatibility with plugin WebP Express

= 3.1.1 (15.11.2021) =
* Updated readme

= 3.1.0 (30.05.2021) =
* Changed function LQIP
* Changed FAQ
* Added Donate link
* Changed Extra links

= 3.0.10 (20.05.2021) =
* Added tab Images
* Added function LQIP

= 3.0.9 (12.02.2021) =
* Added tab with our useful plugins
* Added support for WordPress 5.6+

= 3.0.8 =
* Updated description
* Fixed bugs

= 3.0.6 =
* Updated description

= 3.0.5 =
* Changed Setting page
* Added disable function for loading lazy in WP 5.5 and higher
* Added disable function for lazyload on specific images

= 3.0.4 =
* Added "More optimization" tab
* Deleted support chat link

= 3.0.3 =
* Fixed bugs

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
