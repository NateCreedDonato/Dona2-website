<?php
/**
 * This file is for setting up the wordpress configuration
 */

namespace HISQ\Theme;

class setup{

  private $helper;

  function __construct($env = "production") {

    $this->helper = new helper();

    /*********************************************************************************************** CORE */

    $this->helper->require_multi(
          'core/config.php',
          'core/posttypes.php',
          'core/wordpress_funtionality.php',
          'core/widgets.php'
        );

    //Configure wordpress data structure (Cusotm post types and Taxonomies)
    $config = new Core\config();
    $wordpress_backend_funtionality = new Core\wordpress_funtionality();

    /*********************************************************************************************** BACKEND DEVELOPMENT */

    if($this->helper->require_backend_development_files($env)){
      //load plugin requires only if the 
      $this->helper->require_multi(
            'backend/vendor/tgm/vendor/autoload.php',
            'backend/plugins.php'
          );

      //check if required plugins are running only if the project is in development and the user is in the back end
      $plugins = new Backend\plugins();

    }


    /*********************************************************************************************** BACKEND */


    if($this->helper->require_backend_files()){
      //load plugin requires only if the 
      $this->helper->require_multi(
            'backend/compress_images.php',
            'backend/styling.php'
          );

      $styling = new Backend\styling();
      $compress_images = new Backend\compress_images();

    }


    /*********************************************************************************************** FRONTEND */

    if($this->helper->require_frontend_files()){
      //load plugin requires only if the 
      $this->helper->require_multi(
        'frontend/functions.php',
        'frontend/wordpress_funtionality.php',
        'frontend/compress_html.php',
        'frontend/css_and_js.php'
      );

      $wordpress_frontend_funtionality = new Frontend\wordpress_funtionality();
      //Load the sites css and js
      $css_and_js = new Frontend\css_and_js($env);
      //compress html
      //use caution, this function is not production ready
      //$compress_html = new Frontend\FLHM_HTML_Compression();

    }

    if($this->helper->require_build_files()){

      $this->helper->require_multi(
        'build/gzCompression.php',
        'build/browser_cache.php',
        'build/minify_javascript.php'
      );

      $gzCompression = new Build\gzCompression();
      $browser_cache = new Build\browser_cache();
      $minify_javascript = new Build\minify_javascript();

    }



  }


  public function get_functions(){
    if($this->helper->require_frontend_files()){
      return new Frontend\functions();
    }else{
      return false;
    }
  }

}




?>