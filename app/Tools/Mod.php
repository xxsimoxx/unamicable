<?php
/**
 * Config Class.
 *
 * A simple class for grabbing and returning a configuration file from `/config`.
 *
 * @package   amicable
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2024 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/amicable
 */

namespace Amicable\Tools;

use Closure;
use Backdrop\App;

use function Backdrop\Theme\mod;

/**
 * Theme mod class.
 *
 * @since  1.0.0
 * @access public
 */
class Mod {

	/**
	 * Returns a theme mod value.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $name
	 * @param  mixed   $default
	 * @return mixed
	 */
	public static function get( $name, $default = '' ) {

		$fallback = static::fallback( $name );

		return mod(
			$name,
			! $default && ! is_null( $fallback ) ? $fallback : $default
		);
	}

	/**
	 * Returns a default theme mod.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  string  $name
	 * @return mixed
	 */
	public static function fallback( $name ) {

		$mods = App::resolve( 'amicable/mods' );

		if ( isset( $mods[ $name ] ) ) {

			return $mods[ $name ] instanceof Closure ? $mods[ $name ]->__invoke() : $mods[ $name ];
		}

		return null;
	}
}
