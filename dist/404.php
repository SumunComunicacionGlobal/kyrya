<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package understrap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );

?>

<div class="wrapper" id="error-404-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main">

					<section class="error-404 not-found">

						<header class="page-header">

							<h1 class="page-title"><i class="fa fa-times"></i> <?php esc_html_e( 'No podemos mostrar esta página',
							'kyrya' ); ?></h1>

						</header><!-- .page-header -->

						<div class="page-content">

							<p><?php esc_html_e( 'Posiblemente encuentre lo que busca en alguno de los enlaces a continuación. También una búsqueda puede ayudar:',
							'kyrya' ); ?></p>

							<?php get_search_form(); ?>


							<?php
							$menu_items = wp_get_nav_menu_items( 735 );
							if (!empty($menu_items)) {
								$item_strings = array();
								foreach ($menu_items as $item) {
									$item_strings[] = '<a class="btn btn-primary mr-1 mb-1" href="'.esc_url( $item->url).'" title="'.$item->title.'">'.$item->title.'</a>';
								}
							
								echo '<div class="my-5">';
									echo implode('', $item_strings);
								echo '</div>';
							}
							?>

							<div class="row">

								<div class="col">

									<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

								</div>

									<?php if ( understrap_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
								
										<div class="col">

											<div class="widget widget_categories">

												<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'understrap' ); ?></h2>

												<ul>
													<?php
													wp_list_categories( array(
														'orderby'    => 'count',
														'order'      => 'DESC',
														'show_count' => 1,
														'title_li'   => '',
														'number'     => 10,
													) );
													?>
												</ul>

											</div><!-- .widget -->

										</div>
									<?php endif; ?>

								<div class="col">

									<?php
									the_widget( 'WP_Widget_Tag_Cloud' );
									?>

								</div><!-- .col -->

							</div><!-- .row -->

						</div><!-- .page-content -->

					</section><!-- .error-404 -->

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
