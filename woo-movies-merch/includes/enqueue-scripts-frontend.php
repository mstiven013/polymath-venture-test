<?php 

if( !function_exists('woo_add_movie_merch_frontend_styles') ) {

	function woo_add_movie_merch_frontend_styles() {

		$js_data_passed = array(
	        'ajax_url' => admin_url( 'admin-ajax.php' )
	    );

		if( is_product() ) {
		    wp_enqueue_style( 'movie-merch-styles', plugin_dir_url( dirname(__FILE__) ) . '/../templates/assets/css/product-front.css', array(), '1.0.0');

		    wp_enqueue_script( 'movie-merch-product-js', plugin_dir_url( dirname(__FILE__) ) . '/../templates/assets/js/product-front.js', array('jquery'), '1.0.0', true );
    		wp_localize_script( 'movie-merch-product-js', 'php', $js_data_passed);
		}

	}
	add_action( 'wp_enqueue_scripts', 'woo_add_movie_merch_frontend_styles' );

}