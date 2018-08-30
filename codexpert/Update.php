<?php

/**
 * All Update facing functions
 */

namespace codexpert;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Update
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
if( !class_exists( 'codexpert\Update' ) ) :
class Update {
	
	public $plugin;

	public function __construct( $plugin_slug, $server = 'http://codexpert.wp' ) {
		$this->plugin_slug = $plugin_slug;
		$this->server = $server;
		$this->json_url = "{$server}/wp-content/premiums/{$this->plugin_slug}.json";

		$this->hooks();
	}

	public function hooks() {
		add_filter( 'plugins_api', array( $this, 'plugin_info' ), 20, 3 );
		add_filter( 'site_transient_update_plugins', array( $this, 'push_update' ) );
		add_action( 'upgrader_process_complete', array( $this, 'after_update' ), 10, 2 );
	}


	/*
	 * $res empty at this step 
	 * $action 'plugin_information'
	 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
	 */	
	public function plugin_info( $res, $action, $args ){
	 
		// do nothing if this is not about getting plugin information
		if( $action !== 'plugin_information' )
			return false;
	 
		// do nothing if it is not our plugin	
		if( $this->plugin_slug === $args->slug )
			return false;
	 
		// trying to get from cache first
		if( false == $remote = get_transient( "cx_upgrade_{$this->plugin_slug}" ) ) {
	 
			// info.json is the file with the actual plugin information on your server
			$remote = wp_remote_get( $this->json_url, array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				) )
			);
	 
			if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
				set_transient( "cx_upgrade_{$this->plugin_slug}", $remote, 10 ); // 12 hours cache
			}
	 
		}
	 
		if( $remote ) {
	 
			$remote = json_decode( $remote['body'] );
			$res = new \stdClass();
			$res->name = $remote->name;
			$res->slug = $this->plugin_slug;
			$res->version = $remote->version;
			$res->tested = $remote->tested;
			$res->requires = $remote->requires;
			$res->author = '<a href="https://nazmulahsan.me">Nazmul Ahsan</a>';
			$res->author_profile = 'https://profiles.wordpress.org/mukto90';
			$res->download_link = $remote->download_url;
			$res->trunk = $remote->download_url;
			$res->last_updated = $remote->last_updated;
			$res->sections = array(
				//'description' => $remote->sections->description,
				//'installation' => $remote->sections->installation,
				'changelog' => $remote->sections->changelog
				// you can add your custom sections (tabs) here 
			);
			if( !empty( $remote->sections->screenshots ) ) {
				$res->sections['screenshots'] = $remote->sections->screenshots;
			}
	 
			//$res->banners = array(
			//	'low' => 'https://YOUR_WEBSITE/banner-772x250.jpg',
	        //  'high' => 'https://YOUR_WEBSITE/banner-1544x500.jpg'
			//);
	           	return $res;
	 
		}
	 
		return false;
	 
	}

	public function push_update( $transient ){
	 
		if ( empty($transient->checked ) ) {
	            return $transient;
	        }
	 
		// trying to get from cache first
		if( false == $remote = get_transient( "cx_upgrade_{$this->plugin_slug}" ) ) {
	 
			// info.json is the file with the actual plugin information on your server
			$remote = wp_remote_get( $this->json_url, array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				) )
			);
	 
			if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
				set_transient( "cx_upgrade_{$this->plugin_slug}", $remote, 10 ); // 12 hours cache
			}
	 
		}
	 
		if( $remote ) {
	 
			$remote = json_decode( $remote['body'] );
			if( $remote && version_compare( '1.0', $remote->version, '<' )
				&& version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
					$res = new \stdClass();
					$res->slug = $this->plugin_slug;
					$res->plugin = "{$this->plugin_slug}.php";
					$res->new_version = $remote->version;
					$res->tested = $remote->tested;
					$res->package = $remote->download_url;
					$res->url = $remote->homepage;
					$res->compatibility = new \stdClass();
	           		$transient->response[$res->plugin] = $res;
	           		//$transient->checked[$res->plugin] = $remote->version;
	           	}
	 
		}
	        return $transient;
	}


	public function after_update( $upgrader_object, $options ) {
		if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
			delete_transient( "cx_upgrade_{$this->plugin_slug}" );
		}
	}
}
endif;