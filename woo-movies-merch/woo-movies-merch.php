<?php
/**
 * Plugin Name: Movies Merch - WooCommerce
 * Plugin URI: https://stivenlopez.com/
 * Description: Plugin para agregar películas relacionadas a los productos del e-Commerce basados en generos obtenidos desde TheMovieDB
 * Version: 1.0.0
 * Author: Stiven Lopez
 * Author URI: https://stivenlopez.com
 * Text Domain: woo-movies-merch
 * Requires at least: 5.4
 * Requires PHP: 7.4
 *
 * @package WooMoviesMerch
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'MOVIE_MERCH_NS' ) ) {
    define( 'MOVIE_MERCH_NS', 'woo-movie-merch' );
}


/**
 * Chequear si woocommerce está activo
 */
if( in_array( 'woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins') ) ) ) {

    // Load core packages and the autoloader.
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/includes/the-movie-db.php';

    // Require include on settings page is defined
    require __DIR__ . '/includes/general-settings.php';

    // Require include for show custom genres tab
    require __DIR__ . '/includes/product-genre-settings.php';

    // Require include to enqueue frontend scripts and styles
    require __DIR__ . '/includes/enqueue-scripts-frontend.php';

    // Require include for show custom genres tab
    require __DIR__ . '/includes/product-front-field.php';

}