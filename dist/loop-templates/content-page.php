<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

$subtitulo = get_post_meta( $post->ID, 'subtitulo', true );
?>
<article <?php post_class('row'); ?> id="post-<?php the_ID(); ?>">

	<?php if ( has_post_thumbnail() ) { ?>

		<div class="col-md-4">

			<?php echo '<a data-rel="lightbox" href="'.get_the_post_thumbnail_url( get_the_ID(), 'large' ).'" title="'.get_the_title().'">' . get_the_post_thumbnail( $post->ID, 'medium_large', array('class' => 'mb-4 aparecer d-none d-md-block') ) . '</a>'; ?>
			<?php if ($subtitulo) {
				echo '<div class="subtitulo-pagina">'.$subtitulo.'</div>';
			}
			?>

		</div>

	<?php } ?>

	<div class="col">
		<header class="entry-header">

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
	</div>

</article><!-- #post-## -->
