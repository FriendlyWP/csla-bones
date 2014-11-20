<?php get_header(); ?>

<script type="text/javascript">

	jQuery(document).ready(function($) {
		var oTable,
		//var myTable = $('#participation_table').DataTable({
		  oTable = $('#participation_table').DataTable({
		  	"responsive": true,	
	         columnDefs: [ {
	            targets: [ 4 ],
	            orderData: [ 4, 5 ]
		        }, {
		            targets: [ 5 ],
		            orderData: [ 5, 4 ]
	        }],

		});

		 yadcf.init(oTable, [
		    {column_number : 0, filter_container_id: "filter0", column_data_type: "html", html_data_type: "text", filter_default_label: "Select"},
		    {column_number : 1, filter_container_id: "filter1", column_data_type: "html", html_data_type: "text", filter_default_label: "Select"},
		    {column_number : 2, filter_container_id: "filter2", column_data_type: "html", html_data_type: "text", filter_default_label: "Select"},
		    {column_number : 3, filter_container_id: "filter3", column_data_type: "html", html_data_type: "text", filter_default_label: "Select"},
		    {column_number : 4, filter_container_id: "filter4", sort_as: "num", filter_default_label: "Select"},
		    {column_number : 5, filter_container_id: "filter5", sort_as: "num", filter_default_label: "Select"},		    
		    ]);

		});
</script>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

			<?php if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			} ?>
			<header class="article-header">

	                  <h1 class="page-title" itemprop="headline"><?php 
				    	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
				    	$title = $term->name; 
				    	if (function_exists('get_field') && get_field('full_name', $term->taxonomy . '_' . $term->term_id )) {
				       		echo get_field('full_name', $term->taxonomy . '_' . $term->term_id );
				        } else { 
				        	echo $title; 
				        } ?></h1>

	        </header> <?php // end article header ?>

	        <?php if (function_exists('get_field') && get_field('logo', $term->taxonomy . '_' . $term->term_id )) {
	       		echo '<img src="' . get_field('logo', $term->taxonomy . '_' . $term->term_id) . '" class="alignleft" />';
	        }
	       
	        if (is_tax() && ($term->description !== '')) { ?>
				<p class="cat-desc"><?php echo $term->description; ?></p>
			<?php } ?>

			<?php if (have_posts()) {
				$current = get_queried_object();
				$current_tax = $current->taxonomy; 
				$count=0;
				?>
				<div class="filters">
					<h3>Filter by:</h3>
					<?php if ('association_info' !== $current_tax) { ?>
						<span id="filter<?php echo $count; $count++; ?>">
            				<span>Association</span>
            			</span>
            		<?php } ?>

					<?php if ('division_info' !== $current_tax) { ?>
						<span id="filter<?php echo $count; $count++; ?>">
            				<span>Division</span>
            			</span>
            		<?php } ?>

					<?php if ('group_info' !== $current_tax) { ?>
					<span id="filter<?php echo $count; $count++; ?>">
            			<span>Group</span>
            		</span>
            		<?php } ?>

					<?php if ('position' !== $current_tax) { ?>
					<span id="filter<?php echo $count; $count++; ?>">
            			<span>Position</span>
            		</span>
            		<?php } ?>

					<span id="filter<?php echo $count; $count++; ?>">
            			<span>Member</span>
            		</span>

					<span id="filter<?php echo $count; $count++; ?>">
            			<span>Start</span>
            		</span>

            		<span id="filter<?php echo $count; $count++; ?>">
            			<span>End</span>
            		</span>

				</div>
				<table class="datatable dataTable" style="clear:both;" id="participation_table">
            		<thead>
            		 	<tr>
	            			<!--<th>Office</th>-->
	            			
	            			<?php if ('association_info' !== $current_tax) { ?>
	            				<th>Association</th>
	            			<?php } ?>
	            			<?php if ('division_info' !== $current_tax) { ?>
	            				<th>Divsion</th>
	            			<?php } ?>
	            			<?php if ('group_info' !== $current_tax) { ?>
	            				<th>Group</th>
	            			<?php } ?>
	            			<?php if ('position' !== $current_tax) { ?>
	            				<th>Position</th>
	            			<?php } ?>
	            			<th>Member</th>
	            			<th>Start</th>
	            			<th>End</th>
            			</tr>
            		</thead>

            		<tfoot>
            		 	<tr>
	            			<!--<th>Office</th>-->
	            			
	            			<?php if ('association_info' !== $current_tax) { ?>
	            				<th data-role="dtFilterSelect">Association</th>
	            			<?php } ?>
	            			<?php if ('division_info' !== $current_tax) { ?>
	            				<th data-role="dtFilterSelect">Divsion</th>
	            			<?php } ?>
	            			<?php if ('group_info' !== $current_tax) { ?>
	            				<th data-role="dtFilterSelect">Group</th>
	            			<?php } ?>
	            			<?php if ('position' !== $current_tax) { ?>
	            				<th data-role="dtFilterSelect">Position</th>
	            			<?php } ?>
	            			<th data-role="dtFilterSelect">Member</th>
	            			<th data-role="dtFilterSelect">Years Served</th>
	            			<th data-role="dtFilterSelect">Years Served</th>
            			</tr>
            		</tfoot>
            		

				<?php while (have_posts()) : the_post(); 

				$current_id = $post->ID; 

				// LOOP THROUGH MEMBERS, ONE ROW PER MEMBER WHO SERVED IN THIS OFFICE
				$args = array(
					'post_type'	=> 'member',
					'suppress_filters' => false,					
					'meta_query' => array(
						array(
							'key' => 'position_%_position_held',
							'value' => '"' . $current_id . '"',
							'compare' => 'LIKE'
						)
					)
				);
				 
				// get results
				$the_query = new WP_Query( $args );
				//var_dump($the_query);
				 
				// The Loop
				?>
				<?php if( $the_query->have_posts() ) { ?>
					
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); 
					
					
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
					endwhile; 
				 } 

				 wp_reset_query(); 
			endwhile; ?>
		</table>

		<?php } else { ?>

			<article id="post-not-found" class="hentry cf">
					<header class="article-header">
						<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
					</section>
					<footer class="article-footer">
							<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
					</footer>
			</article>

		<?php } ?>

	</div>

	<?php get_sidebar(); ?>

	</div>

	</div>

<?php get_footer(); ?>
