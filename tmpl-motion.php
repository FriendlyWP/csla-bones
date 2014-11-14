<?php
/*
Template Name: Motions Test Template
*/
?>

<?php get_header(); ?>
			
			<div id="content">
				
				

				<div id="inner-content" class="wrap cf">

					<div id="main" class="twelvecol first clearfix" role="main">
						
						<div class="cf">
							<?php 
									if (function_exists('get_field')) {
										$fields = get_fields();
 
										if( $fields )
										{
											foreach( $fields as $field_name => $value )
											{
												// get_field_object( $field_name, $post_id, $options )
												// - $value has already been loaded for us, no point to load it again in the get_field_object function
												$field = get_field_object($field_name, false, array('load_value' => false));

												if($value) {
												echo '<div>';
													echo '<h3>' . $field['label'] . '</h3>';
													echo $value;
												echo '</div>';	
												}
										
												
											}
										}
									}
									 ?>
						</div>

					 <?php get_sidebar(); ?>

				</div>

			</div>

<?php get_footer(); ?>
