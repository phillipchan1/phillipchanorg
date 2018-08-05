<?php
/**
 * ThemePile Model
 *
 * @package    WordPress
 * @subpackage ThemePile
 * @since      Scriptor
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * ThemePile Model
 *
 * @category ThemePile
 */

class ThemePile_Model {

	/**
	 * wpdb object
	 *
	 */
	protected $_db;

	/**
	 * Current Table
	 *
	 */
	protected $_table;

	/**
	 * Is query SQL_CALC_FOUND_ROWS
	 *
	 * @access private
	 * @var bool
	 */
	private $_foundRows = false;

	/**
	 * Construct
	 *
	 */
	public function __construct() {
		global $wpdb;
		$this->_db = $wpdb;
	}

	/**
	 * Get All
	 *
	 * @param array $where
	 * @param int   $limit
	 * @param int   $offset
	 *
	 * @return object
	 */
	public function getAll(
		$where = array(),
		$orderBy = array( 'id', 'ASC' ),
		$limit = 30,
		$offset = 0,
		$calcFoundRows = false
	) {
		$wheres = array();
		foreach ( (array) $where as $field => $value ) {
			$wheres[] = "`$field` = {$value}";
		}
		$where         = count( $wheres ) > 0 ? ( 'WHERE ' . implode( ' AND ', $wheres ) ) : '';
		$calcFoundRows = $calcFoundRows ? 'SQL_CALC_FOUND_ROWS' : '';

		if ( $calcFoundRows ) {
			$calcFoundRows    = 'SQL_CALC_FOUND_ROWS';
			$this->_foundRows = true;
		}
		else {
			$calcFoundRows    = '';
			$this->_foundRows = false;
		}

		return $this->_db->get_results(
			"SELECT {$calcFoundRows} * FROM {$this->_table} {$where} ORDER BY {$orderBy[0]} {$orderBy[1]} LIMIT {$offset}, {$limit}"
		);
	}

	/**
	 * Get One
	 *
	 * @param int    $id
	 * @param string $field
	 *
	 * @return object
	 */
	public function getOne( $id, $field = 'id' ) {
		return $this->_db->get_row(
			$this->_db->prepare( "SELECT * FROM `{$this->_table}` WHERE `{$field}` = '%s' LIMIT 1", $id )
		);
	}

	/**
	 * Get Count
	 *
	 * @param string $field
	 *
	 * @return int
	 */
	public function getCount( $field = 'id' ) {
		if ( $this->_foundRows ) {
			$sql              = 'SELECT FOUND_ROWS();';
			$this->_foundRows = false;
		}
		else {
			$sql = "SELECT COUNT({$field}) FROM {$this->_table}";
		}

		return ( int ) $this->_db->get_var( $sql );
	}

	/**
	 * Set Table
	 *
	 * @param string $table
	 *
	 * @return ThemePile_Model
	 */
	public function setTable( $table ) {
		$this->_table = $table;
		return $this;
	}

	/**
	 * Delete Row
	 *
	 * @param int|string $value
	 * @param string     $field
	 * @param int        $limit
	 *
	 * @return bool
	 */
	public function delete( $value, $field = 'id', $limit = 1 ) {
		return $this->_db->query(
			$this->_db->prepare( "DELETE FROM `{$this->_table}` WHERE `{$field}` = '%s' LIMIT %d", $value, $limit )
		);
	}

	/**
	 * Query
	 *
	 * @param string $query
	 *
	 * @return object | bool
	 */
	public function query( $query ) {
		return $this->_db->query( $query );
	}

	/**
	 * Update Row
	 *
	 * @param array        $data
	 * @param array        $where
	 * @param array|string $format
	 * @param array|string $where_format
	 *
	 * @return bool
	 */
	public function update( $data, $where, $format = null, $where_format = null ) {
		return $this->_db->update( $this->_table, $data, $where, $format, $where_format );
	}

	/**
	 * Insert
	 *
	 * @param array        $data
	 * @param array|string $format
	 *
	 * @return bool
	 */
	public function insert( $data, $format = null ) {
		return $this->_db->insert( $this->_table, $data, $format );
	}

	/**
	 * DB
	 *
	 * @return object (wpdb)
	 */
	public function db() {
		return $this->_db;
	}
}