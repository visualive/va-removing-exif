<?php
/**
 * WordPress plugin core class.
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

namespace VAREMOVINGEXIF\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/defines.php';
require_once dirname( __FILE__ ) . '/functions.php';
require_once dirname( __FILE__ ) . '/trait-instance.php';

/**
 * Class Core.
 *
 * @package VAREMOVINGEXIF\Modules
 */
class Core {
	use Instance;

	/**
	 * This hook is called once any activated plugins have been loaded.
	 */
	protected function __construct() {
		add_filter( 'intermediate_image_sizes_advanced', array( &$this, 'intermediate_image_sizes_advanced' ), 10, 2 );
	}

	/**
	 * Removing exif.
	 *
	 * @param array $sizes    An associative array of image sizes.
	 * @param array $metadata An associative array of image metadata: width, height, file.
	 *
	 * @return array
	 */
	function intermediate_image_sizes_advanced( $sizes, $metadata ) {
		$upload_dir     = wp_upload_dir();
		$file           = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $metadata['file'];
		$filetype       = wp_check_filetype( $file );
		$upload['file'] = $file;
		$upload['type'] = $filetype['type'];

		self::_removing_exif( $upload );

		return $sizes;
	}

	/**
	 * Removing exif.
	 *
	 * @since 1.0.0
	 *
	 * @param array $upload Array of upload data.
	 *
	 * @return array
	 */
	protected function _removing_exif( $upload = array() ) {
		if ( ! isset( $upload['type'] ) || 'image/jpeg' !== $upload['type'] || ! vare_load() ) {
			return $upload;
		}

		if ( vare_imagick_exist() ) {
			$image = new \Imagick( $upload['file'] );

			if ( $image->valid() ) {
				$image->stripImage();
				$image->writeImage( $upload['file'] );
				$image->clear();
				$image->destroy();
			}
		} elseif ( vare_gd_exist() ) {
			$image = imagecreatefromjpeg( $upload['file'] );

			imagejpeg( $image, $upload['file'], apply_filters( 'jpeg_quality', 90 ) );
			imagedestroy( $image );
		}

		return $upload;
	}
}
