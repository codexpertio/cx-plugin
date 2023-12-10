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

	public function create_tables() {

	    $generics_sql = "CREATE TABLE `{$this->prefix}test` (
            id bigint NOT NULL AUTO_INCREMENT,
            name varchar(255),
            PRIMARY KEY (id)
        ) $this->collate;";

	    $this->exec( $generics_sql );
	}

	public function exec( $query ) {
		dbDelta( $query );
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
	}

	/**
	 * @param array $where `[ [ key, value, compare ] ]` or `[ key, value, compare ]`
	 */
	public function list( $table, $select = '*', $where = [], $limit = null ) {
		
		$sql = "SELECT {$select} FROM `{$this->prefix}{$table}` WHERE 1 = 1";

		if( is_array( $where ) && count( $where ) > 0 ) {
			
			if( ! is_array( $where[0] ) ) {
				$where = [ $where ];
			}

			foreach ( $where as $set ) {
				if( isset( $set[0] ) && isset( $set[1] ) ) {
					
					$key		= $set[0];
					$value		= $set[1];
					$compare	= ! isset( $set[2] ) ? '=' : $set[2];

					if( $compare == 'LIKE' ) {
						$value = "%$value%";
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

		return $this->run( $sql, ARRAY_A );
	}

	public function run( $sql, $return = ARRAY_A ) {
		return $this->db->get_results( $sql, $return );
	}

	public function get_last_id() {
		return $this->db->insert_id;
	}
}