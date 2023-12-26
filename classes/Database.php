<?php
namespace Codexpert\CX_Plugin;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Database
 * @author Codexpert <hi@codexpert.io>
 */
class Database {

	public $db;

	public $prefix;

	public $collate;

	/**
	 * Constructor function
	 */
	public function __construct() {
		
		global $wpdb;

		$this->db		= $wpdb;
		$this->prefix	= $this->db->prefix . 'cx_';
		$this->collate	= $this->db->get_charset_collate();
	}

	public function exec( $query ) {
		dbDelta( $query );
	}

	public function prepare( $query, ...$args ) {
		return $this->db->prepare( $query, ...$args );
	}

	public function insert( $table, $data = [], $format = [] ) {

		if( $data == [] ) return;

		$this->db->insert(
			$this->prefix . $table,
			$data,
			$format
		);

		return $this->get_last_id();
	}

	public function delete( $table, $where = [], $format = [] ) {

		if( $where == [] ) return;

		$this->db->delete(
			$this->prefix . $table,
			$where,
			$format
		);
	}

	public function update( $table, $data = [], $where = [] ) {

		if( $data == [] ) return;

		$this->db->update(
			$this->prefix . $table,
			$data,
			$where
		);

		return $this->get_last_id();
	}

	/**
	 * Lists data from a specific table
	 * 
	 * @param array $where `[ [ key, value, compare? ] ]` or `[ key, value, compare? ]`
	 * 
	 * @return [ object ]
	 */
	public function list( $table, $select = '*', $where = [], $limit = null ) {
		
		$sql = "SELECT {$select} FROM `{$this->prefix}{$table}` WHERE 1 = 1";

		$has_IN_operator = false;

		if( is_array( $where ) && count( $where ) > 0 ) {
			
			if( ! is_array( $where[0] ) ) {
				$where = [ $where ];
			}

			foreach ( $where as $set ) {
				if( ! is_null( $set[0] ) && ! is_null( $set[1] ) ) {
					$key		= $set[0];
					$value		= $set[1];
					$compare	= ! isset( $set[2] ) ? '=' : $set[2];

					if( $compare == 'LIKE' ) {
						$value = "%$value%";
					}

					if( $compare == 'IN' && is_array( $value ) ) {
						$value = sprintf( '(%s)', implode( ',', $value ) );

						$has_IN_operator = true;
					}

					$sql .= $this->db->prepare(
						( is_numeric( $value ) ? ' AND `%1$s` %2$s %3$s' : ' AND `%1$s` %2$s \'%3$s\'' ),
						$key,
						$compare,
						$value
					);
				}
			}
		}

	    if( $limit ) {
			$sql .= " LIMIT {$limit}";
		}

		if( $has_IN_operator ) {
			$sql = str_replace( [ '\'(', ')\'' ], [ '(', ')' ], $sql );
		}

		return $this->run( $sql );
	}

	public function get( $table, $select = '*', $where = [] ) {
		$query = $this->list( $table, $select, $where, 1 );

		if( count( $query ) <= 0 ) return [];

		return $query[0];
	}

	public function run( $sql, $return = ARRAY_A ) {
		return $this->db->get_results( $sql, $return );
	}

	public function get_last_id() {
		return $this->db->insert_id;
	}

	/**
	 * If an item is found in a given table
	 * 
	 * @return bool
	 */
	public function is_found( $table, $where = [] ) {
		return count( $this->list( $table, '*', $where ) ) > 0;
	}
}