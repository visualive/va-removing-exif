VA Removing Exif
==============================

Automatically removing all the Exif of the newly uploaded JPEG images.

## Description

Automatically removing all the Exif of the newly uploaded JPEG images. Please note that already uploaded images will not be processed. If you want to delete Exif from the already uploaded image, please generate thumbnail image again with "[Regenerate Thumbnails](https://ja.wordpress.org/plugins/regenerate-thumbnails/)" etc.

Since Exif is stored in the database, it can be acquired with the wp_get_attachment_metadata function. This is useful if you are run a Photolog.

### How to use

Usage is easy. Just activate the plugin. This plugin requires PHP modules of the ImageMagick or GD.

### Requires
* WordPress 4.4+
* PHP 5.4+ & ImageMagick or GD modules

### Attention

This plugin is intended to save your privacy and should not be used for illegal activity like copyright violations.

## Installation

To install VA Removing Exif:

1. Upload the "va-removing-exif" directory and all its contents to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Changelog

### 1.0.0
* First public release.