<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
$is_landing = false;
if (is_page_template( 'page-templates/landing.php' )) {
	$is_landing = true;
}

if (!$is_landing) {
	?>

	<?php get_sidebar( 'footerfull' ); ?>

	<div class="wrapper bg-dark text-light mt-5" id="wrapper-footer">

		<div class="<?php echo esc_attr( $container ); ?>">

			<div class="row">
				
				<div class="col-md-12">

					<footer class="site-footer" id="colophon">

						<div class="site-info row">
							<div class="col-md-3 text-left">
								<strong><?php _e( 'Kyrya', 'kyrya' ); ?></strong> ® Copyright <?php echo date("Y"); ?>
							</div>
							<div class="col-md-6 text-center">
								<?php wp_nav_menu( array(
									'theme_location'  => 'legal',
									'menu'            => '',
									'container'       => 'nav',
									'container_class' => 'navbar navbar-expand-lg',
									'container_id'    => '',
									'menu_class'      => 'menu',
									'menu_id'         => '',
									'before'          => '',
									'after'           => '',
									'link_before'     => '',
									'link_after'      => '',
									'items_wrap'      => '<ul id = "%1$s" class = "navbar-nav %2$s">%3$s</ul>',
									'depth'           => 0,
									'walker'          => '',
								) );
								?>
							</div>
							<div class="col-md-3 text-right">
								<?php echo redes_sociales_shortcode(); ?>
							</div>
						</div><!-- .site-info -->

					</footer><!-- #colophon -->

				</div><!--col end -->

			</div><!-- row end -->

			<?php kyrya_language_selector(); ?>

		</div><!-- container end -->

	</div><!-- wrapper end -->

	</div><!-- #page we need this extra closing tag here -->

	<?php if(!is_page( CONTACTO_ID )) { ?>
		<a class="btn btn-primary btn-contacto" href="<?php echo get_the_permalink( CONTACTO_ID ); ?>"><i class="fa fa-envelope mr-2"></i> <?php echo get_the_title( CONTACTO_ID ); ?></a>
	<?php } ?>

	<!-- Modal Ajax Post -->
	<div class="modal fade" id="modal-ajax-post">
	  <div class="modal-dialog modal-lg modal-dialog-centered">
	    <div class="modal-content">

	      <div class="modal-header">
	        <h4 class="modal-title"><img src="<?php echo get_stylesheet_directory_uri() . '/img/favicon-kyrya.png' ?>" alt="Icono Kyrya" /></h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <div class="modal-body">
	        
	      </div>

	      <div class="modal-footer">
	        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
	      </div>

	    </div>
	  </div>
	</div>

	<!-- Modal Ajax Post -->
	<div class="modal fade" id="modal-ajax-login">
	  <div class="modal-dialog modal-dialog-centered">
	    <div class="modal-content">

	      <div class="modal-header">
	        <h4 class="modal-title"><img src="<?php echo get_stylesheet_directory_uri() . '/img/favicon-kyrya.png' ?>" alt="Icono Kyrya" /></h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <div class="modal-body">
	        <?php 
	        echo do_shortcode( '[wpmem_form login]' ); 
	        if (is_user_logged_in()) {
	        	echo sprintf( __( 'Puede %smodificar sus datos personales y de empresa%s, así como %scambiar su contraseña%s en %s"mi perfil"%s', 'kyrya' ), '<a href="'.get_permalink( MI_PERFIL ).'?a=edit">', '</a>', '<a href="'.get_permalink( MI_PERFIL ).'/?a=pwdchange">', '</a>', '<a href="'.get_permalink( MI_PERFIL ).'">', '</a>' );
	        }


	        ?>
	      </div>

	      <div class="modal-footer">
	        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
	      </div>

	    </div>
	  </div>
	</div>


	<!-- <div class="modal-wrapper" id="modal-ajax-post">
	  <div class="modal">
	    <div class="close-modal">X</div>
	    <div id="modal-body"></div>
	  </div>
	</div> -->

<?php } // endif; ?>

<?php wp_footer(); ?>

</body>

</html>

