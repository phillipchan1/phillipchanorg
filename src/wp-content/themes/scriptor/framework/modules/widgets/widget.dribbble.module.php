<?php

/**
 * ThemePileDribble Class
 */

class ThemePileDribble {

	function __construct() {
		add_shortcode( 'themepile_dribbble', array( &$this, 'shortcode' ) );
		add_action( 'widgets_init', create_function( '', 'register_widget("ThemePile_Dribbble");' ) );
	}

	function shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'player' => '',
					'shots'  => 5
				),
				$atts
			)
		);

		return $this->do_themepile_dribbbler( esc_attr( $player ), esc_attr( $shots ) );
	}

	function do_themepile_dribbbler( $player, $shots ) {
		// check for cached version
		$key         = 'themepiledribbbler_' . $player;
		$shots_cache = get_transient( $key );

		if ( $shots_cache === false ) {
			$url      = 'http://api.dribbble.com/players/' . $player . '/shots/?per_page=15';
			$response = wp_remote_get( $url );

			if ( is_wp_error( $response ) ) {
				return;
			}

			$xml = wp_remote_retrieve_body( $response );

			if ( is_wp_error( $xml ) ) {
				return;
			}

			if ( $response['headers']['status'] == 200 ) {

				$json           = json_decode( $xml );
				$dribbble_shots = $json->shots;

				set_transient( $key, $dribbble_shots, 60 * 5 );
			}
		}
		else {
			$dribbble_shots = $shots_cache;
		}

		if ( $dribbble_shots ) {
			$i      = 0;
			$output = '<ul class="widget_themepile_dribbbler">';

			foreach ( $dribbble_shots as $dribbble_shot ) {
				if ( $i == $shots ) {
					break;
				}

				$output .= '<li>';
				$output .= '<a href="' . $dribbble_shot->url . '">';
				$output .= '<img height="' . $dribbble_shot->height . '" width="' . $dribbble_shots[$i]->width . '" src="' . $dribbble_shot->image_url . '" alt="' . $dribbble_shot->title . '" />';
				$output .= '</a>';
				$output .= '</li>';

				$i ++;
			}

			$output .= '</ul>';
		}
		else {
			$output = '<em>' . __( 'Error retrieving Dribbble shots', THEMEPILE_LANGUAGE ) . '</em>';
		}

		return $output;
	}
}

global $themepile_dribbble;
$themepile_dribbble = new ThemePileDribble();


/**
 * Widget
 */

class ThemePile_Dribbble extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'description' => __(
				'Use this widget to display your latest Dribbble shots.',
				THEMEPILE_LANGUAGE
			)
		);
		parent::__construct(
			'themepile_dribbbler',
			__( 'ThemePile Dribbble Widget', THEMEPILE_LANGUAGE ),
			$widget_ops
		);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title  = apply_filters( 'widget_title', $instance['title'] );
		$player = $instance['player'];
		$shots  = $instance['shots'];

		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		global $themepile_dribbble;
		echo $themepile_dribbble->do_themepile_dribbbler( $player, $shots );

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['description'] = strip_tags( $new_instance['description'], '<a><b><strong><i><em>' );
		$instance['player']      = trim( $new_instance['player'] );
		$instance['shots']       = trim( $new_instance['shots'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'       => '',
			'description' => '',
			'player'      => 'sergeyshapiro',
			'shots'       => 3
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title  = $instance['title'];
		$desc   = $instance['description'];
		$player = $instance['player'];
		$shots  = $instance['shots'];

		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e(
					'Title:',
					THEMEPILE_LANGUAGE
				); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
						 name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
						 value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label
					for="<?php echo $this->get_field_id( 'player' ); ?>"><?php _e(
					'Dribbble player:',
					THEMEPILE_LANGUAGE
				); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'player' ); ?>"
						 name="<?php echo $this->get_field_name( 'player' ); ?>" type="text" value="<?php echo $player; ?>" />
		</p>
		<p>
			<label
					for="<?php echo $this->get_field_id( 'shots' ); ?>"><?php _e(
					'Number of shots to display:',
					THEMEPILE_LANGUAGE
				); ?></label>
			<select name="<?php echo $this->get_field_name( 'shots' ); ?>">
				<?php for ( $i = 1; $i <= 15; $i ++ ) { ?>
					<option value="<?php echo $i; ?>" <?php selected( $i, $shots ); ?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>

	<?php
	}
}
