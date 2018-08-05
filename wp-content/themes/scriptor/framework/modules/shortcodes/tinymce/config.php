<?php

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$themepile_shortcodes['button'] = array(
	'no_preview'  => true,
	'params'      => array(
		'url'     => array(
			'std'   => '',
			'type'  => 'text',
			'label' => __( 'Button URL', THEMEPILE_LANGUAGE ),
			'desc'  => __( 'Add the button\'s url eg http://example.com', THEMEPILE_LANGUAGE )
		),
		'style'   => array(
			'type'    => 'select',
			'label'   => __( 'Button Style', THEMEPILE_LANGUAGE ),
			'desc'    => __( 'Select the button\'s style, ie the button\'s colour', THEMEPILE_LANGUAGE ),
			'options' => array(
				'default-style' => 'Default',
				'primary'       => 'Primary',
				'success'       => 'Success',
				'info'          => 'Info',
				'warning'       => 'Warning',
				'danger'        => 'Danger'
			)
		),
		'size'    => array(
			'type'    => 'select',
			'label'   => __( 'Button Size', THEMEPILE_LANGUAGE ),
			'desc'    => __( 'Select the button\'s size', THEMEPILE_LANGUAGE ),
			'options' => array(
				'default-size' => 'Default',
				'medium'       => 'Medium',
				'large'        => 'Large'
			)
		),
		'target'  => array(
			'type'    => 'select',
			'label'   => __( 'Button Target', THEMEPILE_LANGUAGE ),
			'desc'    => __( '_self = open in same window. _blank = open in new window', THEMEPILE_LANGUAGE ),
			'options' => array(
				'_self'  => '_self',
				'_blank' => '_blank'
			)
		),
		'content' => array(
			'std'   => 'Button Text',
			'type'  => 'text',
			'label' => __( 'Button\'s Text', THEMEPILE_LANGUAGE ),
			'desc'  => __( 'Add the button\'s text', THEMEPILE_LANGUAGE ),
		)
	),
	'shortcode'   => '[themepile_button url="{{url}}" style="{{style}}" size="{{size}}" target="{{target}}"] {{content}} [/themepile_button]',
	'popup_title' => __( 'Insert Button Shortcode', THEMEPILE_LANGUAGE )
);

/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$themepile_shortcodes['alert'] = array(
	'no_preview'  => true,
	'params'      => array(
		'style'   => array(
			'type'    => 'select',
			'label'   => __( 'Alert Style', THEMEPILE_LANGUAGE ),
			'desc'    => __( 'Select the alert\'s style, ie the alert colour', THEMEPILE_LANGUAGE ),
			'options' => array(
				'default' => 'Default',
				'info'    => 'Info',
				'success' => 'Success',
				'yellow'  => 'Yellow',
				'error'   => 'Error'
			)
		),
		'content' => array(
			'std'   => 'Your Alert!',
			'type'  => 'textarea',
			'label' => __( 'Alert Text', THEMEPILE_LANGUAGE ),
			'desc'  => __( 'Add the alert\'s text', THEMEPILE_LANGUAGE ),
		)

	),
	'shortcode'   => '[themepile_alert style="{{style}}"] {{content}} [/themepile_alert]',
	'popup_title' => __( 'Insert Alert Shortcode', THEMEPILE_LANGUAGE )
);

/*-----------------------------------------------------------------------------------*/
/*	Toggle Config
/*-----------------------------------------------------------------------------------*/

$themepile_shortcodes['toggle'] = array(
	'no_preview'  => true,
	'params'      => array(
		'title'   => array(
			'type'  => 'text',
			'label' => __( 'Toggle Content Title', THEMEPILE_LANGUAGE ),
			'desc'  => __( 'Add the title that will go above the toggle content', THEMEPILE_LANGUAGE ),
			'std'   => 'Title'
		),
		'content' => array(
			'std'   => 'Content',
			'type'  => 'textarea',
			'label' => __( 'Toggle Content', THEMEPILE_LANGUAGE ),
			'desc'  => __( 'Add the toggle content. Will accept HTML', THEMEPILE_LANGUAGE ),
		),
		'state'   => array(
			'type'    => 'select',
			'label'   => __( 'Toggle State', THEMEPILE_LANGUAGE ),
			'desc'    => __( 'Select the state of the toggle on page load', THEMEPILE_LANGUAGE ),
			'options' => array(
				'open'   => 'Open',
				'closed' => 'Closed'
			)
		),

	),
	'shortcode'   => '[themepile_toggle title="{{title}}" state="{{state}}"] {{content}} [/themepile_toggle]',
	'popup_title' => __( 'Insert Toggle Content Shortcode', THEMEPILE_LANGUAGE )
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$themepile_shortcodes['tabs'] = array(
	'params'          => array(),
	'no_preview'      => true,
	'shortcode'       => '[themepile_tabs] {{child_shortcode}}  [/themepile_tabs]',
	'popup_title'     => __( 'Insert Tab Shortcode', THEMEPILE_LANGUAGE ),
	'child_shortcode' => array(
		'params'       => array(
			'title'   => array(
				'std'   => 'Title',
				'type'  => 'text',
				'label' => __( 'Tab Title', THEMEPILE_LANGUAGE ),
				'desc'  => __( 'Title of the tab', THEMEPILE_LANGUAGE ),
			),
			'content' => array(
				'std'   => 'Tab Content',
				'type'  => 'textarea',
				'label' => __( 'Tab Content', THEMEPILE_LANGUAGE ),
				'desc'  => __( 'Add the tabs content', THEMEPILE_LANGUAGE )
			)
		),
		'shortcode'    => '[themepile_tab title="{{title}}"] {{content}} [/themepile_tab]',
		'clone_button' => __( 'Add Tab', THEMEPILE_LANGUAGE )
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

$themepile_shortcodes['columns'] = array(
	'params'          => array(),
	'shortcode'       => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title'     => __( 'Insert Columns Shortcode', THEMEPILE_LANGUAGE ),
	'no_preview'      => true,
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params'       => array(
			'column'  => array(
				'type'    => 'select',
				'label'   => __( 'Column Type', THEMEPILE_LANGUAGE ),
				'desc'    => __( 'Select the type, ie width of the column.', THEMEPILE_LANGUAGE ),
				'options' => array(
					'themepile_column_one'    => 'One Column Size',
					'themepile_column_two'    => 'Two Column Size',
					'themepile_column_three'  => 'Three Column Size',
					'themepile_column_four'   => 'Four Column Size',
					'themepile_column_five'   => 'Five Column Size',
					'themepile_column_six'    => 'Siz Column Size',
					'themepile_column_seven'  => 'Seven Column Size',
					'themepile_column_eight'  => 'Eight Column Size',
					'themepile_column_nine'   => 'Nine Eight Column Size',
					'themepile_column_ten'    => 'Ten Column Size',
					'themepile_column_eleven' => 'Eleven Column Size',
					'themepile_column_twelve' => 'Twelve Column Size'
				)
			),
			'content' => array(
				'std'   => '',
				'type'  => 'textarea',
				'label' => __( 'Column Content', THEMEPILE_LANGUAGE ),
				'desc'  => __( 'Add the column content.', THEMEPILE_LANGUAGE ),
			)
		),
		'shortcode'    => '[{{column}}] {{content}} [/{{column}}] ',
		'clone_button' => __( 'Add Column', THEMEPILE_LANGUAGE )
	)
);

?>