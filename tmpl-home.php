<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>
			
			<div id="content">
				
				

				<div id="inner-content" class="wrap cf">

					<div id="main" class="twelvecol first clearfix" role="main">
						
						<div class="cf">
							<div class="side-content">
								<?php get_template_part('flexslider'); ?>
							</div>
							<div class="home-content">
								<?php the_content(); ?>
							</div>
							
						</div>

					<?php if ( is_active_sidebar( 'home-widgets' ) ) { ?>
					<div class="home-widgets widget-container cf">

						<?php dynamic_sidebar( 'home-widgets' ); ?>
					</div>

					<?php } ?>

				</div>

			</div>

<?php get_footer(); ?>
