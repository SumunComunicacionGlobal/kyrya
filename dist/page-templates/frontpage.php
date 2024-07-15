<?php
/**
 * Template Name: Página de inicio
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

get_header();
$container = get_theme_mod( 'understrap_container_type' );

$video = get_field( 'video_portada' );
$mapa = get_field( 'mapa' );
$contenido_secundario = get_field('contenido_secundario');

if (!$video) $video = '<img src="'.get_stylesheet_directory_uri().'/img/foto-mano-agua.jpg" />';
if (!$mapa) $mapa = '<img src="'.get_stylesheet_directory_uri().'/img/mapa-kyrya.jpg" class="imagen-mapa" />';
?>

<div class="wrapper" id="full-width-page-wrapper">
	
	<?php get_template_part( 'loop-templates/slider', 'home' ); ?>

	<?php if( INSPIRACION_ID ) : ?>

	<section class="bg-dark py-5">
		<div class="<?php echo esc_attr( $container ); ?> text-center">
			<a class="aparecer btn btn-outline-light btn-lg" href="<?php esc_url( the_permalink( INSPIRACION_ID ) ); ?>" title="<?php echo get_the_title( INSPIRACION_ID ); ?>"><?php echo get_the_title( INSPIRACION_ID ); ?></a>
		</div>
	</section>

	<?php endif; ?>

	<?php get_template_part( 'global-templates/hero' ); ?>

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row no-gutters">

			<div class="col-md-6 content-area pt-5 pb-3 pr-3 align-self-center" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php the_content(); ?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

			<div class="col-md-6" id="home-destacado-1">
				<?php // echo $video; ?>
				<div class="row no-gutters bloques">
					<?php if ( is_active_sidebar( 'home-destacado-1' ) ) :
						dynamic_sidebar( 'home-destacado-1' );
					endif; ?>
				</div>
			</div>

		</div><!-- .row end -->
	</div>

	<section id="contenido-secundario" class="bg-white">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="row no-gutters" id="home-destacado-2">
				<div class="col-md-6">
					<div class="row no-gutters bloques">
						<?php dynamic_sidebar( 'home-destacado-2' ); ?>
					</div>
				</div>
				<div class="col-md-6 content-area pt-5 pb-3 pl-5 align-self-center">
					<?php echo $contenido_secundario; ?>
					<?php //get_search_form(); ?>
				</div>
			</div>
		</div>
	</section>

	<?php if ( is_active_sidebar( 'home-destacado-3' ) ) : ?>
		<section class="bg-light">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="row no-gutters pt-4">
					<div class="col-md-12">
						<h3 class="titulo-destacado-home text-right mt-4 mb-4"><?php _e( 'Personalización', 'kyrya' ); ?></h3>
					</div>
				</div>
			</div>
		</section>
		<section class="bg-light pb-5">
			<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row no-gutters bloques" id="home-destacado-3">
						<?php dynamic_sidebar( 'home-destacado-3' ); ?>
					</div>
			</div><!-- Container end -->
		</section>
	<?php endif; ?>

	<section class="" id="home-destacado-4">
	<!-- <section class="border-bottom border-dark"> -->
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="row no-gutters">
				<div class="col-md-6 pt-5 pr-5">
					<?php if ( is_active_sidebar( 'home-destacado-4-izq' ) ) :
						dynamic_sidebar( 'home-destacado-4-izq' );
					endif; ?>
				</div>
				<div class="col-md-6">
					<div class="row no-gutters bloques">
								<?php if ( is_active_sidebar( 'home-destacado-4-dcha' ) ) :
									dynamic_sidebar( 'home-destacado-4-dcha' );
								endif; ?>
					</div>
					<?php //echo $video; ?>
				</div>
			</div>
		</div><!-- Container end -->
	</section>

	<?php $noticias = noticias_home();
	if ('' != $noticias) { ?>
		<section class="bg-light pt-5 pb-5" id="home-noticias">
			<div class="container">
				<?php echo $noticias; ?>
			</div>
		</section>
	<?php } ?>



	<div id="map" class="row section-mapa no-gutters">
		<div class="col-md-8 mapa-home d-flex flex-column justify-content-center">
			<?php echo $mapa; ?>
			<div class="logo-mapa">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-kyrya-group.png" alt="<?php bloginfo( 'name' ); ?>" />
			</div>
		</div>
		<div class="col-md-4 contacto-home p-5 d-flex flex-column justify-content-end">
			<?php if ( is_active_sidebar( 'home-contacto' ) ) : ?>
					<?php dynamic_sidebar( 'home-contacto' ); ?>
			<?php endif; ?>
		</div>
	</div>

</div><!-- Wrapper end -->

<?php get_footer(); ?>
