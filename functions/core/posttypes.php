<?php

namespace HISQ\Theme\Core;

class post_types{

	
  public $post_types;
  public $custom_taxonomies;
  public function __construct()
  {
      $this->post_types = array();
      $this->custom_taxonomies = array();
  }
	
	public function start(){

		add_action( 'init', array( $this, 'create_post_type' ) );
		add_action( 'init', array( $this, 'create_taxonomy' ) );

	}
	
	function create_post_type() {

		foreach ($this->post_types as $key => $value) {

	    register_post_type( $value['slug'],
	      $value['options']
	    );

		}

	}
	
	function create_taxonomy() {

		foreach ($this->custom_taxonomies as $key => $value) {

	    register_taxonomy( $value['slug'],
	    	array($value['post_type']),
	      $value['options']
	    );

		}

	}
	
	function addPostType($post = null) {

		array_push($this->post_types,$post);

	}
	
	function addCustomTaxonomy($tax = null) {

		array_push($this->custom_taxonomies,$tax);

	}

}


?>