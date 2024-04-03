<?php

namespace HISQ\Theme\Core;

class wordpress_funtionality{

  private $menuName;

  public function __construct(){

    //disable the theme editor
    define( 'DISALLOW_FILE_EDIT', true );

    add_action( 'after_setup_theme', array( $this, 'themeSetup') );
    $this->configureMenu("Main Menu");

  }

  public function configureMenu($name){
    $this->menuName = $name;
    add_action( 'init' , array( $this, 'addMenu' ));
  }

  function addMenu() {
    register_nav_menu(urlencode($this->menuName),__( $this->menuName ));
  }


  // add featured image support
  function themeSetup(){
    //uncomment to enable language translations
    //load_theme_textdomain( 'default', get_template_directory() . '/languages' );
    add_theme_support( 'post-thumbnails' );
    //uncomment if using widgets
    //add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ) );
    register_nav_menus( array(
      'menu-1' => esc_html__( 'Primary', 'test' ),
    ) );


    //developer attention needed
    add_theme_support( 'custom-background', apply_filters( 'default_custom_background_args', array(
      'default-color' => 'ffffff',
      'default-image' => '',
    ) ) );
    add_theme_support( 'custom-logo', array(
      'height'      => 250,
      'width'       => 250,
      'flex-width'  => true,
      'flex-height' => true,
    ) );
    $GLOBALS['content_width'] = apply_filters( 'default_content_width', 640 );

    add_editor_style(get_template_directory_uri() . "/library/css/main.css");

  }

}

?>