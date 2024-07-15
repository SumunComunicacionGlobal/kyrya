<?php
/**
 * Theme basic setup.
 *
 * @package understrap
 */


// Set the content width based on the theme's design and stylesheet.
// if ( ! isset( $content_width ) ) {
// 	$content_width = 1000; /* pixels */
// }

if ( ! function_exists( 'understrap_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function understrap_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on understrap, use a find and replace
		 * to change 'understrap' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'understrap', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Menú principal', 'kyrya-admin' ),
			'legal' => __( 'Menú legal en el pie', 'kyrya-admin' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Adding support for Widget edit icons in customizer
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'understrap_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Set up the WordPress Theme logo feature.
		add_theme_support( 'custom-logo' );

		// Check and setup theme default settings.
		understrap_setup_theme_default_settings();

	}
endif; // understrap_setup.
add_action( 'after_setup_theme', 'understrap_setup' );

if ( ! function_exists( 'understrap_custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function understrap_custom_excerpt_more( $more ) {
		return '';
	}
}
add_filter( 'excerpt_more', 'understrap_custom_excerpt_more' );

if ( ! function_exists( 'understrap_all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function understrap_all_excerpts_get_more_link( $post_excerpt ) {

		return $post_excerpt . ' [...]<p><a class="btn btn-secondary understrap-read-more-link" href="' . esc_url( get_permalink( get_the_ID() )) . '">' . __( 'Read More...',
		'understrap' ) . '</a></p>';
	}
}
// add_filter( 'wp_trim_excerpt', 'understrap_all_excerpts_get_more_link' );

add_post_type_support( 'page', 'excerpt' );


function kyrya_posts_per_page( $query ) {
    if ( is_admin() || ! $query->is_main_query() || $query->is_search() )
        return;

    $query->set( 'posts_per_page', -1 );
        return;
}
add_action( 'pre_get_posts', 'kyrya_posts_per_page', 1 );



// AÑADE UNA PÁGINA DE OPCIONES
add_action( 'admin_menu', 'kyrya_add_admin_menu' );
add_action( 'admin_init', 'kyrya_settings_init' );


function kyrya_add_admin_menu(  ) { 

	// add_options_page( 'Kyrya', 'Kyrya', 'manage_options', 'kyrya', 'kyrya_options_page' );

}


function kyrya_settings_init(  ) { 

	register_setting( 'pluginPage', 'kyrya_settings' );

	add_settings_section(
		'kyrya_pluginPage_section', 
		__( 'Opciones del sitio web de Kyrya', 'kyrya-admin' ), 
		'kyrya_settings_section_callback', 
		'pluginPage'
	);

	$post_types = get_post_types( array('public' => true));
	foreach ($post_types as $pt) {

		$pto = get_post_type_object( $pt );

		
	}


		// add_settings_field( 
		// 	'kyrya_pagina_archivo_' . $pt, 
		// 	$pto->labels->name, 
		// 	'kyrya_pagina_archivo_render', 
		// 	'pluginPage', 
		// 	'kyrya_pluginPage_section' 
		// );
		

	// add_settings_field( 
	// 	'kyrya_text_field_1', 
	// 	__( 'Settings field description', 'kyrya-admin' ), 
	// 	'kyrya_text_field_1_render', 
	// 	'pluginPage', 
	// 	'kyrya_pluginPage_section' 
	// );

	// add_settings_field( 
	// 	'kyrya_checkbox_field_2', 
	// 	__( 'Settings field description', 'kyrya-admin' ), 
	// 	'kyrya_checkbox_field_2_render', 
	// 	'pluginPage', 
	// 	'kyrya_pluginPage_section' 
	// );

	// add_settings_field( 
	// 	'kyrya_radio_field_3', 
	// 	__( 'Settings field description', 'kyrya-admin' ), 
	// 	'kyrya_radio_field_3_render', 
	// 	'pluginPage', 
	// 	'kyrya_pluginPage_section' 
	// );

	// add_settings_field( 
	// 	'kyrya_textarea_field_4', 
	// 	__( 'Settings field description', 'kyrya-admin' ), 
	// 	'kyrya_textarea_field_4_render', 
	// 	'pluginPage', 
	// 	'kyrya_pluginPage_section' 
	// );


}


function kyrya_pagina_archivo_render(  ) { 

	$options = get_option( 'kyrya_settings' );
	$pages = get_pages();
		?>
		<select name='kyrya_settings[kyrya_pagina_archivo_<?php echo $pt; ?>]'>
			<option value='0' <?php selected( $options['kyrya_pagina_archivo_'.$pt.''], 1 ); ?>><?php _e( 'Ninguna', 'kyrya-admin' ); ?></option>';
			<?php foreach($pages as $page) {
				echo '<option value="'.$page->ID.'" '. selected( $options['kyrya_pagina_archivo_'.$pt.''], 1 ) , '>'.$page->post_title.'</option>';
			} ?>
		</select>

	<?php

}

/*
// function kyrya_text_field_1_render(  ) { 

// 	$options = get_option( 'kyrya_settings' );
// 	?>
// 	<input type='text' name='kyrya_settings[kyrya_text_field_1]' value='<?php echo $options['kyrya_text_field_1']; ?>'>
// 	<?php

// }


// function kyrya_checkbox_field_2_render(  ) { 

// 	$options = get_option( 'kyrya_settings' );
// 	?>
// 	<input type='checkbox' name='kyrya_settings[kyrya_checkbox_field_2]' <?php checked( $options['kyrya_checkbox_field_2'], 1 ); ?> value='1'>
// 	<?php

// }


// function kyrya_radio_field_3_render(  ) { 

// 	$options = get_option( 'kyrya_settings' );
// 	?>
// 	<input type='radio' name='kyrya_settings[kyrya_radio_field_3]' <?php checked( $options['kyrya_radio_field_3'], 1 ); ?> value='1'>
// 	<?php

// }


// function kyrya_textarea_field_4_render(  ) { 

// 	$options = get_option( 'kyrya_settings' );
// 	?>
// 	<textarea cols='40' rows='5' name='kyrya_settings[kyrya_textarea_field_4]'> 
// 		<?php echo $options['kyrya_textarea_field_4']; ?>
//  	</textarea>
// 	<?php

// }
*/


function kyrya_settings_section_callback(  ) { 

	// echo __( 'This section description', 'kyrya-admin' );

}


function kyrya_options_page(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>kyrya</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}

function anadir_post_class( $classes ) {
	global $post;
	if( is_archive() && 'post' != get_post_type() ) {
		$classes[] = 'col-md-3';
	}
	return $classes;
}
add_filter( 'post_class', 'anadir_post_class' );

function anadir_body_class( $classes ) {
	global $post;
	if (is_page_template('page-templates/template-archivo.php')) {
		$classes[] = 'archive';
	}
	return $classes;
}
add_filter( 'body_class', 'anadir_body_class' );


if ( ! function_exists('custom_post_type_slide') ) {

// Register Custom Post Type
function custom_post_type_slide() {

	$labels = array(
		'name'                  => _x( 'Slides', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Slides', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Slides', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nueva Slide', 'kyrya-admin' ),
		'new_item'              => __( 'Nueva Slide', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Slide', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Slide', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Slide', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Slide', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Slides', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-slides',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('cat_slide'),
	);
	register_post_type( 'slide', $args );

}
add_action( 'init', 'custom_post_type_slide', 0 );

}

if ( ! function_exists('custom_post_type_redes_sociales') ) {

// Register Custom Post Type
function custom_post_type_redes_sociales() {

	$labels = array(
		'name'                  => _x( 'Redes sociales', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Red social', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Redes sociales', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Redes sociales', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nueva Red social', 'kyrya-admin' ),
		'new_item'              => __( 'Nueva Red social', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Red social', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Red social', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Red social', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Red social', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Redes sociales', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'excerpt', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-facebook',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'red_social', $args );

}
add_action( 'init', 'custom_post_type_redes_sociales', 0 );

}


if ( ! function_exists('custom_post_type_composicion') ) {

// Register Custom Post Type
function custom_post_type_composicion() {

	$labels = array(
		'name'                  => _x( 'Composiciones', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Composición', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Composiciones', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Composiciones', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nueva Composición', 'kyrya-admin' ),
		'new_item'              => __( 'Nueva Composición', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Composición', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Composición', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Composición', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Composiciones', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Composiciones', 'kyrya' ),
		'description'           => __( 'Design attitude', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-images-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('coleccion', 'categoria_producto'),

	);
	register_post_type( 'composicion', $args );

}
add_action( 'init', 'custom_post_type_composicion', 0 );

}


if ( ! function_exists('custom_post_type_productos') ) {

// Register Custom Post Type
function custom_post_type_productos() {

	$labels = array(
		'name'                  => _x( 'Productos', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Producto', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Productos', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Productos', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo Producto', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Producto', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Producto', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Producto', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Producto', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Productos', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Producto', 'kyrya' ),
		'description'           => __( 'Nuestro catálogo', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'page-attributes' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-screenoptions',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('categoria_producto'),
	);
	register_post_type( 'producto', $args );

}
add_action( 'init', 'custom_post_type_productos', 0 );

}

if ( ! function_exists('custom_post_type_opcion_productos') ) {

// Register Custom Post Type
function custom_post_type_opcion_productos() {

	$labels = array(
		'name'                  => _x( 'Opciones de producto', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Opción de producto', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Opciones de producto', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Opciones de producto', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nueva Opción de producto', 'kyrya-admin' ),
		'new_item'              => __( 'Nueva Opción de producto', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Opción de producto', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Opción de producto', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Opción de producto', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Opciones de producto', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Opción de producto', 'kyrya' ),
		// 'description'           => __( 'Nuestro catálogo', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'excerpt' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-image-filter',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		// 'taxonomies'			=> array('categoria_producto'),
	);
	register_post_type( 'opcion_producto', $args );

}
add_action( 'init', 'custom_post_type_opcion_productos', 0 );

}


if ( ! function_exists('custom_post_type_integrated_spaces') ) {

// Register Custom Post Type
function custom_post_type_integrated_spaces() {

	$labels = array(
		'name'                  => _x( 'Integrated Spaces', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Integrated Space', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Integrated Spaces', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Integrated Spaces', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo Integrated Space', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Integrated Space', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Integrated Space', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Integrated Space', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Integrated Space', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Integrated Space', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Integrated Space', 'kyrya' ),
		'description'           => __( 'Solución integral', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-home',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('categoria_producto'),
	);
	register_post_type( 'integrated_space', $args );

}
// add_action( 'init', 'custom_post_type_integrated_spaces', 0 );

}

if ( ! function_exists('custom_post_type_solution_spaces') ) {

// Register Custom Post Type
function custom_post_type_solution_spaces() {

	$labels = array(
		'name'                  => _x( 'Solution Spaces', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Solution Space', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Solution Spaces', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Solution Spaces', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo Solution Space', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Solution Space', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Solution Space', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Solution Space', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Solution Space', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Solution Space', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Integrated Space', 'kyrya' ),
		'description'           => __( 'Mobiliario a medida', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-home',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('categoria_producto'),
	);
	register_post_type( 'solution_space', $args );

}
add_action( 'init', 'custom_post_type_solution_spaces', 0 );

}


// if ( ! function_exists('custom_post_type_estructuras') ) {

// // Register Custom Post Type
// function custom_post_type_estructuras() {

// 	$labels = array(
// 		'name'                  => _x( 'Estructuras', 'Post Type General Name', 'kyrya' ),
// 		'singular_name'         => _x( 'Estructura', 'Post Type Singular Name', 'kyrya' ),
// 		'menu_name'             => __( 'Estructuras', 'kyrya-admin' ),
// 		'name_admin_bar'        => __( 'Estructuras', 'kyrya-admin' ),
// 		'add_new'               => __( 'Añadir nueva Estructura', 'kyrya-admin' ),
// 		'new_item'              => __( 'Nueva Estructura', 'kyrya-admin' ),
// 		'edit_item'             => __( 'Editar Estructura', 'kyrya-admin' ),
// 		'update_item'           => __( 'Actualizar Estructura', 'kyrya-admin' ),
// 		'view_item'             => __( 'Ver Estructura', 'kyrya-admin' ),
// 		'view_items'            => __( 'Ver Estructuras', 'kyrya-admin' ),
// 	);
// 	$args = array(
// 		'label'                 => __( 'Estructura', 'kyrya' ),
// 		// 'description'           => __( 'Todas las posibilidades', 'kyrya' ),
// 		'labels'                => $labels,
// 		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
// 		'hierarchical'          => false,
// 		'public'                => true,
// 		'show_ui'               => true,
// 		'show_in_menu'          => true,
// 		'menu_position'         => 5,
// 		'menu_icon'             => 'dashicons-admin-appearance',
// 		'show_in_admin_bar'     => true,
// 		'show_in_nav_menus'     => true,
// 		'can_export'            => true,
// 		'has_archive'           => true,
// 		'exclude_from_search'   => false,
// 		'publicly_queryable'    => true,
// 		'capability_type'       => 'page',
// 		'taxonomies'			=> array('coleccion'),
// 	);
// 	register_post_type( 'estructura', $args );

// }
// add_action( 'init', 'custom_post_type_estructuras', 0 );

// }

if ( ! function_exists('custom_post_type_acabados') ) {

// Register Custom Post Type
function custom_post_type_acabados() {

	$labels = array(
		'name'                  => _x( 'Acabados', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Acabado', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Acabados', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Acabados', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nuevo Acabado', 'kyrya-admin' ),
		'new_item'              => __( 'Nuevo Acabado', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Acabado', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Acabado', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Acabado', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Acabados', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Acabado', 'kyrya' ),
		'description'           => __( 'Todas las posibilidades', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-appearance',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('categoria_acabado'),
	);
	register_post_type( 'acabado', $args );

}
add_action( 'init', 'custom_post_type_acabados', 0 );

}


if ( ! function_exists('custom_post_type_aperturas') ) {

// Register Custom Post Type
function custom_post_type_aperturas() {

	$labels = array(
		'name'                  => _x( 'Aperturas', 'Post Type General Name', 'kyrya' ),
		'singular_name'         => _x( 'Apertura', 'Post Type Singular Name', 'kyrya' ),
		'menu_name'             => __( 'Aperturas', 'kyrya-admin' ),
		'name_admin_bar'        => __( 'Aperturas', 'kyrya-admin' ),
		'add_new'               => __( 'Añadir nueva Apertura', 'kyrya-admin' ),
		'new_item'              => __( 'Nueva Apertura', 'kyrya-admin' ),
		'edit_item'             => __( 'Editar Apertura', 'kyrya-admin' ),
		'update_item'           => __( 'Actualizar Apertura', 'kyrya-admin' ),
		'view_item'             => __( 'Ver Apertura', 'kyrya-admin' ),
		'view_items'            => __( 'Ver Aperturas', 'kyrya-admin' ),
	);
	$args = array(
		'label'                 => __( 'Apertura', 'kyrya' ),
		'description'           => __( '', 'kyrya' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-editor-expand',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'taxonomies'			=> array('tipo_apertura'),
	);
	register_post_type( 'apertura', $args );

}
add_action( 'init', 'custom_post_type_aperturas', 0 );

}




if ( ! function_exists('cat_slide_function') ) {

// Register Custom Taxonomy
function cat_slide_function() {

	$labels = array(
		'name'                       => _x( 'Categorías de Slides', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Categoría de Slide', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Categorías de Slides', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'cat_slide', array( 'slide' ), $args );

}
add_action( 'init', 'cat_slide_function', 0 );

}

if ( ! function_exists('categoria_producto_function') ) {

// Register Custom Taxonomy
function categoria_producto_function() {

	$labels = array(
		'name'                       => _x( 'Categorías de producto', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Categoría de producto', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Categorías de producto', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'categoria_producto', array( 'producto', 'composicion', 'integrated_space', 'solution_space' ), $args );

}
add_action( 'init', 'categoria_producto_function', 0 );

}

if ( ! function_exists('coleccion_tax_function') ) {

// Register Custom Taxonomy
function coleccion_tax_function() {

	$labels = array(
		'name'                       => _x( 'Colecciones', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Coleccion', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Colecciones', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'coleccion', array( 'composicion' ), $args );

}
add_action( 'init', 'coleccion_tax_function', 0 );

}

if ( ! function_exists('categoria_acabado_tax_function') ) {

// Register Custom Taxonomy
function categoria_acabado_tax_function() {

	$labels = array(
		'name'                       => _x( 'Categorías de acabados', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Categoría de acabados', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Categorías de acabados', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'categoria_acabado', array( 'acabado' ), $args );

}
add_action( 'init', 'categoria_acabado_tax_function', 0 );

}

if ( ! function_exists('tipo_apertura_tax_function') ) {

// Register Custom Taxonomy
function tipo_apertura_tax_function() {

	$labels = array(
		'name'                       => _x( 'Tipos de Apertura', 'Taxonomy General Name', 'kyrya' ),
		'singular_name'              => _x( 'Tipo de Apertura', 'Taxonomy Singular Name', 'kyrya' ),
		'menu_name'                  => __( 'Tipos de Apertura', 'kyrya-admin' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'tipo_apertura', array( 'apertura' ), $args );

}
add_action( 'init', 'tipo_apertura_tax_function', 0 );

}


function wpb_custom_logo() {
echo '
	<style type="text/css">
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			background-image: url(' . get_bloginfo('stylesheet_directory') . '/img/logo-kyrya-blanco.png) !important;
			color:rgba(0, 0, 0, 0);
			background-size: contain;
			background-repeat: no-repeat;
			display: block;
		}
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon {
			width: 80px;
		}
		#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
		}
	</style>';
}
 
//hook into the administrative header output
add_action('wp_before_admin_bar_render', 'wpb_custom_logo');







function filter_productos_by_taxonomies( $post_type, $which ) {

	// Apply this only on a specific post type
	// if ( 'car' !== $post_type )
	// 	return;


	// A list of taxonomy slugs to filter by
	// $taxonomies = array( 'manufacturer', 'model', 'transmission', 'doors', 'color' );
	$taxonomies = get_object_taxonomies( $post_type );
	if (($key = array_search('acabado', $taxonomies)) !== false) {
	    unset($taxonomies[$key]);
	}

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( array(
			'taxonomy'	=> $taxonomy_slug,
			'orderby' 	=> 'name',
			'hide_empty'	=> true,
		) );

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Todos los %s' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}
add_action( 'restrict_manage_posts', 'filter_productos_by_taxonomies' , 10, 2);



add_filter('manage_posts_columns', 'kyrya_columns_head');
add_action('manage_posts_custom_column', 'kyrya_columns_content', 10, 2);


// ADD NEW COLUMN
function kyrya_columns_head($defaults) {
	// $defaults = array('featured_image' => 'Imagen') + $defaults;
    // $defaults['featured_image'] = 'Imagen';
    $defaults['referencia'] = 'Referencia';
    $defaults['slug'] = 'Slug';
    $defaults['excerpt-content'] = 'Contenido';
    $defaults['medidas'] = 'Medidas';
    $defaults['texto_destacado'] = 'Destacado';
    $defaults['croquis'] = 'Croquis';

    return $defaults;
}
 
// SHOW THE COLUMNS CONTENT
function kyrya_columns_content($column_name, $post_ID) {
    // if ($column_name == 'featured_image') {
    // 	echo get_the_post_thumbnail( $post_ID, array(80,80) );
    // }
    // if ($column_name == 'excerpt') {
    // 	echo get_the_excerpt( $post_ID );
    // }
    switch ($column_name) {
        case 'featured_image':
            echo '<img src="'.get_the_post_thumbnail_url( $post_ID, 'medium' ).'" height="100" style="max-width:120px;" />';
            break;
        
        case 'croquis':
            $img = get_post_meta( $post_ID, 'plano' );
            echo '<img src="' . wp_get_attachment_image_url( $img, 'medium' ) . '" height="100" style="max-width:120px;" />';
            break;
        
        case 'slug':
            echo get_post_field( 'post_name', $post_ID, 'raw' );
            break;
        
        case 'excerpt-content':
        	$post = get_post($post_ID);
        	echo '<b style="color:lightgray;">Extracto:</b><br>';
        	echo $post->post_excerpt;
        	echo '<hr>';
        	echo '<b style="color:lightgray;">Contenido:</b><br>';
    		echo $post->post_content;
            break;

        case 'medidas':
            $medidas = get_field('medidas', $post_ID);
            $diametro = get_field('diametro', $post_ID);
            echo '<span style="color:lightgray;"><b>Medidas: </b></span>' . $medidas . '<br>';
            echo '<span style="color:lightgray;"><b>Ø: </b></span>' . $diametro . '<br>';
            break;
        
        case 'texto_destacado':
            the_field('texto_destacado', $post_ID);
            break;
        
        case 'referencia':
            the_field('referencia', $post_ID);
            break;
        
        default:
            # code...
            break;
    }
}


// Admin columnas personalizadas downloads
add_filter('manage_edit-dlm_download_columns', 'columnas_personalizadas_descargas');
function columnas_personalizadas_descargas($columns) {
    $columns['traduccion_titulo'] = __( 'Traducciones', 'kyrya' );
    return $columns;
}
// Render the custom columns for the "DOWNLOADS" post type
add_action('manage_dlm_download_posts_custom_column', 'render_columnas_personalizadas_descargas', 10, 2);
function render_columnas_personalizadas_descargas($column_name) {
    global $post;
    switch ($column_name) {
         case 'traduccion_titulo':
         $traducciones = get_post_meta( $post->ID, $column_name, true );
         if( $traducciones) {
            echo $traducciones;
            // echo(sprintf( '<span class="acf-field %s">%s</span>', $column_name, $traducciones ) );
        }
        break;
    }
}


// COLUMNAS EN TABLAS DE USUARIOS
function kyrya_modify_user_table( $column ) {
    $column['telefono'] = 'Teléfono';
    $column['registrado'] = 'Registrado el';
    $column['descargas'] = 'Descargas';
    $column['activado'] = 'Activado';
    return $column;
}
add_filter( 'manage_users_columns', 'kyrya_modify_user_table' );

function kyrya_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'telefono' :
        	$telefono = get_the_author_meta( 'phone1', $user_id );
        	$telefono_link = 'tel:' . str_replace(' ', '', $telefono);
            return '<b><a href="'.$telefono_link.'"><span class="dashicons dashicons-phone"></span> ' . $telefono . '</a></b><br><small>' . get_the_author_meta( 'perfil', $user_id ) . ' (' . get_the_author_meta( 'city', $user_id ) . ')</small>';
            break;
        case 'activado' :
        	$r = '<a href="'.get_edit_user_link( $user_id ).'#activate_user" title="';
	        	if ('1' == get_the_author_meta( 'active', $user_id ) ) {
	        		$r .= __( 'Desactivar', 'kyrya-admin' ) . '">';
	        	    $r .= '<span style="color:lightblue;">' . __( 'Sí', 'kyrya-admin' );
	        	} else {
	        		$r .= __( 'Activar', 'kyrya-admin' ) . '">';
	        		$r .= '<span style="color:red;">' . __( 'No', 'kyrya-admin' );
	        	}

	        	$r .= ' <span class="dashicons dashicons-arrow-right-alt" style=""></span></span>';
	        $r .= '</a>';

        	return $r;

            break;
        case 'registrado' :
        	$user_data = get_userdata( $user_id );
        	$registered = $user_data->user_registered;
        	// return $registered;
        	return date_i18n( get_option('date_format'), strtotime( $registered ) );
        	break;

        case 'descargas' :
        	global $wpdb;
        	$r = '';
        	$descargas = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}download_log WHERE user_id = {$user_id}", OBJECT );
        	if (!empty($descargas)) {
        		$r .= '<p style="border-bottom:1px solid lightgray;"><strong>'.__( 'Total', 'kyrya-admin' ).': '.count($descargas).'</strong></p>';
        		$r .= '<ul style="line-height:1.2; overflow:hidden;" class="colapsar">';
	        	foreach ($descargas as $descarga) {
		        	$r .= '<li><small>' . get_the_title( $descarga->download_id ) . ' <span style="color:lightgray;">(' . date_i18n( get_option('date_format'), strtotime( $descarga->download_date ) )  . ')</span></small></li>';
		        	// $r .= '<li>' . get_the_title( $descarga->download_id ) . '</li>';
	        	}
	        	$r .= '</ul>';
		    }



	        return $r;
        	break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'kyrya_modify_user_table_row', 10, 3 );

add_action( 'admin_footer', 'estilos_y_scripts_admin', 10 );
function estilos_y_scripts_admin() {
	global $pagenow;
	if ('users.php' == $pagenow) { ?>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
				  var maxheight=100;
				  var showText = "<?php _e('...<br>Ver más', 'kyrya-admin'); ?>";
				  var hideText = "[<?php _e('Cerrar', 'kyrya-admin'); ?>]";

				  $('.colapsar').each(function () {
				    var text = $(this);
				    if (text.height() > maxheight){
				        text.css('max-height', maxheight + 'px').addClass('oculto');

				        var link = $('<a class="leer-mas" href="#">' + showText + '</a>');
				        var linkDiv = $('<div></div>');
				        linkDiv.append(link);
				        $(this).after(linkDiv);

				        link.click(function (event) {
				          event.preventDefault();
				          if (text.height() > maxheight) {
				              $(this).html(showText);
				              text.css('max-height', maxheight + 'px').addClass('oculto');
				          } else {
				              $(this).html(hideText);
				              text.css('max-height', '10000px').removeClass('oculto');
				          }
				        });
				    }       
				  });
				});
			</script>
	<?php }
}

add_filter( 'manage_users_sortable_columns', 'kyrya_make_registered_column_sortable' );
function kyrya_make_registered_column_sortable( $columns ) {
	return wp_parse_args( array( 
		'registrado' => 'reg',
		// 'activado' => 'act',
		 ), $columns );
	// return wp_parse_args( array( 'activado' => 'act' ), $columns );
}


add_action( 'pre_user_query', 'kyrya_pre_user_query', 1 );
function kyrya_pre_user_query( $query ) {
    global $wpdb, $current_screen;

    // Only filter in the admin
    if ( ! is_admin() )
        return;

    // Only filter on the users screen
    if ( ! ( isset( $current_screen ) && 'users' == $current_screen->id ) )
        return;
  
   	// echo '<pre>'; print_r($query); echo '</pre>';


	if ( !isset( $_GET['orderby'] ) ) {
		$query->query_orderby = 'ORDER BY user_registered DESC';
		return;
	}

    // We need the order - default is ASC
    $order = isset( $query->query_vars ) && isset( $query->query_vars[ 'order' ] ) && strcasecmp( $query->query_vars[ 'order' ], 'asc' ) == 0 ? 'ASC' : 'DESC';


    // Only filter if orderby is set to 'art'
    if ( 'reg' == $query->query_vars[ 'orderby' ] ) {
        // Order the posts by product count
        // $query->query_orderby = "ORDER BY ( SELECT COUNT(*) FROM {$wpdb->posts} products WHERE products.post_type = 'product' AND products.post_status = 'publish' AND products.post_author = {$wpdb->users}.ID ) {$order}";
    	$query->query_orderby = 'ORDER BY user_registered ' . $order;
    } elseif ( 'act' == $query->query_vars[ 'orderby' ] ) {
    	// $query->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='active')";
    	$query->query_from .= " INNER JOIN {$wpdb->usermeta} m1 ON {$wpdb->users}.ID=m1.user_id AND (m1.meta_key='active')";
        $query->query_orderby = ' ORDER BY UPPER(m1.meta_value) '. $order;
    }

}
?>
