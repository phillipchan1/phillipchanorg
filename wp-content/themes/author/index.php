<?php get_header(); ?>

		<!-- excerpt scroller -->
		<?php if ( of_get_option('of_show_excerpt_scroll') == 'yes' ) { ?>
			<?php if(is_home()) { ?>
				<div class="scroll">
					<div class="flexslider">
						<ul class="slides">
							<?php query_posts('showposts='.of_get_option('of_excerpt_count')); ?>
							<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
								<?php if (empty($post->post_password)) { ?>
									<li>
										<div class="scroll-excerpt">
											<a href="<?php the_permalink(); ?>"><?php echo get_the_excerpt(); ?></a>
										</div>
										<div class="scroll-post">
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> <?php _e('by','okay'); ?> <?php the_author_link(); ?>
										</div>
									</li>
								<?php } ?>	
							<?php endwhile; ?>
							<?php endif; ?>
							<?php wp_reset_query(); ?>
						</ul>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
		
		<div id="content">
			<!-- conditional subtitles -->
			<?php if(is_search()) { ?>
				<div class="sub-title"><?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $count = $allsearch->post_count; _e(''); echo $count . ' '; wp_reset_query(); ?><?php _e('Search Results for','okay'); ?> "<?php the_search_query() ?>" </div>
			<?php } else if(is_tag()) { ?>
				<div class="sub-title"><?php _e('Tag:','okay'); ?> <?php single_tag_title(); ?></div>
			<?php } else if(is_day()) { ?>
				<div class="sub-title"><?php _e('Archive:','okay'); ?> <?php echo get_the_date(); ?></div>
			<?php } else if(is_month()) { ?>
				<div class="sub-title"><?php _e('Archive:','okay'); ?> <?php echo get_the_date('F Y'); ?></div>
			<?php } else if(is_year()) { ?>
				<div class="sub-title"><?php _e('Archive:','okay'); ?> <?php echo get_the_date('Y'); ?></div>
			<?php } else if(is_404()) { ?>
				<div class="sub-title"><?php _e('404 - Page Not Found!','okay'); ?></div>
			<?php } else if(is_category()) { ?>
				<div class="sub-title"><?php _e('Category:','okay'); ?> <?php single_cat_title(); ?></div>
			<?php } else if(is_author()) { ?>
				<div class="sub-title"><?php _e('Posts by Author:','okay'); ?> <?php the_author_posts(); ?> <?php _e('posts by','okay'); ?> <?php
				$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo $curauth->nickname; ?></div>		
			<?php } ?>
			
			<div class="post-wrap">
				<!-- grab the posts -->
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
					<div <?php post_class(); ?>>
						<div class="box">
							
							<!-- grab the image attachments -->		
							<?php 
								//find images in the content with "wp-image-{n}" in the class name
								preg_match_all('/<img[^>]?class=["|\'][^"]*wp-image-([0-9]*)[^"]*["|\'][^>]*>/i', get_the_content(), $result);  
								
								$exclude_imgs = $result[1];
								
								$args = array(
									'order'          => 'ASC',
									'orderby'        => 'menu_order ID',
									'post_type'      => 'attachment',
									'post_parent'    => $post->ID,
									'exclude'		 => $exclude_imgs,
									'post_mime_type' => 'image',
									'post_status'    => null,
									'numberposts'    => -1,
								);
								
								$attachments = get_posts($args);
								if ($attachments) {
								
								echo "<div class='gallery-wrap'><div class='flexslider'><ul class='slides'>";
									foreach ($attachments as $attachment) {
										echo "<li> <a href='". get_attachment_link($attachment_id) ."'>";
										echo wp_get_attachment_image($attachment->ID, 'large-image', false, false);
										echo "</a></li>";
									}
								echo "</ul></div></div>"; 
								
								}
							?>
			
							<!-- grab the video -->
							<?php if ( get_post_meta($post->ID, 'okvideo', true) ) { ?>
								<div class="okvideo">
									<?php echo get_post_meta($post->ID, 'okvideo', true) ?>
								</div>
							<?php } ?>
							
							<div class="clear"></div>
							
							<div class="frame">
								<div class="title-wrap">
									<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
									
									<div class="title-meta">
										<span><?php the_author_link(); ?></span> <span><a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a></span> <span><a href="<?php the_permalink(); ?>/#comment-jump" title="<?php the_title(); ?> comments"><?php comments_number(__('No Comments','okay'),__('1 Comment','okay'),__( '% Comments','okay') );?></a></span>
									</div>
								</div>
								
								<div class="post-content">
									<?php if(is_search() || is_archive()) { ?> 
										<?php the_excerpt(); ?>
									<?php } else { ?>
										<?php the_content('Read more &rarr;'); ?>
										
										<?php if(is_single()) { ?>
											<div class="pagelink">
												<?php wp_link_pages(); ?>
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</div><!-- frame -->
							
							<!-- meta info bar -->
							<?php if(is_page()) { } else { ?>
								<div class="bar">
									<div class="bar-frame clearfix">
										<div class="meta-info">
											<div class="share">
												<!-- google plus -->
												<a class="share-google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','gplusshare','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;"><?php _e('google','okay'); ?></a>
												
												<!-- facebook -->
												<a class="share-facebook" onclick="window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" title="<?php the_title(); ?>"  target="blank"><?php _e('facebook','okay'); ?></a>
												
												<!-- twitter -->
												<a class="share-twitter" onclick="window.open('http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="<?php the_title(); ?>" target="blank"><?php _e('twitter','okay'); ?></a>
											</div><!-- share -->
											
											<div class="categories">
												<div class="title entypo">i</div>
												<?php the_category(', '); ?>
											</div>						
										  	
										  	<?php the_tags('<div class="tags">
										  		<div class="title entypo">ñ</div>
										  		',', ','
										  	</div>'); ?>
									  	</div><!-- meta info -->
									</div><!-- bar frame -->
								</div><!-- bar -->
							<?php } ?>
						</div><!-- box -->
					</div><!-- post-->
					
				
				<?php if(is_single()) { ?>
					<!-- next and previous posts -->	
					<div class="next-prev">
						<?php previous_post_link('<div class="prev-post"><strong class="title">' . __('&larr; Previous Post', 'okay') . '</strong><span>%link</span></div>'); ?>
						<?php next_post_link('<div class="next-post"><strong class="title">' . __('Next Post &rarr;', 'okay') . '</strong><span>%link</span></div>'); ?>
					</div>	
				<?php } ?>			
				
				<?php endwhile; ?>
			</div><!-- post wrap -->
							
			<?php if(is_single()) { } else { ?>	
				<!-- post navigation -->
				<div class="post-nav">
					<div class="postnav-left"><?php previous_posts_link(__('&larr; Newer Posts', 'okay')) ?></div>
					<div class="postnav-right"><?php next_posts_link(__('Older Posts &rarr;', 'okay')) ?></div>	
					<div style="clear:both;"> </div>
				</div><!-- end post navigation -->
			<?php } ?>
			<?php else: ?>
				</div> <!-- end content if no posts -->
			
			<?php endif; ?><!-- end posts -->
			
			<?php if(is_404()) { ?>
				<p><?php _e('Sorry, but the page you are looking for is no longer here. Please use the navigations or the search to find what what you are looking for.','okay'); ?></p>
				
				<form action="<?php echo home_url( '/' ); ?>" class="search-form clearfix">
					<fieldset>
						<input type="text" class="search-form-input text" name="s" onfocus="if (this.value == '<?php _e('Search','okay'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search','okay'); ?>';}" value="<?php _e('Search','okay'); ?>"/>
						<input type="submit" value="Go" class="submit" />
					</fieldset>
				</form>
				
				</div><!-- end content if 404 -->
			<?php } ?>
			
			<!-- comments -->
			<?php if(is_single ()) { ?>
				<?php if ('open' == $post->comment_status) { ?>
				<div id="comment-jump" class="comments">
					<?php comments_template(); ?>
				</div>
				<?php } ?>
			<?php } ?>
		</div><!--content-->
		
		<!-- grab the sidebar -->
		<?php get_sidebar(); ?>
	
		<!-- grab footer -->
		<?php get_footer(); ?>