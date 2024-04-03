<?php


use HISQ\Theme;

require_once 'functions/setup.php';
require_once 'functions/helper.php';

$theme = new HISQ\Theme\setup("development");

//allow access to front end helper functions
$f = $theme->get_functions();



/**************************************************************************** CUSTOM */


if( function_exists('acf_add_options_page') ) {

  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));


  if( function_exists('acf_add_local_field_group') ){

    acf_add_local_field_group(array(
      'key' => 'group_5e255cd3b9f8c',
      'title' => 'Options Page',
      'fields' => array(
        array(
          'key' => 'field_5e255cdebaa01',
          'label' => 'Compress Images',
          'name' => 'compress_images',
          'type' => 'radio',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array(
            'true' => 'True',
            'false' => 'False',
          ),
          'allow_null' => 0,
          'other_choice' => 0,
          'default_value' => 'false',
          'layout' => 'vertical',
          'return_format' => 'value',
          'save_other_choice' => 0,
        ),
      ),
      'location' => array(
        array(
          array(
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'theme-general-settings',
          ),
        ),
      ),
      'menu_order' => 0,
      'position' => 'normal',
      'style' => 'default',
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'hide_on_screen' => '',
      'active' => true,
      'description' => '',
    ));

  }

}


//SVG compatibility
function my_own_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'my_own_mime_types' );

show_admin_bar( false );


/**
 * Let's Chat/Contact forms
 */
function enquiry_action() {

	if ( !wp_verify_nonce( $_REQUEST["nonce"], "enquiry_nonce")) {
		exit("No naughty business please");
	}


  $return = array();


  $return = array(
    "status" => "0"
  );


  echo json_encode($return);

	wp_die();

}
add_action( 'wp_ajax_nopriv_enquiry_action', 'enquiry_action' );
add_action( 'wp_ajax_enquiry_action', 'enquiry_action' );


function images_url($file_name = "") {
  return get_bloginfo("template_url")."/library/images/".$file_name;
}

?>