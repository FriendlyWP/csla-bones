<?php
/*
Template Name: Listings Page
*/
?>
<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

							<?php if (has_post_thumbnail()) { 
								the_post_thumbnail('page-header');
							} ?>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
								<?php if ( function_exists('yoast_breadcrumb') ) {
									yoast_breadcrumb('<p id="breadcrumbs">','</p>');
								} ?>
								<header class="article-header">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

								</header> <?php // end article header ?>

								

								<section class="entry-content cf" itemprop="articleBody">
									<?php the_content(); 

									if (function_exists('get_field')) {

										

										if( have_rows('listing_section') ):
 
										    while ( have_rows('listing_section') ) : the_row();

											
											if (get_sub_field('listing_title')) {
													echo '<h2 class="cf">' . get_sub_field('listing_title') . '</h2>';
												}

											if( have_rows('listings') ):
	 
											    while ( have_rows('listings') ) : the_row();

												
											 
											        $image = get_sub_field('image');
													$name = get_sub_field('name');
													$csla_title = get_sub_field('csla_title');
													$employment_info = get_sub_field('employment_info');
													echo '<div class="cf listing">';
														echo '<span class="imgdisplay">';
														if( !empty($image) ) { 
														 
															// vars
															$url = $image['url'];
															$size = 'thumbnail';
															$thumb = $image['sizes'][ $size ];
															echo '<img src="' . $thumb . '" alt="' . $name . '" class="alignleft" />';
												        } else {
												        	echo '&nbsp;';
												        }
												        echo '</span>';
												        echo '<span class="persondisplay"><h4>' . $name . '</h4>';
												        echo '<h5>' . $csla_title . '</h5>';
												        echo $employment_info . '</span>';
												    echo '</div>';

											    endwhile;
											 
											else :
											 
											    // no rows found
											 
											endif;

										endwhile;
											 
									else :
									 
									    // no rows found
									 
									endif;



									}




									?>
								</section> <?php // end article section ?>

							</article>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
										</header>
										<section class="entry-content">
											<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
										</section>
										<footer class="article-footer">
												<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
										</footer>
									</article>

							<?php endif; ?>

						</div>

						<?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
