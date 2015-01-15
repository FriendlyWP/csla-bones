<?php
/*
Template Name: Taxonomy List
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

									$args = array( 'orderby=menu_order&order=ASC' );

									$terms = get_terms( 'group_info', $args );
									if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
									    $count = count( $terms );
									    $i = 0;
									    $term_list = '<ul class="term-list">';
									    foreach ( $terms as $term ) {
									        $i++;
									    	$term_list .= '<li><a href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) . '">' . $term->name . '</a>';
									    	if ( $count != $i ) {
									            $term_list .= '</li>';
									        }
									        else {
									            $term_list .= '</li></ul>';
									        }
									    }
									    echo $term_list;
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
