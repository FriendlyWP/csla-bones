

<script type="text/javascript" language="javascript">
    jQuery(document).ready(function($) {
        var n = 1
        $('.flexslider').flexslider({
            //namespace: "mmflex-",
            controlsContainer: ".flexslider",
          animation: "fade",
          slideshowSpeed: 10000,
          directionNav: false,
          controlNav: true,
          animationLoop: true,
          prevText: "",
          nextText: "",
        });
    });
</script>

						
<?php
echo '<div class="flexslider">';
// WP_Query arguments
if (function_exists('get_field') ) {
    if (get_field('frames')) {
    echo '<ul class="slides">'; 
         
        while(has_sub_field('frames')):
            
            //$overlay_color = get_sub_field('overlay_color');
          $overlay_color = "taupe";
            $text = get_sub_field('text');
            $button_text = get_sub_field('button_text');
            $button_destination = get_sub_field('button_destination');
            $slide_image = get_sub_field('slide_image');
            $image_info =  wp_get_attachment_image_src( $slide_image, 'medium' );
            
            
            echo '<li><span class="cf bgcolor ' . $overlay_color . '"><a href="' . $button_destination . '"><img src="' . $image_info[0] . '" /></a><span>'. $text . '<a href="' . $button_destination . '" class="button red">' . $button_text . '</a></span></span></li>';
        endwhile; 
    echo '</ul>';
    }
}
?>
 	
</div>