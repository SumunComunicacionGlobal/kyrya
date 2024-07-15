<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();
$pt = get_post_type();
$pto = get_post_type_object( $pt );
// echo '<pre>'; print_r($pto); echo '</pre>';

$mostrar_productos = true;
?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php foreach ($pto->taxonomies as $tax) {
					$terms_args = array(
							'hide_empty'			=> 0,
							'taxonomy'				=> $tax,
							'parent'				=> 0,
						);
					$terms = get_terms($terms_args);
					if (!empty($terms)) {
						$mostrar_productos = false;

						$col_class = 'col-md-3';
						switch (count($terms)) {
							case 1:
								$col_class = 'col-md-12';
								break;
							case 2:
								$col_class = 'col-md-6';
								break;
							case 3:
							case 6:
							case 9:
								$col_class = 'col-md-4';
								break;

							default:
								$col_class = 'col-md-3';
								break;
						}
						$col_class .= ' col-sm-12';



						echo '<div class="row no-gutters mt-3 mb-10 bloques">';

							foreach ($terms as $term) {
								include( locate_template ( 'loop-templates/content-term.php' ) );
							}
						echo '</div>';
					}


				} ?>

				<?php if ($mostrar_productos) :
					if ( have_posts() ) : ?>


						<div class="row">
							<?php /* Start the Loop */ ?>
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
								?>

							<?php endwhile; ?>
						</div>

					<?php else : ?>

						<?php get_template_part( 'loop-templates/content', 'none' ); ?>

					<?php endif; ?>
				<?php endif; ?>

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
