<?php 


if( !function_exists('woo_display_movie_genre_field') ) {
    function woo_display_movie_genre_field() {

        global $post;

        // Checkear el campo personalizado del genero cinematografico
        $product = wc_get_product( $post->ID );
        $genre = $product->get_meta( 'woo_movie_genre' );

        // Mostrar el template solo si el producto tiene un genero seleccionado desde el panel de administracion
        if( $genre ) {
            $tmdb = new TheMovieDB();
            $movies = $tmdb->get_genre_movie( $genre );
            $movies = $movies['movies'];
            $images_base_dir = 'https://image.tmdb.org/t/p/w200/';
            $placeholder_image = plugin_dir_url( dirname(__FILE__) ) . '/../templates/assets/img/placeholder.jpg';

            if( count($movies) > 0 ) :
                require __DIR__ . '/../templates/front/product-movies.php';
            endif;

        }

    }
    add_action( 'woocommerce_before_add_to_cart_quantity', 'woo_display_movie_genre_field' );
}

// Validacion en caso de que el producto tenga un genero cinematografico relacionado y no tenga seleccionada una pelicula
if( !function_exists('woo_return_error_when_not_has_related_movie') ) {
    function woo_return_error_when_not_has_related_movie( $passed, $product_id, $quantity ) {

        // Checkear el campo personalizado del genero cinematografico
        $product = wc_get_product( $product_id );
        $genre = $product->get_meta( 'woo_movie_genre' );

        // Si tiene genero relacionado y no ha seleccionado ninguna pelicula devolver error
        if( $genre ) {
            if( !isset($_POST['related_movie']) || empty($_POST['related_movie']) ) {
                $passed = false;
                wc_add_notice( __( 'Debes seleccionar una película relacionada', MOVIE_MERCH_NS ), 'error' );
            }
        }

        return $passed;
    }
    add_filter( 'woocommerce_add_to_cart_validation', 'woo_return_error_when_not_has_related_movie', 10, 3 );
}

// Agregar custom data al item en el carrito
if( !function_exists('woo_add_custom_field_related_movie_to_cart_item') ) {
    function woo_add_custom_field_related_movie_to_cart_item( $cart_item_data, $product_id, $variation_id, $quantity ) {

        // Checkear el campo personalizado del genero cinematografico
        $product = wc_get_product( $product_id );
        $genre = $product->get_meta( 'woo_movie_genre' );

        // Si el producto tiene genero relacionado y la pelicula relacionada no esta vacia agregar a la data del carrito
        if( $genre && !empty( $_POST['related_movie'] ) ) {
            $cart_item_data['related_movie'] = $_POST['related_movie'];
        }

        return $cart_item_data;
    }
    add_filter( 'woocommerce_add_cart_item_data', 'woo_add_custom_field_related_movie_to_cart_item', 10, 4 );
}

// Mostrar la informacion del producto relacionado en el carrito y el checkout
if( !function_exists('woo_show_related_movie_in_product_cart_item') ) {
    function woo_show_related_movie_in_product_cart_item( $name, $cart_item, $cart_item_key ) {
        if( isset( $cart_item['related_movie'] ) ) {
            $name .= sprintf( '<dl class="variation"><dt>%s:</dt> <dd>%s</dd></dl>',
                            __( 'Película seleccionada', MOVIE_MERCH_NS ), 
                            esc_html( $cart_item['related_movie'] ) 
                    );
        }
        return $name;
    }
    add_filter( 'woocommerce_cart_item_name', 'woo_show_related_movie_in_product_cart_item', 10, 3 );
}

// Agregar el custom field a los pedidos
if( !function_exists('woo_add_related_movie_to_order') ) {
    function woo_add_related_movie_to_order( $item, $cart_item_key, $values, $order ) {
        foreach( $item as $cart_item_key=>$values ) {
            if( isset( $values['related_movie'] ) ) {
                $item->add_meta_data( __( 'Película seleccionada', MOVIE_MERCH_NS ), $values['related_movie'], true );
            }
        }
    }
    add_action( 'woocommerce_checkout_create_order_line_item', 'woo_add_related_movie_to_order', 10, 4 );
}