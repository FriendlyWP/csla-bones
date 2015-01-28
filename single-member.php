<?php get_header(); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var oTable,
		//var myTable = $('#participation_table').DataTable({
		  oTable = $('#participation_table').DataTable({
		  	"responsive": true,
		  	"order": [[ 4, "asc" ]],
		  	 "pageLength": 25,
		  	 "language": {
	            "search": "Search within table:",
	        },
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
	        },

		});

		 yadcf.init(oTable, [
		    {column_number : 0, filter_container_id: "filter0", column_data_type: "html", html_data_type: "text", filter_match_mode: "exact", filter_default_label: "Select"},
		    {column_number : 1, filter_container_id: "filter1", column_data_type: "html", html_data_type: "text", filter_match_mode: "exact", filter_default_label: "Select"},
		    {column_number : 2, filter_container_id: "filter2", column_data_type: "html", html_data_type: "text", filter_match_mode: "exact", filter_default_label: "Select"},
		    {column_number : 3, filter_container_id: "filter3", column_data_type: "html", html_data_type: "text", filter_match_mode: "exact", filter_default_label: "Select"},
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

                	<?php // IMAGE
                	if ( function_exists('get_field') && get_field('photo')) {

                		$image = get_field('photo');
                		$size = 'thumbnail';
                		$attr = array('class'=>"alignleft",);
                		$large_image_url = wp_get_attachment_image_src( $image, 'large' );
                		echo '<a rel="lightbox" href="' . $large_image_url[0] . '">' . wp_get_attachment_image( $image, $size, false, $attr ) . '</a>';
                		
                	}  ?>

                	<?php // NOTES
                	if ( function_exists('get_field') && get_field('notes')) {
                		//echo '<h3>Notes</h3>';
                		the_field('notes');
                	}  ?>

                  <?php
                    if( have_rows('position') ) { 
                    	//var_dump(get_field('position'));
                    	?>
                    <h3 style="clear:both;">Participation History</h3>
                    <div class="filters">
					
					<h3>Filter by:</h3>
					
						<span id="filter0">
            				<span>Position</span>
            			</span>
            		
						<span id="filter1">
            				<span>Association</span>
            			</span>
					
						<span id="filter2">
	            			<span>Division</span>
	            		</span>
	            		
						<span id="filter3">
	            			<span>Group</span>
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
                			<th>Position</th>
                			<th>Association</th>
                			<th>Division</th>
                			<th>Group</th>
                			<th>Start</th>
                			<th>End</th>
                		</tr>
                	</thead>

                    <?php	while ( have_rows('position') ) : the_row();

                    	$ids = get_sub_field('position_held', false, false);
						//var_dump($ids);
						$position_query = new WP_Query(array(
							'post_type'      	=> 'office',
							'posts_per_page'	=> -1,
							'suppress_filters' => false,
							'post__in'		=> $ids,
							//'post_status'		=> 'publish',
							'orderby'        	=> 'menu_order',
						));
						//var_dump($position_query);
						 if( $position_query->have_posts() ) { ?>
						
						<?php while ( $position_query->have_posts() ) : $position_query->the_post(); 
						
								echo "<tr>\n";		
									// POSITION INFO
			    			$terms = get_the_terms( $position_query->ID, 'position' );
							if ( $terms && ! is_wp_error( $terms ) ) {
							$terms = array_values($terms); ?>
							<td>
								<a href="<?php echo get_term_link($terms[0]->term_id, 'position'); ?>"><?php echo $terms[0]->name; ?></a>
							</td>
						<?php
						}

						// ASSOCIAION INFO
						
			    			$terms = get_the_terms( $position_query->ID, 'association_info' );
							if ( $terms && ! is_wp_error( $terms ) ) {
							$terms = array_values($terms); 
							?>
								<td>
									<a href="<?php echo get_term_link($terms[0]->term_id, 'association_info'); ?>"><?php echo $terms[0]->name; ?></a>
								</td>
						<?php }
						

						// DIVSION INFO
						
		    			$terms = get_the_terms( $position_query->ID, 'division_info' );
						if ( $terms && ! is_wp_error( $terms ) ) {
						$terms = array_values($terms); ?>
							<td>
								<a href="<?php echo get_term_link($terms[0]->term_id, 'division_info'); ?>"><?php echo $terms[0]->name; ?></a>
							</td>
						<?php }
						

						// GROUP INFO
						
		    			$terms = get_the_terms( $position_query->ID, 'group_info' );
						if ( $terms && ! is_wp_error( $terms ) ) {
						$terms = array_values($terms); ?>
							<td>
								<a href="<?php echo get_term_link($terms[0]->term_id, 'group_info'); ?>"><?php echo $terms[0]->name; ?></a>
							</td>
						<?php }
							$start_date = get_sub_field('start_date');
							 	$end_date = get_sub_field('end_date');
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

								?>
								<td class="start-date"><?php echo $start_date; ?></td>
								<td  class="end-date"><?php echo $end_date; ?></td>
								<td class="duration"><?php echo $output; ?></td>
							<?php 

							echo "</tr>\n";
							endwhile;
						} // endif $position_query
						wp_reset_query();
						endwhile;
						echo '</table>';
                    } // endif have_rows('position')
                  ?>
              </table>
                </section> <?php // end article section ?>


              </article> <?php // end article ?>

			<?php endwhile; ?>

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
