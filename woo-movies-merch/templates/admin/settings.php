<h2><?php _e( 'Ajustes de integración - The Movie DB', MOVIE_MERCH_NS ); ?></h2>
<form action="options.php" method="post">
	<?php settings_fields( 'woo_movie_merch_settings' ); ?>
	<?php do_settings_sections( 'woo_movie_merch' ); ?>

	<input type="submit" name="submit" class="button button-primary" value="<?php _e('Guardar', MOVIE_MERCH_NS); ?>"/>
</form>