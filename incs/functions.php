<?php
/**
 * WordPress plugin functions.
 *
 * @package    WordPress
 * @subpackage VA Removing Exif
 * @since      1.0.0
 * @author     KUCKLU <kuck1u@visualive.jp>
 *             Copyright (C) 2016 KUCKLU and VisuAlive.
 *             This program is free software; you can redistribute it and/or modify
 *             it under the terms of the GNU General Public License as published by
 *             the Free Software Foundation; either version 2 of the License, or
 *             (at your option) any later version.
 *             This program is distributed in the hope that it will be useful,
 *             but WITHOUT ANY WARRANTY; without even the implied warranty of
 *             MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU General Public License for more details.
 *             You should have received a copy of the GNU General Public License along
 *             with this program; if not, write to the Free Software Foundation, Inc.,
 *             51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *             It is also available through the world-wide-web at this URL:
 *             http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * ImageMagick exist.
 *
 * @return bool
 */
function vare_imagick_exist() {
	return class_exists( 'Imagick' );
}

/**
 * GD exist.
 *
 * @return bool
 */
function vare_gd_exist() {
	return extension_loaded( 'gd' ) && function_exists( 'gd_info' );
}

/**
 * Load.
 *
 * @return bool
 */
function vare_load() {
	return vare_imagick_exist() || vare_gd_exist();
}