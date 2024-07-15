<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

define('ACABADOS_ID', apply_filters( 'wpml_object_id', 246, 'page' ));
define('APERTURAS_ID', apply_filters( 'wpml_object_id', 902, 'page' ) );
define('ESTRUCTURAS_ID', apply_filters( 'wpml_object_id', 2278, 'page' ) );
define('PRODUCTOS_ID', apply_filters( 'wpml_object_id', 59, 'page' ) );
define('COLECCIONES_ID', apply_filters( 'wpml_object_id', 61, 'page' ) );
define('SPACES_SOLUTIONS_ID', apply_filters( 'wpml_object_id', 65, 'page' ) );
define('INTEGRATED_SPACES_ID', apply_filters( 'wpml_object_id', 67, 'page' ) );
define('CONTACTO_ID', apply_filters( 'wpml_object_id', 17, 'page' ) );
// define('INSPIRACION_ID', apply_filters( 'wpml_object_id', 21004, 'page' ) );
define('INSPIRACION_ID', false );
define('ID_FORMULARIO_DESCARGA', 1274 );
define('CATEGORIA_CATALOGOS', 82 );
define('AREA_PROFESIONAL', apply_filters( 'wpml_object_id', 11, 'page' ) );
define('MI_PERFIL', apply_filters( 'wpml_object_id', 253, 'page' ) );
define('KYRYA_PRO_URL', 'https://pro.kyryagroup.com/' . kyrya_get_language_code() );

function kyrya_get_language_code() {
    $code = apply_filters( 'wpml_current_language', NULL );
    if ( 'es' == $code ) return '';

    return $code;
}
/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/theme-settings.php';

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Comments file.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';

/**
 * Widgets Kyrya.
 */
require get_template_directory() . '/inc/widget-kyrya-bloque.php';

// add_action('wp_head', 'show_template');
function show_template() {
    if (is_user_logged_in()) {
        global $template;
        if (is_user_logged_in()){
            echo '<div style="position:absolute;top:30%;">';
            echo 'Plantilla: ';
            print_r($template);
            echo '</div>';
        }
    }
}

add_filter( 'the_excerpt', 'shortcode_unautop');
add_filter( 'the_excerpt', 'do_shortcode');

add_filter('acf/settings/remove_wp_meta_box', '__return_false');

add_action( 'gdpr_force_reload', '__return_true' );


function wpb_remove_schedule_delete() {
    remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
}
add_action( 'init', 'wpb_remove_schedule_delete' );


add_action('wp_head', 'inyectar_scripts_y_styles_personalizados');
function inyectar_scripts_y_styles_personalizados() {
    if (is_singular()) {
        global $post;
        $scripts = get_post_meta( $post->ID, 'scripts_estilos', true );
        if ($scripts && '' != $scripts ) {
            echo $scripts;
        }
    }
}

add_filter('body_class', 'wpml_body_class');
function wpml_body_class($classes) {
    $classes[] = ICL_LANGUAGE_CODE;
    return $classes;
}

function load_custom_wp_admin_style(){
    wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/css/admin.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

// PRO
// Envía notificaciones extra cuando se registra un usuario
add_filter( 'wpmem_notify_addr', 'kyrya_notificaciones_registro' );
function kyrya_notificaciones_registro( $email ) {
 
    // single email example
    $email = 'info@kyrya.es';
     
    // multiple emails example
    // $email = 'notify1@mydomain.com, notify2@mydomain.com';
     
    // take the default and append a second address to it example:
    // $email = $email . ', info@kyrya.es';
     
    // return the result
    return $email;
}

// PRO
function get_estado_usuario() {
    if (is_user_logged_in()) {
        $mi_perfil_id = 253;
        $link_perfil = get_permalink( $mi_perfil_id );
        return do_shortcode( '<strong><a href="'.$link_perfil.'" title="'.get_the_title( $mi_perfil_id ).'">[wpmem_field user_login]</a></strong>: [wpmem_logout url="'.get_permalink().'"]' . __( 'Cerrar sesión', 'kyrya' ) . '[/wpmem_logout]' );
    }
    return false;
}

add_action('after_setup_theme', 'kyrya_setup_theme');
function kyrya_setup_theme() {
    add_theme_support( 'align-wide' );
    add_theme_support( 'align-full' );
    if (!current_user_can('edit_posts') && !is_admin()) {
      show_admin_bar(false);
    }
}

// PRO
add_action( 'init', 'restringir_acceso_al_admin' );
function restringir_acceso_al_admin() {
    if ( is_user_logged_in() && is_admin() && ! current_user_can( 'edit_posts' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        wp_redirect( home_url() );
        exit;
    }
}

function mostrar_tagline() {
	$r = '';
    if ( is_singular( 'post' ) ) {
        return;
    } elseif  ( is_page() && !is_front_page() ) {
        $r .= '<h1>'.get_the_title().'</h1>';
    } elseif (!is_page() && is_singular() ) {
        $titulo = get_the_title();
        // $pto = get_post_type_object( get_post_type() );
        // if ('acabado' == $pto->name) {
        //     $titulo = get_the_excerpt();
        // } else {
        //     $titulo = get_the_title();
        // }
		$r .= '<h1>'. $pto->labels->name . ': ' .$titulo.'</h1>';
	} elseif(is_tax()) {
		$q_obj = get_queried_object();
		$r .= '<h1>'. $q_obj->name .'</h1>';
	} elseif(is_post_type_archive()) {
		$pto = get_post_type_object( get_post_type() );
		$r .= '<h1>' . $pto->labels->name . '</h1>';
	}

	if ('' != $r ) echo '<div class="tagline">'. $r .'</div>';

}

add_action('wp_enqueue_scripts', 'google_fonts');
function google_fonts() {
	$query_args = array(
        // 'family' => 'Montserrat:200,500|Roboto+Condensed',
        'family' => 'Roboto+Condensed|Barlow:300,400,600',
        'display' => 'swap',
        'subset' => 'latin,latin-ext',
	);
	wp_register_style( 'kyrya_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
	wp_enqueue_style( 'kyrya_fonts' );
}

function redes_sociales_shortcode(  ) {
    $args = array(
            'post_type'         => 'red_social',
            'posts_per_page'    => -1,
        );
    
    $r = '';
    $q = new WP_Query($args);
    if ($q->have_posts()) {
        $r .= '<span class="redes-sociales">';

        while ($q->have_posts()) { $q->the_post();
            $r .= '<a href="'.get_the_excerpt().'" target="_blank" title="'.get_the_title().'"><img src="'.get_the_post_thumbnail_url().'" alt="'.get_the_title().'" /></a>';
        }
        $r .= '</span>';
    }

    wp_reset_postdata();

    return $r;
}
add_shortcode( 'redes_sociales', 'redes_sociales_shortcode' );


function kyrya_get_post_types_by_taxonomy( $tax = 'category' )
{
    global $wp_taxonomies;
    return ( isset( $wp_taxonomies[$tax] ) ) ? $wp_taxonomies[$tax]->object_type : array();
}

function ordenar_alfabeticamente( $query ) {
    if (is_admin()) return;
    
    $pt = false;
    if (is_tax()) {
        $qobj = get_queried_object();
        if ($qobj) {
            $pt = kyrya_get_post_types_by_taxonomy($qobj->taxonomy);
        }
        // echo '<pre>'; print_r($pt); echo '</pre>';
    } elseif (is_page_template( $template = 'page-templates/template-archivo.php' )) {
        $pt = get_post_meta( get_the_ID(), 'archivo', true );
    }

    if ($pt) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }

}
add_action( 'pre_get_posts', 'ordenar_alfabeticamente' );

function mostrar_solo_mobiliaro_en_categorias_producto( $query ) {

    if ( is_admin() || !$query->is_main_query() ) return;
    if ( !is_tax( 'categoria_producto' ) ) return;

    $query->set( 'post_type', ['producto']);

}
add_action( 'pre_get_posts', 'mostrar_solo_mobiliaro_en_categorias_producto' );


function kyrya_placeholder_url() {
	return get_stylesheet_directory_uri() . '/img/kyrya-placeholder.jpg';
}

function flecha_animada( $color = '#fff', $direccion = 'derecha' ) {
	if ($direccion != 'derecha') {
		$direccion == 'izquierda';
	}
	$r = '<svg class="arrow-icon '.$direccion.'" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
						      <g fill="none" stroke="'.$color.'" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
						        <circle class="arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>';
	if ($direccion == 'derecha')
		$r .= '<path transform="rotate(-180 16.562461853027344,15.63349151611328) " stroke="'.$color.'" id="svg_6" d="m16.484828,8.062496l-7.609849,7.53216l7.60983,7.60983l-7.454528,-7.454528l15.219661,-0.155303" opacity="1" stroke-width="1.5" fill="none"/>';
	else
		$r .= '<path stroke="'.$color.'" id="svg_6" d="m16.484828,8.062496l-7.609849,7.53216l7.60983,7.60983l-7.454528,-7.454528l15.219661,-0.155303" opacity="1" stroke-width="1.5" fill="none"/>';

	$r .= '</g>
			</svg>';

	return $r;
}

/*function shortcode_descargas() {
    $r = '';

    $es_pagina_privada = get_post_meta( get_the_ID(), '_wpmem_block', true );

    // $r .= 'privada' . $es_pagina_privada;

    $tax = 'dlm_download_category';

    $members_only = "false";
    $privadas = array();
    if ( 1 == $es_pagina_privada ) {
        $members_only = "true";
    } else {
        $privadas = get_posts(array(
            'post_type'     => 'dlm_download',
            'posts_per_page'  => -1,
            'fields'            => 'ids',
            'meta_query' => [
                                [
                                    'key' => '_members_only',
                                    'value'    => 'yes',
                                    'compare' => '='
                                ]
                            ],
        ));

        // $privadas = implode(',', $privadas);
    }


    $terms = get_terms( array(
            'hide_empty'        => 0,
            'taxonomy'          => $tax,
        ) );

    foreach ($terms as $term) {
        $r .= '<h3>'.$term->name.'</h3>';
        $r .= '[downloads orderby="download_count" order="DESC" category="'.$term->slug.'" exclude="'. implode(',', $privadas) .'"]';
    }

    $sin_categoria = get_posts(array(
            'post_type'     => 'dlm_download',
            'posts_per_page'  => -1,
            'fields'            => 'ids',
            'tax_query' => [
                                [
                                    'taxonomy' => $tax,
                                    'terms'    => get_terms( $tax, [ 'fields' => 'ids', 'hide_empty' => 0  ] ),
                                    'operator' => 'NOT IN'
                                ]
                            ],
        ));

    $sin_categoria = array_diff($sin_categoria, $privadas);

    if (!empty($sin_categoria)) {
        $r .= '<h3>'.__( 'Otras', 'kyrya' ).'</h3>';
        $r .= '[downloads orderby="download_count" order="DESC" include="'.implode(',', $sin_categoria).'"]';
        
        $r = '<div class="descargas">'.$r.'</div>';
    }
    return do_shortcode($r);
}*/

// PRO
function descargas_term( $term = false ) {
    $r = '';

    if (is_int($term)) {
        $term = get_term($term);
    }

    $es_pagina_privada = get_post_meta( get_the_ID(), '_wpmem_block', true );
    $tax = 'dlm_download_category';
    $args = array(
        'post_type'     => 'dlm_download',
        'posts_per_page'  => -1,
        'fields'            => 'ids',
    );

    $privadas = array();
    if ( 1 != $es_pagina_privada ) {
        $privadas = get_posts(array(
            'post_type'     => 'dlm_download',
            'posts_per_page'  => -1,
            'fields'            => 'ids',
            'meta_query' => [
                                [
                                    'key' => '_members_only',
                                    'value'    => 'yes',
                                    'compare' => '='
                                ]
                            ],
        ));
        $args['post__not_in'] = $privadas;


    }

    if (!$term) {
        $args['fields'] = 'ids';
        $args['tax_query'] = [[
                                'taxonomy' => $tax,
                                'terms'    => get_terms( $tax, [ 'fields' => 'ids', 'hide_empty' => 0  ] ),
                                'operator' => 'NOT IN',
                            ]];

        $sin_categoria = get_posts($args);

        // if ( count($sin_categoria) > 0) {
        //     $r .= '<a data-toggle="collapse" href="#collapse-sin-categoria" role="button" aria-expanded="false" aria-controls="collapse-sin-categoria"><h2>'.__( 'Otras', 'kyrya' ).'</h2></a>';
        //     $r .= '<div class="collapse" id="collapse-sin-categoria">';

        //     if ( 1 == $es_pagina_privada) {
        //             $r .= '[downloads orderby="download_count" order="DESC" include="'. implode(',', $sin_categoria) .'"]';
        //     } else {
        //            $r .= '<ul class="dlm-downloads">';
        //                 $r .= '[email-download download_id="'.implode(',', $sin_categoria).'" contact_form_id="'.ID_FORMULARIO_DESCARGA.'"]';
        //             $r .= '</ul>';
        //     }

        //     $r .= '</div>';
        // }

    } else {

        // $r .= '<h3>'.$term->name.'</h3>';
        // $r .= '<a data-toggle="collapse" href="#collapse-'.$term->slug.'" role="button" aria-expanded="false" aria-controls="collapse-'.$term->slug.'"><h6>'.$term->name.'</h6></a>';
        if (1 == $es_pagina_privada) {
            // if ( current_user_can('manage_options') ) {
            //     echo '<pre>'; print_r( $term ); echo '</pre>';
            // }
            
            $r .= '<div class="collapse" id="collapse-'.$term->slug.'">';
            $r .= '[downloads orderby="download_count" order="DESC" category="'.$term->slug.'" exclude="'. implode(',', $privadas) .'"]';
            $r .= '</div>';
       } else {

        }
    }
    return do_shortcode($r);

}

// PRO
add_action( 'init', 'pro_search_redirect');
function pro_search_redirect() {

    // Si está establecido el parámetro "f" en la url, redirige al Área Pro
    // De este modo se puede usar una url más sencilla para las búsquedas: https://kyrya.es?f=cuadro

    if ( isset($_GET['f']) ) {

        // Redirecciona automáticamente al idioma correspondiente según el idioma del navegador del visitante
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        do_action( 'wpml_switch_language', $lang );
        $page_id = apply_filters( 'wpml_object_id', AREA_PROFESIONAL, 'page', true, $lang );
        $base_url = get_the_permalink( $page_id );

        // Establece parámetros UTM por defecto para medición si no vienen en la url
        $utm_source = ( isset($_GET['utm_source']) ) ? $_GET['utm_source'] : 'Tarifa interactiva';
        $utm_medium = ( isset($_GET['utm_medium']) ) ? $_GET['utm_medium'] : 'Enlace en tarifa pdf';
        $utm_campaign = ( isset($_GET['utm_campaign']) ) ? $_GET['utm_campaign'] : 'Tarifa Kyrya 2021 - idioma: ' . $lang;
        $utm_term = $_GET['f'];

        // Crea la url con el parámetro de búsqueda y los UTM y redirige
        $url = add_query_arg( array(
                                'prosearch'         => $_GET['f'],
                                'utm_source'        => $utm_source,
                                'utm_medium'        => $utm_medium,
                                'utm_campaign'      => $utm_campaign,
                                'utm_term'          => $utm_term,
                            ), $base_url );
        wp_redirect( $url ); 
        exit; 
    }   
}


// PRO
function shortcode_descargas() {
    $r = '';

    $pro_search = (isset($_GET['prosearch'])) ? $_GET['prosearch'] : false;

    $tax = 'dlm_download_category';
    $es_pagina_privada = ( get_post_meta( get_the_ID(), '_wpmem_block', true ) == 1 ) ? true : false;

    if ( !$es_pagina_privada ) {
       
            $args = array(
                'post_type'     => 'dlm_download',
                'posts_per_page'  => -1,
                'fields'            => 'ids',
            );
            $args['tax_query'] = [[
                    'taxonomy'  => $tax,
                    'field'     => 'term_id',
                    'terms'     => CATEGORIA_CATALOGOS,
            ]];
            $args['meta_query'] = [[
                    'key' => '_members_only',
                    'value'    => 'yes',
                    'compare' => '!=',
            ]];

            $q = get_posts($args);
            if ( !empty($q) ) {
               // $r .= '<div class="collapse" id="collapse-'.$term->slug.'"><ul class="dlm-downloads">';
               $r .= '<ul class="dlm-downloads">';
                    $r .= '<div class="miniaturas-descargas">';
                        foreach ($q as $id_descarga) {
                            if (has_post_thumbnail( $id_descarga )) $r .= get_the_post_thumbnail( $id_descarga, 'medium', array('class' => 'miniatura-descarga') );
                        }
                    $r .= '</div>';

                    $r .= '[email-download download_id="'.implode(',', $q).'" contact_form_id="'.ID_FORMULARIO_DESCARGA.'"]';
                
                // $r .= '</ul></div>';
                $r .= '</ul>';
            }


    } else { // Es página privada

            if( $pro_search ) {

                $args_pro_query = array(
                    'post_type'         => array('dlm_download'),
                    'posts_per_page'    => -1,
                    'fields'            => 'ids',
                    's'                 => $pro_search,
                );

                $pro_search_query = new WP_Query($args_pro_query);
                wp_reset_postdata();

                $args_pro_meta_query = array(
                    'post_type'         => array('dlm_download'),
                    'posts_per_page'    => -1,
                    'fields'            => 'ids',
                    'meta_query'        => array(
                                            'relation'      => 'OR',
                                            array(
                                                'key'       => 'traduccion_titulo',
                                                'value'     => $pro_search,
                                                'compare'   => 'LIKE',
                    )),
                );

                $pro_meta_query = new WP_Query($args_pro_meta_query);
                wp_reset_postdata();

                $args_pro_tax_query = array(
                    'post_type'         => array('dlm_download'),
                    'posts_per_page'    => -1,
                    'fields'            => 'ids',
                    'tax_query'        => array(
                                            'relation'  => 'OR',
                                            array(
                                                'taxonomy'       => 'dlm_download_category',
                                                'field'     => 'name',
                                                'terms'     => $pro_search,
                                                'operator'   => 'IN',
                                            ),
                                            array(
                                                'taxonomy'       => 'dlm_download_tag',
                                                'field'     => 'name',
                                                'terms'     => $pro_search,
                                                'operator'   => 'IN',
                                            )
                                        ),
                );

                $pro_tax_query = new WP_Query($args_pro_tax_query);
                wp_reset_postdata();

                $pro_search_results = array_merge( $pro_search_query->posts, $pro_meta_query->posts, $pro_tax_query->posts );

                // print_r($pro_search_query->posts);
                // print_r($pro_meta_query->posts);
                // print_r($pro_search_results);

                $r .= '<div class="pro-search-wrapper">';

                    if ( $pro_search_results ) {

                        $r .= '<p class="lead">' . sprintf( __( 'Resultados de la búsqueda por: %s', 'kyrya' ), $pro_search) . '</p>';

                        $r .= '<div class="mb-5">[downloads orderby="download_count" order="DESC" include="'. implode(',', $pro_search_results ) .'"]</div>';



                    } else {
                        $r .= '<p class="lead">' . sprintf( __( 'No se ha encontrado nada para el término: %s', 'kyrya' ), $pro_search) . '</p>';
                    }

                $r .= '</div>';

            }

            $r .= kyrya_pro_search_shortcode();

            $r .= '<h4>'.__( 'Todas las fichas técnicas', 'kyrya' ).'</h4>';
            $r .= '<p>' . __( 'Puede navegar por todas las fichas de producto a continuacion', 'kyrya' ) . ':</p>';


            $r .= '<div class="pro-search-wrapper">';

                $terms = get_terms( array(
                        'hide_empty'        => false,
                        'parent'            => 0,
                        'taxonomy'          => $tax,
                    ) );

                // if ( current_user_can('manage_options') ) {
                //     echo '<pre>'; print_r( $terms ); echo '</pre>';
                // }
                

                foreach ($terms as $term) {

                    $args_hay_posts = array(
                        'post_type'     => 'dlm_download',
                        'posts_per_page'  => -1,
                        'fields'            => 'ids',
                        'tax_query' => [
                                            [
                                                'taxonomy' => $tax,
                                                'field'    => 'term_id',
                                                'terms' => array(CATEGORIA_CATALOGOS),
                                            ]
                                        ],
                        // 'meta_query' => [
                        //                     [
                        //                         'key' => '_members_only',
                        //                         'value'    => 'yes',
                        //                         'compare' => '!='
                        //                     ]
                        //                 ],
                    );

                    $hay_posts = get_posts($args_hay_posts);

                    if ( !empty($hay_posts) ) {
                        $descargas = descargas_term($term);
                        if ('' != $descargas ) {
                            $r .= '<a data-toggle="collapse" href="#collapse-'.$term->slug.'" role="button" aria-expanded="false" aria-controls="collapse-'.$term->slug.'"><h2 class="">'.$term->name.'</h2></a>';
                        }
                        $subterms = get_terms( array('hide_empty' => 0, 'parent' => $term->term_id, 'taxonomy' => $tax) );
                        if (!empty($subterms)) {
                            foreach ($subterms as $subterm) {
                                $descargas = descargas_term($subterm);
                                // echo '<pre>aaa'; print_r($subterms); echo '</pre>';
                                if ('' != $descargas) {
                                    $r .= '<a data-toggle="collapse" href="#collapse-'.$subterm->slug.'" role="button" aria-expanded="false" aria-controls="collapse-'.$subterm->slug.'"><h6>'.$subterm->name.' <img src="'.get_stylesheet_directory_uri().'/img/iconos/icono-chevron-down.png" alt="down" height="8" width="8" /></h6></a>';
                                    $r .= $descargas;
                                }
                            }
                        } else {
                            $r .= descargas_term($term);
                        }     
                    }   

                }

                $r .= descargas_term( false );

            $r .= '</div>';
        
    }



    $r = '<div class="descargas">'.$r.'</div>';

    return do_shortcode($r);
}
add_shortcode( 'descargas', 'shortcode_descargas' );

// function title_filter( $where, &$wp_query ){
//     global $wpdb;
//     if ( $search_term = $wp_query->get( 'pro_search' ) ) {
//         $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
//     }
//     return $where;
// }

// PRO
function shortcode_descargas_publicas() {
    $r = '';

    $args = array(
        'post_type'     => 'dlm_download',
        'posts_per_page'  => -1,
        'fields'            => 'ids',
        'meta_query' => [
                            [
                                'key' => '_members_only',
                                'value'    => 'yes',
                                'compare' => '!='
                            ]
                        ],
    );

    $ids_descargas = get_posts($args);
    // $r .= '[email-download download_id="'.implode(',', $ids_descargas).'" contact_form_id="'.ID_FORMULARIO_DESCARGA.'"]';
    $r .= '[downloads include="'.implode(',', $ids_descargas).'"]';
    foreach ($ids_descargas as $id) {
        $r .= '<br>' . get_the_title( $id ) . ' - ' . $id;
        $versiones = get_posts( array('posts_per_page' => -1, 'post_type' => 'dlm_download_version', 'post_parent' => $id ) );
        foreach ($versiones as $v ) {
            $files = get_post_meta( $v->ID, '_files' );
            $r .= '<br><small>'.get_the_title($v->ID).' - ' . $v->ID . ' - '.implode(', ', $files).'</small>';
        }
    }
    // $r .= implode(',', $ids_descargas);
    $r = '<div class="descargas">'.$r.'</div>';

    // if (current_user_can( 'manage_options' )) {
    //     return do_shortcode($r);
    // }

    // return $r;
    return '';
}
add_shortcode( 'descargas_publicas', 'shortcode_descargas_publicas' );


// add_action( 'wp_head', 'remove_actions', 1000 );
// function remove_actions() {
    remove_action( 'the_content', 'wrap_content' );
// }

function kyrya_contacto() {
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/template-contacto.php'
    ));
    if (!empty($pages)) {
        $page = $pages[0];
        $contacto = get_field('informacion_de_contacto', $page->ID);
        return '<p><i class="fa fa-map-marker fa-3x"></i></p>' . $contacto;
    }
    return false;
}
add_shortcode( 'contacto', 'kyrya_contacto' );

function paginas_hijas() {
    global $post;
    if ( is_post_type_hierarchical( $post->post_type ) /*&& '' == $post->post_content */) {
        $args = array(
            'post_type'         => array($post->post_type),
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'orderby'           => 'menu_order',
            'order'             => 'ASC',
            'post_parent'       => $post->ID,
        );

        if(!is_user_logged_in()) {
            $args['meta_key'] = '_wpmem_block';
            $args['meta_compare'] = 'NOT EXISTS';
        }

        $r = '';
        $query = new WP_Query($args);
        if ($query->have_posts() ) {
            $r .= '<div class="contenido-adicional mt-3">';
            // $r .= '<h3>'.__( 'Contenido en', 'sumun' ).' "'.$post->post_title.'"</h3>';
            while($query->have_posts() ) {
                $query->the_post();
                // if(current_user_can('manage_options')) {
                //     echo '<pre>'; print_r(get_post_meta( get_the_ID() )); echo '</pre>';
                // }
                $r .= '<a class="pagina-hija mr-2 mb-2 btn btn-primary" href="'.get_permalink( get_the_ID() ).'" title="'.get_the_title().'">'.get_the_title().'</a>';
            }
            $r .= '</div>';
        }
        wp_reset_postdata();
        return $r;
    }
}
add_shortcode( 'paginas_hijas', 'paginas_hijas' );

function link_contacto($obj = null) {
    $url = get_permalink( CONTACTO_ID );
    if ( is_a($obj, 'WP_Term') ) {
        $tax_obj = get_taxonomy( $obj->taxonomy );
        $url = add_query_arg( array(
                'kt'     => $tax_obj->labels->singular_name,
                'kid'    => $obj->term_id,
                'kn'     => $obj->name,
            ), $url);
    } elseif ( is_a($obj, 'WP_Post') ) {
        $pt_obj = get_post_type_object( $obj->post_type );
        $url = add_query_arg( array(
                'kt'     => $pt_obj->labels->singular_name,
                'kid'    => $obj->ID,
                'kn'     => $obj->post_title,
            ), $url);
    }
    $r = '<div class="link-contacto"><a class="btn btn-secondary mb-1 mr-1" href="'.$url.'" target="_blank">'.__( 'Solicitar información', 'kyrya' ).'</a></div>';
    echo $r;
}


function kyrya_botones_acabados() {

    $link_acabados = get_the_permalink( ACABADOS_ID );
    $colecciones = wp_get_post_terms( get_the_ID(), 'coleccion' );
    if (!empty($colecciones)) {
        $coleccion = $colecciones[0];
        $disponible_solo_en_acabados = get_field('disponible_solo_en_acabados', $coleccion);
        if (!empty($disponible_solo_en_acabados)) $link_acabados = add_query_arg('ac', implode(',', $disponible_solo_en_acabados), $link_acabados );
    }

    $r = '<div class="mt-10">';
    if ('acabado' != get_post_meta( get_the_ID(), 'archivo', true) && !is_tax('categoria_acabado') ) $r .= '<a class="btn btn-primary mb-1 mr-1 d-inline-block" href="'. $link_acabados.'" target="_blank" title="'. __( 'Ver todos nuestros acabados', 'kyrya' ).'">'. __( 'Ver todos nuestros acabados', 'kyrya' ).'</a>';
    if ('apertura' != get_post_meta( get_the_ID(), 'archivo', true) && !is_tax('categoria_apertura') ) $r .= '<a class="btn btn-primary mb-1 d-inline-block" href="'. get_the_permalink( APERTURAS_ID ).'" target="_blank" title="'. __( 'Ver todos nuestros sistemas de apertura', 'kyrya' ).'">'. __( 'Ver todos nuestros sistemas de apertura', 'kyrya' ).'</a>';
    $r .= '</div>';
    return $r;
}


function opciones_de_producto( $opciones = array() ) {
    $r = '';

    if ( $opciones && !is_array( $opciones ) ) {
        $opciones = array( $opciones );
    }   
    
    if (!empty($opciones)) {
        $r .= '<div class="opciones-producto">';

        foreach ( $opciones as $original_opcion_id ) {

            $opcion_id = apply_filters( 'wpml_object_id', $original_opcion_id, 'opcion_producto', TRUE, ICL_LANGUAGE_CODE );

            $r .= '<div class="opcion-producto">';
                if (has_post_thumbnail($original_opcion_id)) {
                    $r .= get_the_post_thumbnail( $original_opcion_id, 'post-thumbnail', array( 'title' => get_the_title( $opcion_id ) ) );
                } else {
                    $placeholder_id = 30;
                    $r .= wp_get_attachment_image( $placeholder_id, 'thumbnail', false, array( 'title' => get_the_title( $opcion_id ) ) );
                }

                $r .= '<div class="titulo-opcion">'.get_the_title( $opcion_id ).'</div>';
            
            $r .= '</div>';
        }
    
        $r .= '</div>';
   }

    echo $r;
}

function es_composicion( $pt = '' ) {
    if ( 'composicion' == $pt || 'integrated_space' == $pt || 'solution_space' == $pt ) return true;
    return false;
}
function es_producto( $pt = '' ) {
    if ( 'producto' == $pt || 'acabado' == $pt || 'apertura' == $pt || 'opcion_producto' == $pt ) return true;
    return false;
}
function acabados($ids, $post_id = 0) {
    $r = '';

    if ($ids) {

        // $default_lang = apply_filters('wpml_default_language', NULL );

        $r .= '<hr>';
        $r .= '<h6>' . __( 'Acabados', 'kyrya' ) . ':</h6>';
        $r .= '<div class="acabados">';
        foreach ($ids as $id ) {
            $item_pt = get_post_type($id);
            $titulo = '';
            $descripcion = '';
            if ('acabado' == $item_pt) {
                // $titulo = get_post_field('post_excerpt', $id);
                // $id = apply_filters( 'wpml_object_id', $id, 'acabado', TRUE, $default_lang );
                $titulo = get_the_title( $id );
                $descripcion = '';
            } elseif ('apertura' == $item_pt) {
                $tipo_apertura = wp_get_post_terms( $id, 'tipo_apertura', array('fields' => 'names') );
                if (!empty($tipo_apertura)) {
                    $titulo = implode(', ', $tipo_apertura);
                }
                $descripcion = get_the_title($id);
            } else {
                $titulo = get_the_title($id);
                $descripcion = get_post_field('post_excerpt', $id);
            }

            $r .= '<div class="acabado-li"><a href="'.get_permalink( $id ).'" target="_blank">'.get_the_post_thumbnail( $id, 'thumbnail', array('class' => 'thumb-acabado') ).'</a><br>'.$titulo;
            if ('' != $descripcion ) $r .= '<br><span class="small">'.$descripcion.'</span>';
            $r .= '</div>';
        }
        $r .= '</div>';
    }

    // $pt = get_post_type( $post_id );


    // $ocultar_texto_acabados = false;
    // $taxes = get_post_taxonomies( $post_id );
    // $term = false;
    // if ($taxes) {
    //     $tax = $taxes[0];
    //     $terms = wp_get_post_terms( $post_id, $tax );
    // }
    // if (!empty($terms)) $ocultar_texto_acabados = get_field('ocultar_texto_acabados', kyrya_default_language_term( $terms[0] ) );

    // if ( ( es_composicion($pt) || 'producto' == $pt ) && ( 1 != $ocultar_texto_acabados) ) {
    //     $r .= '<p class="mt-5 small">'.__( 'Puede personalizar este elemento con cualquiera de nuestros acabados y sistemas de apertura (con algunas excepciones - consultar en su distribuidor)', 'kyrya' ).'</p>';
    //     $r .= kyrya_botones_acabados();
    // }

    echo $r;
}

function descargas_asociadas($ids, $post_id_id = 0) {

    return false;
    
    $r = '';
    if ($ids && !empty($ids)) {
        if (is_array($ids)) $ids = implode(',', $ids);
        $r .= '<h6 class="mb-0 mt-3">'.__( 'Descargas', 'kyrya' ).'</h6>';
        $wpmem_options = get_option( 'wpmembers_settings' );
        // print_r($wpmem_options);
        $regpageid = $wpmem_options['user_pages']['register'];
        $loginpageid = $wpmem_options['user_pages']['login'];

        $regpageid = apply_filters( 'wpml_object_id', $regpageid, 'page' );
        $loginpageid = apply_filters( 'wpml_object_id', $loginpageid, 'page' );

        if (is_user_logged_in()) {
            $r .= '[downloads orderby="download_count" order="DESC" include="'. $ids .'"]';
        } else {
            $r .= '<p><small>('.__( 'Sólo para usuarios registrados', 'kyrya' ).')</small></p>';
            // $r .= '<a href="'.get_the_permalink( $regpageid ).'" class="mr-2 mb-2 btn btn-primary" title="'.get_the_title( $regpageid ).'" target="_blank">'.get_the_title( $regpageid ).'</a>';
            $r .= '<a href="'.get_the_permalink( $loginpageid ).'" class="mr-2 mb-2 btn btn-primary" title="'.get_the_title( $loginpageid ).'" target="_blank">'.get_the_title( $loginpageid ).'</a>';
        }
    }
    echo do_shortcode($r);
}
function get_tax_navigation( $taxonomy = 'category', $direction = '' ) {
    // Make sure we are on a taxonomy term/category/tag archive page, if not, bail
    if ( 'category' === $taxonomy ) {
        if ( !is_category() )
            return false;
    } elseif ( 'post_tag' === $taxonomy ) {
        if ( !is_tag() )
            return false;
    } else {
        if ( !is_tax( $taxonomy ) )
            return false;
    }

    // Make sure the taxonomy is valid and sanitize the taxonomy
    if (    'category' !== $taxonomy 
         || 'post_tag' !== $taxonomy
    ) {
        $taxonomy = filter_var( $taxonomy, FILTER_SANITIZE_STRING );
        if ( !$taxonomy )
            return false;

        if ( !taxonomy_exists( $taxonomy ) )
            return false;
    }

    // Get the current term object
    $current_term = get_term( $GLOBALS['wp_the_query']->get_queried_object() );

    // Get all the terms ordered by slug 
    $terms = get_terms( $taxonomy, ['parent' => $current_term->parent /*'orderby' => 'slug'*/] );

    // Make sure we have terms before we continue
    if ( !$terms ) 
        return false;

    // Because empty terms stuffs around with array keys, lets reset them
    $terms = array_values( $terms );

    // Lets get all the term id's from the array of term objects
    $term_ids = wp_list_pluck( $terms, 'term_id' );

    /**
     * We now need to locate the position of the current term amongs the $term_ids array. \
     * This way, we can now know which terms are adjacent to the current one
     */
    $current_term_position = array_search( $current_term->term_id, $term_ids );

    // Set default variables to hold the next and previous terms
    $previous_term = '';
    $next_term     = '';

    // Get the previous term
    if (    'previous' === $direction 
         || !$direction
    ) {
        if ( 0 === $current_term_position ) {
            // $previous_term = $terms[intval( count( $term_ids ) - 1 )];
        } elseif ($current_term_position > 0) {
            $previous_term = $terms[$current_term_position - 1];
        }
    }

    // Get the next term
    if (    'next' === $direction
         || !$direction
    ) {
        if ( intval( count( $term_ids ) - 1 ) === $current_term_position ) {
            // $next_term = $terms[0];
        } else {
            if (isset($terms[$current_term_position + 1])) {
                $next_term = $terms[$current_term_position + 1];
            }
        }
    }

    $link = [];
    // Build the links
    if ( $previous_term ) 
        $link[] = '<a class="btn btn-secondary" href="' . esc_url( get_term_link( $previous_term ) ) . '">< ' . $previous_term->name . '</a>';

    if ( $next_term ) 
        $link[] = '<a class="btn btn-secondary" href="' . esc_url( get_term_link( $next_term ) ) . '">' . $next_term->name . ' ></a>';

    return '<div class="tax-navigation text-center mt-2 mb-1">' . implode( ' ', $link ) . '</div>';
}


// add_action( 'admin_init', 'borrar_posts', 10 );
function borrar_posts() {
    for ($i = 1589; $i<=1671; $i++) {
        wp_delete_post( $i, true );
    }
}

// SELECTOR DE IDIOMA
function kyrya_language_selector(){
    $languages = icl_get_languages('skip_missing=0');
    if(count($languages) > 1 ){
        echo '<div class="wpml-ls wpml-ls-legacy-list-horizontal"><ul>';
        foreach($languages as $l){
            $active_class = ( $l['active'] ) ? 'wpml-ls-item-active' : '';
            echo '<li class="wpml-ls-slot-footer wpml-ls-item '.$active_class.'">';
            if(!$l['active']) echo '<a href="'.$l['url'].'">';
            // echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
            echo substr( $l['language_code'], 0, 2);
            if(!$l['active']) echo '</a>';
            echo '</li>';
        }
        echo '</ul></div>';
    }
}


add_filter('post-types-order_save-ajax-order', 'sincronizar_menu_order_wpml', 10, 3);
function sincronizar_menu_order_wpml($data, $key, $id) {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    global $wpdb;

    if ( !empty( $languages ) ) {
        foreach( $languages as $l ) {
            $post = get_post($id);
            $id =  apply_filters( 'wpml_object_id', $id, $post->post_type, FALSE, $l['language_code'] );
            $wpdb->update( $wpdb->posts, $data, array('ID' => $id) );
  
        }
    }

    return $data;
}

add_action('tto/update-order', 'sincronizar_term_order_wpml', 20);
function sincronizar_term_order_wpml() {
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
    global $wpdb;

    if ( !empty( $languages ) ) {

        $data               = stripslashes($_POST['order']);
        $unserialised_data  = json_decode($data, TRUE);

        foreach( $languages as $l ) {

            if (is_array($unserialised_data))
            foreach($unserialised_data as $key => $values ) {
                //$key_parent = str_replace("item_", "", $key);
                $items = explode("&", $values);
                unset($item);
                foreach ($items as $item_key => $item_)
                    {
                        $items[$item_key] = trim(str_replace("item[]=", "",$item_));
                    }
                
                if (is_array($items) && count($items) > 0)
                foreach( $items as $item_key => $term_id ) 
                    {
                        $term = get_term($term_id);
                        $term_id =  apply_filters( 'wpml_object_id', $term_id, $term->taxonomy, FALSE, $l['language_code'] );
                        $wpdb->update( $wpdb->terms, array('term_order' => ($item_key + 1)), array('term_id' => $term_id) );
                    } 
            }
  
        }
    }

}


function kyrya_default_language_term($term) {
    global $icl_adjust_id_url_filter_off;
    $orig_flag_value = $icl_adjust_id_url_filter_off;
    $icl_adjust_id_url_filter_off = true;
    $default_lang = apply_filters('wpml_default_language', NULL );
    if (is_a($term, 'WP_Term')) {
        $default_term_id =  apply_filters( 'wpml_object_id', $term->term_id, $term->taxonomy, FALSE, $default_lang );
        $default_term = get_term( $default_term_id );
        $icl_adjust_id_url_filter_off = $orig_flag_value;

        return $default_term;
    }
    return false;

}

// add_action( 'wp_head', 'traducir' );
function traducir() {
    $args = array(
            'post_type'         => 'producto',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );


    $strings_es = array(
            // '1 puerta',
            // '2 puertas',
            // '3 puertas',
            // '4 puertas',
            // 'Puerta',
            // '1 cajón',
            // '2 cajones',
            // '3 cajones',
            // '4 cajones',
            // '1 decorativo',
            // '2 decorativos',
            // '2 decorativo',
            // 'decorativo',
            'fondo mínimo',
            'fondo hasta',
            // 'Bancada',
            // '3 huecos',
            // '2 huecos',
            // '4 huecos',
            // '8 huecos',
            // 'Ejemplo',
            // 'Extrafino',
        );

    $strings_en = array(
            // '1 door',
            // '2 doors',
            // '3 doors',
            // '4 doors',
            // 'Door',
            // '1 drawer',
            // '2 drawers',
            // '3 drawers',
            // '4 drawers',
            // '1 decorative element',
            // '2 decorative elements',
            // '2 decorative elements',
            // 'decorative element',
            'min. depth',
            'depth: up to',
            // 'Bench',
            // '3 gaps',
            // '2 gaps',
            // '4 gaps',
            // '8 gaps',
            // 'Example',
            // 'Extra thin',
        );

    $strings_fr = array(
            // '1 porte',
            // '2 portes',
            // '3 portes',
            // '4 portes',
            // 'Porte',
            // '1 tiroir',
            // '2 tiroirs',
            // '3 tiroirs',
            // '4 tiroirs',
            // '1 niche',
            // '2 niches',
            // '2 niches',
            // 'niche',
            'prof. minimum',
            'profondeur jusqu\'à',
            // 'Module bas',
            // '3 niches',
            // '2 niches',
            // '4 niches',
            // '8 niches',
            // 'Exemple',
            // 'Extrafin',
        );

    $strings_it = array(
            // '1 anta',
            // '2 ante',
            // '3 ante',
            // '4 ante',
            // 'Ante',
            // '1 cassetto',
            // '2 cassetti',
            // '3 cassetti',
            // '4 cassetti',
            // '1 decorativo',
            // '2 decorativos',
            // '2 decorativos',
            // 'decorativo',
            'fondo minimo',
            'fondo fino a',
            // 'Mobile basso',
            // '3 vani',
            // '2 vani',
            // '4 vani',
            // '8 vani',
            // 'Esempio',
            // 'Extrasottile',
        );

    $strings_pt = array(
            // '1 porta',
            // '2 portas',
            // '3 portas',
            // '4 portas',
            // 'Porta',
            // '1 gaveta',
            // '2 gavetas',
            // '3 gavetas',
            // '4 gavetas',
            // '1 espaço',
            // '2 espaços',
            // '2 espaços',
            // 'espaço',
            'fundo minimo',
            'fundo até',
            // 'Móvel',
            // '3 espaços',
            // '2 espaços',
            // '4 espaços',
            // '8 espaços',
            // 'Exemplo',
            // 'Extrafino',
        );

    foreach ($posts as $post) {
        $excerpt = $post->post_content;
        $excerpt_traducido = $excerpt;

        if ('' != $excerpt) {
            switch (ICL_LANGUAGE_CODE) {
                case 'en':
                $strings_traducidas = $strings_en;
                    break;

                case 'fr':
                $strings_traducidas = $strings_fr;
                    break;

                case 'it':
                $strings_traducidas = $strings_it;
                    break;

                case 'pt-pt':
                $strings_traducidas = $strings_pt;
                    break;
                
                default:
                    $strings_traducidas = $strings_es;
                    break;
            }

            for ($i=0; $i < count($strings_es); $i++) { 
                if ( strpos($excerpt_traducido, $strings_es[$i]) !== false ) {
                    // echo $strings_es[$i] . '/' . $strings_traducidas[$i] . '/' . $excerpt_traducido . '<br>';
                    $excerpt_traducido = str_replace($strings_es[$i], $strings_traducidas[$i], $excerpt_traducido);
                    // echo $strings_es[$i] . '/' . $strings_traducidas[$i] . '/' . $excerpt_traducido . '<br>';
                }
            }



            if ($excerpt != $excerpt_traducido) {
                // Actualizar post
                echo $post->post_title . ': ' . $excerpt_traducido . '</br>';
                $updated_post = array(
                        'ID' => $post->ID,
                        'post_content' => $excerpt_traducido,
                    );
                wp_update_post( $updated_post );
            }
        }

    }



    // echo count($posts) . '<br>';
    // echo '<pre>'; print_r($posts); echo '</pre>';
}

// add_action( 'wp_head', 'cambiar_textos_acabados' );
function cambiar_textos_acabados() {
    $args = array(
            'post_type'         => 'acabado',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );



    foreach ($posts as $post) {
        $excerpt = $post->post_excerpt;
        $titulo = $post->post_title;

        if ('' != $excerpt && strlen($excerpt) == 6 && strlen($titulo) != 6) {
            // Actualizar post
            echo $titulo . ': ' . $excerpt . '</br>';
            $updated_post = array(
                    'ID' => $post->ID,
                    'post_title' => $excerpt,
                    'post_excerpt' => $titulo,
                );
            wp_update_post( $updated_post );
        }

    }



    // echo count($posts) . '<br>';
    // echo '<pre>'; print_r($posts); echo '</pre>';
}

// add_action( 'wp_head', 'insertar_postmeta' );
function insertar_postmeta() {
    $args = array(
            'post_type'         => 'producto',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );



    foreach ($posts as $post) {
        $titulo = $post->post_title;
        // update_post_meta( $post->ID, '_wpml_media_featured', 1 );
        $wpml_media_featured = get_post_meta( $post->ID, '_wpml_media_featured', true );
        echo $post->post_type . ' - ' . $titulo . ': ' . $wpml_media_featured . '<br>';
    }
}

// add_action( 'wp_head', 'quitar_imagenes_destacadas' );
function quitar_imagenes_destacadas() {

    $args = array(
            'post_type'         => 'producto',
            'posts_per_page'    => -1,
            'orderby'           => 'title',
            'order'             => 'ASC',
        );

    $posts = get_posts( $args );



    foreach ($posts as $post) {
        if ( ICL_LANGUAGE_CODE != 'es' ) {
            $lang_info = wpml_get_language_information($post->ID);
            $lang = $lang_info['locale'];
            $is_translated = apply_filters( 'wpml_element_has_translations', NULL, $post->ID, $post->post_type );

            $titulo = $post->post_title;
            if ($is_translated) {
                echo $lang . ' - ' . $post->post_type . ' - ' . $is_translated . ' - ' . $titulo . ': '. get_post_thumbnail_id( $post ) . '<br>';
                delete_post_meta( $post->ID, '_thumbnail_id' );
            }
        }
    }
}

function get_primera_imagen_fondo_fallback($term) {
    remove_action( 'pre_get_posts', 'ordenar_alfabeticamente' );
    $primer_el = get_posts( array(
        'posts_per_page'    => 1,
        'post_type'         => 'any',
        'tax_query'         => array(array(
                                'taxonomy'      => $term->taxonomy,
                                'field'         => 'term_id',
                                'terms'         => $term->term_id,
            )),
        ) );
    add_action( 'pre_get_posts', 'ordenar_alfabeticamente' );
    if (!empty($primer_el)) {
        $thumb_url = get_the_post_thumbnail_url( $primer_el[0], 'medium_large' );
        return $thumb_url;
    }
    return false;
}

// add_action( 'wp_footer', 'script_seleccionar_lista_newsletter' );
function script_seleccionar_lista_newsletter() { ?>
    <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            function comprobar_checks() {
                if ( $(".js-cm-form input[type='checkbox']:checked").length == 0) {
                    $(".js-cm-form button[type='submit']").prop("disabled", true);
                } else {
                    $(".js-cm-form button[type='submit']").prop("disabled", false);
                }
            }

            comprobar_checks();

            $(".js-cm-form input[type='checkbox']").click(function() {
                comprobar_checks();
            });

        });
    </script>
<?php }

add_action( 'wp_footer', 'script_prerrellenar_asunto_formulario' );
function script_prerrellenar_asunto_formulario() { 
    if ( is_front_page() || !is_singular() ) return;

    global $post;

    ?>

    <script type="text/javascript">
        jQuery( 'input[name="your-subject"' ).each(function( index ) {
            jQuery(this).val("<?php echo $post->post_title; ?>");
        });
    </script>
<?php }

// add_filter( 'wpseo_breadcrumb_single_link_info', 'modificar_yoast_breadcrumb', 10, 3 );
function modificar_yoast_breadcrumb( $link_info, $index, $crumbs ) {
    echo '<pre>';
        print_r($link_info);
        // print_r($index);
        // print_r($crumbs);
    echo '</pre>';

    $link_info['text'] = $link_info['text'] . ' test';
    return $link_info;
}


add_filter( 'wpseo_breadcrumb_links', 'modificar_yoast_breadcrumb2', 10, 3 );
function modificar_yoast_breadcrumb2( $crumbs ) {

    $nuevas_crumbs = array();

    foreach ($crumbs as $key=>$crumb) {
        if (isset($crumb['ptarchive'])) {
            $args = array(
                    'post_type'     => 'page',
                    'meta_key'      => 'archivo',
                    'meta_value'    => $crumb['ptarchive'],
                    'posts_per_page' => 1,
                    'fields'        => 'ids',
                );
            $paginas = get_posts($args);
            if (isset($paginas[0])) {
                $pagina = $paginas[0];
                $ancestors = get_post_ancestors( $pagina );
                array_reverse($ancestors);
                $ancestors[] = $pagina;
                foreach ($ancestors as $ancestor ) {
                    $nuevas_crumbs[] = array('id' => $ancestor);
                }
                // echo '<pre>';
                //     print_r($pagina);
                // echo '</pre>';
            }
        } else {
            $nuevas_crumbs[] = $crumb;
        }

    }
    return $nuevas_crumbs;
}

// add_action('admin_init', 'actualizar_term_count');
function actualizar_term_count() {
    $update_taxonomy = 'categoria_producto';
    $get_terms_args = array(
            'taxonomy' => $update_taxonomy,
            'fields' => 'ids',
            'hide_empty' => false,
            );

    $update_terms = get_terms($get_terms_args);
    echo '<pre>'; print_r($update_terms); echo '</pre>';
    wp_update_term_count_now($update_terms, $update_taxonomy);    
}

function noticias_home() {

    $args = array(
            'posts_per_page' => 4,
        );

    $q = new WP_Query($args);
    $r = '';

    if ($q->have_posts()) {
        // $r .= '<h3>'.__( 'News', 'kyrya' ).'</h3>';
        $r .= '<div class="row mb-5">';
        while ($q->have_posts()) { $q->the_post();
            $r .= '<div class="col-sm-3 col-6 mb-5 aparecer">';
                $r .= get_the_post_thumbnail( null, 'thumbnail', array('class' => 'mb-3') );
                $r .= '<a href="'.get_the_permalink().'" title="'.get_the_title().'"><h5>' . get_the_title() . '</h5></a>';
                $r .= '<div class="excerpt">' . get_the_excerpt() . '</div>';
            $r .= '</div>';
        }
            $r .= '<div class="col-sm-3">';
                $page_for_posts = get_option( 'page_for_posts' );
                $r .= apply_filters( 'the_content', get_post_field( 'post_content', $page_for_posts ) );
            $r .= '</div>';
        $r .= '</div>';

        // $r .= '<a class="btn btn-primary" href="'.get_the_permalink( $page_for_posts ).'" title="'.get_the_title( $page_for_posts ).'">'.__( 'Ver todo', 'kyrya' ).'</a>';

    }

    wp_reset_postdata();

    return $r;
}

function custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
       // global $post;
    return ' [...]';
}
add_filter('excerpt_more', 'new_excerpt_more');


function slider_destacados( $pt = 'composicion', $q_obj = false, $slider_class = '' ) {
    $args = array(
            'post_type'         => $pt,
            'posts_per_page'    => -1,
            'orderby'           => 'post_title',
            'order'             => 'ASC',
            'meta_key'          => 'destacada',
            'meta_value'        => 1,
        );

    if ($q_obj) {
        $args['tax_query'] = array(array(
                                        'taxonomy'      => $q_obj->taxonomy,
                                        'field'         => 'term_id',
                                        'terms'         => $q_obj->term_id,
                                        'include_children' => false,
                ));
    }

    $destacadas_query = new WP_Query($args);
    // print_r($destacadas_query);

    $r = '';

    if ($destacadas_query->have_posts()) {
        $slider_class .= ($q_obj) ? $q_obj->taxonomy : '';
        $r .= '<div class="slider '. $slider_class . '">';
            $r .= '<div id="slider-principal" class="carousel slide" data-ride="carousel">';
                $r .= '<div class="carousel-inner" role="listbox">';
                $indicators = '';

                while($destacadas_query->have_posts()) {
                    $destacadas_query->the_post();
                    $active_class = ($destacadas_query->current_post == 0) ? ' active' : '';

                    $thumb_url = get_the_post_thumbnail_url( null, 'large' );
                    // $r .= '<div class="carousel-item bg-cover';
                    // $r .= ($destacadas_query->current_post == 0) ? ' active' : '';
                    // $r .= '" style="background-image:url(\'' . $thumb_url . '\')">';
                    //  $r .= '<div class="carousel-caption"><div class="h2"><a href="'. get_the_permalink() .'" title="' . get_the_title() . '" data-toggle="modal" data-target="#modal-ajax-post" class="no-underline modal-link">' . get_the_title() . '</a></div></div>';
                    // $r .= '</div>';
                    $r .= '<div class="carousel-item bg-secondary ' . $active_class . '">';

                    $r .= '<a href="'.get_the_permalink().'" class="modal-link">';
                        $r .= '<div class="carousel-img-container bg-cover"';
                        $r .= ' style="background-image:url(\'' . $thumb_url . '\')">';
                            // $r .= '<div class="carousel-caption"><div class="h2"><a href="'. get_the_permalink() .'" title="' . get_the_title() . '" data-toggle="modal" data-target="#modal-ajax-post" class="no-underline modal-link">' . get_the_title() . '</a></div></div>';
                        $r .= '</div>';
                    $r .= '</a>';
                    $r .= '</div>';

                    $indicators .= '<li data-target="#slider-principal" data-slide-to="'.$destacadas_query->current_post.'" class="'.$active_class.'"></li>';
                }

                $r .= '</div>';

                // $r .= '<!-- Left and right controls -->
                //   <a class="left carousel-control-prev" href="#slider-principal" data-slide="prev">
                //     <span class="glyphicon glyphicon-chevron-left carousel-control-prev-icon"></span>
                //     <span class="sr-only">Previous</span>
                //   </a>
                //   <a class="right carousel-control-next" href="#slider-principal" data-slide="next">
                //     <span class="glyphicon glyphicon-chevron-right carousel-control-next-icon"></span>
                //     <span class="sr-only">Next</span>
                //   </a>';

                  $r .= '<ol class="carousel-indicators">'.$indicators.'</ol>';

                  $r .= '<a class="carousel-control-prev link link--arrowed" href="#slider-principal" data-slide="prev">' . flecha_animada('#fff', 'izquierda') . __( 'Prev', 'kyrya' ) . '</a>';
                  $r .= '<a class="carousel-control-next link link--arrowed" href="#slider-principal" data-slide="next">' . __( 'Next', 'kyrya' ) . flecha_animada('#fff', 'derecha') . '</a>';

            $r .= '</div>';
        $r .= '</div>';

    }
    wp_reset_postdata();


    echo $r;

}

add_shortcode( 'slider_destacados', 'get_slider_destacados' );
function get_slider_destacados() {
    ob_start();
    slider_destacados('composicion', false, 'inspiracion');
    return ob_get_clean();
}

// PRO
function boton_login() {

    $icon_class = 'password';
    if ( is_front_page() ) {
        $icon_class = 'password-blanco text-white';
    }

    return '<a href="'. KYRYA_PRO_URL .'" target="_blank" class="icono '.$icon_class.' no-underline">&nbsp;</a>';

    // if (is_user_logged_in()) {
    //     $icon_class = 'user';
    //     if (is_front_page()) {
    //         $icon_class = 'user-blanco text-white';
    //     }
    //     return '<a href="#" data-toggle="modal" data-target="#modal-ajax-login" class="icono '.$icon_class.' no-underline">'.do_shortcode( '[wpmem_field user_login]' ).'</a>';
    // } else {
    //     $icon_class = 'password';
    //     if (is_front_page()) {
    //         $icon_class = 'password-blanco text-white';
    //     }

    //     return '<a href="'.get_the_permalink( AREA_PROFESIONAL ).'" class="icono '.$icon_class.' no-underline">&nbsp;</a>';
    // }
}


// PRO
// add_action('wp_head', 'modificar_titulos_descargas');
function modificar_titulos_descargas() {
    if (current_user_can( 'manage_options' ) && (1 == get_current_user_id() ) ) {
        $args = array(
                'post_type' => 'dlm_download',
                'posts_per_page'    => -1,
            );

        $posts = get_posts( $args );

        echo count($posts) . '<br>';
        $i = 0;

        foreach ($posts as $post ) {
            $i++;
            $titulo = get_the_title( $post->ID );
            // $nuevo_titulo = str_replace('-', ' ', $titulo);
            // $nuevo_titulo = str_replace('_', ' ', $nuevo_titulo);
            $nuevo_titulo = str_replace('V01 2', '', $titulo);


            if ($titulo != $nuevo_titulo) {

                echo $i . ' - ' . $titulo . ' - ' . $nuevo_titulo . '<br>';

                $nuevo_post = array(
                        'ID' => $post->ID,
                        'post_title' => $nuevo_titulo,
                    );

                $post_id = wp_update_post( $nuevo_post, true );
                if (is_wp_error($post_id)) {
                    $errors = $post_id->get_error_messages();
                    foreach ($errors as $error) {
                        echo $error;
                    }
                }
            }
        }
    }
}

// PRO
add_filter( 'the_title', 'mostrar_descarga_version', 10, 2);
function mostrar_descarga_version( $title, $post_id)  {
    if ('dlm_download_version' != get_post_type( $post_id ) ) return $title;

    $parent_id = wp_get_post_parent_id( $post_id );
    $version = get_post_meta( $post_id, '_version', true );
    return get_the_title( $parent_id ) . ' - ' . $title . ' (v: '.$version.')';
}

function info_basica_privacidad() {
    // global $post;
      $privacidad_page_id = apply_filters( 'wpml_object_id', 111, 'page' );
      $privacidad_page = get_post( $privacidad_page_id );
      // $contenido = apply_filters('the_content', $privacidad_page->post_content);
      $contenido = $privacidad_page->post_content;

        echo '<div class="modal fade modal-privacidad" tabindex="-1" role="dialog" id="modal-privacidad">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">'.$privacidad_page->post_title.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="'.__( 'Cerrar', 'kyrya' ).'">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="mw-800">
                    '.$contenido.'
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary aceptar-politica">'.__( 'Aceptar', 'kyrya' ).'</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.__( 'Cancelar', 'kyrya' ).'</button>
              </div>
            </div>
          </div>
        </div>';

      // echo '<div id="contenido-info-basica-privacidad" style="display:none;"><br><br>' . $contenido . '<br><br></div>';

      ?>
        <script type="text/javascript">
          jQuery(document).ready(function($) {

            var casilla = $('.wpcf7-acceptance input[type="checkbox"][name="aceptacion"], input.wpcf7-acceptance, input[type="checkbox"]#tos');
            var formid = 'vacio';

            $('#wpmem_register input[type="submit"]').prop('disabled', true);
            $('#wpmem_register #tos').siblings('a').removeAttr('onclick').removeAttr('href');

            casilla.change(function() {
                if(this.checked) {
                    $(this).parents('form').find('input[type="submit"]').prop('disabled', true);
                    $(this).prop('checked', false);

                    if( $(this).hasClass('wpcf7-acceptance') || $(this).parents('.wpcf7-acceptance').length) {
                        // alert('es cf7');
                        formid = $(this).parents(".wpcf7").attr('id');
                    } else {
                        // alert('no es cf7');
                        formid = $(this).parents("form").attr('id');
                    }

                    // $('#modal-privacidad').attr('data-form-id', formid);
                    $('#modal-privacidad .aceptar-politica').attr('data-form-id', formid);
                    $('#modal-privacidad').modal('show');
                }
            });

            $('.aceptar-politica').click(function(event) {
                var destformid = $(this).attr('data-form-id');
                var form =  $('#' + destformid);
                if ( form.hasClass('wpcf7') ) {
                    $('#' + destformid + ' .wpcf7-acceptance input[type="checkbox"][name="aceptacion"]').prop('checked', true);
                } else {
                    $('#' + destformid + ' input[type="checkbox"]#tos').prop('checked', true);
                }
                $('#' + destformid + ' input[type="submit"]').prop('disabled', false);
                $('#modal-privacidad').modal('hide');
            });

            // var casilla = $('.wpcf7-acceptance input[type="checkbox"], input.wpcf7-acceptance');
            // var contenido = $('#contenido-info-basica-privacidad').html();
            // var estilos = 'border: 1px solid lightgray; padding: 2rem 4rem; margin: 2rem; background: #f1f1f1;';


            // casilla.parent().parent().append('<div class="info-basica-privacidad" style="display:none;'+estilos+'">'+contenido+'<p><strong><a href="#" class="aceptar-cerrar">[Aceptar y cerrar]</a></strong></p></div>');

            // casilla.change(function() {
            //     if(this.checked) {
            //       $(this).parents(".wpcf7").find(".info-basica-privacidad").show();
            //     } else {
            //       $(this).parents(".wpcf7").find(".info-basica-privacidad").hide();
            //     }
            // });

            // $('.aceptar-cerrar').click(function(event) {
            //   event.preventDefault();
            //   $('.info-basica-privacidad').hide();
            // });
          });
        </script>
      <?php
}
add_action ('wp_footer', 'info_basica_privacidad');

// wpml shortcodes --------------------
 
add_shortcode( 'lang', 'wpml_find_language');
/* ---------------------------------------------------------------------------
 
 * Shortcode [lang code="en"][/lang]
 
 * --------------------------------------------------------------------------- */
function wpml_find_language( $attr, $content = null ){
    extract(shortcode_atts(array(
        'code' => '',
    ), $attr));
     
    $current_language = ICL_LANGUAGE_CODE;
     
    if($current_language == $code){
        $output = do_shortcode($content);
    }else{
        $default_lang = apply_filters('wpml_default_language', NULL );
        $output = "";
    }
         
    return $output;
}

add_filter( 'single_post_title', 'traducir_solo_titulo', 10, 2 );
add_filter( 'the_title', 'traducir_solo_titulo', 10, 2 );
function traducir_solo_titulo( $title, $post ) {
    if (is_object($post)) {
        $post_id = $post->ID;
    } else {
        $post_id = $post;
    }

    $traducciones = get_post_meta( $post_id, 'traduccion_titulo', true );


    // if ( current_user_can('manage_options') ) {
    //     echo '<pre>'; 
    //     if (!$traducciones) echo 'false';
    //     print_r( $traducciones ); 
    //     echo '</pre>';
    // }
    
    if ($traducciones && '' != $traducciones ) {
        $traducciones_array = preg_split('/\r\n|[\r\n]/', $traducciones);
        $traducciones_codes_array = array();
        foreach ($traducciones_array as $trad_item) {
            $temp = explode(':', $trad_item);
            if (count($temp) > 1) {
                $code = trim( $temp[0] );
                if ( $code == 'pt') { $code = 'pt-pt'; }
                $traducciones_codes_array[$code] = trim( $temp[1] );
            }
        }
        if (isset($traducciones_codes_array[ICL_LANGUAGE_CODE])) {
            $title = $traducciones_codes_array[ICL_LANGUAGE_CODE];
        }
    }
    return $title;
}


// Add product slug column after product name
// add_filter('manage_edit-acabado_columns','add_slug_column_heading');
// add_filter('manage_edit-apertura_columns','add_slug_column_heading');
// add_filter('manage_edit-solution_space_columns','add_slug_column_heading');
// add_filter('manage_edit-integrated_space_columns','add_slug_column_heading');
// add_filter('manage_edit-producto_columns','add_slug_column_heading');
// add_filter('manage_edit-composicion_columns','add_slug_column_heading');
// function add_slug_column_heading( $columns ) {
//     $slug_column = array(
//         'product_slug'  => __( 'Slug' ),
//         'croquis'       => __( 'Croquis' )
//     );
//     $columns = array_slice( $columns, 0, 3, true ) + $slug_column + array_slice( $columns, 3, count( $columns ) - 1, true );

//     return $columns;
// }
// Display product slug
// function add_slug_column_value( $column_name, $id ) {
//     switch ($column_name) {
//         case 'product_slug':
//             echo get_post_field( 'post_name', $id, 'raw' );
//             break;
        
//         case 'croquis':
//             $img = get_field('plano', $id);
//             echo '<img src="'.$img['sizes']['medium'].'" height="100" style="max-width:150px;" />';
//             break;
        
//         default:
//             # code...
//             break;
//     }

//     // if ( 'product_slug' == $column_name ) {
//     //     echo get_post_field( 'post_name', $id, 'raw' );
//     // }
// }
// add_action( "manage_acabado_posts_custom_column", 'add_slug_column_value', 10, 2 );
// add_action( "manage_apertura_posts_custom_column", 'add_slug_column_value', 10, 2 );
// add_action( "manage_solution_space_posts_custom_column", 'add_slug_column_value', 10, 2 );
// add_action( "manage_integrated_space_posts_custom_column", 'add_slug_column_value', 10, 2 );
// add_action( "manage_producto_posts_custom_column", 'add_slug_column_value', 10, 2 );
// add_action( "manage_composicion_posts_custom_column", 'add_slug_column_value', 10, 2 );

/*
 * quick_edit_custom_box allows to add HTML in Quick Edit
 * Please note: it files for EACH column, so it is similar to manage_posts_custom_column
 */

// add_action('quick_edit_custom_box',  'misha_quick_edit_fields', 10, 2);
function misha_quick_edit_fields( $column_name, $post_type ) {
 
    // you can check post type as well but is seems not required because your columns are added for specific CPT anyway
 
    switch( $column_name ) :
        case 'traduccion_titulo': {
 
            // you can also print Nonce here, do not do it ouside the switch() because it will be printed many times
            wp_nonce_field( 'misha_q_edit_nonce', 'misha_nonce' );
 
            // please note: the <fieldset> classes could be:
            // inline-edit-col-left, inline-edit-col-center, inline-edit-col-right
            // each class for each column, all columns are float:left,
            // so, if you want a left column, use clear:both element before
            // the best way to use classes here is to look in browser "inspect element" at the other fields
 
            // for the FIRST column only, it opens <fieldset> element, all our fields will be there
            echo '<fieldset class="inline-edit-col-right">
                <div class="inline-edit-col">
                    <div class="inline-edit-group wp-clearfix">';
 
            echo '<label class="">
                    <span class="title">'.__( 'Traducción del título', 'kyrya' ).'</span>
                    <textarea style="height:150px; width:100%;" cols="22" rows="8" name="'.$column_name.'" autocomplete="off"></textarea>
                </label>';

             // for the LAST column only - closing the fieldset element
            echo '</div></div></fieldset>';

            break;
 
        }
        // case 'featured': {
 
        //     echo '<label class="alignleft">
        //             <input type="checkbox" name="featured">
        //             <span class="checkbox-title">Featured product</span>
        //         </label>';
 
        //     // for the LAST column only - closing the fieldset element
        //     echo '</div></div></fieldset>';
 
        //     break;
 
        // }
 
    endswitch;
 
}

/*
 * Quick Edit Save
 */
// add_action( 'save_post', 'misha_quick_edit_save' );
function misha_quick_edit_save( $post_id ){
 
    // check user capabilities
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
 
    // check nonce
    if ( !wp_verify_nonce( $_POST['misha_nonce'], 'misha_q_edit_nonce' ) ) {
        return;
    }
 
    // update the price
    if ( isset( $_POST['traduccion_titulo'] ) ) {
        update_post_meta( $post_id, 'traduccion_titulo', $_POST['traduccion_titulo'] );
    }
 
    // // update checkbox
    // if ( isset( $_POST['featured'] ) ) {
    //     update_post_meta( $post_id, 'product_featured', 'on' );
    // } else {
    //     update_post_meta( $post_id, 'product_featured', '' );
    // }
}

// add_action( 'admin_enqueue_scripts', 'misha_enqueue_quick_edit_population' );
function misha_enqueue_quick_edit_population( $pagehook ) {
 
    // do nothing if we are not on the target pages
    if ( 'edit.php' != $pagehook ) {
        return;
    }
 
    wp_enqueue_script( 'populatequickedit', get_stylesheet_directory_uri() . '/populate.js', array( 'jquery' ) );
 
}

// add_action( 'admin_footer', 'misha_inline_script_quick_edit_population' );
function misha_inline_script_quick_edit_population( $pagehook ) {

    $screen = get_current_screen();
    
    // do nothing if we are not on the target pages
    if ( 'edit' != $screen->parent_base ) {
        return;
    } ?>
 
    <script>

        jQuery(function($){
            // it is a copy of the inline edit function
            var wp_inline_edit_function = inlineEditPost.edit;
         
            // we overwrite the it with our own
            inlineEditPost.edit = function( post_id ) {
         
                // let's merge arguments of the original function
                wp_inline_edit_function.apply( this, arguments );
         
                // get the post ID from the argument
                var id = 0;
                if ( typeof( post_id ) == 'object' ) { // if it is object, get the ID number
                    id = parseInt( this.getId( post_id ) );
                }
         
                //if post id exists
                if ( id > 0 ) {
         
                    // add rows to variables
                    var specific_post_edit_row = $( '#edit-' + id ),
                        specific_post_row = $( '#post-' + id ),
                        traduccion_titulo = $( '.column-traduccion_titulo', specific_post_row ).text();
                        // featured_product = false; // let's say by default checkbox is unchecked
         
                    // check if the Featured Product column says Yes
                    // if( $( '.column-featured', specific_post_row ).text() == 'Yes' ) featured_product = true;
         
                    // populate the inputs with column data
                    $( 'textarea[name="traduccion_titulo"]', specific_post_edit_row ).val( traduccion_titulo );
                    // $( ':input[name="featured"]', specific_post_edit_row ).prop('checked', featured_product );
                }
            }
        });
    </script> 
<?php }



// Quitar algunas páginas del buscador
add_action( 'pre_get_posts', 'sumun_search_filter' );
function sumun_search_filter( $query ) {
    if ( !is_admin() && $query->is_search && $query->is_main_query() ) {
        $query->set( 'post__not_in', array( 12694 ) );
    }
}


add_filter( 'parse_tax_query', function ( $query ) {
    if ( 
        $query->is_main_query()
        && $query->is_tax()
    ) {
        $query->tax_query->queries[0]['include_children'] = 0;
    }
});

function postmeta_variable( $post_meta = array(), $key = '' ) {
    if ( !isset($post_meta[$key]) || !$post_meta[$key] ) return false;
    if (is_serialized( $post_meta[$key][0] )) return unserialize($post_meta[$key][0]);
    return $post_meta[$key][0];
}

/** Incluir categorías en las búsquedas */
function atom_search_where($where){
  global $wpdb;

  if ( is_search() )
    $where .= "OR (t.name LIKE '%".get_search_query() . "%' AND {$wpdb->posts} . post_status = 'publish')";

  return $where;
}

function atom_search_join($join){
  global $wpdb;

  if ( is_search() )
    $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
  return $join;
}

function atom_search_groupby($groupby){
  global $wpdb;

  // we need to group on post ID
  $groupby_id = "{$wpdb->posts} . ID";
  if ( ! is_search() || strpos($groupby, $groupby_id) !== false )
    return $groupby;

  // groupby was empty, use ours
  if ( ! strlen( trim($groupby) ) )
    return $groupby_id;

  // wasn't empty, append ours
  return $groupby . ", " . $groupby_id;
}

add_filter('posts_where', 'atom_search_where');
add_filter('posts_join', 'atom_search_join');
add_filter('posts_groupby', 'atom_search_groupby');
/**/

/*
add_filter( 'cbqe_get_post_types_args', 'quick_edit_post_type_filter', 10 );
function quick_edit_post_type_filter( $args ) {

    $args['_builtin'] = false;
    return $args;
}
*/

// PRO
// add_action( 'wpmem_account_validation_success', 'kyrya_anadir_suscriptor_createsend' );
add_action( 'user_register', 'kyrya_anadir_suscriptor_createsend' );
function kyrya_anadir_suscriptor_createsend( $user_id ) {

    $user_data = get_userdata( $user_id );
    $user_meta = get_user_meta( $user_id );

    // print_r($user_data);
    // print_r($user_meta);

    $email = $user_data->user_email;
    $name = $user_meta['first_name'][0];
    if( isset($user_meta['last_name'][0]) && $user_meta['last_name'][0] ) $name .= ' ' . $user_meta['last_name'][0];
    $CustomFields[] ="";
    $CustomFields[] = array('Key'=>'País', 'Value'=>$user_meta['country'][0] );

    $subscribe = ( $user_meta['newsletter'][0] == 1) ? true : false;


    if($subscribe){

        try {


                $apiKey = '9ab9d43e61d544ee50703b68082332a078ab65d7844e76a2';
                $listId = 'cb5dfdc8ae3b21a9f5d2be59b69e15d3'; // Suscriptores desde el registro Kyrya Pro

                $subscriber = array(
                    'EmailAddress' => $email,
                    'Name' => $name,
                    'CustomFields' => $CustomFields,
                    'Resubscribe' => true,
                    'RestartSubscriptionBasedAutoresponders' => true,
                    'ConsentToTrack' => 'Yes' );

                $url = sprintf('https://api.createsend.com/api/v3.2/subscribers/%s.json', $listId);

                $vc_headers = array(
                                            'headers' => array(
                                                            'Authorization' => 'Basic ' . base64_encode($apiKey . ':x')
                                                                                ),
                                            'body' => wp_json_encode($subscriber)
                                                 );

                $resultsend = wp_remote_post($url, $vc_headers );

                $resultfinal = $resultsend;

                $cme_db_log = new cme_db_log( 'cme_db_issues',  $logfileEnabled,'api',$idform );
                $cme_db_log->cme_log_insert_db(1, 'Subscribe Response: ' , $resultfinal  );

        } catch ( Exception $e ) {

            $cme_db_log = new cme_db_log( 'cme_db_issues' , $logfileEnabled,'api',$idform );
            $cme_db_log->cme_log_insert_db(4, 'Contact Form 7 response: Try Catch  ' . $e->getMessage()  , $e  );

        }  
    }
}

// PRO
function kyrya_pro_search_shortcode() {

    // return false;

    // kyrya_pro_search_scripts();
    $pro_search_value = (isset($_GET['prosearch'])) ? $_GET['prosearch'] : '';

    ob_start(); ?>

    <div class="pro-search-wrapper bg-light">

        <h4><?php echo __( 'Buscador de fichas técnicas', 'kyrya' ); ?></h4>
        <div id="kyrya-pro-search">
            <form action="" method="get">
                <div class="input-group">
                    <input class="field form-control" type="text" name="prosearch" id="prosearch" value="" placeholder="<?php echo __( 'Buscar por código o nombre de producto...', 'kyrya' ); ?>">

                    <span class="input-group-btn">
                        <input class="btn btn-primary" type="submit" id="submit" name="submit" value="<?php echo __( 'Buscar', 'kyrya' ); ?>">
                    </span>
                </div>
            </form>

            <ul id="kyrya-pro-search-results" class="dlm-downloads"></ul>
        </div>

    </div>
     
    <?php
    return ob_get_clean();
}
add_shortcode ('kyrya_pro_search', 'kyrya_pro_search_shortcode');

// PRO
function kyrya_pro_search_scripts() {
    
    wp_enqueue_script( 'kyrya_pro_search', get_stylesheet_directory_uri(). '/js/kyrya-pro-search-script.js', array(), '1.0', true );
    wp_localize_script( 'kyrya_pro_search', 'pro_search_ajax_object', 
        array( 
            'ajax_url' => admin_url('admin-ajax.php') 
        )
    );
}

// PRO
// Ajax Callback
 
// add_action('wp_ajax_kyrya_pro_search', 'ajax_kyrya_pro_search_callback');
// add_action('wp_ajax_nopriv_kyrya_pro_search', 'ajax_kyrya_pro_search_callback');
 
function ajax_kyrya_pro_search_callback() {
 
    header("Content-Type: application/json"); 
 
    // $meta_query = array('relation' => 'AND');
 
    // if(isset($_GET['year'])) {
    //     $year = sanitize_text_field( $_GET['year'] );
    //     $meta_query[] = array(
    //         'key' => 'year',
    //         'value' => $year,
    //         'compare' => '='
    //     );
    // }
 
    // if(isset($_GET['rating'])) {
    //     $rating = sanitize_text_field( $_GET['rating'] );
    //     $meta_query[] = array(
    //         'key' => 'rating',
    //         'value' => $rating,
    //         'compare' => '>='
    //     );
    // }
 
    // if(isset($_GET['language'])) {
    //     $language = sanitize_text_field( $_GET['language'] );
    //     $meta_query[] = array(
    //         'key' => 'language',
    //         'value' => $language,
    //         'compare' => '='
    //     );
    // }
 
    // $tax_query = array();
 
    // if(isset($_GET['genre'])) {
    //     $genre = sanitize_text_field( $_GET['genre'] );
    //     $tax_query[] = array(
    //         'taxonomy' => 'category',
    //         'field' => 'slug',
    //         'terms' => $genre
    //     );
    // }
 
    $args = array(
        'post_type' => 'dlm_download',
        'posts_per_page' => -1,
        // 'meta_query' => $meta_query,
        // 'tax_query' => $tax_query
    );
 
    if(isset($_GET['search'])) {
        $search = sanitize_text_field( $_GET['prosearch'] );
        $args['s'] = $search;

    } else {

    }

    $search_query = new WP_Query( $args );
     
    if ( $search_query->have_posts() ) {
 
        $result = array();
 
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
 
            // $cats = strip_tags( get_the_category_list(", ") );
            $result[] = array(
                "id" => get_the_ID(),
                "title" => get_the_title(),
                "content" => get_the_content(),
                "permalink" => get_permalink(),
            );
        }
        wp_reset_query();
 
        echo json_encode($result);
 
    } else {
        // no posts found
    }
    wp_die();
}

/**
 * Change ACF field to be read-only.
 *
 * @param array $field Field attributes.
 *
 * @return array
 */
function dorzki_acf_read_only_field( $field ) {

  if( in_array( $field['name'], array(
    'referencia',
    'ancho',
    'alto',
    'fondo',
    'ancho_hasta',
    'alto_hasta',
    'fondo_hasta',
  ) ) ) {
    $field['disabled'] = true;  
  }

  return $field;

}

add_filter( 'acf/load_field', 'dorzki_acf_read_only_field' );

function composiciones_ejemplo() {

    if ( !is_tax( 'categoria_producto' ) ) return false;

    $term = get_queried_object();

    $args = array(
        'post_type'         => 'composicion',
        'posts_per_page'    => -1,
        'tax_query'				=> array(
            array(
                'taxonomy'		=> 'categoria_producto',
                'terms'			=> $term->term_id,
            ),
        ),
        'posts_per_page'		=> -1,
        'orderby'				=> 'title',
        'oreder'				=> 'ASC',
    );

    $q = new WP_Query($args);

    if ( $q->have_posts() ) : ?>

        <h2><?php echo __( 'Ejemplos de composiciones', 'kyrya' ); ?></h2>

        <div class="row no-gutters mb-5 pb-5 bloques">

            <?php while ( $q->have_posts() ) : $q->the_post(); ?>

                <?php get_template_part( 'loop-templates/content' ); ?>

            <?php endwhile; ?>

        </div>

    <?php endif;

}

add_filter( 'term_link', 'modificar_destino_term_link', 10, 3 );
function modificar_destino_term_link( $url, $term, $taxonomy ) {

    if ( 'categoria_producto' === $taxonomy ) {

        $pagina_id = get_field( 'redireccion', $term );
        
        if ( !empty( $pagina_id ) ) {

            $nueva_url = get_permalink( $pagina_id );
            if ( $nueva_url ) {
                return $nueva_url; // Devuelve la nueva URL si es válida
            }
        }
    }
    
    return $url;
}

