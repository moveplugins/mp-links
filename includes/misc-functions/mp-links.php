<?php

/**
 * Function which displays a list of links
 */
function mp_links($mp_link_group){
	
	//Set the args for the new query
	$link_args = array(
		'post_type' => "mp_link",
		'posts_per_page' => 0,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'mp_link_groups',
				'field'    => 'id',
				'terms'    => array( $mp_link_group ),
				'operator' => 'IN'
			)
		)
	);	
	
	//Create new query for links
	$link_group = new WP_Query( apply_filters( 'mp_links_link_args', $link_args ) );
		
	//Set html output to null
	$html_output = NULL;
	
	//Loop through the link group		
	if ( $link_group->have_posts() ) : 
		$html_output .= '<ul class="mp-links">';
		while( $link_group->have_posts() ) : $link_group->the_post(); 
		
			//Display this link
			$html_output .= '<li class="' . get_post_meta(get_the_id(), 'link_type', true)  . '-li">';
			$html_output .= '<a target="' . get_post_meta(get_the_id(), 'link_target', true) . '" class="' . get_post_meta(get_the_id(), 'link_type', true) . '-a" href="' . get_post_meta(get_the_id(), 'link_url', true) . '">';
				$html_output .= '<div style="background-image:url(' . get_post_meta(get_the_id(), 'link_custom_icon', true) . ');" class="' . get_post_meta(get_the_id(), 'link_type', true) .  '" >';
					//Usually we will hide this div using css so we just see the icon
					$html_output .= '<div class="mp-links-title" >' . get_the_title() . '</div>';
				$html_output .= '</div>';
			$html_output .= '</a>';
			$html_output .= '</li>';
			
			
		endwhile;
		$html_output .= '</ul>';
	endif;
	
	wp_reset_query();
	
	return $html_output;
}