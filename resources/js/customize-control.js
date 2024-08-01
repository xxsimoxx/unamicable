/**
 * Layouts preview.
 *
 * This file handles the JavaScript for the live preview of the layouts feature
 * in the customizer.
 *
 * @package   Exhale
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright 2019 Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @link      https://themehybrid.com/themes/exhale
 */

(function($) {
    wp.customize('theme_global_layout', function(value) {
        value.bind(function(newval) {
			console.log( newval );
            if (newval === 'full') {
                $('body').removeClass('boxed-width').addClass('full-width');
            } else if (newval === 'boxed') {
                $('body').removeClass('full-width').addClass('boxed-width');
            }
        });
    });
})(jQuery);
