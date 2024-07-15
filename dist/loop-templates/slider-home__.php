<?php
$args = array(
		'post_type'				=> 'slide',
		'tax_query'				=> array(
									array(
										'taxonomy'		=> 'cat_slide',
										'field'			=> 'slug',
										'terms'			=> 'home',
										),
			),
		'posts_per_page'		=> -1,
		'orderby'				=> 'menu_order',
		'oreder'				=> 'ASC',
	);

$q = new WP_Query($args);
if ($q->have_posts()) {
	echo '<div class="slider nav-izquierda">';
		echo '<div id="slider-principal" class="carousel slide" data-ride="carousel" data-interval="7000" data-pause="hover">';
			echo '<div class="carousel-inner" role="listbox">';

			while ($q->have_posts()) { $q->the_post();
				$thumb_url = get_the_post_thumbnail_url( null, 'full' );
				echo '<div class="carousel-item bg-secondary';
				echo ($q->current_post == 0) ? ' active' : '';
				echo '">';
					echo '<div class="row no-gutters">';
						echo '<div class="col-md-8 bg-cover home-carousel-img-container';
							echo '" style="background-image:url(\'' . $thumb_url . '\')">';
								echo '<div class="overlay-slider"></div>';
							// echo '</div>';
						echo '</div>';
						echo '<div class="col-md-4 bg-cover';
							echo '" style="background-image:url(\'' . $thumb_url . '\')">';
							echo '<div class="overlay overlay-full"></div>';
							echo '<div class="carousel-caption">
										<div class="h2">' . get_the_title() . '</div>
										<div class="texto-slider">' . get_the_content() . '</div>
									</div>';

						echo '</div>';
					echo '</div>';
				echo '</div>';
			}

			echo '</div>';
			echo '<a class="carousel-control-prev link link--arrowed" href="#slider-principal" data-slide="prev">' . flecha_animada('#fff', 'izquierda') . __( 'Prev', 'kyrya' ) . '</a>';
			echo '<a class="carousel-control-next link link--arrowed" href="#slider-principal" data-slide="next">' . __( 'Next', 'kyrya' ) . flecha_animada('#fff', 'derecha') . '</a>';

		echo '</div>';
	echo '</div>';
} else {
	echo 'nanay';
}