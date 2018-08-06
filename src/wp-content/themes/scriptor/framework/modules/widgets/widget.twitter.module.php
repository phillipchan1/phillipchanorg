<?php


/**
 * ThemePileTwitter Class
 */

class ThemePileTwitter {
	function __construct() {
		add_action( 'widgets_init', create_function( '', 'register_widget("ThemePile_Twitter_Widget");' ) );
	}
}

global $themepile_twitter;
$themepile_twitter = new ThemePileTwitter();

/**
 * ThemePile_Twitter_Widget Class
 */
class ThemePile_Twitter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'themepile_twitter',
			'ThemePile Twitter Widget',
			array(
				'description' => __(
					'A widget that displays your most recent tweets with API v1.1',
					THEMEPILE_LANGUAGE
				),
			)
		);
	}

	private function convert_links( $status, $targetBlank = true, $linkMaxLen = 250 ) {
		$target = $targetBlank ? " target=\"_blank\" " : "";
		$status = preg_replace(
			"/((http:\/\/|https:\/\/)[^ )]+)/e",
			"'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'",
			$status
		);
		$status = preg_replace(
			"/(@([_a-z0-9\-]+))/i",
			"<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",
			$status
		);
		$status = preg_replace(
			"/(#([_a-z0-9\-]+))/i",
			"<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",
			$status
		);
		return $status;
	}

	private function relative_time( $a ) {
		$b      = strtotime( "now" );
		$c      = strtotime( $a );
		$d      = $b - $c;
		$minute = 60;
		$hour   = $minute * 60;
		$day    = $hour * 24;
		$week   = $day * 7;

		if ( is_numeric( $d ) && $d > 0 ) {
			if ( $d < 3 ) {
				return __( 'right now', THEMEPILE_LANGUAGE );
			}
			if ( $d < $minute ) {
				return floor( $d ) . _e( ' seconds ago', THEMEPILE_LANGUAGE );
			}
			if ( $d < $minute * 2 ) {
				return __( 'about 1 minute ago', THEMEPILE_LANGUAGE );
			}
			if ( $d < $hour ) {
				return floor( $d / $minute ) . __( '  minute ago', THEMEPILE_LANGUAGE );
			}
			if ( $d < $hour * 2 ) {
				return __( 'about 1 hour ago', THEMEPILE_LANGUAGE );
			}
			if ( $d < $day ) {
				return floor( $d / $hour ) . __( ' hours ago', THEMEPILE_LANGUAGE );
			}
			if ( $d > $day && $d < $day * 2 ) {
				return __( 'yesterday', THEMEPILE_LANGUAGE );
			}
			if ( $d < $day * 365 ) {
				return floor( $d / $day ) . __( ' days ago', THEMEPILE_LANGUAGE );
			}
			return __( 'over a year ago', THEMEPILE_LANGUAGE );
		}
	}

	public function widget( $args, $instance ) {
		extract( $args );
		if ( ! empty( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		}

		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}

		if ( empty( $instance['consumerkey'] ) || empty( $instance['consumersecret'] ) || empty( $instance['accesstoken'] ) || empty( $instance['accesstokensecret'] ) || empty( $instance['cachetime'] ) || empty( $instance['username'] ) ) {
			echo '<strong>Please fill all widget settings!</strong>' . $after_widget;
			return;
		}


		$tp_twitter_plugin_last_cache_time = get_option( 'tp_twitter_plugin_last_cache_time' );
		$diff                              = time() - $tp_twitter_plugin_last_cache_time;
		$crt                               = $instance['cachetime'] * 3600;


		if ( $diff >= $crt || empty( $tp_twitter_plugin_last_cache_time ) ) {

			if ( ! require_once( 'libs/twitteroauth.php' ) ) {
				echo '<strong>Couldn\'t find twitteroauth.php!</strong>' . $after_widget;
				return;
			}

			function getConnectionWithAccessToken( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret ) {
				$connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
				return $connection;
			}

			$connection = getConnectionWithAccessToken(
				$instance['consumerkey'],
				$instance['consumersecret'],
				$instance['accesstoken'],
				$instance['accesstokensecret']
			);
			$tweets = $connection->get(
				"https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $instance['username'] . "&count=10"
			) or die( 'Couldn\'t retrieve tweets! Wrong username?' );

			if ( ! empty( $tweets->errors ) ) {
				if ( $tweets->errors[0]->message == 'Invalid or expired token' ) {
					echo '<strong>' . $tweets->errors[0]->message . '!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
				}
				else {
					echo '<strong>' . $tweets->errors[0]->message . '</strong>' . $after_widget;
				}
				return;
			}

			for ( $i = 0; $i <= count( $tweets ); $i ++ ) {
				if ( ! empty( $tweets[$i] ) ) {
					$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
					$tweets_array[$i]['text']       = $tweets[$i]->text;
					$tweets_array[$i]['status_id']  = $tweets[$i]->id_str;
				}
			}

			update_option( 'tp_twitter_plugin_tweets', serialize( $tweets_array ) );
			update_option( 'tp_twitter_plugin_last_cache_time', time() );

			echo '<!-- twitter cache has been updated! -->';
		}


		$tp_twitter_plugin_tweets = maybe_unserialize( get_option( 'tp_twitter_plugin_tweets' ) );
		$id                       = rand( 0, 999 );

		if ( ! empty( $tp_twitter_plugin_tweets ) ) {
			print '<ul>';
			$fctr = '1';
			foreach ( $tp_twitter_plugin_tweets as $tweet ) {
				print
						'<li>
										<p>
														<span class="tweet_text">' . $this->convert_links( $tweet['text'] ) . '</span>
                            </p>
                            <p class="date">
                                <span class="tweet_time">
                                    <a class="twitter_time" target="_blank" href="http://twitter.com/' . $instance['username'] . '/statuses/' . $tweet['status_id'] . '">' . $this->relative_time(
							$tweet['created_at']
						) . '</a>
                                </span>
                            </p>
                        </li>';
				if ( $fctr == $instance['tweetstoshow'] ) {
					break;
				}
				$fctr ++;
			}
			print '
		    </ul>';
			if ( $instance['tweettext'] != '' ) : ?> <a href="http://twitter.com/<?php echo $instance['username'] ?>"
																									class="button"
																									target="blank"><?php echo $instance['tweettext'] ?></a><?php endif;
		}
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance                      = array();
		$instance['title']             = strip_tags( $new_instance['title'] );
		$instance['consumerkey']       = strip_tags( $new_instance['consumerkey'] );
		$instance['consumersecret']    = strip_tags( $new_instance['consumersecret'] );
		$instance['accesstoken']       = strip_tags( $new_instance['accesstoken'] );
		$instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
		$instance['cachetime']         = strip_tags( $new_instance['cachetime'] );
		$instance['username']          = strip_tags( $new_instance['username'] );
		$instance['tweetstoshow']      = strip_tags( $new_instance['tweetstoshow'] );
		$instance['tweettext']         = strip_tags( $new_instance['tweettext'] );

		if ( $old_instance['username'] != $new_instance['username'] ) {
			delete_option( 'tp_twitter_plugin_last_cache_time' );
		}

		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			'title'             => __( 'ThemePile Twitter Widget:', THEMEPILE_LANGUAGE ),
			'consumerkey'       => '',
			'consumersecret'    => '',
			'accesstoken'       => '',
			'accesstokensecret' => '',
			'cachetime'         => '2',
			'username'          => 'shaggysmile',
			'tweetstoshow'      => '',
			'tweettext'         => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		echo '
	<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:', THEMEPILE_LANGUAGE ) . ' </label>
		<input type="text" name="' . $this->get_field_name( 'title' ) . '" id="' . $this->get_field_id(
			'title'
		) . '" value="' . esc_attr( $instance['title'] ) . '" class="widefat" /></p>
	<p><label for="' . $this->get_field_id( 'consumerkey' ) . '">' . __( 'Consumer Key:', THEMEPILE_LANGUAGE ) . '</label>
		<input type="text" name="' . $this->get_field_name( 'consumerkey' ) . '" id="' . $this->get_field_id(
			'consumerkey'
		) . '" value="' . esc_attr( $instance['consumerkey'] ) . '" class="widefat" /></p>
	<p><label for="' . $this->get_field_id( 'consumersecret' ) . '">' . __( 'Consumer Secret:', THEMEPILE_LANGUAGE ) . '</label>
		<input type="text" name="' . $this->get_field_name( 'consumersecret' ) . '" id="' . $this->get_field_id(
			'consumersecret'
		) . '" value="' . esc_attr( $instance['consumersecret'] ) . '" class="widefat" /></p>
	<p><label for="' . $this->get_field_id( 'accesstoken' ) . '">' . __( 'Access Token:', THEMEPILE_LANGUAGE ) . '</label>
		<input type="text" name="' . $this->get_field_name( 'accesstoken' ) . '" id="' . $this->get_field_id(
			'accesstoken'
		) . '" value="' . esc_attr( $instance['accesstoken'] ) . '" class="widefat" /></p>
	<p><label for="' . $this->get_field_id( 'accesstokensecret' ) . '">' . __(
			'Access Token Secret:',
			THEMEPILE_LANGUAGE
		) . '</label>
		<input type="text" name="' . $this->get_field_name( 'accesstokensecret' ) . '" id="' . $this->get_field_id(
			'accesstokensecret'
		) . '" value="' . esc_attr( $instance['accesstokensecret'] ) . '" class="widefat" /></p>
	<p><label for="' . $this->get_field_id( 'cachetime' ) . '">' . __( 'Cache every:', THEMEPILE_LANGUAGE ) . '</label>
		<input type="text" name="' . $this->get_field_name( 'cachetime' ) . '" id="' . $this->get_field_id(
			'cachetime'
		) . '" value="' . esc_attr( $instance['cachetime'] ) . '" class="small-text" /> hours</p>
	<p><label for="' . $this->get_field_id( 'username' ) . '">' . __(
			'Twitter Username (ex: <a href="http://www.twitter.com/inthemepile">ThemePile</a>)',
			THEMEPILE_LANGUAGE
		) . '</label>
		<input type="text" name="' . $this->get_field_name( 'username' ) . '" id="' . $this->get_field_id(
			'username'
		) . '" value="' . esc_attr( $instance['username'] ) . '" class="widefat" /></p>
	<p style="margin-bottom: 15px;"><label for="' . $this->get_field_id( 'tweetstoshow' ) . '">' . __(
			'Number of Tweets:',
			THEMEPILE_LANGUAGE
		) . '</label>
		<select type="text" name="' . $this->get_field_name( 'tweetstoshow' ) . '" id="' . $this->get_field_id(
			'tweetstoshow'
		) . '">';
		$i = 1;
		for ( i; $i <= 10; $i ++ ) {
			echo '<option value="' . $i . '"';
			if ( $instance['tweetstoshow'] == $i ) {
				echo ' selected="selected"';
			}
			echo '>' . $i . '</option>';
		}
		echo '
		</select>
	</p>';
	}
}

?>