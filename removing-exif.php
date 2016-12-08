<?php
/**
 * Plugin Name: VA Removing Exif
 * Plugin URI: https://github.com/visualive/va-removing-exif
 * Description: :)
 * Author: KUCKLU
 * Version: 1.0.0
 * Author URI: https://www.visualive.jp
 * Domain Path: /langs
 * Text Domain: va-removing-exif
 * Prefix: va_removing_exif_
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package    WordPress
 * @subpackage VA Removing Exif
 * @since      1.0.0
 * @author     KUCKLU <kuck1u@visualive.jp>
 *             Copyright (C) 2016 KUCKLU & VisuAlive.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/incs/class-module-core.php';

/**
 * Run plugin.
 */
add_action( 'plugins_loaded', array( '\VAREMOVINGEXIF\Modules\Core', 'get_instance' ) );
