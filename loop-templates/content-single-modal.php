<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

$post_type = $post->post_type;

$tax = false;
if ( 'composicion' == $post_type ) {
	$tax = 'coleccion';
}
$excerpt = ( '' != $post->post_excerpt ) ? do_shortcode($post->post_excerpt) . ' - ' : '';
$titulo = '<h1 class="entry-title">' . $excerpt . get_the_title() . '</h1>';
$descripcion = apply_filters( 'the_content', $post->post_content );
if ($post_type == 'acabado') {
	// $titulo = '<h1 class="entry-title">' . get_post_field( 'post_excerpt', get_the_ID() ) . '</h1>';
    $default_lang = apply_filters('wpml_default_language', NULL );
    $id = apply_filters( 'wpml_object_id', $id, 'acabado', FALSE, $default_lang );
    $titulo = get_the_title( $id );

	$titulo = '<h1 class="entry-title">' . $titulo . '</h1>';
	$descripcion = '';
}

$post_meta = get_post_meta($post->ID, '');

/*
$plano = (isset($post_meta['plano'])) ? $post_meta['plano'] : false;
$medidas = (isset($post_meta['medidas'])) ? $post_meta['medidas'] : false;
$diametro = (isset($post_meta['diametro'])) ? $post_meta['diametro'] : false;
$opciones_productos = (isset($post_meta['opciones_de_producto'])) ? $post_meta['opciones_de_producto'] : false;
$acabados = (isset($post_meta['acabados_aperturas'])) ? $post_meta['acabados_aperturas'] : false;
$descargas_asociadas = (isset($post_meta['descargas'])) ? $post_meta['descargas'] : false;
*/

$plano = postmeta_variable($post_meta, 'plano');
$medidas = postmeta_variable($post_meta, 'medidas');
$diametro = postmeta_variable($post_meta, 'diametro');
$opciones_productos = postmeta_variable($post_meta, 'opciones_de_producto');
$acabados = postmeta_variable($post_meta, 'acabados_aperturas');
$descargas_asociadas = postmeta_variable($post_meta, 'descargas');
$url_simulador = postmeta_variable($post_meta, 'url_simulador');


$images = array();
if (has_post_thumbnail()) $images[] = get_post_thumbnail_id();
if ($post_meta) {
	foreach ( $post_meta as $key => $value ) {
		if ( substr( $key, 0, 7 ) === "imagen_" && isset($value[0]) && '' != $value[0] ) {
			$images[] = $value[0];
		}
	}
}



?>
<div id="modal-ready">


	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<?php

// echo '<pre>'; print_r($post_meta); echo '</pre>';

		// echo '<pre>'; print_r($post_meta); print_r($post); echo '</pre>';


		// to do: navegación dentro de la ventana modal
		// switch ($post_type) {
		// 	case 'composicion':
		// 		$nav_tax = 'coleccion';
		// 		break;
		// 	case 'apertura':
		// 		$nav_tax = 'tipo_apertura';
		// 		break;
		// 	case 'producto':
		// 		$nav_tax = 'categoria_producto';
		// 		break;
			
		// 	default:
		// 		$nav_tax = false;
		// 		break;
		// }

		// if ( $nav_tax ) {

		// 	$next_post = get_previous_post( true, '', $nav_tax );
		// 	$prev_post = get_next_post( true, '', $nav_tax );

		// 	if ( $prev_post != null && $prev_post != '' ) {
		// 		echo '<a class="modal-link" href="'.get_permalink( $prev_post ).'" title="'.get_the_title( $prev_post ).'"><i class="fa fa-chevron-left"></i> </a>';
		// 	}
		// 	if ( $next_post != null && $next_post != '' ) {
		// 		echo '<a class="modal-link" href="'.get_permalink( $next_post ).'" title="'.get_the_title( $next_post ).'"><i class="fa fa-chevron-right"></i></a>';
		// 	}

		// }


		?>

		<div class="logo-modal">
			<?php 
			if ($tax) {
				$terms = get_the_terms( $post, $tax );
				if (!empty($terms)) {
					foreach ($terms as $term ) {
						$logo = get_field('logo', $term);
						echo wp_get_attachment_image( $logo['id'], 'medium' );
					}
				}
			}
			?>
		</div>

		<div id="carrusel-post-<?php echo $post->ID; ?>" class="carousel slide mb-5 carrusel-post row" data-ride="carousel" data-interval="5000">
			<div class="col-md-8">
					<div >
						<div class="carousel-inner" role="listbox">
							<?php
								$i = 0;
								$indicators = '';
								foreach ( $images as $image_id ) {
									$active = '';
									if (0 == $i) $active = 'active';
									echo '<div class="carousel-item '.$active.'">';
										echo wp_get_attachment_image( $image_id, 'large' );
									echo '</div>';

									$indicators .= '<li data-target="#carrusel-post-'.$post->ID.'" data-slide-to="'.$i.'" class="'.$active.'">'.wp_get_attachment_image( $image_id, 'thumbnail' ).'</li>';

									$i++;
								}
							?>
						</div>
						<?php
						  // echo '<a class="carousel-control-prev link link--arrowed" href="#carrusel-post-'.$post->ID.'" data-slide="prev">' . flecha_animada('#fff', 'izquierda') . __( 'Prev', 'kyrya' ) . '</a>';
						  // echo '<a class="carousel-control-next link link--arrowed" href="#carrusel-post-'.$post->ID.'" data-slide="next">' . __( 'Next', 'kyrya' ) . flecha_animada('#fff', 'derecha') . '</a>';
						  $indicators = '<ol class="carousel-indicators">'.$indicators.'</ol>';
						?>
					</div>

					<div class="imagen-plano">
						<?php if( $plano ) echo wp_get_attachment_image( $plano, 'medium_large' ); ?>
					</div>

			</div>
			<div class="col-md-4 carousel-thumbnails">

				<header class="entry-header">

					<?php echo $titulo; ?>

				</header><!-- .entry-header -->

				<div class="entry-content">
					<?php edit_post_link(); ?>
					<?php if (current_user_can( 'edit_posts' )) echo ' / <a href="'.get_the_permalink().'" target="_blank">Ver en nueva pestaña</a>'; ?>
					<p class="dimensiones">
						<?php if ($medidas) echo '<span class="medidas h5 icono ruler mr-3">'.$medidas.'</span>'; ?>
						<?php if ($diametro) echo '<span class="medidas h5">Ø '.$diametro.'</span>'; ?>
					</p>

					<?php if ( $url_simulador ) {
						echo wpautop( '<a class="btn btn-secondary" href="'. $url_simulador .'" target="_blank" rel="noopener noreferrer">'. __( 'Ver simulador', 'kyrya' ) .'</a>' );
					} ?>

					<div class="mb-5"><?php echo $descripcion; ?></div>

					<?php opciones_de_producto($opciones_productos); ?>
					<?php if (count($images) > 1 ) echo $indicators; ?>

					<?php acabados($acabados, get_the_ID()); ?>
					<?php link_contacto(get_queried_object()); ?>
					<?php descargas_asociadas($descargas_asociadas, get_the_ID()); ?>


				</div><!-- .entry-content -->

			</div>
		</div>

	</article><!-- #post-## -->
	<?php /*if ($tax) { ?>
		<div class="post-navigation row mt-4">
			<?php 
			$prev = get_adjacent_post( true, '', true, $tax );
			$next = get_adjacent_post( true, '', false, $tax );
			echo '<div class="col-6 text-left">';
				if ($prev) echo '<a data-toggle="modal" data-target="#modal-ajax-post" class="h6 no-underline modal-link" href="'.get_permalink( $prev ).'" title="'.$prev->post_title.'">< '.$prev->post_title.'</a>';
			echo '</div>';
			echo '<div class="col-6 text-right">';
				if ($next) echo '<a data-toggle="modal" data-target="#modal-ajax-post" class="h6 right no-underline modal-link" href="'.get_permalink( $next ).'" title="'.$next->post_title.'">'.$next->post_title.' ></a>';
			echo '</div>';
			?>
		</div>
	<?php }*/ ?>

</div>
