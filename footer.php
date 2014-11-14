			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap cf">



					<?php if ( is_active_sidebar( 'footer-widgets' ) ) { ?>
					<div class="footer-widgets widget-container cf">

						<?php dynamic_sidebar( 'footer-widgets' ); ?>
					</div>

					<?php } ?>

					<?php if ( is_active_sidebar( 'copyright-address' ) ) { ?>
					<div class="copyright cf">

						<?php dynamic_sidebar( 'copyright-address' ); ?>
					</div>

					<?php } ?>


				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

</html> <!-- end of site. what a ride! -->
