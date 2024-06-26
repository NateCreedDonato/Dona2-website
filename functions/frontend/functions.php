<?php

namespace HISQ\Theme\Frontend;

class functions{
	
	public function get_template_part($part = null, $name = null, $contextItem = null, $parameters = null){

		if($part != null && is_string($part)){

			if(is_int($contextItem)){
				setup_postdata($contextItem);
			}
			if($parameters != null){
				set_query_var( 'data', $parameters );
			}

			if(is_string($contextItem)){
				get_template_part( $part, $name );
			}else{
				get_template_part($part);
			}

			if(is_int($contextItem)){
				wp_reset_postdata();
			}

		}

	}

	function post_thumbnail($post_thumbnail = "post-thumbnail") {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( $post_thumbnail, array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}

	function posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'default' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}

	function posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'default' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}

	function edit_link() {

		if ( get_edit_post_link() ){

			echo '<footer class="post-edit-wrapper">';

				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit '.get_post_type().' <span class="screen-reader-text">%s</span>', 'default' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);

				echo '<span class="edit-link"><a target="blank" class="post-edit-link" href="'.get_dashboard_url().'?reset-theme=true">Reset Theme</a></span>';

			echo '</footer><!-- .entry-footer -->';

		}

	}

	/*
	 * Print an array
	 *
	 * @param $data array. An array of data
	 *
	 */
	public function dump($data, $print_r = false){
		echo "var_dump: <br/>";
		
		echo "<pre>";
		($print_r) ? print_r($data) : var_dump($data);
		echo "</pre>";
		
		echo "<br/>";
		
	}	

	public function is_child( $pid ) {
		global $post;

		if (is_int($pid)) {

		  if ( is_page($pid) ){
		  	return true;
		  }
		  
	    $anc = get_post_ancestors( $post->ID );

	    foreach ( $anc as $ancestor ) {

		    if( is_page() && $ancestor == $pid ) {

		    	return true;

		    }

	    }

		}elseif (is_string($pid)) {

		  $page = get_page_by_path( $pid );

		  if ($post->ID == $page->ID) {
		  	return true;
		  }

		  $anc = get_post_ancestors( $post->ID );

		  foreach ( $anc as $ancestor ) {

	      if( is_page() && $ancestor == $page->ID ) {
	      	return true;
	      }

		  }

		}

	}

}

?>