<?php
/**
 * Backdrop Core ( src/Tools/ServiceProvider.php )
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @license   GNU General PUblic License v2 or later ( https://www.gnu.org/licenses/gpl-2.0.html )
 * @author    Benjamin Lu ( https://getbenonit.com )
 */

/**
 * Define namespace
 */
namespace Amicable\Customize;

use Amicable\Customize\Layout;
use Backdrop\Core\ServiceProvider;
use ReflectionException;

class Provider extends ServiceProvider {

    /**
     * Registration callback that adds a single instance of the customize
     * object to the container.
     *
     * @since  1.0.0
     * @return void
     *
     * @access public
     */
    public function register(): void {

        $this->app->singleton( Component::class, function() {

			return new Component( [
				Layout\Customize::class
			] );
		} );
    }

    /**
     * Boots the customize component by firing its hooks in the `boot()` method.
     *
     * @since  1.0.0
     * @return void
     *
     * @access public
     */
    public function boot(): void {

        $this->app->resolve( Component::class )->boot();
    }
}
