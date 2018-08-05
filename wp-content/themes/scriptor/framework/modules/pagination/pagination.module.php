<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
/**
 * ThemePile Pagination
 *
 * NOTICE OF LICENSE
 *
 * <notice_of_license>
 *
 * @category  ThemePile Pagination
 * @package   ThemePile Framework
 * @copyright Copyright (c) 2013 ThemePile (http://www.themepile.co.uk/). All Rights Reserved.
 * @license   <license_url>
 */

/**
 * ThemePile Pagination Class
 *
 */

if ( class_exists( 'ThemePile_Core_Abstract' ) ) {

	class ThemePile_Pagination extends ThemePile_Core_Abstract {
		public $currentPage;

		public $postsPerPage;

		public $countPages;

		public $postType;

		public $term;

		public $taxonomy;

		private $_countVisiblePages = 4;

		private $_isAjax;


		public function __construct( $isAjax = false ) {

			global $wp_query;

			$this->_isAjax      = $isAjax;
			$this->postType     = isset( $wp_query->query_vars['post_type'] ) ? $wp_query->query_vars['post_type'] : self::post(
				'post_type',
				true
			);
			$this->term         = isset( $wp_query->query_vars['term'] ) ? $wp_query->query_vars['term'] : self::post(
				'term',
				true
			);
			$this->taxonomy     = isset( $wp_query->query_vars['taxonomy'] ) ? $wp_query->query_vars['taxonomy'] : self::post(
				'taxonomy',
				true
			);
			$this->_wpQuery     = & $wp_query;
			$this->postsPerPage = intval( get_option( 'posts_per_page' ) );
			$this->currentPage  = get_query_var( 'paged' );
			$this->currentPage  = empty( $this->currentPage ) ? 1 : intval( $this->currentPage );
			$this->countPages   = intval( ceil( $this->_wpQuery->found_posts / $this->postsPerPage ) );

			if ( $isAjax ) {
				$this->currentPage = self::post( 'page', array( 'intval' ), $this->currentPage );
			}
		}

		public function getPrevLink() {
			return esc_url( get_pagenum_link( $this->currentPage - 1 ) );
		}

		public function getNextLink() {
			return esc_url( get_pagenum_link( $this->currentPage + 1 ) );
		}

		public function generate() {
			if ( $this->countPages <= 1 ) {
				return;
			}
			return self::getView( 'pagination', 'pagination', array( 'pagination' => $this ), true );
		}

		public function ajaxGetResult() {

			$posts = '';
			query_posts(
				array(
					'post_type'     => $this->postType,
					'post_status'   => 'publish',
					'paged'         => $this->currentPage,
					$this->taxonomy => $this->term
				)
			);

			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					ob_start();
					include( get_template_directory() . '/loop.php' );
					$posts .= ob_get_contents();
					@ob_end_clean();
				}
			}


			echo json_encode(
				array(
					'currentPage' => $this->currentPage,
					'countPages'  => intval( ceil( $this->_wpQuery->found_posts / $this->postsPerPage ) ),
					'result'      => $posts,
				)
			);

			exit();
		}

		public function getPaginator() {
			if ( $this->_isAjax ) {
				return self::getView( 'pagination', 'paginationAjax', array( 'pagination' => $this ), true );
			}

			return $this->generate();
		}

		public function getStartVisiblePage() {
			$part = $this->_countVisiblePages / 2;
			if ( $this->currentPage <= $part ) {
				return 1;
			}

			if ( $this->countPages - $this->currentPage - $part < 0 && ( $this->currentPage - $part + $this->countPages - $this->currentPage - $part ) > 0 ) {
				return $this->currentPage - $part + $this->countPages - $this->currentPage - $part;
			}

			return $this->currentPage - $part;


		}

		public function getEndVisiblePage() {
			$part = $this->_countVisiblePages / 2;
			if ( $this->currentPage + $part > $this->countPages ) {
				return $this->countPages;
			}

			if ( $this->getStartVisiblePage() + $part - $this->currentPage > 0 && ( $this->getStartVisiblePage() + $this->_countVisiblePages <= $this->countPages )
			) {
				return $this->getStartVisiblePage() + $this->_countVisiblePages;
			}

			return $this->currentPage + $part;


		}
	}

	function ThemePile_Pagination() {
		$isAjaxPagination = ThemePileTheme::get_theme_option( 'pagination_type', true ) == 'ajax' ? true : false;
		$pagination       = new ThemePile_Pagination( $isAjaxPagination );
		return $pagination->getPaginator();

	}

	if ( ! function_exists( 'themepile_pagination_enqueue_scripts' ) ) :
		function themepile_pagination_enqueue_scripts () {
			wp_register_script( 'jquery.modularis.pagination', THEMEPILE_FRAMEWORK_PATH_URI . '/assets/js/modularis/jquery.modularis.pagination.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'jquery.modularis.pagination' );
		}
	endif;

	add_action( 'wp_ajax_pagination', array( new ThemePile_Pagination( true ), 'ajaxGetResult' ) );
	add_action( 'wp_ajax_nopriv_pagination', array( new ThemePile_Pagination( true ), 'ajaxGetResult' ) );
	add_action( 'wp_ajax_no_pagination', array( new ThemePile_Pagination( true ), 'ajaxGetResult' ) );
	add_action( 'wp_ajax_nopriv_no_pagination', array( new ThemePile_Pagination( true ), 'ajaxGetResult' ) );
	add_action( 'wp_enqueue_scripts', 'themepile_pagination_enqueue_scripts' );




} // class_exist