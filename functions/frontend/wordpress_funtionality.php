<?php

namespace HISQ\Theme\Frontend;

class wordpress_funtionality{

  public function __construct(){

    add_action( 'wp_head', array($this,'default_pingback_header'));
    add_filter( 'excerpt_length', array($this,'custom_excerpt_length'));
    add_filter('excerpt_more', array($this,'new_excerpt_more'));

  }

  function default_pingback_header() {
    if ( is_singular() && pings_open() ) {
      printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
  }

  function custom_excerpt_length($length) {
      return 28;
  }

  function new_excerpt_more( $more ) {
      return '...';
  }
  


}

?>