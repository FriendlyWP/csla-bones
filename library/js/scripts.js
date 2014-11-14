/*
 * jQuery Scripts
 * Author: Eddie Machado / Michelle McGinnis
 *
*/

/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {


  // ADD CLASS TO LINKS CONTAINING IMAGES
    $('a:has(img)').addClass('imglink');

    // ADD COUNT CLASS TO FOOTER WIDGETS FOR STYLING
     
     //var num = $('.widget-container').children('.widget').length;
     $( ".widget-container" ).each(function( index ) {
        var num = $(this).children().length;
        $(this).addClass('floats_' + num);
      });

}); /* end of as page load scripts */
