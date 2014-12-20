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

			<?php if (have_posts()) {
				 while (have_posts()) : the_post(); ?>
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

                	<div class="filters">
					
					<h3>Filter by:</h3>
					
						<span id="filter0">
            				<span>Association</span>
            			</span>
            		
						<span id="filter1">
            				<span>Division</span>
            			</span>
					
						<span id="filter2">
	            			<span>Group</span>
	            		</span>
	            		
						<span id="filter3">
	            			<span>Member</span>
	            		</span>

						<span id="filter4">
	            			<span>Start</span>
	            		</span>

	            		<span id="filter5">
	            			<span>End</span>
	            		</span>

	            		<span id="filter6">
	            			<span>School Year</span>
	            		</span>

					</div>

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
										<a href="<?php echo get_term_link($terms[0]->term_id, 'division_info'); ?>"><?php echo $terms[0]->name; ?></a>
									</td>
								<?php }
								}

								// GROUP INFO
								if ('group_info' !== $current_tax) {
				    			$terms = get_the_terms( $current_id, 'group_info' );
								if ( $terms && ! is_wp_error( $terms ) ) {
								$terms = array_values($terms); ?>
									<td><a href="<?php echo get_term_link($terms[0]->term_id, 'group_info'); ?>"><?php echo $terms[0]->name; ?></a></td>
								<?php }
								}

								
								// MEMBER INFO
								echo '<td data-order="' . $last_name . ', ' . $first_name . '"><a href="' . get_permalink() . '"><!-- ' . $last_name . ', ' . $first_name . ' --> ' . get_the_title() . '</a></td>';
								echo '<td class="start-date">' . $start_date . '</td>';
								echo '<td class="end-date">' . $end_date . '</td>';
								echo '<td class="duration">' . $output . '</td>';
								echo '</tr>';
								
							}
						} // end $rows if
					endwhile; // end the_query while
				 } //end the_query
				 ?>
		</table>
		<?php endwhile;
	} ?>
			

		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>