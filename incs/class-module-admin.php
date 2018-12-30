<?php
/**
 * WordPress plugin admin class.
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

/**
 * Class Admin.
 *
 * @package VAREMOVINGEXIF\Modules
 */
class Admin {
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

		add_action( 'admin_init', array( &$this, 'admin_init' ) );
	}

	/**
	 * Add settings.
	 */
	public function admin_init() {
		register_setting( 'media', VA_REMOVING_EXIF_NAME_OPTION, array( &$this, 'sanitize_option' ) );
		add_settings_section( VA_REMOVING_EXIF_PREFIX . 'section', __( 'Remove Exif Metadata', 'va-removing-exif' ), array( &$this, 'section_description' ), 'media' );
		add_settings_field(
			VA_REMOVING_EXIF_PREFIX . 'save_exif',
			'<label for="' . esc_attr( VA_REMOVING_EXIF_PREFIX . 'save_exif' ) . '">' . __( 'Save Exif', 'va-removing-exif' ) . '</label>',
			array( &$this, 'render_save_exif' ),
			'media',
			VA_REMOVING_EXIF_PREFIX . 'section'
		);
	}

	public function section_description() {
		echo esc_html( __( 'Configure options for the removal of Exif metadata from uploaded JPEG and PNG images.', 'va-removing-exif' ) );
	}

	/**
	 * Render.
	 */
	public function render_save_exif() {
		printf(
			'<label for="%1$s"><input id="%1$s" type="checkbox" name="%2$s" value="1"%3$s>%4$s</label><br /><span class="description">%5$s %6$s</span>',
			esc_attr( VA_REMOVING_EXIF_PREFIX . 'save_exif' ),
			esc_attr( VA_REMOVING_EXIF_NAME_OPTION ),
			checked( self::$option, '1', false ),
			esc_html( __( 'Save Exif in the post meta.', 'va-removing-exif' ) ),
			esc_html( __( 'Since Exif is stored in the database, it can be acquired with the wp_get_attachment_metadata function.', 'va-removing-exif' ) ),
			esc_html( __( 'This is useful if you are run a Photolog.', 'va-removing-exif' ) )
		);
	}

	/**
	 * Sanitize.
	 *
	 * @param array $options Option.
	 *
	 * @return array
	 */
	public function sanitize_option( $options ) {
		$options = '1' === $options ? $options : '0';

		return $options;
	}
}
