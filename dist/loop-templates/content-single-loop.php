<?php
/**
 * Loop Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class('row mb-5 pb-4'); ?> id="post-<?php the_ID(); ?>">
	<div class="col-sm-2">
		<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
	</div>
	<div class="col-sm-10">
		<header class="entry-header">

			<a href="<?php the_permalink(); ?>"><?php the_title( '<h2 class="entry-title">', '</h2>' ); ?></a>

			<div class="entry-meta">

				<?php the_date(); ?>

			</div><!-- .entry-meta -->

		</header><!-- .entry-header -->


		<div class="entry-content">

			<?php the_excerpt(); ?>

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

</article><!-- #post-## -->
