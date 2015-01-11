=== Random Backgrounds ===
Contributors: Erikvona
Plugin Name: Random backgrounds
Tags: random, backgrounds, background
Author URI: http://evona.nl/over-mij
Author: Erik von Asmuth (Erikvona)
Requires at least: 3.5
Tested up to: 4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


This plugin allows you to select multiple backgrounds, and display one each page.

== Description ==

Random backgrounds, as simple as possible! Just add your background, choose if you want to stretch it, tile it, or use custom HTML to display it. Find the settings under appearance -> random backgrounds. You can also set your own CSS for the random backgrounds. The plugin uses the WordPress image uploader to upload and insert images, and allows you to set as many images as you want. It also uses config files instead of MySQL, for superior efficiency in most server configurations.

Out of the box it deploys the Stuff and the Dirty Wall backgrounds, which are especially designed to make you want to delete them, so you will be familiar with the settings panel.

== Installation ==

Installation is plain and simple

1. Add the plugin to WordPress by searching and installing, uploading a zip, FTP copy, or some other way, and activate it
1. Go to Apperance -> random backgrounds.
1. Remove the standard backgrounds, and add your own!
1. Not displaying like you want it to? Customize the CSS used to display the backgrounds, or add your own HTML to display them correctly

== Changelog ==

= 1.0 =
- Now uses $_SERVER superglobal to locate current page url
- Removed redundant slash in the CSS url
- Compatibility with Evona Config Manager (to be released, allows you to keep this plugin from removing its config files upon deinstallation).

= 0.3 =
Fixed an issue that could occur when WordPress was hosted inside a subfolder of the domain

= 0.2 beta =
Initial release for the WordPress plugin repository


