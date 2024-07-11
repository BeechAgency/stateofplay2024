<?php

if ( ! function_exists( 'sop_number_pagination') ) :
	/**
	* Displays A List of Posts
	*/
	function sop_number_pagination() {
		$args = array(
			'base'               => '%_%',
			'format'             => '?paged=%#%',
			'total'              => 1,
			'current'            => 0,
			'show_all'           => false,
			'end_size'           => 1,
			'mid_size'           => 2,
			'prev_next'          => true,
			'prev_text'          => __('«'),
			'next_text'          => __('»'),
			'type'               => 'plain',
			'add_args'           => false,
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => ''
		);
		
		global $wp_query;
		$big = 9999999; // need an unlikely integer
		
		echo '<div class="posts-pagination">';
		echo paginate_links( 
			array(
			   'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			   'format' => '?paged=%#%',
			   'current' => max( 1, get_query_var('paged') ),
			   'total' => $wp_query->max_num_pages,
			   'prev_text' => __('<svg xmlns="http://www.w3.org/2000/svg" width="7.466" height="12.812" viewBox="0 0 7.466 12.812"><path id="Path_568" data-name="Path 568" d="M-7223.768,2647.072l5.875,5.876-5.875,5.875" transform="translate(-7216.832 2659.354) rotate(-180)" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>'),
			   'next_text' => __('<svg xmlns="http://www.w3.org/2000/svg" width="7.466" height="12.812" viewBox="0 0 7.466 12.812"><path id="Path_567" data-name="Path 567" d="M-7223.768,2647.072l5.875,5.876-5.875,5.875" transform="translate(7224.298 -2646.542)" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>
			 ')
			)
		);
		echo '</div>';
	}	/*»«*/

endif;



function beech_taxonomy_value_filter_list($taxonomy = 'product', $posts_page_url = '/') {

	//var_dump(is_tax() || is_category());
	$queried_object = get_queried_object();
	$current_page = '';
    
	if ( $queried_object ) {
        $current_page = $queried_object->slug;
    }

	// Get all terms from the custom taxonomy
	$terms = get_terms(array(
		'taxonomy' => $taxonomy,
		'hide_empty' => false, // Include terms with no posts
	));

	if (!empty($terms)) {
		echo "<div class='filter-list-inner tax-$taxonomy'>";
		echo "<div class='title'>Filter:</div><ul class='filter-list tax-$taxonomy'>";
		echo "<li class='item item-all'><a href='$posts_page_url' data-term=''>All</a></li>";
		foreach ($terms as $term) {
			// Count the number of posts for each term
			$term_post_count = $term->count;
			$count = $term_post_count;

			$term_link = get_term_link($term, $taxonomy);

			$active_class = '';
			if($current_page === $term->slug) {
				$active_class = 'active';
			}

			if($taxonomy === 'product') {
				$landing_page = get_field('landing_page',$taxonomy."_".$term->term_id);
				$landing_page_id = $landing_page[0];

				if(!empty($landing_page_id)):
					$term_link = get_the_permalink( $landing_page_id );
				endif;
			}
			if($count > 0):
				echo '<li class="item '.$active_class.'"><a href="' . esc_url($term_link) . '" >' . esc_html($term->name);
				echo '<span class="count">' . $count . '</span></a></li>';
			endif;
		}
		echo '</ul></div>';
	}
}
