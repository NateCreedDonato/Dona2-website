<?php
/**
 * This file is for setting up the wordpress configuration
 */

namespace HISQ\Theme;

class helper{

  function __construct() {



  }

  /**.
   * Runs code that should only be run when the developer requests it
   * @return [bool]
   */
  function require_build_files(){
      return (current_user_can('administrator') && isset($_GET['reset-theme']) && $_GET['reset-theme'] == 'true') ? true : false;
  }

  function require_backend_development_files($env){
      return ($env == "development" && is_admin()) ? true : false;
  }

  function require_backend_files(){
      return (is_admin()) ? true : false;
  }

  function require_frontend_files(){
      return (!is_admin()) ? true : false;
  }

  function require_multi($files) {
    $files = func_get_args();
    foreach ( $files as $file ) require_once( $file );

  }

}




?>