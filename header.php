<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

$container = get_theme_mod( 'understrap_container_type' );
$logo = 'logo-kyrya.png';
if( is_singular()) {
	$restricted = get_post_meta( get_the_ID(), '_wpmem_block', true );
	if( $restricted == 1 ) {
		$logo = 'logo-kyrya-pro.png';
	}
}
$navbar_class = 'navbar-light';
$menu_transparente = '';
$is_landing = false;
if (is_page_template( 'page-templates/frontpage.php' )) {
	$menu_transparente = ' transparente';
	$logo = 'logo-kyrya-blanco.png';
	$navbar_class = 'navbar-dark';
}
if (is_page_template( 'page-templates/landing.php' )) {
	$is_landing = true;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="hfeed site" id="page">
	<div id="top-bar" class="container-fluid bg-dark">
		<?php kyrya_language_selector(); ?>
	</div>
	<?php if (!$is_landing) { ?>
		<!-- ******************* The Navbar Area ******************* -->
		<div class="wrapper-fluid wrapper-navbar<?php echo $menu_transparente; ?>" id="wrapper-navbar">

			<a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content',
			'understrap' ); ?></a>

			<nav class="navbar <?php echo $navbar_class; ?>">

			<?php if ( 'container' == $container ) : ?>
				<div class="container-fluid">
			<?php endif; ?>
						<div>
						<!-- Your site title as branding in the menu -->
						<?php if ( ! has_custom_logo() ) { ?>
													
							<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/<?php echo $logo; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
						
						<?php } else {
							the_custom_logo();
						} ?><!-- end custom logo -->
						<?php if (is_front_page()) echo boton_login(); ?>
						</div>
					<?php mostrar_tagline(); ?>
		
					<button class="navbar-toggler" id="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

				<?php if ( 'container' == $container ) : ?>
				</div><!-- .container -->
				<?php endif; ?>

			</nav><!-- .site-navigation -->
			<div class="menu-kyrya bg-dark text-light">
				<div class="container">
					<!-- The WordPress Menu goes here -->
					<?php wp_nav_menu(
						array(
							'theme_location'  => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id'    => 'navbarNavDropdown',
							'menu_class'      => 'navbar-nav',
							'fallback_cb'     => '',
							'menu_id'         => 'main-menu',
							'walker'          => new understrap_WP_Bootstrap_Navwalker(),
						)
					); ?>
				</div>
			</div>
		</div><!-- .wrapper-navbar end -->
	<?php } ?>

<?php if( !is_front_page() && !$is_landing ) {
	echo '<div class="container-fluid mt-2"><div class="row flex-row-reverse">';
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<div class="col-8"><div class="breadcrumb">','</div></div>');
		}		
		// echo '<div class="col-4 estado-usuario">';
		// 		echo boton_login();
		// echo '</div>';
	echo '</div></div>';
} 

?>
