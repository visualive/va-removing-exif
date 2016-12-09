<?php
/**
 * WordPress plugin defines.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$va_removing_exif_path = str_replace( 'incs/defines.php', 'removing-exif.php', __FILE__ );
$va_removing_exif_data = get_file_data( $va_removing_exif_path, array(
	'Name'        => 'Plugin Name',
	'PluginURI'   => 'Plugin URI',
	'Version'     => 'Version',
	'Description' => 'Description',
	'Author'      => 'Author',
	'AuthorURI'   => 'Author URI',
	'DomainPath'  => 'Domain Path',
	'TextDomain'  => 'Text Domain',
	'Prefix'      => 'Prefix',
) );
$va_removing_exif_name = rtrim( $va_removing_exif_data['Prefix'], '_' );

define( 'VA_REMOVING_EXIF_URL', plugin_dir_url( $va_removing_exif_path ) );
define( 'VA_REMOVING_EXIF_PATH', untrailingslashit( plugin_dir_path( $va_removing_exif_path ) ) );
define( 'VA_REMOVING_EXIF_BASENAME', dirname( plugin_basename( $va_removing_exif_path ) ) );
define( 'VA_REMOVING_EXIF_NAME', $va_removing_exif_data['Name'] );
define( 'VA_REMOVING_EXIF_NAME_OPTION', $va_removing_exif_name );
define( 'VA_REMOVING_EXIF_VERSION', $va_removing_exif_data['Version'] );
define( 'VA_REMOVING_EXIF_PREFIX', $va_removing_exif_data['Prefix'] );

unset( $va_removing_exif_path );
unset( $va_removing_exif_data );
unset( $va_removing_exif_name );
