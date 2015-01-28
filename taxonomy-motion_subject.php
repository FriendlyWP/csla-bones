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
            "dom": 'T<"clear">lfrtip',
            tableTools: {
	            "sSwfPath": "/wp-content/themes/csla-bones/library/js/copy_csv_xls_pdf.swf",
	        }
		});

		 yadcf.init(oTable, [
		    {column_number : 0, filter_container_id: "filter0", column_data_type: "html", html_data_type: "text", filter_match_mode: "exact", filter_default_label: "Select"},
		    {column_number : 1, filter_container_id: "filter1", column_data_type: "html", html_data_type: "text", filter_match_mode: "exact", filter_default_label: "Select"},
		    {column_number : 2, filter_container_id: "filter2", column_data_type: "html", html_data_type: "text", filter_match_mode: "exact", filter_default_label: "Select"},
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
				        	echo 'Motions: ' . $title; 
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
				/* echo '<h2>main query:</h2><pre>';
				var_dump($current);
				echo '</pre>'; */
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

            		<span id="filter<?php echo $count; $count++; ?>">
            			<span>School Year</span>
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
	            				<th>Division</th>
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
	            				<th data-role="dtFilterSelect">Division</th>
	            			<?php } ?>
	            			<?php if ('group_info' !== $current_tax) { ?>
	            				<th data-role="dtFilterSelect">Group</th>
	            			<?php } ?>
	            			<?php if ('position' !== $current_tax) { ?>
	            				<th data-role="dtFilterSelect">Position</th>
	            			<?php } ?>
	            			<th data-role="dtFilterSelect">Member</th>
	            			<th data-role="dtFilterSelect">Start</th>
	            			<th data-role="dtFilterSelect">End</th>
            			</tr>
            		</tfoot>
            		

			<?php while (have_posts()) : the_post(); 
				//the_title();
				$current_id = $post->ID; 
				/* echo '<h2>for every office in this tax show Office title/ID:</h2>';
				the_title();
				the_ID(); */
				//var_dump($the_query);

				// LOOP THROUGH MEMBERS, ONE ROW PER MEMBER WHO SERVED IN THIS OFFICE
				$args = array(
					'post_type'	=> 'member',
					//'suppress_filters' => false,
					'posts_per_page' => -1,					
					'meta_query' => array(
						array(
							'key' => 'position_%_position_held',
							'value' => '"' . $current_id . '"',
							//'value' => $current_id,
							'compare' => 'LIKE'
						),
					)
				);
				 
				// get results
				$the_query = new WP_Query( $args );
				/*echo '<h2>member query:</h2><pre>';
				var_dump($the_query);
				 echo '</pre>'; */
				// The Loop

				?>
				<?php if( $the_query->have_posts() ) { 

					while ( $the_query->have_posts() ) : $the_query->the_post(); 
						
						$memberID = get_the_ID();
						/*echo '<strong>OFFICEID: ' . $current_id . '</strong>;
						echo '<h5>for each member, show name/ID</h5>';
						echo '<strong>' . get_the_title() . '/' . $memberID . '</strong><br />'; */

						$rows = $wpdb->get_results($wpdb->prepare( 
				            "SELECT * 
				            FROM $wpdb->postmeta
				            WHERE post_id = %s
				            AND meta_key LIKE %s
				            AND meta_value LIKE %s
				            ",
				            $memberID,
				            "position_%_position_held", // meta_name: $ParentName_$RowNumber_$ChildName
				            '%' . $current_id . '%' // meta_value: 'type_3' for example
			        	));

			       //var_dump($rows);

					// loop through the results
						if( $rows ) {

							foreach( $rows as $row ) {

								// for each result, find the 'repeater row number' and use it to load the image sub field!
								preg_match('_([0-9]+)_', $row->meta_key, $matches);
								$start_meta_key = 'position_' . $matches[0] . '_start_date'; // $matches[0] contains the row number!
								$end_meta_key = 'position_' . $matches[0] . '_end_date'; // $matches[0] contains the row number!

								//  use get_post_meta to load the image sub field
								// - http://codex.wordpress.org/Function_Reference/get_post_meta
								$start_date = get_post_meta( $row->post_id, $start_meta_key, true );
								$end_date = get_post_meta( $row->post_id, $end_meta_key, true );

								$first_name = get_post_meta( $row->post_id, 'first_name', true );
								$last_name = get_post_meta( $row->post_id, 'last_name', true );

								$start_date = date('Y', strtotime($start_date));
								$end_date = date('Y', strtotime($end_date));

								$duration = '';
								$school_year = '';
								for ( $i = $start_date; $i < $end_date; $i++  ) {
									$duration .= '12/' . $i . ',';
									$year2 = $i + 1;
									$school_year .= $i . '-' . $year2 . ',';
									$output = rtrim($school_year, ',');
								}

								echo '<tr>';
								// ASSOCIAION INFO
								if ('association_info' !== $current_tax) {
					    			$terms = get_the_terms( $current_id, 'association_info' );
									if ( $terms && ! is_wp_error( $terms ) ) {
									$terms = array_values($terms); 
									?>
										<td><a href="<?php echo get_term_link($terms[0]->term_id, 'association_info'); ?>"><?php echo $terms[0]->name; ?></a></td>
								<?php }
								}

								// DIVSION INFO
								if ('division_info' !== $current_tax) {
				    			$terms = get_the_terms( $current_id, 'division_info' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td>
										<a href="<?php echo get_term_link($terms[0]->term_id, 'division_info'); ?>"><?php echo $terms[0]->name; ?></a>
									</td>
								<?php }
								}

								// GROUP INFO
								if ('group_info' !== $current_tax) {
				    			$terms = get_the_terms( $current_id, 'group_info' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td>
										<a href="<?php echo get_term_link($terms[0]->term_id, 'group_info'); ?>"><?php echo $terms[0]->name; ?></a>
									</td>
								<?php }
								}

								// POSITION INFO
								if ('position' !== $current_tax) {
				    			$terms = get_the_terms( $current_id, 'position' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td>
										<a href="<?php echo get_term_link($terms[0]->term_id, 'position'); ?>"><?php echo $terms[0]->name; ?></a>
									</td>
								<?php }
								}

								// MEMBER INFO
								echo '<td data-order="' . $last_name . ', ' . $first_name . '"><a href="' . get_permalink() . '"><!-- ' . $last_name . ', ' . $first_name . ' -->' . get_the_title() . '</a></td>';
								echo '<td class="start-date">' . $start_date . '</td>';
								echo '<td class="end-date">' . $end_date . '</td>';
								echo '<td class="duration">' . $output . '</td>';
								echo '</tr>';
								
							}
						}

					endwhile; 
				 } 

				 //wp_reset_query(); 
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
