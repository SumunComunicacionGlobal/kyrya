<?php
/**
 * Static hero sidebar setup.
 *
 * @package understrap
 */

$container   = get_theme_mod( 'understrap_container_type' );

?>

<?php if ( is_active_sidebar( 'statichero' ) ) : ?>

	<!-- ******************* The Hero Widget Area ******************* -->

	<div class="wrapper bg-dark text-white" id="wrapper-static-hero">

			<div class="<?php echo esc_attr( $container ); ?>" id="wrapper-static-content" tabindex="-1">

				<?php dynamic_sidebar( 'statichero' ); ?>

			</div>

	</div><!-- #wrapper-static-hero -->

<?php endif; ?>
