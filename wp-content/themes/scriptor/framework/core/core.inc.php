<?php
/**
 * ThemePile Core Framework
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! function_exists( 'get_called_class' ) ) {
	function get_called_class() {
		$obj       = false;
		$backtrace = debug_backtrace();
		foreach ( $backtrace as $row ) {
			if ( $row['function'] == 'call_user_func' ) {
				$obj = explode( '::', $backtrace[2]['args'][0] );
				$obj = $obj[0];
				break;
			}
		}
		if ( ! $obj ) {
			$backtrace = $backtrace[1];
			$file      = file_get_contents( $backtrace["file"] );
			$file      = explode( "\n", $file );
			for ( $line = $backtrace["line"] - 1; $line > 0; $line -- ) {
				preg_match( "/(?<class>\w+)::(.*)/", trim( $file[$line] ), $matches );
				if ( isset( $matches["class"] ) ) {
					return $matches["class"];
				}
			}
			throw new Exception( "Could not find" );
		}
		return $obj;
	}
}

class ThemePile_Core_Abstract {

	// only one instance
	private static $instances = array();

	protected function __construct() {
	}

	protected function __clone() {
	}

	public static function getInstance() {
		$cls = get_called_class(); // late-static-bound class name
		if ( ! isset( self::$instances[$cls] ) ) {
			self::$instances[$cls] = new $cls;
		}
		return self::$instances[$cls];
	}

	/**
	 * For childs
	 *
	 * @param     $action
	 * @param     $method
	 * @param int $priority
	 * @param int $args
	 *
	 * @return ThemePile_Abstract
	 */
	public function add_action( $action, $method, $priority = 10, $args = 1 ) {
		add_action( $action, array( $this, $method ), $priority, $args );
		return $this;
	}


	/**
	 * For childs
	 *
	 * @param     $action
	 * @param     $method
	 * @param int $priority
	 * @param int $args
	 *
	 * @return ThemePile_Abstract
	 */
	public function add_filter( $action, $method, $priority = 10, $args = 1 ) {
		add_filter( $action, array( $this, $method ), $priority, $args );
		return $this;
	}


	/**
	 * Labels array for register custom post types
	 * @static
	 *
	 * @param        $name
	 * @param string $singularName
	 * @param string $addItem
	 *
	 * @return array
	 */
	public static function getPostLabel( $name, $singularName = '', $addItem = '' ) {
		if ( empty( $singularName ) ) {
			$singularName = $name;
		}

		return array(
			'name'          => __( $name ),
			'singular_name' => __( $singularName, THEMEPILE_LANGUAGE ),
			'add_new'       => __( 'Add new ' . $addItem, THEMEPILE_LANGUAGE ),
			'add_new_item'  => __( 'Add new ' . $addItem, THEMEPILE_LANGUAGE ),
			'edit_item'     => __( 'Edit ' . $addItem, THEMEPILE_LANGUAGE ),
			'menu_name'     => __( $name, THEMEPILE_LANGUAGE )
		);
	}


	/**
	 * Generate Array for register taxonomy or custom post types
	 * @static
	 *
	 * @param      $name
	 * @param null $plural
	 *
	 * @return array
	 */
	public static function returnLabels( $name, $plural = null ) {
		return array(
			'name'               => $plural ? $plural : $name . 's',
			'singular_name'      => $name,
			'add_new'            => __( 'Add New ' . $name, THEMEPILE_LANGUAGE ),
			'add_new_item'       => __( 'Add New ' . $name, THEMEPILE_LANGUAGE ),
			'view'               => __( 'View ' . $name, THEMEPILE_LANGUAGE ),
			'view_item'          => __( 'View ' . $name, THEMEPILE_LANGUAGE ),
			'edit'               => __( 'Edit ' . $name, THEMEPILE_LANGUAGE ),
			'edit_item'          => __( 'Edit ' . $name, THEMEPILE_LANGUAGE ),
			'new_item'           => __( 'New ' . $name, THEMEPILE_LANGUAGE ),
			'search_items'       => __( 'Search in ' . ( $plural ? $plural : $name ), THEMEPILE_LANGUAGE ),
			'not_found'          => __( 'No ' . $name . ' found', THEMEPILE_LANGUAGE ),
			'not_fount_in_trash' => __( 'No ' . $name . ' found in Trash', THEMEPILE_LANGUAGE )
		);
	}

	/**
	 * Get View
	 *
	 * @param string $module
	 * @param string $view
	 * @param array  $vars
	 * @param bool   $return
	 *
	 * @return string
	 */
	public static function getView( $module, $view, $vars = array(), $return = false ) {
		$viewFile = THEMEPILE_FRAMEWORK_MODULE_PATH . '/' . $module . '/views/' . $view . '.php';

		if ( ! file_exists( $viewFile ) ) {
			self::throwException( 'Undefined view file ' . $viewFile );
		}

		ob_start();

		extract( $vars );
		include( $viewFile );
		$buffer = ob_get_contents();

		@ob_end_clean();

		if ( $return === true ) {
			return $buffer;
		}
		echo $buffer;
	}

	/**
	 * Retrieve model object
	 *
	 * @param string $plugin
	 * @param string $model
	 *
	 * @return object
	 */
	public static function getModel( $module = false, $model = false ) {
		if ( $module === false && $model === false ) {
			return new ThemePile_Model();
		}

		$modelFile = THEMEPILE_FRAMEWORK_MODULE_PATH . "/" . $module . '/models/' . ucfirst( $model ) . 'Model.php';
		$className = $module . '_' . ucfirst( $model ) . 'Model';

		if ( ! file_exists( $modelFile ) ) {
			self::throwException( 'Undefined model file ' . $modelFile );
		}

		require_once( $modelFile );

		if ( ! class_exists( $className ) ) {
			self::throwException( 'Undefined model class ' . $className );
		}

		return new $className;
	}

	/**
	 * Retrieve controller object
	 *
	 * @param string $plugin
	 * @param string $controller
	 * @param string $className
	 *
	 * @return object
	 */
	public static function getController( $module, $controller ) {
		$controllerFile = THEMEPILE_FRAMEWORK_MODULE_PATH . "/" . $module . '/controllers/' . ucfirst(
			$controller
		) . 'Controller.php';
		$className      = $module . '_' . ucfirst( $controller ) . 'Controller';

		if ( ! file_exists( $controllerFile ) ) {
			self::throwException( 'Undefined controller file ' . $controllerFile );
		}

		require_once( $controllerFile );

		if ( ! class_exists( $className ) ) {
			self::throwException( 'Undefined controller class ' . $className );
		}

		return new $className;
	}

	/**
	 * Retrieve Library object
	 *
	 * @param string $lib
	 * @param string $plugin
	 *
	 * @return object
	 */
	public static function getLib( $lib, $plugin = 'ThemePile' ) {
		if ( ! defined( 'WP_PLUGIN_DIR' ) ) {
			self::throwException( 'WP_PLUGIN_DIR is not defined' );
		}

		$libFile = WP_PLUGIN_DIR . '/' . $plugin . '/libraries/' . $lib . '.php';

		if ( ! file_exists( $libFile ) ) {
			self::throwException( 'Undefined library file ' . $libFile );
		}

		require_once( $libFile );

		if ( ! class_exists( $lib ) ) {
			self::throwException( 'Undefined library class ' . $model );
		}

		return new $lib;
	}

	/**
	 * Throw Exception
	 *
	 * @param string $message
	 */
	public static function throwException( $message ) {
		throw new Themepile_Core_Exception( $message );
	}

	/**
	 * Write to log file
	 *
	 * @param string $errorMessage
	 */
	public static function log( $errorMessage, $echo = true ) {
		if ( ! defined( 'WP_PLUGIN_DIR' ) ) {
			return;
		}

		$logDir  = plugin_dir_path( __FILE__ ) . 'log';
		$logFile = $logDir . '/system.log';

		try {
			if ( ! is_dir( $logDir ) ) {
				mkdir( $logDir, 0777, true );
			}

			$fp = fopen( $logFile, 'a+' );
			fwrite( $fp, $errorMessage . PHP_EOL );
			fclose( $fp );

			if ( $echo ) {
				echo __( 'An error has occured. Error code has been saved to the log fie. <br />' );
			}
		} catch ( Exception $e ) {
		}
	}

	/**
	 * Xss Clean
	 *
	 * @param string $str
	 *
	 * @return string
	 */
	public static function xssClean( $str ) {
		if ( get_magic_quotes_gpc() ) {
			$str = stripslashes( $str );
		}

		$str = htmlspecialchars( $str );
		$str = str_replace( "'", '&rsquo;', $str );
		$str = str_replace( "/", '&frasl;', $str );
		$str = strip_tags( $str );

		return $str;
	}

	/**
	 * Get Array Value
	 *
	 * @param array      $array
	 * @param string|int $index
	 * @param moxed      $return
	 * @param bool       $xssClean
	 *
	 * @return mixed
	 */
	public static function getArrayValue( $array, $index, $return, $xssClean ) {
		if ( ! array_key_exists( $index, $array ) ) {
			return $return;
		}

		$result = $array[$index];

		if ( is_array( $xssClean ) ) {
			foreach ( $xssClean as $rule ) {
				if ( function_exists( $rule ) ) {
					$result = $rule( $result );
				}
			}
		}
		elseif ( is_bool( $xssClean ) && $xssClean === true ) {
			$result = self::xssClean( $result );
		}

		return $result;
	}

	/**
	 * Get Value From POST Array
	 *
	 * @param string $index
	 * @param bool   $xssClean
	 * @param mixed  $return
	 *
	 * @return string|bool
	 */
	public static function post( $index = '', $xssClean = false, $return = false ) {
		return self::getArrayValue( $_POST, $index, $return, $xssClean );
	}

	/**
	 * Get Value From GET Array
	 *
	 * @param string $index
	 * @param bool   $xssClean
	 * @param mixed  $return
	 *
	 * @return string|bool
	 */
	public static function get( $index = '', $xssClean = false, $return = false ) {
		return self::getArrayValue( $_GET, $index, $return, $xssClean );
	}

	/**
	 * Get Value From REQUEST Array
	 *
	 * @param string $index
	 * @param bool   $xssClean
	 * @param mixed  $return
	 *
	 * @return string|bool
	 */
	public static function request( $index = '', $xssClean = false, $return = false ) {
		return self::getArrayValue( $_REQUEST, $index, $return, $xssClean );
	}

	/**
	 * Get Value From SESSION Array
	 *
	 * @param string $index
	 * @param bool   $xssClean
	 * @param mixed  $return
	 *
	 * @return string|bool
	 */
	public static function session( $index = '', $xssClean = false, $return = false ) {
		return self::getArrayValue( $_SESSION, $index, $return, $xssClean );
	}

	/**
	 * Get Value From COOKIE Array
	 *
	 * @param string $index
	 * @param bool   $xssClean
	 * @param mixed  $return
	 *
	 * @return string|bool
	 */
	public static function cookie( $index = '', $xssClean = false, $return = false ) {
		return self::getArrayValue( $_COOKIE, $index, $return, $xssClean );
	}

	/**
	 * Get Value From URL
	 *
	 * @param int   $key
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public static function urlSegment( $key = 1, $default = false ) {
		if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
			return $default;
		}

		$url = explode( '/', $_SERVER['REQUEST_URI'] );
		if ( array_key_exists( $key, $url ) && $url[$key] != '' ) {
			return $url[$key];
		}

		return $default;
	}

	/**
	 * Is Ajax Query
	 *
	 * @return bool
	 */
	public static function isAjaxQuery() {
		if ( self::request( 'ajax' ) ) {
			return true;
		}

		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower(
			$_SERVER['HTTP_X_REQUESTED_WITH']
		) == 'xmlhttprequest'
		) {
			return true;
		}

		return false;
	}
}


/**
 * Catching Errors And Exceptions
 *
 * @category    ThemePile
 * @package     ThemePile_All
 * @author      ThemePile
 */

class Themepile_Core_Exception extends Exception {
}

if ( THEMEPILE_LOGGING ) {
	set_exception_handler( 'themepileCoreError' );
	set_error_handler( 'themepileCoreError' );
}

/**
 * ThemePile Error Catcher
 *
 * @param int|object $errno
 * @param string     $errmsg
 * @param string     $errfile
 * @param int        $errline
 */
function themepileCoreError( $errno, $errmsg = null, $errfile = null, $errline = 0 ) {
	if ( func_num_args() == 1 && is_object( $errno ) && $errno instanceof Exception ) {
		$exception = $errno;
		$errno     = $exception->getCode();
		$errmsg    = $exception->getMessage();
		$errfile   = $exception->getFile();
		$errline   = $exception->getLine();
	}

	if ( ! defined( 'E_STRICT' ) ) {
		define( 'E_STRICT', 2048 );
	}

	if ( $errno == E_STRICT ) {
		return true;
	}

	$errorMessage = '';

	switch ( $errno ) {
		case E_ERROR:
			$errorMessage .= "Error";
			break;

		case E_WARNING:
			$errorMessage .= "Warning";
			break;

		case E_PARSE:
			$errorMessage .= "Parse Error";
			break;

		case E_NOTICE:
			$errorMessage .= "Notice";
			break;

		case E_CORE_ERROR:
			$errorMessage .= "Core Error";
			break;

		case E_CORE_WARNING:
			$errorMessage .= "Core Warning";
			break;

		case E_COMPILE_ERROR:
			$errorMessage .= "Compile Error";
			break;

		case E_COMPILE_WARNING:
			$errorMessage .= "Compile Warning";
			break;

		case E_USER_ERROR:
			$errorMessage .= "User Error";
			break;

		case E_USER_WARNING:
			$errorMessage .= "User Warning";
			break;

		case E_USER_NOTICE:
			$errorMessage .= "User Notice";
			break;

		case E_STRICT:
			$errorMessage .= "Strict Notice";
			break;

		case E_RECOVERABLE_ERROR:
			$errorMessage .= "Recoverable Error";
			break;

		case E_DEPRECATED:
			$errorMessage .= "Deprecated functionality";
			break;

		default:
			$errorMessage .= 'Unknown error (' . $errno . ')';
			break;
	}

	$errorMessage .= ": {$errmsg}  in {$errfile} on line {$errline}";

	if ( defined( 'THEMEPILE_DEVELOPER_MODE' ) && THEMEPILE_DEVELOPER_MODE ) {
		echo $errorMessage . '<br />';
	}
	else {
		ThemePile_Core_Abstract::log( $errorMessage );
	}
}
