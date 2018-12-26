=== VA Removing Exif ===
Contributors: kuck1u, naoki21st, mayukojpn, dim-0
Donate link: http://www.amazon.co.jp/registry/wishlist/AN9BLYUQMVZ5/
Tags: exif, privacy, attachment, attachments, media library, image, images, picture, imagemagick, imagick, gd
Requires at least: 4.4
Tested up to: 5.0.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically remove all Exif data from new JPEG and PNG images when uploading.

== Description ==

Automatically remove all Exif data from new JPEG and PNG images when uploading.

Exif data can optionally be saved as metadata separately.

Please note that already uploaded images will not be processed. If you want to delete Exif from the already uploaded image, please generate thumbnail image again with "[Regenerate Thumbnails](https://ja.wordpress.org/plugins/regenerate-thumbnails/)" etc.

= How to use =

Usage is easy. Just activate the plugin. This plugin requires PHP modules of the ImageMagick or GD.

= Requires =
* WordPress 4.4+
* PHP 5.4+ & ImageMagick or GD modules

= Contribute =

You can fork the plugin from [GitHub](https://github.com/visualive/va-removing-exif)

= Attention =

This plugin is intended to save your privacy and should not be used for illegal activity like copyright violations.

== Installation ==

To install VA Removing Exif:

1. Upload the "va-removing-exif" directory and all its contents to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Optimize your setting through the "Settings > Media" menu in WordPress.

== Screenshots ==

1. Settings > Media.

== Frequently Asked Questions ==

= What is this? =

The description covers it all.

== Changelog ==

= 1.0.2 =
* Added support for PNG images
* Added [@dim-0](https://profiles.wordpress.org/lmika/) to contributors.
* Minor adjustments to option page
* Added german translation

= 1.0.1 =
* Update description.
* Added [@mayukojpn](https://profiles.wordpress.org/mayukojpn/) to contributors.

= 1.0.0 =
* First public release.
