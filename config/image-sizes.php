<?php
/**
 * Image Sizes Config.
 *
 * Defines the image sizes that the theme sets.
 *
 * @package   Amicable
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2024 Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://luthemes.com/portfolio/amicable
 */

 return [

	// Landscape sizes.
	'post-thumbnail' => [
		'label'            => __( 'Landscape: Thumbnail', 'amicable' ),
		'width'            => 178,
		'height'           => 100,
		'is_featured_size' => false
	],
	'amicable-landscape-medium' => [
		'label'  => __( 'Landscape: Medium', 'amicable' ),
		'width'  => 640,
		'height' => 360
	],
	'amicable-landscape-large' => [
		'label'  => __( 'Landscape: Large', 'amicable' ),
		'width'  => 896,
		'height' => 504
	],
	'amicable-landscape-extra-large' => [
		'label'  => __( 'Landscape: Extra Large', 'amicable' ),
		'width'  => 1366,
		'height' => 768
	],
];
