<?php 

if( !function_exists('woo_movie_merch_fields') ) {
    function woo_movie_merch_fields() {

        global $post;

        $tmdb = new TheMovieDB();
        $genres = $tmdb->get_all_genres();
        if( $genres['status'] > 200 ) {
            echo $genres['status_message'];
            return false;
        }

        $options[''] = __( 'Selecciona un genero', MOVIE_MERCH_NS);
        foreach ( $genres['body']->genres as $genre ) {
            $options["$genre->id"] = $genre->name;
        }

        // Get the selected value  <== <== (updated)
        $value = get_post_meta( $post->ID, 'woo_movie_genre', true );
        if( empty( $value ) ) $value = '';

        $select_args = array(
            'id' => 'woo_movie_genre',
            'class' => 'woo_movie_genre',
            'label' => __('Género cinematográfico', MOVIE_MERCH_NS),
            'value' => $value,
            'options' => $options
        );

        echo '<div class="options_group">';
        echo woocommerce_wp_select( $select_args );
        echo '</div>';

    }
    add_action( 'woocommerce_product_options_general_product_data', 'woo_movie_merch_fields' );
}

// Guardar genero cinematografico
if( !function_exists('woo_add_movie_genre_general_fields_save') ) {
    function woo_add_movie_genre_general_fields_save( $post_id ){
        $movie_genre = $_POST['woo_movie_genre'];
        if( !empty( $movie_genre ) ) {
            update_post_meta( $post_id, 'woo_movie_genre', esc_attr( $movie_genre ) );
        } else {
            update_post_meta( $post_id, 'woo_movie_genre',  '' );
        }
    }
    add_action( 'woocommerce_process_product_meta', 'woo_add_movie_genre_general_fields_save' );
}
