<?php

/*-----------------------------------------------------------------------------------*/
/*	Column Shortcodes
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'themepile_column_one' ) ) {
	function themepile_column_one( $atts, $content = null ) {
		return '<div class="g-column--1">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_one', 'themepile_column_one' );
}

if ( ! function_exists( 'themepile_column_two' ) ) {
	function themepile_column_two( $atts, $content = null ) {
		return '<div class="g-column--2">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_two', 'themepile_column_two' );
}

if ( ! function_exists( 'themepile_column_three' ) ) {
	function themepile_column_three( $atts, $content = null ) {
		return '<div class="g-column--3">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_three', 'themepile_column_three' );
}

if ( ! function_exists( 'themepile_column_four' ) ) {
	function themepile_column_four( $atts, $content = null ) {
		return '<div class="g-column--4">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_four', 'themepile_column_four' );
}

if ( ! function_exists( 'themepile_column_five' ) ) {
	function themepile_column_five( $atts, $content = null ) {
		return '<div class="g-column--5">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_five', 'themepile_column_five' );
}

if ( ! function_exists( 'themepile_column_six' ) ) {
	function themepile_column_six( $atts, $content = null ) {
		return '<div class="g-column--6">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_six', 'themepile_column_six' );
}

if ( ! function_exists( 'themepile_column_seven' ) ) {
	function themepile_column_seven( $atts, $content = null ) {
		return '<div class="g-column--7">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_seven', 'themepile_column_seven' );
}

if ( ! function_exists( 'themepile_column_eight' ) ) {
	function themepile_column_eight( $atts, $content = null ) {
		return '<div class="g-column--8">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_eight', 'themepile_column_eight' );
}

if ( ! function_exists( 'themepile_column_nine' ) ) {
	function themepile_column_nine( $atts, $content = null ) {
		return '<div class="g-column--9">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_nine', 'themepile_column_nine' );
}

if ( ! function_exists( 'themepile_column_ten' ) ) {
	function themepile_column_ten( $atts, $content = null ) {
		return '<div class="g-column--10">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_ten', 'themepile_column_ten' );
}

if ( ! function_exists( 'themepile_column_eleven' ) ) {
	function themepile_column_eleven( $atts, $content = null ) {
		return '<div class="g-column--11">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_eleven', 'themepile_column_eleven' );
}

if ( ! function_exists( 'themepile_column_twelve' ) ) {
	function themepile_column_twelve( $atts, $content = null ) {
		return '<div class="g-column--12">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_column_twelve', 'themepile_column_twelve' );
}


/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'themepile_button' ) ) {
	function themepile_button( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'url'    => '#',
					'target' => '_self',
					'style'  => 'default-style',
					'size'   => 'default-size'
				),
				$atts
			)
		);

		return '<a target="' . $target . '" class="modularis-button modularis-button--' . $size . ' modularis-button--' . $style . '" href="' . $url . '">' . do_shortcode(
			$content
		) . '</a>';
	}

	add_shortcode( 'themepile_button', 'themepile_button' );
}


/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'themepile_alert' ) ) {
	function themepile_alert( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'style' => 'default'
				),
				$atts
			)
		);

		return
				'<div class="modularis-alert modularis-alert--' . $style . '"> ' .
					do_shortcode( $content ).
				'</div>';
	}

	add_shortcode( 'themepile_alert', 'themepile_alert' );
}


/*-----------------------------------------------------------------------------------*/
/*	Toggle Shortcodes
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'themepile_toggle' ) ) {
	function themepile_toggle( $atts, $content = null ) {
		extract(
			shortcode_atts(
				array(
					'title' => __( 'Title goes here', THEMEPILE_LANGUAGE ),
					'state' => 'open'
				),
				$atts
			)
		);
		$icon = "+";
		if ( $state == "open" ) {
			$icon = "-";
		}
		return '
        <div class="modularis-toggle modularis-toggle--' . $state . '">
            <a href="#" class="modularis-toggle-control"><span class="modularis-toggle-control-icon">' . $icon . '</span><b>' . $title . '</b></a>
            <div class="modularis-toggle-content">
                ' . do_shortcode( $content ) . '
            </div>
        </div>';
	}

	add_shortcode( 'themepile_toggle', 'themepile_toggle' );
}


/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'themepile_tabs' ) ) {
	function themepile_tabs( $atts, $content = null ) {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );

		STATIC $i = 0;
		$i ++;

		// Extract the tab titles for use in the tab widget.
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

		$tab_titles = array();
		if ( isset( $matches[1] ) ) {
			$tab_titles = $matches[1];
		}

		$output = '';
		$output .=
				'<div id="modularis-tabs-' . $i . '" class="modularis-tabs">';
		$output .= '<div class="modularis-tabs-navigation">';
		foreach ( $tab_titles as $key => $tab ) {
			$tab_class_current = '';
			if ( $key == 0 ) {
				$tab_class_current = 'modularis-tabs-navigation-item--show';
			}
			$output .= '<div class="modularis-tabs-navigation-item ' . $tab_class_current . '"><a class="modularis-tabs-control" href="#themepile-tab-' . sanitize_title(
				$tab[0]
			) . '"><b>' . $tab[0] . '</b></a></div>';
		}
		$output .= '</div>';
		$output .= '<div class="modularis-tabs-wrapper">';
		$output .= do_shortcode( $content );
		$output .= '</div>';
		$output .= '</div>';


		return $output;
	}

	add_shortcode( 'themepile_tabs', 'themepile_tabs' );
}

if ( ! function_exists( 'themepile_tab' ) ) {
	function themepile_tab( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		return '<div id="themepile-tab-' . sanitize_title(
			$title
		) . '" class="modularis-tabs-content">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'themepile_tab', 'themepile_tab' );
}

?>