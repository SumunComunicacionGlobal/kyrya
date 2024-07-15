<?php
/**
* Adds .Bloque Destacado widget
*/
class Bloquedestacado_Widget extends WP_Widget {

	/**
	* Register widget with WordPress
	*/
	function __construct() {
		parent::__construct(
			'bloquedestacado_widget', // Base ID
			esc_html__( '.Bloque Destacado', 'kyrya-admin' ), // Name
			array( 'description' => esc_html__( 'Inserta contenido en forma de bloque, especial para el área de Home Destacado', 'kyrya-admin' ), ) // Args
		);
	}

	/**
	* Widget Fields
	*/
	private $widget_fields = array(
		array(
			'label' => 'ID de la página (o dejar vacío si no es una página)',
			'id' => 'id_pagina',
			'type' => 'number',
		),
		array(
			'label' => 'Enlace (dejar en blanco si has rellenado el campo anterior)',
			'id' => 'enlace',
			'type' => 'url',
		),
		array(
			'label' => 'Abrir enlace en nueva pestaña',
			'id' => 'nueva_pestana',
			'type' => 'checkbox',
		),
	);

	/**
	* Front-end display of widget
	*/
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		// Output widget title
		// if ( ! empty( $instance['title'] ) ) {
		// 	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		// }

		// Output generated fields
		// echo '<p>'.$instance['id_pagina'].'</p>';
		// echo '<p>'.$instance['enlace'].'</p>';
		// echo '<p>'.$instance['nueva_pestana'].'</p>';
		// echo '<pre>'; print_r($instance); print_r($args); echo '</pre>';

		// print_r($args);
        $translated_id =  apply_filters( 'wpml_object_id', $instance['id_pagina'], 'page', FALSE, ICL_LANGUAGE_CODE );
        $link_externo = $instance['enlace'];
        $target = $instance['nueva_pestana'];

		$term = get_post($translated_id);
		$col_class = 'col';
		if ($args['id'] == 'home-destacado-1' || $args['id'] == 'home-destacado-2' ) {
			include( locate_template ( 'loop-templates/content-term.php' ) );
		} else {
			include( locate_template ( 'loop-templates/content-term-half.php' ) );
		}
		echo $args['after_widget'];
	}

	/**
	* Back-end widget fields
	*/
	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : esc_html__( $widget_field['default'], 'kyrya' );
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$output .= '<p>';
					$output .= '<input class="checkbox" type="checkbox" '.checked( $widget_value, true, false ).' id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" value="1">';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'kyrya' ).'</label>';
					$output .= '</p>';
					break;
				default:
					$output .= '<p>';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'], 'kyrya' ).':</label> ';
					$output .= '<input class="widefat" id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" type="'.$widget_field['type'].'" value="'.esc_attr( $widget_value ).'">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'kyrya' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'kyrya' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		

		<?php
		$this->field_generator( $instance );
	}

	/**
	* Sanitize widget form values as they are saved
	*/
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$instance[$widget_field['id']] = $_POST[$this->get_field_id( $widget_field['id'] )];
					break;
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
		return $instance;
	}
} // class Bloquedestacado_Widget

// register .Bloque Destacado widget
function register_bloquedestacado_widget() {
	register_widget( 'Bloquedestacado_Widget' );
}
add_action( 'widgets_init', 'register_bloquedestacado_widget' );