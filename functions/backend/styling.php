<?php

namespace HISQ\Theme\Backend;

class styling{

	private $menuName;

	public function __construct(){

		add_action( 'login_enqueue_scripts', array( $this, 'setUpLoginPage') );
		add_action('wp_before_admin_bar_render', array( $this, 'setDashboardLogo'));

	}

	function setUpLoginPage() { 
		if(file_exists(get_template_directory().'/img/logo-large.png')){
		?> 
		<style type="text/css"> 
			body.login div#login h1 a {
				background-image: url(<?php bloginfo("template_url");?>/img/logo-large.png);
				background-position: center;
				padding-bottom: 30px; 
				width:100%;
				background-size:90%;
			} 
			body.login div#login h1 a:focus {
				outline: none;
				box-shadow:none;
			} 
		</style>
		 <?php 
		}

		if(file_exists(get_template_directory().'/img/login-bg.jpg')){
		?> 
		<style type="text/css"> 
			body.login{
				background-image: url(<?php bloginfo("template_url");?>/img/login-bg.jpg);
				background-size:cover;
				background-repeat: no-repeat;
			}
			body.login:after {
			   content: "&nbsp;";
			   visibility: hidden;
			   display: block;
			   height: 0;
			   clear: both;
			}
			body.login:before {
			   content: "&nbsp;";
			   visibility: hidden;
			   display: block;
			   height: 0;
			   clear: both;
			}
			body.login #login {
			    width: 360px;
			    margin-top:8%; 
			    padding: 10px 20px 20px;
			    background: #fff;
			}
		</style>
		 <?php 
		}

	} 
		
	function setDashboardLogo() {
		if(file_exists(get_template_directory().'/img/favicon.png')){
		?>
		<style type="text/css">
			#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			background-image: url(<?php bloginfo("template_url");?>/img/favicon.png) !important;
			background-position: 0 0;
			-webkit-background-size: 90%;
			background-size: 90%;
			color:rgba(0, 0, 0, 0);
			}
			#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
			background-position: 0 0;
			}
			</style>
		<?php
		}
	}

}

?>