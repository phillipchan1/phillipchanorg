<?php
/*-----------------------------------------------------------------------------------*/
/* Social Count
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'load_okay_social_widget' );

function load_okay_social_widget() {
	register_widget( 'okay_social' );
}

class okay_social extends WP_Widget {

	function okay_social() {
	$widget_ops = array( 'classname' => 'ok-social', 'description' => __('Okay Social Count Widget', 'ok-social') );
	$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ok-social' );
	$this->WP_Widget( 'ok-social', __('Okay Social Count Widget', 'ok-social'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );
//		echo '<pre>'.print_r($args,true).'</pre>';
		$twitter_user = $instance['twitter_user'];
		$facebook_user = $instance['facebook_user'];
		$dribbble_user = $instance['dribbble_user'];

		echo $before_widget;
?>

		<div class="social-count">
			<?php if ( $twitter_user ) { ?>
				<div class="twitter-count count-box">
					<div class="count-text">
						<?php
							$trans_name = substr( "twitter-{$twitter_user}-{$widget_id}", 0, 45 );
							$twitter_count = get_transient( $trans_name ); //$widget_id extracted from $args above
							if ( ! $twitter_count ) {
								$url = "http://twitter.com/users/show/".$twitter_user;
								$response = @file_get_contents( $url );
								$t_profile = new SimpleXMLElement ( $response );
								$twitter_count = intval( $t_profile->followers_count );
								set_transient( $trans_name, $twitter_count, 60*15 ); //15 minutes
							}

							echo $twitter_count;
						?>
					</div>
					<div class="follow-text">
						<a target="blank" href="http://twitter.com/<?php echo $instance['twitter_user']; ?>"><?php _e('Follow on Twitter','okay'); ?></a>
					</div>
				</div>
			<?php } ?>

			<?php if ( $dribbble_user ) { ?>
				<div class="dribbble-count count-box">
					<div class="count-text">
						<?php
							$trans_name = substr( "dribbble-{$dribbble_user}-{$widget_id}", 0, 45 );
							$dribbble_count = get_transient( $trans_name ); //$widget_id extracted from $args above
							if ( ! $dribbble_count ) {
								$page_id = $dribbble_user;
								$query = "http://api.dribbble.com/$page_id";
								$content = json_decode(@file_get_contents($query));
								$dribbble_count = intval( $content -> followers_count );
								set_transient( $trans_name, $dribbble_count, 60*15 ); //15 minutes
							}

							echo $dribbble_count;
						?>
					</div>
					<div class="follow-text">
						<a target="blank" href="http://dribbble.com/<?php echo $instance['dribbble_user']; ?>"><?php _e('Follow on Dribbble','okay'); ?></a>
					</div>
				</div>
			<?php } ?>

			<?php if ( $facebook_user ) { ?>
				<div class="facebook-count count-box">
					<div class="count-text">
						<?php

							function fb_count($value='') { $url='http://api.facebook.com/method/fql.query?query=SELECT fan_count FROM page WHERE';
								if(is_numeric($value)) { $qry=' page_id="'.$value.'"';} //If value is a page ID
								else {$qry=' username="'.$value.'"';} //If value is not a ID.
								$xml = @simplexml_load_file($url.$qry) or die ("invalid operation");
								$fb_count = $xml->page->fan_count;
								return $fb_count;
							}

							$trans_name = substr( "facebook-{$facebook_user}-{$widget_id}", 0, 45 );
							$facebook_count = get_transient( $trans_name ); //$widget_id extracted from $args above
							if ( ! $facebook_count ) {
								$facebook_count = intval( fb_count($facebook_user) );
								set_transient( $trans_name, $facebook_count, 60*15 ); //15 minutes
							}

							echo $facebook_count;
					?>
					</div>
					<div class="follow-text">
						<a target="blank" href="http://facebook.com/<?php echo $instance['facebook_user']; ?>"><?php _e('Fans on Facebook','okay'); ?></a>
					</div>
				</div>
			<?php } ?>
		</div>


<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['twitter_user'] = $new_instance['twitter_user'];
		$instance['facebook_user'] = $new_instance['facebook_user'];
		$instance['dribbble_user'] = $new_instance['dribbble_user'];
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array)

		$instance, array( 'title' => '', 'twitter_user' => '', 'facebook_user' => '', 'dribbble_user' => '', 'rss_feed' => '' ) );

		$instance['twitter_user'] = $instance['twitter_user'];
		$instance['facebook_user'] = $instance['facebook_user'];
		$instance['dribbble_user'] = $instance['dribbble_user'];
		$instance['rss_feed'] = $instance['rss_feed'];
?>
			<p>
				<label for="<?php echo $this->get_field_id('twitter user'); ?>"><?php _e('Twitter Username','okay'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('twitter_user'); ?>" name="<?php echo $this->get_field_name('twitter_user'); ?>" type="text" value="<?php echo $instance['twitter_user']; ?>" /></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('facebook_user'); ?>"><?php _e('Facebook Username','okay'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('facebook_user'); ?>" name="<?php echo $this->get_field_name('facebook_user'); ?>" type="text" value="<?php echo $instance['facebook_user']; ?>" /></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('dribbble_user'); ?>"><?php _e('Dribbble Username','okay'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('dribbble_user'); ?>" name="<?php echo $this->get_field_name('dribbble_user'); ?>" type="text" value="<?php echo $instance['dribbble_user']; ?>" /></label>
			</p>
<?php
}
}
?>
