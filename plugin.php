<?php namespace Cleanup_Dup_Meta;

/**
 * @package     Cleanup_Dup_Meta
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

/**
 * Plugin Name: Cleanup Duplicate Meta
 * Plugin URI:  http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * Description: Checks for and deletes duplicate Post and/or User Meta entries in the database tables
 * Version:     1.0.1
 * Author:      WP Developers Club and Tonya
 * Author URI:  http://wpdevelopersclub.com
 */

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

//* Oh no you don't. Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheating&#8217; uh?' );
}

require_once( __DIR__ . '/assets/vendor/autoload.php' );

use Cleanup_Dup_Meta\Models\Model;

define( 'CLEANUP_DUP_META_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CLEANUP_DUP_META_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//* Time to launch Core
if ( version_compare( $GLOBALS['wp_version'], Plugin::MIN_WP_VERSION, '>' ) ) {

	add_action( 'init', __NAMESPACE__ . '\\launch' );
	/**
	 * Launch the plugin, if the user is an admin
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function launch() {

		new Plugin(
			include( CLEANUP_DUP_META_PLUGIN_DIR . 'lib/config/plugin.php' ),
			new Model( include( CLEANUP_DUP_META_PLUGIN_DIR . 'lib/config/postmeta.php' ) ),
			new Model( include( CLEANUP_DUP_META_PLUGIN_DIR . 'lib/config/usermeta.php' ) )
		);
	}
}