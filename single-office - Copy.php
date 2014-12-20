<?php get_header(); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var oTable,
		//var myTable = $('#participation_table').DataTable({
		  oTable = $('#participation_table').DataTable({
		  	"responsive": true,
		  	"order": [[ 4, "desc" ]],
		  	 "pageLength": 25,
		  	"lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	         columnDefs: [ {
	            	targets: [ 4 ],
	            	orderData: [ 4, 5 ]
		        }, 
		        {
		            targets: [ 5 ],
		            orderData: [ 5, 4 ]
	        	},
	        	{
	                "targets": [ 6 ],
	                "visible": false,
            	},
            ],

		});

		 yadcf.init(oTable, [
		    {column_number : 0, filter_container_id: "filter0", column_data_type: "html", html_data_type: "text", filter_default_label: "Select"},
		    {column_number : 1, filter_container_id: "filter1", column_data_type: "html", html_data_type: "text", filter_default_label: "Select"},
		    {column_number : 2, filter_container_id: "filter2", column_data_type: "html", html_data_type: "text", filter_default_label: "Select"},
		    {column_number : 3, filter_container_id: "filter3",  html5_data: "data-order", filter_default_label: "Select"},
		    {column_number : 4, filter_container_id: "filter4", sort_as: "num", filter_default_label: "Select"},
		    {column_number : 5, filter_container_id: "filter5", sort_as: "num", filter_default_label: "Select"},		    
		    {column_number : 6, filter_container_id: "filter6", column_data_type: "text",  text_data_delimiter: ",", sort_as: "alpha", filter_default_label: "School Year"},	
		    ]);

		});
</script>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<p id="breadcrumbs">','</p>');
			} ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <header class="article-header">

                  <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>

                </header> <?php // end article header ?>

                <section class="entry-content cf" itemprop="articleBody">

                	<?php // DESCRIPTION
                	if ( function_exists('get_field') && get_field('office_description')) {
                		//echo '<h3>Notes</h3>';
                		the_field('office_description');
                	}  ?>

                	<table id="participation_table">
                		<thead>
                		<tr>
                			<th>Association</th>
                			<th>Division</th>
                			<th>Group</th>
                			<th>Member</th>
                			<th>Start</th>
                			<th>End</th>
                		</tr>
                	</thead>

                <?php	$current_id = get_the_ID(); 
                //echo $current_id;

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

					// ASSOCIAION INFO
					if ('association_info' !== $current_tax) {
		    			$terms = get_the_terms( $current_id, 'association_info' );
						if ( $terms && ! is_wp_error( $terms ) ) {
						$terms = array_values($terms); 
						?>
							<td>
								<a href="<?php echo get_term_link($terms[0]->term_id, 'association_info'); ?>">
									<?php echo $terms[0]->name; ?>
								</a>
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
					?>
						<td <?php 
						if (function_exists('get_field') && get_field('last_name')) { echo 'data-order="' . get_field('last_name') . '"'; 
						} ?> ><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
						<?php 
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
						 
					endwhile; ?>
					
				<?php
				 } ?>
				 
				<?php wp_reset_query(); ?>
	            
				
	          </tr>
	      

		<?php endwhile; ?>
		</table>

			<?php else : ?>

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

			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
