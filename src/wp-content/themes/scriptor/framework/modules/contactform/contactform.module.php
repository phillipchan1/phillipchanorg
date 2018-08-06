<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( class_exists( 'ThemePile_Core_Abstract' ) ) {
	/**
	 *
	 */
	class ThemePile_ContactForm extends ThemePile_Core_Abstract {

		/**
		 * @var string
		 */
		public static $_module_name = 'contactform';


		/**
		 * type, label, name, validate(callback)
		 * @var array
		 */
		private $_inputs = array(
			array( 'type' => 'text', 'placeholder' => 'Your Name', 'name' => 'your_name', 'validate' => 'tp_is_null' ),
			array(
				'type'        => 'text',
				'placeholder' => 'Your Email',
				'name'        => 'email',
				'validate'    => 'tp_is_null,is_email'
			),
			array( 'type' => 'text', 'placeholder' => 'Your Phone', 'name' => 'phone', 'validate' => false ),
			array(
				'type'        => 'textarea',
				'placeholder' => 'Your Message',
				'name'        => 'message',
				'validate'    => 'tp_is_null'
			),
		);


		/**
		 * @var
		 */
		private $_title;


		/**
		 * @var
		 */
		private $_result;


		/**
		 * @var array
		 */
		private $_errors = array();


		/**
		 * @var array
		 */
		private $_post_data = array();


		public $_skip_mail = false;

		public function __construct() {
			$this->setTitle( apply_filters( 'themepile_contactform_title', __( 'Contact Form', THEMEPILE_LANGUAGE ) ) );
		}

		/**
		 *
		 */
		public function validate() {

			if ( ! wp_verify_nonce( self::post( '_wpnonce', true ), 'themepile_contactform' ) ) {
				$this->setResult( false );
				return;
			}

			foreach ( $this->getInputs() as $input ) {
				extract( $input );
				$callbacks = explode( ',', $validate );

				$value = self::post( $name, true );

				$this->setPostData( $name, $value );

				foreach ( $callbacks as $func ) {
					$func = trim( $func );
					if ( ! function_exists( $func ) || empty( $func ) ) {
						continue;
					}

					$result = call_user_func( $func, $value );

					if ( ! $result ) {
						$this->setError( $name );
						break; // exit from foreach
					}
				}
			}

			if ( sizeof( $this->getErrors() ) > 0 ) {
				$this->setResult( false );
				return;
			}

			$this->setResult( true );
			$this->send();
		}


		/**
		 *
		 */
		protected function send() {

			do_action( 'themepile_before_send_mail' );

			if ( ! $this->_skip_mail ) {
				$result = wp_mail(
					ThemePileTheme::get_theme_option( 'admin_email', true ),
					$this->getTitle(),
					implode( "\n\n", $this->getPostDatas() )
				);

				if ( ! $result ) {
					$this->setResult( false );
				}
			}

			do_action( 'themepile_after_send_mail' );
		}


		/**
		 *
		 */
		public function render() {
			$this->prepare_inputs();
			self::getView( self::$_module_name, 'form', array( 'form' => $this ) );
		}

		/**
		 * @static
		 *
		 * @param $type
		 * @param $name
		 * @param $placeholder
		 * @param $validate
		 */
		public function render_input( $type, $name, $placeholder, $validate ) {

			$validate = ( $validate != false ) ? apply_filters(
				'themepile_contactform_required_label',
				'<span class="form-required">*</span>'
			) : '';

			$errors = '<label for="%s" generated="true" class="error">' . __(
				'This field is required.',
				THEMEPILE_LANGUAGE
			) . '</label>';

			$class_error = '';
			if ( $this->isError( $name ) ) {
				$validate    = sprintf( $errors, $name ) . $validate;
				$class_error = ' error';
			}

			// @todo: add support select, radio, checkbox, etc.
			switch ( $type ) {
				case 'textarea':
					printf(
						'<textarea id="%s" name="%s" class="textarea%s" rows="8" cols="45" placeholder="%s">%s</textarea>%s',
						esc_attr( $name ),
						esc_attr( $name ),
						$class_error,
						esc_attr( $placeholder ),
						$this->getPostData( $name ),
						$validate
					);
					break;
				case 'text':
				default:
					printf(
						'<input type="%s" id="%s" name="%s" class="input%s" value="%s" placeholder="%s">%s',
						esc_attr( $type ),
						esc_attr( $name ),
						esc_attr( $name ),
						$class_error,
						$this->getPostData( $name ),
						esc_attr( $placeholder ),
						$validate
					);
					break;
			}
		}

		/**
		 *
		 */
		public function prepare_inputs() {
			$this->setInputs( apply_filters( 'themepile_contactform_inputs', $this->getInputs() ) );
		}


		/**
		 *
		 */
		public function before_inputs() {
			?>
			<input type="hidden" name="themepile_contactform" value="1">
			<input type="hidden" name="action" value="themepile_contactform">
			<?php
			wp_nonce_field( 'themepile_contactform' );
			do_action( 'themepile_contactform_before_inputs' );
		}


		/**
		 *
		 */
		public function after_inputs() {
			do_action( 'themepile_contactform_after_inputs' );
		}

		/**
		 * @param $inputs
		 */
		public function setInputs( $inputs ) {
			$this->_inputs = $inputs;
		}

		/**
		 * @return array
		 */
		public function getInputs() {
			return $this->_inputs;
		}

		/**
		 * @param $error
		 */
		public function setError( $name, $error = true ) {
			$this->_errors[$name] = $error;
		}

		/**
		 * @param $errors
		 */
		public function setErrors( $errors ) {
			$this->_errors = $errors;
		}

		/**
		 * @return array
		 */
		public function getErrors() {
			return $this->_errors;
		}

		public function isError( $name ) {
			if ( isset( $this->_errors[$name] ) ) {
				return true;
			}
			return false;
		}

		/**
		 * @param $result
		 */
		public function setResult( $result ) {
			$this->_result = $result;
		}

		/**
		 * @return mixed
		 */
		public function getResult() {
			return $this->_result;
		}

		/**
		 * @param $title
		 */
		public function setTitle( $title ) {
			$this->_title = $title;
		}

		/**
		 * @return mixed
		 */
		public function getTitle() {
			return $this->_title;
		}


		/**
		 * @param $name
		 * @param $post_data
		 */
		public function setPostData( $name, $post_data ) {
			$this->_post_data[$name] = $post_data;
		}


		/**
		 * @param $param
		 *
		 * @return string
		 */
		public function getPostData( $param ) {
			return ( isset( $this->_post_data[$param] ) ? esc_html( $this->_post_data[$param] ) : '' );
		}

		/**
		 * @return array
		 */
		public function getPostDatas() {
			return $this->_post_data;
		}
	}

	add_action( 'init', array( ThemePile_ContactForm::getInstance(), 'validate' ) );


	/**
	 * Validate Function Example
	 *      true - valid
	 *      false - invalid
	 *
	 * @param $value
	 *
	 * @return bool
	 */
	function tp_is_null( $value ) {
		if ( empty( $value ) || is_null( $value ) ) {
			return false;
		}

		return true;
	}
}
