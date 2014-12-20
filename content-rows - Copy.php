 <?php // display a sub field value
					        //the_sub_field('start_date');
					        echo '<tr>';

								// OFFICE INFO
				    			/* $terms = get_the_terms( $current_id, 'position' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td>
										<a href="<?php echo get_permalink( $current_id ); ?>">
											<?php echo get_the_title($current_id); ?>
										</a>
									</td>
								<?php
								} */

								

								// ASSOCIAION INFO
								if ('association_info' !== $current_tax) {
					    			$terms = get_the_terms( $current_id, 'association_info' );
									if ( $terms && ! is_wp_error( $terms ) ) {
									$terms = array_values($terms); 
									?>
										<td>
											<a href="<?php echo get_term_link($terms[0]->term_id, 'association_info'); ?>"><?php echo $terms[0]->name; ?></a>
										</td>
								<?php }
								}

								// DIVSION INFO
								if ('division_info' !== $current_tax) {
				    			$terms = get_the_terms( $current_id, 'division_info' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td>
										<a href="<?php echo get_term_link($terms[0]->term_id, 'division_info'); ?>">
											<?php echo $terms[0]->name; ?>
										</a>
									</td>
								<?php }
								}

								// GROUP INFO
								if ('group_info' !== $current_tax) {
				    			$terms = get_the_terms( $current_id, 'group_info' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td>
										<a href="<?php echo get_term_link($terms[0]->term_id, 'group_info'); ?>">
											<?php echo $terms[0]->name; ?>
										</a>
									</td>
								<?php }
								}

								// POSITION INFO
				    			$terms = get_the_terms( $current_id, 'position' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td>
										<a href="<?php echo get_permalink( $current_id ); ?>">
											<?php echo $terms[0]->name; ?>
										</a>
									</td>
								<?php
								}
								?>
									<td <?php //if (function_exists('get_field') && get_field('last_name')) { echo 'data-filter="' . get_field('last_name') . '"'; } ?>><a href="<?php the_permalink(); ?>"><?php //the_title(); ?><span class="first"><?php the_field('first_name');?></span> <span class="last"><?php the_field('last_name'); ?></span></a></td>

									
									<?php // DATE
									 if( have_rows('position') ) {
										 while( have_rows('position') ): the_row(); 
									 	// IF THIS IS THE ROW THAT CORRESPONDS TO THE CURRENT POSITION_HELD, SHOW THOSE DATES
									 	$pos = get_sub_field('position_held');
								 		$start_date = get_sub_field('start_date');
									 	$end_date = get_sub_field('end_date');
									 	$start_date = date('Y', strtotime($start_date));
									 	$end_date = date('Y', strtotime($end_date));
									 	$output='';
									 	if ( $pos[0] == $current_id ) {
									 		$output .= '<td class="start-date">';
									 			$output .= $start_date;
										 	/* if ( $start_date !== $end_date ) {
										 		$output .= $start_date . '&ndash;' . $end_date; 		
										 	} else {
										 		$output .= $start_date;
										 	} */
										 	$output .= '</td>';
										 	$output .= '<td class="end-date">';
									 			$output .= $end_date;
										 	$output .= '</td>';
										 	echo $output;
									 	}
									 	
									 endwhile;
									}

								echo '</tr>';