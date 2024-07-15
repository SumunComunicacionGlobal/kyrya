<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();
?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
$q_obj_trans = get_queried_object();
$q_obj = kyrya_default_language_term($q_obj_trans);
$pt = get_post_type();

$meta = get_fields($q_obj);

$logo = $meta['logo'];
$miniatura = $meta['miniatura'];
$esquema = $meta['esquema'];
$opciones_productos = isset($meta['opciones_de_producto']) ? $meta['opciones_de_producto'] : false;
$acabados = isset($meta['acabados']) ? $meta['acabados'] : false;

$columnas = array('titulo');
if ($miniatura) $columnas[] = $miniatura;
// if ($opciones_productos) $columnas[] = $opciones_productos;
if ($esquema) $columnas[] = $esquema;

switch ( count($columnas) ) {
	case 1:
		$col1_class = 'col-12';
		break;
	case 2:
		// if ( $opciones_productos ) {
		// 	$col1_class = 'col-sm-8';
		// 	$col2_class = 'col-sm-4';
		// } else {
			$col1_class = 'col-sm-4';
			$col2_class = 'col-sm-8';
			$col3_class = 'col-sm-8';
		// }
		break;
	case 3:
		$col1_class = 'col-sm-4';
		$col2_class = 'col-sm-4';
		$col3_class = 'col-sm-4';
		break;
	case 4:
		$col1_class = 'col-sm-3';
		$col2_class = 'col-sm-3';
		$col3_class = 'col-sm-3';
		$col4_class = 'col-sm-4';
		break;
	default: 
		$col1_class = 'col-12';
		$col2_class = 'col-sm-3';
		$col3_class = 'col-sm-3';
		$col4_class = 'col-sm-4';
		break;
}
$mostrar_productos = true;

?>

<?php if ( es_composicion($pt) )  echo slider_destacados( $pt, $q_obj ); ?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

					<div class="row mt-3 mb-3 cabecera-term">
						<div class="<?php echo $col1_class; ?> col1">
							<header class="page-header">
								<?php
								if ($logo) {
									echo wp_get_attachment_image( $logo['id'], 'medium' );
								} else {
									echo '<div class="d-flex align-items-center">';
										echo '<h1 class="page-title mb-0 mr-3 '. $q_obj->taxonomy .'">' . single_term_title('', false) . '</h1>';
										smn_back_button();
									echo '</div>';
								}

								opciones_de_producto($opciones_productos);

								$description = get_the_archive_description();
								if ('' != $description) {

									$no_collapse = get_field( 'no_description_collapse', $q_obj_trans );
									if ( $no_collapse ) {
										echo do_shortcode ( '<div class="taxonomy-description">' . $description . '</div>' );
									} else {
										echo '<div class="collapse" id="collapse-description">';
										echo do_shortcode ( '<div class="taxonomy-description">' . $description . '</div>' );
										echo '</div>';

										echo '<p><a class="description-more-info" data-toggle="collapse" href="#collapse-description" role="button" aria-expanded="false" aria-controls="collapse-description"><i class="fa fa-info-circle"></i> '.__( 'Más información', 'kyrya' ).' <i class="fa fa-chevron-down girar"></i></a><p>';
									}

								}
								?>
							</header><!-- .page-header -->
						</div>
						<?php if ($miniatura || $acabados) { ?>
							<div class="<?php echo $col2_class; ?> col2">
								<div class="imagen-term miniatura">
									<?php echo wp_get_attachment_image( $miniatura['id'], 'medium_large' ); ?>
								</div>
							</div>
						<?php }
						if ($esquema) { ?>
							<div class="<?php echo $col3_class; ?> col3">
								<div class="imagen-term esquema">
									<?php echo wp_get_attachment_image( $esquema['id'], 'medium_large' ); ?>
								</div>
							</div>
						<?php } ?>
					</div>

					<?php 
						$args_subterms = array(
								'taxonomy'		=> $q_obj->taxonomy,
								'parent'		=> $q_obj_trans->term_id,
								'hide_empty'	=> false,
							);
						$subterms = get_terms( $args_subterms);
						if ('composicion' == $pt && !empty($subterms) ) $mostrar_productos = false;

					?>

					<?php if (!empty($subterms)) { 
						// echo '<h4><a class="btn btn-secondary" href="#subcategorias">' . __( 'Ver subcategorías', 'kyrya' ) . '</a></h4>'; 
						echo '<span class="btn btn-primary btn-sm h4 mb-1 mr-1">' . $q_obj_trans->name . '</span>';
						foreach ($subterms as $subterm) {
							echo '<a class="btn btn-outline-secondary btn-sm h4 mb-1 mr-1" href="'.get_term_link( $subterm ).'">' . $subterm->name . '</a>';
						}
					} else {
						$args_sibling_terms = array(
							'taxonomy'		=> $q_obj->taxonomy,
							'parent'		=> $q_obj->parent,
							'hide_empty'	=> false,
						);

						$sibling_terms = get_terms( $args_sibling_terms);
						if (!empty($sibling_terms)) {

							foreach ($sibling_terms as $subterm) {
								if ( $subterm->term_id == $q_obj->term_id ) {
									echo '<span class="btn btn-secondary btn-sm h4 mb-1 mr-1">' . $subterm->name . '</span>';
								} else {
									echo '<a class="btn btn-outline-secondary btn-sm h4 mb-1 mr-1" href="'.get_term_link( $subterm ).'">' . $subterm->name . '</a>';
								}
							}

						}

					}
					?>

					<?php if ( have_posts() && $mostrar_productos ) : ?>
					<?php // if (!empty($subterms)) echo '<h2>' . __( 'Productos', 'kyrya' ) . '</h2>'; ?>
					<div class="row no-gutters mb-5 pb-5 bloques" id="productos">
						<?php while ( have_posts() ) : the_post(); ?>

							<?php

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							if ('post' == get_post_type()) {
								get_template_part( 'loop-templates/content', 'single-loop' );
							} else {
								get_template_part( 'loop-templates/content', get_post_format() );
							}
							// include( locate_template ( 'loop-templates/content.php' ) );
							?>

						<?php endwhile; ?>
					</div>

				<?php else : ?>

					<?php // if( empty($subterms)) get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

				<?php composiciones_ejemplo(); ?>

					<?php 
						// $args_subterms = array(
						// 		'taxonomy'		=> $q_obj->taxonomy,
						// 		'parent'		=> $q_obj->term_id,
						// 		'hide_empty'	=> false,
						// 	);
						// $subterms = get_terms( $args_subterms);
						if (!empty($subterms)) {
							// array_unshift( $subterms, $q_obj);
							if (have_posts()) {
								// echo '<h4><a class="btn btn-secondary" href="#productos">' . __( 'Ver productos', 'kyrya' ) . '</a></h4>';
								echo '<h2 class="mt-5 pt-5">' . $q_obj_trans->name . ': ' . __( 'Subcategorías', 'kyrya' ) . '</h2>';
							}
							// $mostrar_productos = false;
							echo '<div class="row no-gutters mb-3 bloques" id="subcategorias">';
							foreach ($subterms as $term) {
								include( locate_template ( 'loop-templates/content-subterm.php' ) );
							}
							echo '</div>';
						}
						

					?>

				<?php smn_back_button(); ?>

				<?php echo '<div class="text-center">' . kyrya_botones_acabados() . '</div>'; ?>
				<?php echo get_tax_navigation( $q_obj->taxonomy ); ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div> <!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
