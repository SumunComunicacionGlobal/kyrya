<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class('row'); ?> id="post-<?php the_ID(); ?>">
	<div class="col-sm-8">
		<header class="entry-header">

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<div class="entry-meta">

				<?php the_date(); ?>

			</div><!-- .entry-meta -->

		</header><!-- .entry-header -->


		<div class="entry-content">

			<?php the_content(); ?>

			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
				'after'  => '</div>',
			) );
			?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->
	</div>
	<div class="col-sm-4">
		<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
	</div>

</article><!-- #post-## -->
