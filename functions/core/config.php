<?php

namespace HISQ\Theme\Core;

/**
 * TODO
 * 	- Add developement page for us, when we set site to liev automatcally allow th site to be indexed and ask for a google anayitics code.
 * 
 */


class config{

  private $post_types;

  function __construct() {

    $this->post_types = new post_types();
    $this->configure_post_types();
    $this->configure_taxonomies();
    $this->post_types->start();

  }

  function configure_post_types(){

    //add Post Types
    $p = array(
      "slug"=> 'components',
      "options" => array(
        'labels' => array(
          'name'                => __( 'Components'),
          'singular_name'       => __( 'Component'),
          'menu_name'           => __( 'Components'),
          'parent_item_colon'   => __( 'Parent Component'),
          'all_items'           => __( 'All Components'),
          'view_item'           => __( 'View Component'),
          'add_new_item'        => __( 'Add New Component'),
          'add_new'             => __( 'Add Component'),
          'edit_item'           => __( 'Edit Component'),
          'update_item'         => __( 'Update Component'),
          'search_items'        => __( 'Search Component'),
          'not_found'           => __( 'Not Found'),
          'not_found_in_trash'  => __( 'Not found in Trash'),
        ),
        'public' => false,
        'has_archive' => false,
        'rewrite' => array('slug' => 'components'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' )
      ),
    );

    $this->post_types->addPostType($p);

  }


  function configure_taxonomies(){

    $l = array(
    	"slug"=> 'component-type',
    	"post_type"=> 'components',
    	"options" => array(
        'hierarchical' => true,
        'labels' => array(
    		  'name' => _x( 'Component Type', 'taxonomy general name' ),
    		  'singular_name' => _x( 'Component Type', 'taxonomy singular name' ),
    		  'search_items' =>  __( 'Component Types' ),
    		  'all_items' => __( 'All Component Types' ),
    		  'parent_item' => __( 'Parent Component Type' ),
    		  'parent_item_colon' => __( 'Parent Component Type:' ),
    		  'edit_item' => __( 'Edit Component Type' ), 
    		  'update_item' => __( 'Update Component Type' ),
    		  'add_new_item' => __( 'Add New Component Type' ),
    		  'new_item_name' => __( 'New Component Type Name' ),
    		  'menu_name' => __( 'Component Types' ),
    		),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'component-type' ),
      ),
    );

    $this->post_types->addCustomTaxonomy($l);
  }

}

?>