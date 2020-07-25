=== Helper Lite for PageSpeed ===
Contributors: seojacky
Tags: wordpress, seo-friendly, seo, pagespeed, image
Requires at least: 5.0
Tested up to: 5.4
Stable tag: 2.5.6
Requires PHP: 5.6.20
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A faster your site with image attributes decoding="async" & loading="lazy"

== Description ==
Ускоряет Ваш сайт путём добавления к изображениям b iframe атрибутов decoding="async" & loading="lazy". Убирает замечание "Пассивные прослушиватели событий не используются для улучшения производительности при прокрутке". Помогает поднять баллы в тесте Google PageSpeed Insights.

A faster your site with image  and iframe attributes decoding="async" & loading="lazy". Remove problem "Does not use passive listeners to improve scrolling performance". Help to Up Your Google PageSpeed Insights Score.
The main development is all going on [GitHub] (https://github.com/seojacky/helper-lite-for-pagespeed).

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. (Make your instructions match the desired user flow for activating and installing your plugin. Include any steps that might be needed for explanatory purposes)

== Frequently Asked Questions ==

= Что делает плагин ? =

* Добавляет ко всем изображениям на странице атрибуты decoding="async" & loading="lazy". Экспериментально доказано, что сочетание этих атрибутов **ускоряет загрузку страницы на 0,1-0,2 секунды** и увеличивает баллы.
* Добавляет ко всем <iframe в записях и виджетах атрибут loading="lazy".
* Кроме того можно включить скрипт, который убирает замечание Google PageSpeed Insights "Пассивные прослушиватели событий не используются для улучшения производительности при прокрутке"

= Где находятся настройки плагина ? =

Настройки находятся в секции административного меню Настройки > PageSpeed Helper

= Как настроить ? =
1. В первой вкладке ‘Settings’ Вы можете выбрать способ добавления аттрибутов decoding=”async” &amp; loading=”lazy”.
<ul>
 	<li>Первый способ ‘Filters’ безопасен, но применяет атрибуты не ко всем изображениям.</li>
 	<li>Второй способ ‘Buffer’добавит аттрибуты decoding=”async” &amp; loading=”lazy” абсолютно ко всем изображениям, но **может вызывать проблемы на некоторых сайтах**.</li>
</ul>
2. Во второй вкладке ‘Scripts’ Вы можете включить скрипт, который убирает замечание Google PageSpeed Insights ”Пассивные прослушиватели событий не используются для улучшения производительности при прокрутке” (**может вызывать конфликты** с некоторыми плагинами типа ‘Contact Form 7’).

= Что такое "Пассивные прослушиватели событий не используются для улучшения производительности при прокрутке" ???? =
Это замечание PSI есть, например, на страницах с комментариями где подгружается скрипт comment-reply.min.js. Некоторые другие скрипты также могут приводить к этому замечанию.

= Установил плагин, но баллы в Google PageSpeed Insights не увеличились =
* Очистите кеш на сайте
* Максимальный эффект от плагина будет там, где есть то что он оптимизирует - картинки. Нет картинок - нет и результата
* Плагин не влияет на изображения добавленные в background через css, по той простой причине что к ним невозможно добавить аттрибуты decoding="async" и loading="lazy". Плагин работает лишь с изображениями добавленными через тег <img>.

== Screenshots ==
1. До активации плагина
2. После активации плагина

== Changelog ==

== 2.5.6 ==
* Added support attribute loading="lazy" for iframe
* Added "iframe loading" on "Settings" page

== 2.5.4 ==
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
* Add Russian adn English languge support

= 2.5.1  =
* Fixed WordPress Coding Standarts

= 2.3.8 (17.07.2020) =
* Fixed WordPress Coding Standarts

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

== Upgrade Notice ==

