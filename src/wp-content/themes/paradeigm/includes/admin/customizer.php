<?php
/**
 * Theme Options
 *
 * @package Hypha Theme
 * @since Hypha Theme 1.0
 */


/* Theme Customizer */
function hypha_customizer_register($wp_customize) {
	
	// Modify Default Sections
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Theme Options', 'hyphatheme' );
	$wp_customize->get_section( 'title_tagline' )->priority = 0;
	$wp_customize->get_section( 'static_front_page' )->title = __( 'Sections', 'hyphatheme' );
	$wp_customize->get_section( 'static_front_page' )->description = __( 'Select the default options for the sections of the site.', 'hyphatheme' );
	$wp_customize->get_section( 'static_front_page' )->priority = 1;
		
	// Add Class - Custom Descriptions
	class Custom_Text_Control extends WP_Customize_Control {
		public $type  = 'customtext';
		public $extra = '';
		public function render_content() {
		?>
		<label>
			<?php if ( !empty($this->label) ) { ?>
				<br><hr>
				<span class="customize-control-title" style="font-size: 18px; line-height: 1.2em"><?php echo esc_html( $this->label ); ?></span>
			<?php } ?>
			<p class="description"><?php echo esc_html( $this->extra ); ?></p>
		</label>
		<?php
		}
	}
	
	
	
	
	/**
	 * Theme Options
 	 *
 	 * This section includes all the general theme options
 	 */
 	 
 	// Modify Default Controls
 	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title', 'hyphatheme' );
 	$wp_customize->get_control( 'blogname' )->priority = 0;
	$wp_customize->get_control( 'blogdescription' )->priority = 5;
	$wp_customize->get_control( 'display_header_text' )->priority = 10;
 	 
 	// Hide site tagline
	$wp_customize->add_setting( 'hypha_customizer_hide_tagline', array(
		'default' 		=> '0'
	) );

	$wp_customize->add_control( 'hypha_customizer_hide_tagline', array(
		'type'    		=> 'checkbox',
		'label'   		=> __( 'Hide Site Tagline', 'hyphatheme' ),
		'section' 		=> 'title_tagline'
	) );
	
	// Menu Logo
	$wp_customize->add_setting( 'hypha_customizer_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hypha_customizer_logo', array(
		'label'          => __( 'Menu Logo', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_logo',
		'priority'       => 100
	) ) );
	
	// Menu Retina Logo
	$wp_customize->add_setting( 'hypha_customizer_retina_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hypha_customizer_retina_logo', array(
		'label'          => __( 'Menu Retina Logo', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_retina_logo',
		'priority'       => 105
	) ) );
	
	// Homepage Logo
	$wp_customize->add_setting( 'hypha_customizer_homepage_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hypha_customizer_homepage_logo', array(
		'label'          => __( 'Homepage Logo', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_homepage_logo',
		'priority'       => 110
	) ) );
	
	// Homepage Retina Logo
	$wp_customize->add_setting( 'hypha_customizer_homepage_retina_logo', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hypha_customizer_homepage_retina_logo', array(
		'label'          => __( 'Homepage Retina Logo', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_homepage_retina_logo',
		'priority'       => 110
	) ) );
	
	// Favicon Upload
	$wp_customize->add_setting( 'hypha_customizer_favicon', array(
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'hypha_customizer_favicon', array(
		'label'        => __( 'Favicon Upload', 'hyphatheme' ),
		'section'      => 'title_tagline',
		'settings'     => 'hypha_customizer_favicon',
		'priority'     => 115
	) ) );
	
	
	/* Features
 	/* ---------------------------- */
	$wp_customize->add_setting( 'hypha_customizer_theme_features', array(
		'default'      => '',
		'type'         => 'customtext_features',
		'capability'   => 'edit_theme_options'
		)
	);
	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext_features', array(
		'label'        => __( 'Features', 'hyphatheme' ),
		'section'      => 'title_tagline',
		'settings'     => 'hypha_customizer_theme_features',
		'extra'        => __( 'Enable or disable the effects of this theme.', 'hyphatheme' ),
		'priority'     => 200
		) )
	);
	
	// Featured Image Header
	$wp_customize->add_setting( 'hypha_customizer_custom_header_disable', array(
        'default'       => 'enable',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',
    ));

    $wp_customize->add_control( 'hypha_customizer_custom_header_disable', array(
        'settings' 		=> 'hypha_customizer_custom_header_disable',
        'label'   		=> __( 'Featured Image Header', 'hyphatheme' ),
        'section' 		=> 'title_tagline',
        'type'    		=> 'select',
        'choices'    	=> array(
            'enable' 	=> __( 'Enable', 'hyphatheme' ),
            'disable' 	=> __( 'Disable', 'hyphatheme' ),
        ),
        'priority' 		=> 205
    ));
    
    $wp_customize->add_setting('hypha_customizer_custom_header_disable_desc', array(
		'default'      => '',
		'type'         => 'customtext_custom_header_desc',
		'capability'   => 'edit_theme_options'
		)
	);
	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext_custom_header_desc', array(
		'label'        => '',
		'section'      => 'title_tagline',
		'settings'     => 'hypha_customizer_custom_header_disable_desc',
		'extra'        => __( '* If disabled, will show the default header for every post.', 'hyphatheme' ),
		'priority'     => 210
		) )
	);
	
	/*
	// Auto Dropcaps
	$wp_customize->add_setting( 'hypha_customizer_auto_dropcaps', array(
        'default'       => 'enable',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',
    ));

    $wp_customize->add_control( 'hypha_customizer_auto_dropcaps', array(
        'settings' 		=> 'hypha_customizer_auto_dropcaps',
        'label'   		=> __( 'Auto Dropcaps', 'hyphatheme' ),
        'section' 		=> 'title_tagline',
        'type'    		=> 'select',
        'choices'    	=> array(
            'enable' 	=> __( 'Enable', 'hyphatheme' ),
            'disable' 	=> __( 'Disable', 'hyphatheme' ),
        ),
        'priority' 		=> 215
    ));
    */

	
	/* Social Media
 	/* ---------------------------- */
	$wp_customize->add_setting( 'hypha_customizer_theme_social', array(
		'default'      => '',
		'type'         => 'customtext_social',
		'capability'   => 'edit_theme_options'
		)
	);
	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext_social', array(
		'label'        => __( 'Social Media', 'hyphatheme' ),
		'section'      => 'title_tagline',
		'settings'     => 'hypha_customizer_theme_social',
		'extra'        => __( 'Default social links that will be displayed in the footer.', 'hyphatheme' ),
		'priority'     => 300
		) )
	);

	//Twitter
	$wp_customize->add_setting( 'hypha_customizer_icon_twitter', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_twitter', array(
		'label'          => __( 'Twitter URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_twitter',
		'type'           => 'text',
		'priority'       => 302
	) );

	//Facebook
	$wp_customize->add_setting( 'hypha_customizer_icon_facebook', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_facebook', array(
		'label'          => __( 'Facebook URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_facebook',
		'type'           => 'text',
		'priority'       => 305
	) );

	//Instagram
	$wp_customize->add_setting( 'hypha_customizer_icon_instagram', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_instagram', array(
		'label'          => __( 'Instagram URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_instagram',
		'type'           => 'text',
		'priority'       => 310
	) );

	//Tumblr
	$wp_customize->add_setting( 'hypha_customizer_icon_tumblr', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_tumblr', array(
		'label'          => __( 'Tumblr URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_tumblr',
		'type'           => 'text',
		'priority'       => 315
	) );

	//Dribbble
	$wp_customize->add_setting( 'hypha_customizer_icon_dribbble', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_dribbble', array(
		'label'          => __( 'Dribbble URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_dribbble',
		'type'           => 'text',
		'priority'       => 320
	) );

	//Flickr
	$wp_customize->add_setting( 'hypha_customizer_icon_flickr', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_flickr', array(
		'label'          => __( 'Flickr URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_flickr',
		'type'           => 'text',
		'priority'       => 325
	) );

	//Pinterest
	$wp_customize->add_setting( 'hypha_customizer_icon_pinterest', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_pinterest', array(
		'label'          => __( 'Pinterest URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_pinterest',
		'type'           => 'text',
		'priority'       => 330
	) );

	//Google+
	$wp_customize->add_setting( 'hypha_customizer_icon_googleplus', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_googleplus', array(
		'label'          => __( 'Google+ URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_googleplus',
		'type'           => 'text',
		'priority'       => 335
	) );

	//Vimeo
	$wp_customize->add_setting( 'hypha_customizer_icon_vimeo', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_vimeo', array(
		'label'          => __( 'Vimeo URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_vimeo',
		'type'           => 'text',
		'priority'       => 340
	) );

	//YouTube
	$wp_customize->add_setting( 'hypha_customizer_icon_youtube', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_youtube', array(
		'label'          => __( 'YouTube URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_youtube',
		'type'           => 'text',
		'priority'       => 345
	) );

	//LinkedIn
	$wp_customize->add_setting( 'hypha_customizer_icon_linkedin', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_linkedin', array(
		'label'          => __( 'LinkedIn URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_linkedin',
		'type'           => 'text',
		'priority'       => 350
	) );
	
	//Github
	$wp_customize->add_setting( 'hypha_customizer_icon_github', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_github', array(
		'label'          => __( 'GitHub URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_github',
		'type'           => 'text',
		'priority'       => 355
	) );

	//RSS
	$wp_customize->add_setting( 'hypha_customizer_icon_rss', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_rss', array(
		'label'          => __( 'RSS URL', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_rss',
		'type'           => 'text',
		'priority'       => 360
	) );

	//Email
	$wp_customize->add_setting( 'hypha_customizer_icon_public_email', array(
		'default'        => '',
		'type'           => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_icon_public_email', array(
		'label'          => __( 'Email Address', 'hyphatheme' ),
		'section'        => 'title_tagline',
		'settings'       => 'hypha_customizer_icon_public_email',
		'type'           => 'text',
		'priority'       => 365
	) );
	
	
	
	
	/**
	 * Sections
 	 *
 	 * This section includes all the section information
 	 */
 	
 	// Modify Default Controls
 	$wp_customize->get_control( 'show_on_front' )->priority = 0;
 	$wp_customize->get_control( 'page_on_front' )->priority = 5;
 	$wp_customize->get_control( 'page_for_posts' )->priority = 10;
	
	
	/* Posts Page
 	/* ---------------------------- */
	$wp_customize->add_setting('hypha_customizer_sections_posts_page', array(
		'default'      => '',
		'type'         => 'customtext_posts_page',
		'capability'   => 'edit_theme_options'
		)
	);
	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext_posts_page', array(
		'label'        => __( 'Posts Page', 'hyphatheme' ),
		'section'      => 'static_front_page',
		'settings'     => 'hypha_customizer_sections_posts_page',
		'extra'        => __( 'These options will affect the posts page.', 'hyphatheme' ),
		'priority'     => 100
		) )
	);
	
	// Featured Category
	$wp_customize->add_setting( 'hypha_customizer_category_select', array(
		'default'        => 'sticky',
		'capability'     => 'edit_theme_options',
	));

	$wp_customize->add_control( 'hypha_customizer_category_select', array(
		'label'    => __( 'Featured Category', 'hyphatheme' ),
		'section'  => 'static_front_page',
		'settings' => 'hypha_customizer_category_select',
		'type'     => 'select',
		'choices'  => get_categories_select(),
		'priority'     => 105
	));
	
	$wp_customize->add_setting('hypha_customizer_category_select_desc', array(
		'default'      => '',
		'type'         => 'customtext_cat_select_desc',
		'capability'   => 'edit_theme_options'
		)
	);
	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext_cat_select_desc', array(
		'label'        => '',
		'section'      => 'static_front_page',
		'settings'     => 'hypha_customizer_category_select_desc',
		'extra'        => __( '* Will only show if there is 3 or more featured items. Default shows latest posts.', 'hyphatheme' ),
		'priority'     => 110
		) )
	);
	
	// Featured Content Items
	$wp_customize->add_setting( 'hypha_customizer_featured_content_items', array(
		'default'      => 5,
		'capability'   => 'edit_theme_options',
		'type'         => 'option',
	));

	$wp_customize->add_control( 'hypha_featured_content_items_box', array(
		'settings'     => 'hypha_customizer_featured_content_items',
		'label'        => __( 'Featured Content Items', 'hyphatheme' ),
		'section'      => 'static_front_page',
		'type'         => 'select',
		'choices'      => array(
			'3'	=> 3,
			'4' => 4,
			'5'	=> 5,
		),
		'priority'     => 112
	));
	
	// Time Stamp
	$wp_customize->add_setting( 'hypha_customizer_time_stamp_select', array(
		'default'      => 'time',
		'capability'   => 'edit_theme_options',
		'type'         => 'option',
	));

	$wp_customize->add_control( 'hypha_time_stamp_select_box', array(
		'settings'     => 'hypha_customizer_time_stamp_select',
		'label'        => __( 'Time Stamp', 'hyphatheme' ),
		'section'      => 'static_front_page',
		'type'         => 'select',
		'choices'      => array(
			'date'   => 'Date',
			'time'  => 'Time Ago',
		),
		'priority'     => 115
	));
	
	// Post Tabs
	$wp_customize->add_setting( 'hypha_customizer_tabs_select', array(
		'default'      => 'close',
		'capability'   => 'edit_theme_options',
		'type'         => 'option',
	));

	$wp_customize->add_control( 'hypha_customizer_tabs_select', array(
		'settings'     => 'hypha_customizer_tabs_select',
		'label'        => __( 'Post Tabs Initial State', 'hyphatheme' ),
		'section'      => 'static_front_page',
		'type'         => 'select',
		'choices'      => array(
			'open'   => 'Open',
			'close'  => 'Close',
		),
		'priority'     => 120
	));
	
	// Posts Page Text
	$wp_customize->add_setting( 'hypha_customizer_posts_page_text', array(
		'default'      => __( 'Latest Articles', 'hyphatheme' ),
		'type'         => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_posts_page_text', array(
		'label'        => __( 'Posts Page Text', 'hyphatheme' ),
		'section'      => 'static_front_page',
		'settings'     => 'hypha_customizer_posts_page_text',
		'type'         => 'text',
		'priority'     => 125
	) );	
	
	
	/* Footer
 	/* ---------------------------- */
	$wp_customize->add_setting('hypha_customizer_sections_footer', array(
		'default'      => '',
		'type'         => 'customtext_footer',
		'capability'   => 'edit_theme_options'
		)
	);
	$wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'customtext_footer', array(
		'label'        => __( 'Footer', 'hyphatheme' ),
		'section'      => 'static_front_page',
		'settings'     => 'hypha_customizer_sections_footer',
		'extra'        => __( 'These options will affect the footer.', 'hyphatheme' ),
		'priority'     => 200
		) )
	);
	
	// Footer Text
	$wp_customize->add_setting( 'hypha_customizer_footnote_text', array(
		'default'      => __( '', 'hyphatheme' ),
		'type'         => 'option'
	) );

	$wp_customize->add_control( 'hypha_customizer_footnote_text', array(
		'label'        => __( 'Footnote Text', 'hyphatheme' ),
		'section'      => 'static_front_page',
		'settings'     => 'hypha_customizer_footnote_text',
		'type'         => 'text',
		'priority'     => 205
	) );	
	
	
	
	
	/**
	 * Colors
 	 *
 	 * This section includes all the custom color changes
 	 */
 	
 	// Modify Default Controls
 	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'hyphatheme' );
 	
	//Accent Color
	$wp_customize->add_setting( 'hypha_customizer_color_accent', array(
		'default'  => '#dcbc83'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hypha_customizer_color_accent', array(
		'label'    => __( 'Accent Color', 'hyphatheme' ),
		'section'  => 'colors',
		'settings' => 'hypha_customizer_color_accent',
		'priority' => 100
	) ) );


}
add_action( 'customize_register', 'hypha_customizer_register' );



/* Get Categories */
function get_categories_select() {
	$teh_cats = get_categories();
	$results = array( '' => 'Latest Posts', 'sticky' => 'Sticky Posts' );
	
	$count = count( $teh_cats );
	for ( $i=0; $i < $count; $i++ ) {
		if ( isset( $teh_cats[$i] ) )
			$results[$teh_cats[$i]->term_id] = $teh_cats[$i]->name;
		else
			$count++;
	}
	return $results;
}
