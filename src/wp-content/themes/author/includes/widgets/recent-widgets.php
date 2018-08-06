<?php
/*-----------------------------------------------------------------------------------*/
/* Okay Recent Widgets
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'load_okat_recent_widgets' );

function load_okat_recent_widgets() {
	register_widget( 'okay_recent_widgets' );
}

class okay_recent_widgets extends WP_Widget {

	function okay_recent_widgets() {
	$widget_ops = array( 'classname' => 'ok-recent-posts', 'description' => __('Okay Recent Posts Widget', 'ok-recent-posts') );
	$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ok-recent-widgets' );
	$this->WP_Widget( 'ok-recent-widgets', __('Okay Recent Posts Widget', 'ok-recent-widgets'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );
		$recentcount= $instance['recentcount'];
		$recentcount= $instance['commentcount'];
		$userid = $instance['user_id'];
		$userinfo = get_userdata($userid);
		$userbio = get_user_meta($userid,'description',true);
		$userposturl = get_author_posts_url($userid);
		
		echo $before_widget;
?>
		
		<!-- Okay Recent Posts Widget -->
		<div id="tabs" class="okay-recent-posts">
			<ul class="tab-wrapper tabs">
				<li><a class="current" href="#tab-1"><span>+</span> <?php _e('','okay'); ?></a></li>
				<li><a class="" href="#tab-2"><span>l</span> <?php _e('','okay'); ?></a></li>
				<li><a class="" href="#tab-3"><span>ñ</span> <?php _e('','okay'); ?></a></li>
				<li><a class="" href="#tab-4"><span>:</span> <?php _e('','okay'); ?></a></li>
				<li><a class="" href="#tab-5"><span>7</span> <?php _e('','okay'); ?></a></li>
			</ul>
			
			<!-- User Profile -->
			<div id="tab-1" class="pane">
				<div class="specific_user">
					<a class="profile-img" href='<?php echo $userposturl; ?>' title='<?php echo $userinfo->display_name; ?>'><?php echo get_avatar($userid,53); ?></a>
					
					<?php echo $userbio; ?>
				</div>
			</div><!-- user profile pane -->
			
			<!-- Recent Posts -->
			<div id="tab-2" class="pane">
				<ul class="recent-posts-widget">
					<?php query_posts('showposts='.$instance["recentcount"]); ?>
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<li class="recent-posts">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo get_the_date(); ?>  -  <a href="<?php the_permalink(); ?>/#comments" title="comments"><?php comments_number(__('No Comments','okay'),__('1 Comment','okay'),__( '% Comments','okay') );?></a></p>
						</li>
					<?php endwhile; ?>
					<?php endif; ?>
				</ul>
			</div><!-- recent posts pane -->
			
			<!-- Tag Cloud -->
			<div id="tab-3" class="pane">
				<div class="tagcloud">
					<?php wp_tag_cloud( $args ); ?>
				</div>
				<div class="clear"></div>
			</div><!-- tags pane -->
			
			<!-- Recent Comments -->
			<div id="tab-4" class="pane">
				<ul class="recent-comments-widget">
					<?php $comments = get_comments('status=approve&number='.$instance["commentcount"]); foreach($comments as $comm) :?>
					<?php
						$url = '<a href="'. get_permalink($comm->comment_post_ID).'#comment-'.$comm->comment_ID .'" title="'.$comm->comment_author .' | '.get_the_title($comm->comment_post_ID).'">' . $comm->comment_author . '</a>';
						
						$length = 100; // adjust to needed length
						$thiscomment = $comm->comment_content;
						if ( strlen($thiscomment) > $length ) {
							$thiscomment = substr($thiscomment,0,$length);
							$thiscomment = $thiscomment .' ...';
						}
					?>
					<li>
						<div class="comment-widget-text">
							<div class="comment-avatar">
								<?php echo get_avatar($comm->comment_author_email, 30); ?>
							</div>
							
							<div class="comment-avatar-right">
								<div class="comment-author">
									<?php echo $url; ?>
								</div>
								
								<div class="comment-date">
									<?php echo $comm->comment_date; ?>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						
						<a class="comment-txt" href="<?php echo get_permalink($comm->comment_post_ID);?>#comment-<?php echo $comm->comment_ID ?>"><?php echo ($thiscomment);?></a>
					</li>
					<?php endforeach;?>
				</ul>
			</div><!-- recent comments -->
			
			<!-- Popular Posts -->
			<div id="tab-5" class="pane">
				<ul class="arrow-list">
					<?php
						global $wpdb;
						$popular_posts = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post' ORDER BY comment_count DESC LIMIT 0,5");
						foreach($popular_posts as $post) {
							print "<li><a href='". get_permalink($post->id) ."'>".$post->post_title."</a></li>\n";
						}
					?>
				</ul>
			</div><!-- popular posts -->
		</div><!-- tabs -->

<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['recentcount'] = $new_instance['recentcount'];
		$instance['commentcount'] = $new_instance['commentcount'];	
		$instance['user_id'] = $new_instance['user_id'];
			
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'recentcount' => '', 'commentcount' => '', 'user_id' => '') );			
		$instance['recentcount'] = $instance['recentcount'];
		$instance['commentcount'] = $instance['commentcount'];
		$instance['user_id'] = $instance['user_id'];
		
?>
			<p>
				<label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php _e('User Profile:', 'okay') ?></label> 
				<select id="<?php echo $this->get_field_id( 'user_id' );?>" name="<?php echo $this->get_field_name( 'user_id' );?>" class="widefat" style="width:100%;">
					<?php
					$user_id = $instance['user_id'];

$option_list = user_get_users_list_option($user_id);
					echo $option_list;
					?>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('recentcount'); ?>"><?php _e('Recent Posts Count','okay'); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id('recentcount'); ?>" name="<?php echo $this->get_field_name('recentcount'); ?>" type="text" value="<?php echo $instance['recentcount']; ?>" /></label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('commentcount'); ?>"><?php _e('Comment Count','okay'); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id('commentcount'); ?>" name="<?php echo $this->get_field_name('commentcount'); ?>" type="text" value="<?php echo $instance['commentcount']; ?>" /></label>
			</p>
              
  <?php
	}
}

//function to get all users

function user_get_users_list_option($instance){
$output = '';
global $wpdb; 
$users = $wpdb->get_results("SELECT display_name, ID FROM $wpdb->users");
	foreach($users as $u){
	    $uname = $u->display_name;
	    $uid = $u->ID;
	    $output .="<option value='$uid'";
	    
	    if($instance == $uid){
	    	$output.= 'selected="selected"';
	    } 
	    
	    $output.= ">$uname</option>";
	}
return $output;
}

?>
