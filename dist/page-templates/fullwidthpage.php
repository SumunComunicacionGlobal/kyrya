<?php
/**
 * Template Name: Full Width Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<header class="entry-header">
							<?php the_post_thumbnail( 'full' ); ?>
							<?php the_title( '<div class="h1 entry-title">', '</div>' ); ?>

						</header><!-- .entry-header -->

						<div class="entry-content">

							<?php the_content(); ?>

							<?php
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
								'after'  => '</div>',
							) );

							echo paginas_hijas();
							?>

						</div><!-- .entry-content -->

						<footer class="entry-footer">

							<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

						</footer><!-- .entry-footer -->

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :

							comments_template();

						endif;
						?>

					<?php endwhile; // end of the loop. ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
