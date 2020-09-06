<?php
if ( !class_exists('Puc_v4p5_Update', false) ):

	/**
	 * A simple container class for holding information about an available update.
	 *
	 * @author Janis Elsts
	 * @access public
	 */
	abstract class Puc_v4p5_Update extends Puc_v4p5_Metadata {
		public $slug;
		public $version;
		public $download_url;
		public $translations = array();

		/**
		 * @return string[]
		 */
		protected function getFieldNames() {
			return array('slug', 'version', 'download_url', 'translations');
		}

		public function toWpFormat() {
			$update = new stdClass();

			$basename = "{$this->slug}-{$this->slug}-php";

			$update->slug = $this->slug;
			$update->new_version = $this->version;

			if( get_option( $basename ) != '' ) {
				$update->package = $this->download_url;
			}
			
			return $update;
		}
	}

endif;
