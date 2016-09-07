<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentysixteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own twentysixteen_setup() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'twentysixteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 *
	 *  @since Twenty Sixteen 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'twentysixteen' ),
		'social'  => __( 'Social Links Menu', 'twentysixteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', twentysixteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentysixteen_setup
add_action( 'after_setup_theme', 'twentysixteen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 840 );
}
add_action( 'after_setup_theme', 'twentysixteen_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentysixteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'twentysixteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'twentysixteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentysixteen_widgets_init' );

if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Sixteen.
 *
 * Create your own twentysixteen_fonts_url() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentysixteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Inconsolata:400';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'twentysixteen-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160412' );
	}

	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160412', true );

	wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'twentysixteen' ),
		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'twentysixteen_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args' );


// refs: http://presscustomizr.com/snippet/adding-sections-to-any-page-or-posts-in-customizr/
function add_custom_sections ( $args ) {
	//set up global vars with the section parameters
	global $section_params;
	$defaults = array(
		'ids' 				=> array() , 
		'hook' 				=> '__after_main_wrapper' , 
		'priority' 			=> 0, 
		'layout' 			=> 'full', 
		'context' 			=> 'home',
		'blur' 				=> true,
		'apply_shadow' 		=> true,
		'background' 		=> 'thumb'
	);
 
	$section_params = wp_parse_args( $args, $defaults );
	
	//sets up hooks
	add_action ( 'wp_head' , '_hook_setup' );
	add_action('wp_head' , '_my_custom_sections_style');
}
 
 
function _hook_setup() {
	//gets section(s) parameters
	global $section_params;
	extract( $section_params , EXTR_OVERWRITE );
 
	//check context
	$context_type = is_numeric($context) ? 'post' : $context;
	switch ( $context_type ) {
		case 'post':
			if ( $context != get_the_ID() )
				return;
			break;
		
		default :
			if ( ! tc__f('__is_home') )
       		 	return;
			break;
	}
	//sets up hook
	add_action ( $hook , '_display_my_custom_sections' , $priority);
}
 
 
function _display_my_custom_sections() {
	//gets section(s) parameters
	global $section_params;
	extract( $section_params , EXTR_OVERWRITE );
 
	//check if we have posts ids
	if ( ! is_array($ids) || empty($ids) )
		return;
 
	while ( $current_id = current($ids) ) {
		$section_object = get_post($current_id);
		if ( empty($section_object) ) {
			next($ids);
			continue;
		}
		ob_start()
		?>
		<div class="row-fluid custom-section custom-section-<?php echo $current_id ?>">
		    <div class="custom-section-background"></div>
		    <div id="content span12" class="article-container">
		    	<article>
			    	<div class="entry-content">
			        	<?php echo apply_filters('the_content' , $section_object -> post_content ); ?>
			    	</div>
			    </article>
		    </div>
		    <?php
		    //adds an edit link
		    $edit_enabled                      = ( (is_user_logged_in()) && current_user_can('edit_pages') && ( 'page' == $section_object -> post_type) ) ? true : false;
    		$edit_enabled                      = ( (is_user_logged_in()) && current_user_can('edit_post' , $current_id ) && ( 'page' != $section_object -> post_type ) ) ? true : $edit_enabled;
		    if ( $edit_enabled ) 
		    	printf('<a class="edit-link btn btn-inverse" href="%1$s" title="%2$s" target="_blank">%2$s</a>',
                        get_edit_post_link($current_id),
                        ( 'page' == $section_object -> post_type ) ? __( 'Edit page' , 'customizr' ) : __( 'Edit post' , 'customizr' )
		   		);
		   	?>
		</div>
		<?php
		$html = ob_get_contents();
        if ($html) ob_end_clean();
       	//wrap in a container if layout is not set to full
       	if ( 'full' != $layout )
       		printf('<div class="container boxed-section">%1$s</div>', $html);
       	else
       		echo $html;
 
		next($ids);
	}//end while loop
}
 
function _my_custom_sections_style() {
	//gets section(s) parameters
	global $section_params;
	extract( $section_params , EXTR_OVERWRITE );
	if ( ! is_array($ids) || empty($ids) )
		return;
	?>
	<style type="text/css" id="my-sections-style">
		.custom-section {
			position: relative;
			-webkit-box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
			-moz-box-shadow: 0 2px 10px rgba(0,0,0,.25);
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.25);
		}
		.custom-section .article-container {
			position: relative;
			z-index: 10;
			padding: 20px;
			color: white;
			width: 90%;
			padding: 5% 5%;
			vertical-align: middle;
			display: inline-block;
			position: relative;
		}
		<?php if ($apply_shadow) : ?>
		.custom-section .article-container {
			background: rgba(0, 0, 0, 0.2);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#33000000', endColorstr='#33000000', GradientType=0);
		}
		<?php endif;?>
		.full-width-section .custom-section .article-container {
			padding: 0px;
		}
		.custom-section .edit-link.btn {
			z-index: 100;
			position: absolute;
			bottom: 10px;
			right: 10px;
			right: 12px;
			z-index: 100;
			display: block;
		}
		.custom-section-background {
			height: 100%;
			position: absolute;
			width: 100%;
			z-index: 0;
		}
		<?php if ( false != $blur) : ?>
			<?php $blur = !is_numeric($blur) ? 4 : $blur; ?>
			.custom-section-background {
				-webkit-filter: blur(<?php echo $blur; ?>px);
			  	-moz-filter: blur(<?php echo $blur; ?>px);
			  	-o-filter: blur(<?php echo $blur; ?>px);
			  	-ms-filter: blur(<?php echo $blur; ?>px);
			  	filter: blur(<?php echo $blur; ?>px);
			}
		<?php endif; ?>
		<?php
			$i = 4;
			foreach ($ids as $key => $post_id) {
				if ( ! _set_section_background( $background, $post_id, $i ) )
					continue;
				echo _set_section_background( $background, $post_id, $i );
				$i = ($i < 10 ) ? $i+1 : 1;
			}//end for each
		?>
	</style>
	<?php
}
 
function _set_section_background($background, $post_id, $i) {
	if ( 'none' == $background
		|| ( is_array($background) 
			&& isset($background[$post_id])
			&& 'none' == $background[$post_id] )
		)
		return false;
 
	if ( 'randcolors' == $background 
		|| ( is_array($background) 
			&& isset($background[$post_id]) 
			&& $background[$post_id] == 'randcolors' )
		) {
		//random colors
	    $rand_color_key         = '';
 
	    $colors             = array("#510300" , "#4D2A33", "#2B3F38", "#03A678" ,"#7A5945" , "#807D77" ,"#073233", "#B3858A","#F57B3D", "#449BB5", "#043D5D", "#EB5055", "#68C39F", "#1A4A72", "#4B77BE", "#5C97BF", "#F5AE30", "#EDA737", "#C8C8C8", "#13181C", "#248F79", "#D95448", "#26B89A" , "#EC6766", "#E74C3C");
	    $rand_color_key     = array_rand($colors, 1);
	    return sprintf('.custom-section-%1$s .custom-section-background {background-color:%2$s;opacity: 0.7;}',
			$post_id,
			$colors[$rand_color_key]
		);
	}//end if random colors
 
 
	//if background is a color or an associative array of post_id => color
	if ( ! is_array($background) && false !== strpos($background, '#')
		|| ( is_array($background) 
		&& isset($background[$post_id])
		&& false !== strpos($background[$post_id], '#') )
		) {
		return sprintf('.custom-section-%1$s .custom-section-background {background-color:%2$s;opacity: 0.7;}',
			$post_id,
			is_array($background) ? $background[$post_id] : $background
		);
	} // end if color defined
 
	$is_rand_image = ( 'randimages' == $background
		|| 	( is_array($background) 
			&& isset($background[$post_id]) 
			&& $background[$post_id] == 'randimages' )
		) ? true : false;
	$attachment_id 	= has_post_thumbnail($post_id) ? get_post_thumbnail_id( $post_id ) : false ;
	$thumb_src 		= 'http://lorempixel.com/g/900/500/city/' .$i ;
	$thumb_src 		= ( ! $is_rand_image && false != $attachment_id ) ? wp_get_attachment_image_src( $attachment_id, 'large', false ) : $thumb_src;
	$thumb_src 		= is_array($thumb_src) ? $thumb_src[0] : $thumb_src;
	return sprintf('.custom-section-%1$s .custom-section-background {background: url("%2$s") no-repeat center center fixed;-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; }',
		$post_id,
		$thumb_src
	);
}//end of _set_section_background