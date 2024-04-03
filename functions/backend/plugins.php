<?php

namespace HISQ\Theme\Backend;

class plugins{

	public function __construct(){

		add_action( 'tgmpa_register', array( $this, 'required_Plugins' ) );

	}

	function required_Plugins() {

			$plugins = array(
			array(
				"name" => "Wordpress SEO",
				"slug" => "wordpress-seo",
				"force_activation" => false,
				"required" => false
			),
			array(
				"name" => "Advanced Custom Fields",
				"slug" => "advanced-custom-fields",
				"force_activation" => false,
				"required" => false
			),
			array(
				"name" => "The WP Remote WordPress Plugin",
				"slug" => "wpremote",
				"force_activation" => false,
				"required" => false
			)

		 );

		 tgmpa( $plugins );

	}
}


?>