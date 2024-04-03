<?php
namespace HISQ\Theme\Frontend;

class css_and_js{

  private $_css,$_js,$_version,$_max,$_critical_css_exists,$_template_slug,$_env;

  function __construct($env = "production") {

    if($env == "production"){

      $this->_css = filemtime(get_template_directory().'/library/css/main.css');
      $this->_js = filemtime(get_template_directory().'/library/js/main.js');
      $this->_version = get_option("script_and_style_last_update_version",1);
      $this->_max = max($this->_css,$this->_js);
      $this->_env = $env;

      $this->_template_slug = get_page_template_slug( get_the_id());

      //SCRIPT AND STYLES VERSION
      if($this->_env == "production"){

        if(get_option("script_and_style_last_update")){
          $this->_lastModified = get_option("script_and_style_last_update");

          if($this->_lastModified < $this->_max){
            $this->_version++;
            update_option( "script_and_style_last_update", $this->_max, true );
            update_option( "script_and_style_last_update_version", $this->_version, true );
          }
        }else{
          add_option("script_and_style_last_update",$this->_max);
          add_option("script_and_style_last_update_version",$this->_version);
        }
      }


      add_action( 'wp_enqueue_scripts', array($this,'loadStyles') );
      add_action( 'wp_enqueue_scripts', array($this,'loadScripts') );

      //checks to see if critical css has been created
      $this->_critical_css_exists = file_exists(get_template_directory().'/library/css/critical/'.$this->_template_slug.'.css');

      if($this->_critical_css_exists){

        // LOAD CRITICALCSS

        //deffer main css
        add_filter('style_loader_tag', array($this, 'editCssTags'), 999, 2);

      }
    }else{
      $this->_version = 1;
      add_action( 'wp_enqueue_scripts', array($this,'loadStyles') );
      add_action( 'wp_enqueue_scripts', array($this,'loadScripts') );
    }

  }


  /*************************************************************************** ENQUEUE STYLES */


  function loadStyles() {


    //main fonts
    wp_register_style( 'main_fonts', get_template_directory_uri() . "/library/fonts/stylesheet.css",array(),$this->_version);
    wp_enqueue_style( 'main_fonts' );

    //main style
    wp_register_style( 'main_style', get_template_directory_uri() . "/dist/css/main.min.css",array(),$this->_version);
    wp_enqueue_style( 'main_style' );

    if(current_user_can('administrator')) {
      //admin only styles
      wp_register_style( 'admin_style', get_template_directory_uri() . "/library/css/admin.css");
      wp_enqueue_style( 'admin_style' );

    }

  }


  /*************************************************************************** ASYNC CSS */

  //if you use this be  sure to set up inline critical css


  function editCssTags (string $html, string $handle): string {

      $dom = new \DOMDocument();
      $dom->loadHTML($html);
      $tag = $dom->getElementById($handle . '-css');
      $tag->setAttribute('media', 'print');
      $tag->setAttribute('onload', "this.media='all'");
      $tag->removeAttribute('type');
      $tag->removeAttribute('id');
      $html = $dom->saveHTML($tag);

      return $html;
  }

  /*************************************************************************** ENQUEUE SCRIPTS */

  function loadScripts() {


    wp_enqueue_script("jquery");
    wp_register_script( 'main_script', get_template_directory_uri() . '/dist/js/main.bundle.js', array('jquery'),$this->_version,'in_footer');
    wp_enqueue_script( 'main_script' );

  }

}