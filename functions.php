<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
//require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
add_image_size( 'page-header', 875, 0);
add_image_size( 'slider-image', 875,580, true);

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

//add_theme_support( 'admin-bar', array( 'callback' => 'my_adminbar_css' ) );
function my_adminbar_css() { ?>  
<style type="text/css" media="screen">  
        html { margin-top: 28px !important; }
        * html body { margin-top: 28px !important; }
        
</style>  
<?php  
}

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar Widgets', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'id' => 'footer-widgets',
		'name' => __( 'Footer Widgets', 'bonestheme' ),
		'description' => __( 'The footer area.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

  register_sidebar(array(
    'id' => 'home-widgets',
    'name' => __( 'Home Page Widgets', 'bonestheme' ),
    'description' => __( 'The home page.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'copyright-address',
    'name' => __( 'Copyright & Address', 'bonestheme' ),
    'description' => __( 'Below the footer area.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/************** ADD FILE TYPES TO MEDIA LIBRARY FILTERS ****************/
add_filter( 'post_mime_types', 'custom_mime_types' );
function custom_mime_types( $post_mime_types ) {
        $post_mime_types['application/msword'] = array( __( 'Word Docs' ), __( 'Manage Word Docs' ), _n_noop( 'Word Docs <span class="count">(%s)</span>', 'Word Docs <span class="count">(%s)</span>' ) );
        $post_mime_types['application/vnd.ms-excel'] = array( __( 'Excel Files' ), __( 'Manage Excel Files' ), _n_noop( 'Excel Files <span class="count">(%s)</span>', 'Excel Files <span class="count">(%s)</span>' ) );
        $post_mime_types['application/vnd.ms-powerpoint'] = array( __( 'PowerPoint Files' ), __( 'Manage PowerPoint Files' ), _n_noop( 'PowerPoint Files <span class="count">(%s)</span>', 'PowerPoint Files <span class="count">(%s)</span>' ) );
        $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDFs <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
        $post_mime_types['application/zip'] = array( __( 'ZIPs' ), __( 'Manage ZIPs' ), _n_noop( 'ZIP <span class="count">(%s)</span>', 'ZIPs <span class="count">(%s)</span>' ) );
        
        return $post_mime_types;
}

/************ RESPONSIVE VIDEO ******************/
// remove dimensions from oEmbed videos
add_filter( 'embed_oembed_html', 'tdd_oembed_filter', 10, 4 ) ; 
function tdd_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<figure class="video-container">'.$html.'</figure>';
    return $return;
}

/**************** SHORTCODES ***************/
/* SHORTCODE WHICH INSERTS CURRENT YEAR
 * usage: [year]
*/
add_shortcode('year', 'year_shortcode');
function year_shortcode() {
  $year = date('Y');
  return $year;
}

// ENABLE SHORTCODES IN ALL TEXT WIDGETS
add_filter('widget_text', 'do_shortcode');


// ENABLE STRONG AND EM IN WIDGET TITLES
add_filter( 'widget_title', 'html_widget_title' );
function html_widget_title( $title ) {
    //HTML tag opening/closing brackets
    $title = str_replace( '[', '<', $title );
    $title = str_replace( '[/', '</', $title );

    //<strong></strong>
    $title = str_replace( 's]', 'strong>', $title );
    //<em></em>
    $title = str_replace( 'e]', 'em>', $title );

    return $title;
}


// REMOVE EMPTY P TAGS FROM SHORTCODE CONTENT
// https://gist.github.com/maxxscho/2058547
add_filter('the_content', 'shortcode_empty_paragraph_fix');
add_filter('widget_text', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content)
{  
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
 
    $content = strtr($content, $array);
 
    return $content;
}

add_filter( 'storm_social_icons_use_latest', '__return_true' );

// REMOVE WIDGET TITLE IF IT BEGINS WITH EXCLAMATION POINT
// To use, add a widget and in the Title field put !The title here
// The title will show in the control panel, but not on the site itself
add_filter( 'widget_title', 'remove_widget_title' );
function remove_widget_title( $widget_title ) {
    if ( substr ( $widget_title, 0, 1 ) == '!' )
        return;
    else 
        return ( $widget_title );
}


// FILTER WORDPRESS SEO BY YOAST outputs in the WordPress control panel
// remove WP-SEO columns from edit-list pages in admin
add_filter( 'wpseo_use_page_analysis', '__return_false' );

// put WP-SEO panel at bottom of edit screens (low priority)
add_filter('wpseo_metabox_prio' , 'my_wpseo_metabox_prio' );
function my_wpseo_metabox_prio() {
  return 'low' ;                                
}

/* SHORTCODE WHICH INSERTS CLEARFIX
 * usage: [clear]
*/
add_shortcode('clear', 'clearfix_shortcode');
function clearfix_shortcode() {
  $clear = '<div class="cf clearfix-shortcode"></div>';
  return $clear;
}

/* SHORTCODE WHICH INSERTS HORIZONTAL LINE AND CLEARFIX
 * usage: [line]
*/
add_shortcode('line', 'line_shortcode');
function line_shortcode() {
    $line = '<hr class="cf" />';
  return $line;
}

/*  SHORTCODE FOR EMAIL OBFUSCATION
 *  usage: [email]myaddress@domain.com[/email]
*/
add_shortcode('email', 'emailbot_ssc');
function emailbot_ssc($atts, $content = null) {
 
    $email = '<a class="email_link" href="mailto:'.antispambot($content).'" target="_blank">';
    $email .= antispambot($content);
    $email .= '</a>';
 
    return $email;
}

// ACF CUSTOM FIELDS
if( function_exists('register_field_group') ):

register_field_group(array (
  'key' => 'group_53d28bdec8a71',
  'title' => 'Listings',
  'fields' => array (
    array (
      'key' => 'field_53d2b223201e5',
      'label' => 'Listing Section',
      'name' => 'listing_section',
      'prefix' => '',
      'type' => 'repeater',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'min' => '',
      'max' => '',
      'layout' => 'row',
      'button_label' => 'Add A Listing Section',
      'sub_fields' => array (
        array (
          'key' => 'field_53d2951333088',
          'label' => 'Listing Title',
          'name' => 'listing_title',
          'prefix' => '',
          'type' => 'text',
          'instructions' => 'Not required; this will insert a sub-title above this group of contacts.',
          'required' => 0,
          'conditional_logic' => 0,
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'maxlength' => '',
          'readonly' => 0,
          'disabled' => 0,
        ),
        array (
          'key' => 'field_53d2953633089',
          'label' => 'Listings',
          'name' => 'listings',
          'prefix' => '',
          'type' => 'repeater',
          'instructions' => '',
          'required' => 0,
          'conditional_logic' => 0,
          'min' => '',
          'max' => '',
          'layout' => 'row',
          'button_label' => 'Add Another Person',
          'sub_fields' => array (
            array (
              'key' => 'field_53d298282272e',
              'label' => 'Image',
              'name' => 'image',
              'prefix' => '',
              'type' => 'image',
              'instructions' => 'Don\'t worry about resizing the image, we will use the thumbnail version on the page. Upload the largest version you have.',
              'required' => 0,
              'conditional_logic' => 0,
              'column_width' => '',
              'return_format' => 'array',
              'preview_size' => 'thumbnail',
              'library' => 'all',
            ),
            array (
              'key' => 'field_53d295ab3308a',
              'label' => 'Name',
              'name' => 'name',
              'prefix' => '',
              'type' => 'text',
              'instructions' => '',
              'required' => 1,
              'conditional_logic' => 0,
              'column_width' => '',
              'default_value' => '',
              'placeholder' => '',
              'prepend' => '',
              'append' => '',
              'maxlength' => '',
              'readonly' => 0,
              'disabled' => 0,
            ),
            array (
              'key' => 'field_53d295c33308b',
              'label' => 'CSLA Position / Title',
              'name' => 'csla_title',
              'prefix' => '',
              'type' => 'text',
              'instructions' => 'For instance, President or President-Elect.',
              'required' => 0,
              'conditional_logic' => 0,
              'column_width' => '',
              'default_value' => '',
              'placeholder' => '',
              'prepend' => '',
              'append' => '',
              'maxlength' => '',
              'readonly' => 0,
              'disabled' => 0,
            ),
            array (
              'key' => 'field_53d2962a3308d',
              'label' => 'Employment Info',
              'name' => 'employment_info',
              'prefix' => '',
              'type' => 'wysiwyg',
              'instructions' => 'Job title, Employer Name, Address, and Contact phone/email.',
              'required' => 0,
              'conditional_logic' => 0,
              'column_width' => '',
              'default_value' => '',
              'toolbar' => 'full',
              'media_upload' => 0,
            ),
          ),
        ),
      ),
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'page_template',
        'operator' => '==',
        'value' => 'tmpl-listings.php',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'seamless',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;

// custom filter to replace '=' with 'LIKE'
add_filter('posts_where', 'my_posts_where');
function my_posts_where( $where )
{
  $where = str_replace("meta_key = 'position_%_position_held'", "meta_key LIKE 'position_%_position_held'", $where);
 
  return $where;
}