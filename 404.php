<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

						<article id="post-not-found" class="hentry cf">

							<header class="article-header">

								<h1><?php _e( 'We\'re sorry, that can\'t be found.', 'bonestheme' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'Please try searching the site or peruse the following sitemap:', 'bonestheme' ); ?></p>

								

							</section>

							<section class="search">

									<p><?php get_search_form(); ?></p>

									<?php if ( shortcode_exists( 'list-pages' ) ) { 
									echo do_shortcode('[list-pages sort_column="post_title"]'); 
								} ?>

							</section>

							<footer class="article-footer">

									<!-- <p><?php _e( 'This is the 404.php template.', 'bonestheme' ); ?></p> -->

							</footer>

						</article>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
