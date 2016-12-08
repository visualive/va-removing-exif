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
		add_action( 'wp_handle_upload', array( &$this, 'removing_exif' ) );
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
	public function removing_exif( $upload = array() ) {
		if ( ! vare_load() && 'image/jpeg' !== $upload['type'] ) {
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
