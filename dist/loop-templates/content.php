<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

//$post_meta = get_fields();
$post_meta = get_post_meta(get_the_ID());

$thumb_obj = postmeta_variable($post_meta, 'miniatura');
$medidas = postmeta_variable($post_meta, 'medidas');
$diametro = postmeta_variable($post_meta, 'diametro');
$texto_destacado = postmeta_variable($post_meta, 'texto_destacado');
$bgx = postmeta_variable($post_meta, 'background_position_x');

if ($thumb_obj && is_numeric($thumb_obj)) $thumb_obj = wp_get_attachment_metadata( $thumb_obj );

$pt = get_post_type();
$aparecer = ' aparecer';
$modal_link = 'modal-link';
$clase_icono = '';

if ( 'page' == $pt || 'post' == $pt || 'dlm_download' == $pt ) {
	$modal_link = '';
}


// $thumb_obj = get_field('miniatura');
// $medidas = get_field('medidas');
$bg_size = 'bg-cover';

$term = get_queried_object();
$default_lang_term = kyrya_default_language_term($term);

$contain = get_field('fondo_contain', $default_lang_term);

if ( 1 == $contain ) {
	$bg_size = 'bg-contain';
}

if (!$bgx) {
	if (es_composicion($pt)) {
		$bgx = 'right';
	} elseif ('producto' == $pt ) {
		$bgx = get_field('background_position_x', $default_lang_term);
		if (!$bgx) $bgx = 'center';
	} else {
		$bgx = 'center';
	}
}

if ($thumb_obj) {
	$thumb_url = $thumb_obj['sizes']['large'];
} elseif (!$thumb_obj && has_post_thumbnail()) {
	$thumb_url = get_the_post_thumbnail_url( $post->ID, 'large' );
} else {
	$thumb_url = kyrya_placeholder_url();
}

if (es_composicion($pt)) {
	$titulo = get_the_title();
	$descripcion = get_the_excerpt();
} elseif ($pt == 'acabado' ) {
	// $titulo_temp = $titulo;
	// $titulo = $descripcion;
	$titulo = get_the_title();
	$descripcion = ''; 
} elseif ('' != get_post_field( 'post_excerpt', get_the_ID() ) ) {
	$titulo = get_post_field( 'post_excerpt', get_the_ID() );
	$titulo = do_shortcode( $titulo );
	$descripcion = get_the_title();
} else {
	$titulo = get_the_title();
	$descripcion = '';
}


$clase_titulo = '';
if (strlen($titulo) > 3) $clase_titulo .= ' titulo-peq';
if ($pt == 'dlm_download') {
	$clase_titulo .= ' icono descarga-blanco';
}
$lang_code = '';
if (is_search()) {
	$lang_details = apply_filters( 'wpml_post_language_details', NULL, get_the_ID() );
	$lang_code = $lang_details['language_code'];
}
?>

<article <?php post_class('box col-md-3 col-sm-6' . $aparecer . ' show-lang-' . $lang_code ); ?> id="post-<?php the_ID(); ?>">
		<a class="no-underline <?php echo $modal_link; ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<!-- <a data-toggle="modal" data-target="#modal-ajax-post" class="no-underline modal-link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> -->
		<!-- <a data-toggle="modal" data-target="#modal-ajax-post" class="no-underline" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> -->
		<!-- <a class="no-underline" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> -->
			<div class="hover-zoom">
				<div class="miniatura <?php echo $bg_size; ?>" style="background-image:url('<?php echo $thumb_url; ?>'); background-position: center <?php echo $bgx;?>;">
					<!-- <div class="overlay"></div> -->
				</div>

				<?php if ($texto_destacado) {
					echo '<span class="texto-destacado">' . $texto_destacado . '</span>';
				} ?>

				<?php opciones_de_producto( postmeta_variable($post_meta, 'opciones_de_producto') ); ?>

			</div>
			<div class="entry-content">

				<header class="entry-header">

					<?php echo '<h2 class="entry-title'.$clase_titulo.'">' . $titulo . '</h2>'; ?>

					<?php if ( 'post' == $pt && !is_search() ) : ?>

						<div class="entry-meta">
							<?php understrap_posted_on(); ?>
						</div><!-- .entry-meta -->

					<?php endif; ?>

				</header><!-- .entry-header -->

				<?php if ($medidas) echo '<span class="medidas h6 icono ruler-blanco mr-3">'.$medidas.'</span>'; ?>
				<?php if ($diametro) echo '<span class="medidas h6">Ø '.$diametro.'</span>'; ?>
				<div class="excerpt"><?php 
					// if ( es_composicion($pt) ) {
					// 	the_excerpt();
					// } else {
					// 	if ('acabado' != $pt) echo get_post_field( 'post_excerpt', get_the_ID() );
					// }
					echo $descripcion;
				?></div>

				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
					'after'  => '</div>',
				) );
				?>

			</div><!-- .entry-content -->
		</a>

	<!--<footer class="entry-footer">-->

		<?php // understrap_entry_footer(); ?>

	<!--</footer> .entry-footer -->

	<?php edit_post_link(); ?>
	
</article><!-- #post-## -->
