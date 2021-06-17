<h3 class="woo-movies-header"><?php _e( 'Selecciona una película (Obligatorio)', MOVIE_MERCH_NS ); ?></h3>
<div class="woo-movies-loop">

    <?php foreach( $movies as $movie ) : ?>

        <?php 
            if ( isset($movie->poster_path) && !empty($movie->poster_path) ):
                $image_url = $images_base_dir . $movie->poster_path;
            else :
                $image_url = $placeholder_image;
            endif;
        ?>

        <div class="item">

            <input type="radio" name="related_movie" class="related_movie woo-movies-radio" value="<?php echo $movie->title; ?>" id="woo-movie-<?php echo $movie->id; ?>">

            <label for="woo-movie-<?php echo $movie->id; ?>" class="woo-movies-label">

                <span class="woo-movies-poster">

                    <?php if ( $image_url !== $placeholder_image ): ?>
                        <img src="<?php echo $placeholder_image; ?>" class="woo-movies-poster-placeholder">
                    <?php endif; ?>

                    <img 
                        src="<?php echo $image_url; ?>" 
                        title="<?php echo $movie->title ?>"
                        alt="<?php echo $movie->title ?>" 
                        class="woo-movies-poster-image"
                    >
                </span>

                <span class="woo-movies-title"><?php echo $movie->title; ?></span>
            </label>

        </div>

    <?php endforeach; ?>

</div>