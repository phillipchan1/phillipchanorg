<?php



/**
 * ThemePileFlickr Class
 */

class ThemePileFlickr {
	function __construct() {
		add_action( 'widgets_init', create_function( '', 'register_widget("ThemePile_Flickr_Widget");' ) );
	}
}

global $themepile_flickr;
$themepile_flickr = new ThemePileFlickr();

class ThemePile_Flickr_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => __( 'A widget that displays your Flickr photos.', THEMEPILE_LANGUAGE ) );
		parent::__construct( 'themepile_flickr', __( 'ThemePile Flickr Widget', THEMEPILE_LANGUAGE ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings ---------------------------------------*/
		$title     = apply_filters( 'widget_title', $instance['title'] );
		$flickrID  = $instance['flickrID'];
		$postcount = $instance['postcount'];
		$type      = $instance['type'];
		$display   = $instance['display'];

		/* Build our output -------------------------------------------------------------*/
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		?>

		<div class="widget_themepile_flickr-wrapper">
			<script type="text/javascript"
							src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
		</div>

		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs) ------------------------*/
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );

		/* No need to strip tags --------------------------------------------------------*/
		$instance['postcount'] = $new_instance['postcount'];
		$instance['type']      = $new_instance['type'];
		$instance['display']   = $new_instance['display'];

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings ------------------------------------------*/
		$defaults = array(
			'title'     => __( 'ThemePile Twitter Widget', THEMEPILE_LANGUAGE ),
			'flickrID'  => '10133335@N08',
			'postcount' => '6',
			'type'      => 'user',
			'display'   => 'latest',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		/* Build our form fields -------------------------------------------------------*/
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e(
					'Title:',
					THEMEPILE_LANGUAGE
				) ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>"
						 name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e(
					'Flickr ID:',
					THEMEPILE_LANGUAGE
				) ?>
				(<a href="http://idgettr.com/">idGettr</a>)</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'flickrID' ); ?>"
						 name="<?php echo $this->get_field_name( 'flickrID' ); ?>"
						 value="<?php echo $instance['flickrID']; ?>" />
		</p>

		<p>
			<label
					for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e(
					'Number of Photos:',
					THEMEPILE_LANGUAGE
				) ?></label>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>"
							name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
				<option <?php if ( '1' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>1
				</option>
				<option <?php if ( '2' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>2
				</option>
				<option <?php if ( '3' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>3
				</option>
				<option <?php if ( '4' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>4
				</option>
				<option <?php if ( '5' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>5
				</option>
				<option <?php if ( '6' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>6
				</option>
				<option <?php if ( '7' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>7
				</option>
				<option <?php if ( '8' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>8
				</option>
				<option <?php if ( '9' == $instance['postcount'] ) {
					echo 'selected="selected"';
				} ?>>9
				</option>
			</select>
		</p>

		<p>
			<label
					for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e(
					'Type (user or group):',
					THEMEPILE_LANGUAGE
				) ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name(
				'type'
			); ?>"
							class="widefat">
				<option <?php if ( 'user' == $instance['type'] ) {
					echo 'selected="selected"';
				} ?>>user
				</option>
				<option <?php if ( 'group' == $instance['type'] ) {
					echo 'selected="selected"';
				} ?>>group
				</option>
			</select>
		</p>

		<p>
			<label
					for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e(
					'Display (random or latest):',
					THEMEPILE_LANGUAGE
				) ?></label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>"
							name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option <?php if ( 'random' == $instance['display'] ) {
					echo 'selected="selected"';
				} ?>>random
				</option>
				<option <?php if ( 'latest' == $instance['display'] ) {
					echo 'selected="selected"';
				} ?>>latest
				</option>
			</select>
		</p>

	<?php
	}
}

?>