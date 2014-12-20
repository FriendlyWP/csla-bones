<?php get_header(); ?>

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

                	<?php if ( function_exists('get_field') && get_field('photo')) {
                		$image = get_field('photo');
                		$size = 'thumbnail';
                		$attr = array('class'=>"alignleft",);
                		//echo '<img src="' . $image['url'] . '" />';
                		echo wp_get_attachment_image( $image, $size, false, $attr );
                		
                	}  ?>

                	<?php if ( function_exists('get_field') && get_field('notes')) {
                		//echo '<h3>Notes</h3>';
                		the_field('notes');
                	}  ?>

                  <?php
                    if( have_rows('position') ) { 
                    	var_dump(get_field('position'));
                    	?>
                    <h3 style="clear:both;">Participation History</h3>
                	<table>
                		<tr>
                			<th>Position</th>
                			<th>Association</th>
                			<th>Division</th>
                			<th>Group</th>
                			<th>Years Served</th>
                		</tr>

                    <?php	while ( have_rows('position') ) : the_row();

                    	$ids = get_sub_field('position_held', false, false);
						//var_dump($ids);
						$position_query = new WP_Query(array(
							'post_type'      	=> 'offices',
							'posts_per_page'	=> -1,
							'post__in'		=> $ids,
							'post_status'		=> 'publish',
							'orderby'        	=> 'menu_order',
						));
						 if( $position_query->have_posts() ) { ?>
						
						<?php while ( $position_query->have_posts() ) : $position_query->the_post(); 
						
                    		$positions = get_sub_field('position_held');
							
							foreach( $positions as $position ) { 
								$start_date = get_sub_field('start_date');
							 	$end_date = get_sub_field('end_date');
							 	$start_date = date('Y', strtotime($start_date));
							 	$end_date = date('Y', strtotime($end_date));

								echo "<tr>\n";

								?>
								
								<?php
								
								//START FUNCTION
								global $position;

								  // get position taxonomies
								//$taxonomies = get_object_taxonomies( $position, 'objects' );

								//var_dump($taxonomies);

								//$out = array();
								
								//foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
									// get the terms related to position
									$position_info = get_the_terms( $position->ID, 'position' );		
									if ($position_info) { ?>
										<td>
											<a href="<?php echo get_permalink( $position->ID ); ?>">
												<?php echo $position_info[0]->name; ?>
											</a>
										</td>
									<?php
									}

									$association_info = get_the_terms( $position->ID, 'association_info' );
									if ($association_info) { ?>
										<td>
	<a href="<?php echo get_term_link($association_info[0]->slug, 'association_info' ); ?>">
												<?php echo $association_info[0]->name; ?>
											</a>
										</td>
									<?php
									}

									$division_info = get_the_terms( $position->ID, 'division_info' );
									if ($division_info) {
											?>
										<td>
											<a href="<?php echo get_term_link( $division_info[0]->slug, 'division_info' ); ?>">
												<?php echo $division_info[0]->name; ?>
											</a>
										</td>
									<?php
									}

									$group_info = get_the_terms( $position->ID, 'group_info' );
									if ($division_info) {
											?>
										<td>
											<a href="<?php echo get_term_link( $group_info[0]->slug, 'group_info' ); ?>">
												<?php echo $group_info[0]->name; ?>
											</a>
										</td>
									<?php
									}

								  }

								?>
								<td>
									
									<?php echo $start_date; ?>
									&ndash;
									<?php echo $end_date; ?>
									
								</td>
							<?php 

							echo "</tr>\n";
							//} //end foreach
							
						endwhile;
						echo '</table>';
                    }
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
