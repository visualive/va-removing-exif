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
require_once dirname( __FILE__ ) . '/class-module-admin.php';

/**
 * Class Core.
 *
 * @package VAREMOVINGEXIF\Modules
 */
class Core {
	use Instance;

	/**
	 * Option data.
	 *
	 * @var string
	 */
	private static $option = '';

	/**
	 * This hook is called once any activated plugins have been loaded.
	 */
	protected function __construct() {
		self::$option = get_option( VA_REMOVING_EXIF_NAME_OPTION, '0' );
		$admin        = apply_filters( VA_REMOVING_EXIF_PREFIX . 'module_admin', Admin::get_called_class() );

		$admin::get_instance();
		load_plugin_textdomain( 'va-removing-exif', false, VA_REMOVING_EXIF_BASENAME . '/langs' );

		if ( '1' === self::$option ) {
			add_filter( 'wp_generate_attachment_metadata', array( &$this, 'wp_generate_attachment_metadata' ) );
			add_filter( 'wp_update_attachment_metadata', array( &$this, 'wp_update_attachment_metadata' ), 10, 2 );
		} else {
			add_filter( 'intermediate_image_sizes_advanced', array( &$this, 'intermediate_image_sizes_advanced' ), 10, 2 );
		}
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
		$parent = self::_create_parent_data( $metadata );

		if ( ! empty( $parent ) ) {
			self::_removing_exif( $parent );
		}

		return $sizes;
	}

	/**
	 * Removing exif.
	 *
	 * @param array $metadata An array of attachment meta data.
	 *
	 * @return array
	 */
	public function wp_generate_attachment_metadata( $metadata ) {
		$upload = self::_create_upload_data( $metadata );

		if ( ! empty( $upload ) ) {
			foreach ( $upload as $file ) {
				self::_removing_exif( $file );
			}
		}

		return $metadata;
	}

	/**
	 * Create exif data.
	 *
	 * @param array $metadata      An array of attachment meta data.
	 * @param int   $attachment_id Current attachment ID.
	 *
	 * @return array
	 */
	public function wp_update_attachment_metadata( $metadata, $attachment_id ) {
		if ( isset( $metadata['image_meta']['camera'] ) && ! empty( $metadata['image_meta']['camera'] ) ) {
			update_post_meta( $attachment_id, '_vare_attachment_exif', $metadata['image_meta'] );
		} else {
			$exif = get_post_meta( $attachment_id, '_vare_attachment_exif', true );

			if ( ! empty( $exif ) ) {
				$metadata['image_meta'] = $exif;
			}
		}

		return $metadata;
	}

	/**
	 * Create parent data.
	 *
	 * @param array $metadata An array of attachment meta data.
	 *
	 * @return array
	 */
	protected function _create_parent_data( $metadata ) {
		$parent = array();

		if ( isset( $metadata['file'] ) ) {
			$upload_dir     = wp_upload_dir();
			$file           = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $metadata['file'];
			$filetype       = wp_check_filetype( $file );
			$parent['file'] = $file;
			$parent['type'] = $filetype['type'];
		}

		return $parent;
	}

	/**
	 * Create upload data.
	 *
	 * @param array $metadata An array of attachment meta data.
	 *
	 * @return array
	 */
	protected function _create_upload_data( $metadata ) {
		$upload = array();
		$parent = self::_create_parent_data( $metadata );

		if ( ! empty( $parent ) ) {
			$upload_dir = wp_upload_dir();
			$upload[]   = $parent;

			foreach ( $metadata['sizes'] as $size ) {
				$upload[] = array(
					'file' => $upload_dir['path'] . DIRECTORY_SEPARATOR . $size['file'],
					'type' => $parent['type'],
				);
			}
		}

		return $upload;
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
	public function _removing_exif( $upload = array() ) {
		if ( ! vare_load()  || ! ( $upload['type'] === 'image/jpeg' || $upload['type'] === 'image/png' ) ){
			return $upload;
		}

		if ( vare_imagick_exist() ) {
			$image = new \Imagick( $upload['file'] );

			if ( $image->valid() ) {
				if ( $upload['type'] === 'image/jpeg') {
					$jpeg_quality = apply_filters( 'jpeg_quality', 90 );
					$image->setImageFormat( 'jpeg' );
					$image->setImageCompressionQuality( $jpeg_quality );
				} elseif ( $upload['type'] === 'image/png' ) {
					$image->setImageFormat( 'png' );
				}
				$image->stripImage();
				$image->writeImage( $upload['file'] );
				$image->clear();
				$image->destroy();
			}
		} elseif ( vare_gd_exist() ) {
			if ( $upload['type'] === 'image/jpeg' ) {
				$image = imagecreatefromjpeg( $upload['file'] );
				imagejpeg( $image, $upload['file'], $jpeg_quality );
				imagedestroy( $image );
			} elseif ( $upload['type'] === 'image/png' ) {
				$image = imagecreatefrompng( $upload['file'] );
				imagepng( $image, $upload['file'] );
				imagedestroy( $image );
			}
		}

		return $upload;
	}
}
