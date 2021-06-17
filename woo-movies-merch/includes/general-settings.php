<?php 

// Funcion que agrega el submenu de ajustes del plugin al menu de "WooCoommerce"
if( !function_exists('add_woo_movie_merch_page_submenu') ) {
	function add_woo_movie_merch_page_submenu() {
		add_submenu_page(
			'woocommerce',
			__( 'The Movie DB', MOVIE_MERCH_NS ),
			__( 'The Movie DB', MOVIE_MERCH_NS ),
			'manage_options',
			'woo_movie_merch',
			'woo_movie_merch_render_settings_page'
		);
	}
	add_action( 'admin_menu', 'add_woo_movie_merch_page_submenu' );
}

// Funcion que requiere el archivo donde está el formulario de ajustes
if( !function_exists('woo_movie_merch_render_settings_page') ) {
	function woo_movie_merch_render_settings_page() {
		require __DIR__ . '/../templates/admin/settings.php';
	}
}

if( !function_exists('woo_movie_merch_register_settings') ) {
	function woo_movie_merch_register_settings() {

		// Registrar los ajustes generales del plugin
		register_setting(
			'woo_movie_merch_settings',
			'woo_movie_merch_settings',
			'woo_movie_merch_validate_settings'
		);

		// Crear seccion de ajustes generales
		add_settings_section(
			'woo_movie_merch_general_section',
			'',
			'woo_movie_merch_general_section_text',
			'woo_movie_merch'
		);

		// Agregar el campo para la API Key de TheMovieDB
		add_settings_field(
			'api_key',
			__( 'API Key', MOVIE_MERCH_NS ),
			'woo_movie_merch_render_api_key_field',
			'woo_movie_merch',
			'woo_movie_merch_general_section'
		);

		// Agregar el campo para la API Key de TheMovieDB
		add_settings_field(
			'max_movies_number',
			__( 'Máximo de resultados a mostrar en la página de producto', MOVIE_MERCH_NS ),
			'woo_movie_merch_render_max_movies_number_field',
			'woo_movie_merch',
			'woo_movie_merch_general_section'
		);

	}
	add_action( 'admin_init', 'woo_movie_merch_register_settings' );
}

// Validar los campos de la pagina de ajustes
if( !function_exists('woo_movie_merch_validate_settings') ) {
	function woo_movie_merch_validate_settings( $input ) {
	    $output['api_key'] = sanitize_text_field( $input['api_key'] );
	    $output['is_required_to_buy'] = sanitize_text_field( $input['is_required_to_buy'] );
	    $output['max_movies_number'] = sanitize_text_field( $input['max_movies_number'] );
	    return $output;
	}
}

// Imprimir la descripción general de la página de ajustes
if( !function_exists('woo_movie_merch_general_section_text') ) {
	function woo_movie_merch_general_section_text() {
		_e('Aqui puedes configurar los aspectos generales del plugin', MOVIE_MERCH_NS);
	}
}

// Imprimir el campo para agregar la API Key de The Movie DB
if( !function_exists('woo_movie_merch_render_api_key_field') ) {
	function woo_movie_merch_render_api_key_field() {
		$options = get_option( 'woo_movie_merch_settings' );
		printf(
			'<input type="text" name="%s" placeholder="%s" value="%s" %s />',
			esc_attr( 'woo_movie_merch_settings[api_key]' ),
			__('API Key - The Movie DB', MOVIE_MERCH_NS),
			isset($options['api_key'] ) ? esc_attr( $options['api_key'] ) : '',
			'style="min-width: 400px;"'
		);
	}
}

// Imprimir el campo para agregar el maximo de resultados de pelicular mostrado en el producto
if( !function_exists('woo_movie_merch_render_max_movies_number_field') ) {
	function woo_movie_merch_render_max_movies_number_field() {
		$options = get_option( 'woo_movie_merch_settings' );
		printf(
			'<input type="number" name="%s" placeholder="%s" value="%s" %s />',
			esc_attr( 'woo_movie_merch_settings[max_movies_number]' ),
			__('Máximo de resultado a mostrar en la página de producto', MOVIE_MERCH_NS),
			isset($options['max_movies_number'] ) ? esc_attr( $options['max_movies_number'] ) : '',
			'style="min-width: 400px;"'
		);
	}
}


// Imprimir el campo para preguntar si es obligatorio elegir una pelicula para continuar con la compra
if( !function_exists('woo_movie_merch_render_is_required_to_buy_field') ) {
	function woo_movie_merch_render_is_required_to_buy_field() {
		$options = get_option( 'woo_movie_merch_settings' );
		printf(
			'<input type="radio" name="%s" value="si" %s /> Sí',
			esc_attr( 'woo_movie_merch_settings[is_required_to_buy]' ),
			( isset( $options['is_required_to_buy'] ) && $options['is_required_to_buy'] == 'si' ) ? 'checked="checked"' : '',
		);

		echo '<br/>';

		printf(
			'<input type="radio" name="%s" value="no" %s /> No',
			esc_attr( 'woo_movie_merch_settings[is_required_to_buy]' ),
			( isset( $options['is_required_to_buy'] ) && $options['is_required_to_buy'] == 'no' ) ? 'checked="checked"' : '',
		);
	}
}
