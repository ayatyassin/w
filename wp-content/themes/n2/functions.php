<?php
/**
 * ThemesGenerator functions and definitions
 */

/**
 * ThemesGenerator only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function themesgenerator_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/themesgenerator
	 * If you're building a theme based on ThemesGenerator, use a find and replace
	 * to change 'themesgenerator' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'themesgenerator' );

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
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'themesgenerator-featured-image', 2000, 1200, true );

	add_image_size( 'themesgenerator-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;



	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
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
		'audio',
	) );

	// Add theme support for Custom Logo.
/*
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );
*/
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', themesgenerator_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'themesgenerator' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'themesgenerator' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'themesgenerator' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'themesgenerator' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),
		),
	);

	/**
	 * Filters ThemesGenerator array of starter content.
	 *
	 * @since ThemesGenerator 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'themesgenerator_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'themesgenerator_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function themesgenerator_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( themesgenerator_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter ThemesGenerator content width of the theme.
	 *
	 * @since ThemesGenerator 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'themesgenerator_content_width', $content_width );
}
add_action( 'template_redirect', 'themesgenerator_content_width', 0 );

/**
 * Register custom fonts.
 */
function themesgenerator_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'themesgenerator' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since ThemesGenerator 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function themesgenerator_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'themesgenerator-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'themesgenerator_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function themesgenerator_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'themesgenerator' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'themesgenerator' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'themesgenerator' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'themesgenerator' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'themesgenerator' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'themesgenerator' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'themesgenerator_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since ThemesGenerator 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function themesgenerator_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'themesgenerator' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'themesgenerator_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since ThemesGenerator 1.0
 */
function themesgenerator_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'themesgenerator_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function themesgenerator_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'themesgenerator_pingback_header' );

/**
 * Display custom color CSS.
 */
function themesgenerator_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo themesgenerator_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'themesgenerator_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function themesgenerator_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'themesgenerator-fonts', themesgenerator_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'themesgenerator-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'themesgenerator-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'themesgenerator-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'themesgenerator-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'themesgenerator-style' ), '1.0' );
		wp_style_add_data( 'themesgenerator-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'themesgenerator-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'themesgenerator-style' ), '1.0' );
	wp_style_add_data( 'themesgenerator-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'themesgenerator-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$themesgenerator_l10n = array(
//		'quote'          => themesgenerator_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'themesgenerator-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$themesgenerator_l10n['expand']         = __( 'Expand child menu', 'themesgenerator' );
		$themesgenerator_l10n['collapse']       = __( 'Collapse child menu', 'themesgenerator' );
//		$themesgenerator_l10n['icon']           = themesgenerator_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'themesgenerator-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'themesgenerator-skip-link-focus-fix', 'themesgeneratorScreenReaderText', $themesgenerator_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'themesgenerator_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since ThemesGenerator 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function themesgenerator_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'themesgenerator_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since ThemesGenerator 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function themesgenerator_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'themesgenerator_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since ThemesGenerator 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function themesgenerator_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'themesgenerator_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since ThemesGenerator 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function themesgenerator_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'themesgenerator_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since ThemesGenerator 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function themesgenerator_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'themesgenerator_widget_tag_cloud_args' );

/**
 * Implement the Custom Header feature.
 */
//require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
//require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Checks to see if we're on the homepage or not.
 */
function themesgenerator_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}


/**
 * Customizer additions.
 */
//require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

class Excerpt_Walker extends Walker_Nav_Menu
{
    //function start_el(&$output, $item, $depth, $args)
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
	$classes[] = 'item';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		


        $item_output = $args->before;
        $item_output .= '<a class="navbar-menu-link" '. $attributes .'>';

        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        /*GET THE EXCERPT*/
        /*$q = new WP_Query(array('post__in'=>$item->object_id));
        if($q->have_posts()) : while($q->have_posts()) : $q->the_post();
            $item_output .= '<span class="menu-excerpt">'.get_the_excerpt().'</span>';
        endwhile;endif;*/
        /*****************/

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


/*Edit in TG*/
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
	$external_link=get_template_directory_uri()."/themes-generator-theme.txt";
	$complete_link="https://themesgenerator.com/?editmode=ok&dedit=$external_link";
    $admin_bar->add_menu( array(
        'id'    => 'edit-theme',
        'title' => 'Edit Theme',
        'href'  => $complete_link,
        'meta'  => array(
            'title' => __('Edit theme in Themes Generator', 'themesgenerator'),   
			'target' => __('_blank', 'themesgenerator'),
        ),
    ));
}



/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'themesgenerator'  ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );


/**
 * Add Cart icon and count to header if WC is active
 */
function my_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count = WC()->cart->cart_contents_count;
        ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'themesgenerator' ); ?>"><?php
        if ( $count > 0 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
            <?php
        }
                ?></a><?php
    }
 
}
add_action( 'your_theme_header_top', 'my_wc_cart_count' );








/***********************/
/*Woocommerce ratings */
/*********************/

//Enqueue the plugin's styles.
add_action( 'wp_enqueue_scripts', 'tg_woo_ra_rating_styles' );
function tg_woo_ra_rating_styles() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'ci-comment-rating-styles' );
}

//Create the rating interface.
add_action( 'comment_form_logged_in_after', 'tg_woo_ra_rating_rating_field' );
add_action( 'comment_form_after_fields', 'tg_woo_ra_rating_rating_field' );
function tg_woo_ra_rating_rating_field () {
	?>
	<label for="rating">Rating</label>
	<fieldset class="comments-rating">
		<span class="rating-container">
			<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
				<input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" /><label for="rating-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
			<?php endfor; ?>
			<input type="radio" id="rating-0" class="star-cb-clear" name="rating" value="0" /><label for="rating-0">0</label>
		</span>
	</fieldset>
	<?php
}

//Save the rating submitted by the user.
add_action( 'comment_post', 'tg_woo_ra_rating_save_comment_rating' );
function tg_woo_ra_rating_save_comment_rating( $comment_id ) {
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
	$rating = intval( $_POST['rating'] );
	add_comment_meta( $comment_id, 'rating', $rating );
}

//Make the rating required -> is_product() is not working as expected, so validation is disabled
add_filter( 'preprocess_comment', 'tg_woo_ra_rating_require_rating' );
function tg_woo_ra_rating_require_rating( $commentdata ) {
	if (function_exists( 'is_product' ) ) {
		if ( ! is_admin() && is_product() &&( ! isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] ) ) )
		wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' , 'themesgenerator') );
		return $commentdata;
	} else return $commentdata;
}

//Display the rating on a submitted comment.
add_filter( 'comment_text', 'tg_woo_ra_rating_display_rating');
function tg_woo_ra_rating_display_rating( $comment_text ){

	if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		$stars = '<p class="stars">';
		for ( $i = 1; $i <= $rating; $i++ ) {
			$stars .= '<span class="dashicons dashicons-star-filled"></span>';
		}
		$stars .= '</p>';
		$comment_text = $comment_text . $stars;
		return $comment_text;
	} else {
		return $comment_text;
	}
}

//Get the average rating of a post.
function tg_woo_ra_rating_get_average_ratings( $id ) {
	$comments = get_approved_comments( $id );

	if ( $comments ) {
		$i = 0;
		$total = 0;
		foreach( $comments as $comment ){
			$rate = get_comment_meta( $comment->comment_ID, 'rating', true );
			if( isset( $rate ) && '' !== $rate ) {
				$i++;
				$total += $rate;
			}
		}

		if ( 0 === $i ) {
			return false;
		} else {
			return round( $total / $i, 1 );
		}
	} else {
		return false;
	}
}



/*****************************/
/*Disable comments URL field*/
/***************************/

function crunchify_disable_comment_url($fields) { 
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','crunchify_disable_comment_url');





/**************************/
/*Woocommerce customizer */
/************************/

/*Add shop styles if WC is active*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
add_action( "customize_register", "themesgenchild_register_theme_customizer_woo"); 
}

function themesgenchild_register_theme_customizer_woo( $wp_customize ) {


$wp_customize->add_section( 'tg_woo__theme_colors', array(
	'title' => __( 'Shop Styles', 'themesgenerator' ),
	'priority' => 100,
) );


/*cart_color*/
$wp_customize->add_setting( 'cart_color', array(
	'default' => '#444444',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cart_color', array(
	'label' => 'Cart Color',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'cart_color',
) ) );

/*cart_count_background*/
$wp_customize->add_setting( 'cart_count_background', array(
	'default' => '#2ecc71',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cart_count_background', array(
	'label' => 'Cart Count Background',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'cart_count_background',
) ) );

/*cart_count_text*/
$wp_customize->add_setting( 'cart_count_text', array(
	'default' => '#ffffff',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cart_count_text', array(
	'label' => 'Cart Count Text',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'cart_count_text',
) ) );

/*price_color*/
$wp_customize->add_setting( 'price_color', array(
	'default' => '#77a464',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'price_color', array(
	'label' => 'Price Color',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'price_color',
) ) );

/*buttons_text*/
$wp_customize->add_setting( 'buttons_text', array(
	'default' => '#ffffff',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_text', array(
	'label' => 'Buttons Text',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_text',
) ) );

/*buttons_background*/
$wp_customize->add_setting( 'buttons_background', array(
	'default' => '#a46497',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_background', array(
	'label' => 'Buttons Background',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_background',
) ) );

/*buttons_text_hover*/
$wp_customize->add_setting( 'buttons_text_hover', array(
	'default' => '#e6e6e6',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_text_hover', array(
	'label' => 'Buttons Text Hover',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_text_hover',
) ) );

/*buttons_background_hover*/
$wp_customize->add_setting( 'buttons_background_hover', array(
	'default' => '#935386',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_background_hover', array(
	'label' => 'Buttons Background Hover',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_background_hover',
) ) );



function theme_slug_sanitize_checkbox( $input ){    
	if (isset( $input )) return $input;
	else return "false";
}


/*show_cart_in_menu*/
$wp_customize->add_setting( 'show_cart_in_menu', array(
'default'        => true,
'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox"
 ) );
$wp_customize->add_control('show_cart_in_menu',
array(
    'section'   => 'tg_woo__theme_colors',
    'label'     => 'Show cart in menu',
    'type'      => 'checkbox'
     )
 );

/*show_cart_count*/
$wp_customize->add_setting( 'show_cart_count', array(
'default'        => true,
'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox"
 ) );
$wp_customize->add_control('show_cart_count',
array(
    'section'   => 'tg_woo__theme_colors',
    'label'     => 'Show cart counter',
    'type'      => 'checkbox'
     )
 ); 
 
 
/*cart menu location*/
$wp_customize->add_setting(
	'cart_menu_location',
	array(
		'default' => '1',
		'sanitize_callback' => 'sanitize_float',
	)
);
$wp_customize->add_control(
	'cart_menu_location',
	array(
		'label' => 'Cart location (menu number)',
		'section' => 'tg_woo__theme_colors',
		'type' => 'number',
		'input_attrs' => array(
			'min' => '1', 'step' => '1', 'max' => '999',
		  ),
	)
); 
 
 
 
 
}


function tg_customizer_head_styles() {
	$cart_color = get_theme_mod( 'cart_color' ); 	
	if ( $cart_color != '#444444' ) :
	?>
		<style type="text/css">
			.cart-contents:before {
				color: <?php echo $cart_color; ?>;
			}
		</style>
	<?php
	endif;
	
	$cart_count_background = get_theme_mod( 'cart_count_background' );
	if ( $cart_count_background != '#2ecc71' ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				background-color: <?php echo $cart_count_background; ?>;
			}
		</style>
	<?php
	endif;	

	$cart_count_text = get_theme_mod( 'cart_count_text' );
	if ( $cart_count_text != '#ffffff' ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				color: <?php echo $cart_count_text; ?>;
			}
		</style>
	<?php
	endif;	

	$price_color = get_theme_mod( 'price_color' );
	if ( $price_color != '#77a464' ) :
	?>
		<style type="text/css">
			.woocommerce div.product p.price, .woocommerce div.product span.price {
				color: <?php echo $price_color; ?>;
			}
		</style>
	<?php
	endif;

	$buttons_text = get_theme_mod( 'buttons_text' );
	if ( $buttons_text != '#ffffff' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {
				color: <?php echo $buttons_text; ?>!important;
			}
			.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {
				color: <?php echo $buttons_text; ?>!important;
			}
		</style>
	<?php
	endif;

	$buttons_background = get_theme_mod( 'buttons_background' );
	if ( $buttons_background != '#a46497' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {
				background-color: <?php echo $buttons_background; ?>!important;
			}						
			.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {
				background-color: <?php echo $buttons_background; ?>!important;
			}			
		</style>
	<?php
	endif;
	
	$buttons_text_hover = get_theme_mod( 'buttons_text_hover' );
	if ( $buttons_text_hover != '#e6e6e6' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {
				color: <?php echo $buttons_text_hover; ?>!important;
			}
			.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover{
				color: <?php echo $buttons_text_hover; ?>!important;
			}
		</style>
	<?php
	endif;	
	

	$buttons_background_hover = get_theme_mod( 'buttons_background_hover' );
	if ( $buttons_background_hover != '#935386' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {
				background-color: <?php echo $buttons_background_hover; ?>!important;
			}
			.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover {
				background-color: <?php echo $buttons_background_hover; ?>!important;
			}
		</style>
	<?php
	endif;
		
	
	$show_cart_in_menu = get_theme_mod( 'show_cart_in_menu', 'true' ); 	
	if ( $show_cart_in_menu === true ) :
	?>
		<style type="text/css">
			.cart-contents {
				display: block;
			}
		</style>
	<?php
	endif;
	if ( $show_cart_in_menu === false ) :
	?>
		<style type="text/css">
			.cart-contents {
				display: none!important;
			}
		</style>
	<?php
	endif;


	$show_cart_count = get_theme_mod( 'show_cart_count', 'true' ); 	
	if ( $show_cart_count === true ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				display: inline;
			}
		</style>
	<?php
	endif;
	if ( $show_cart_count === false ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				display: none!important;
			}
		</style>
	<?php
	endif;
	
	$cart_menu_location = get_theme_mod( 'cart_menu_location', 'true' ); 	
	if ( $cart_menu_location == "true" ) $cart_menu_location=1;
	if ( $cart_menu_location != "true" ) :
	?>
		<script>
		jQuery( document ).ready(function() {
			/*Ubico cart en menu location asignada*/
			/*Si el menu asignado a carrito no se encuentra en la current page, no lo muestro*/			
			if (jQuery(".mymenu<?php echo $cart_menu_location;?>").length){
				jQuery(".cart-contents").insertAfter( ".mymenu<?php echo $cart_menu_location;?>" );	
			} else jQuery(".cart-contents").remove();						
		});		
		</script>
	<?php
	endif;	
}
add_action( 'wp_head', 'tg_customizer_head_styles' );


/**************************/
/*Site Layout customizer */
/************************/
add_action( "customize_register", "themesgenchild_register_theme_customizer_sitelayout"); 
function themesgenchild_register_theme_customizer_sitelayout( $wp_customize ) {
	$wp_customize->add_section( 'tg_layout', array(
		'title' => __( 'Main Options', 'themesgenerator' ),
		'priority' => 100,
	) );
	function sanitize_float( $input ) {
		return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	}
	/*content_min_height*/
	$wp_customize->add_setting(
		'content_min_height',
		array(
			'default' => '588',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'content_min_height',
		array(
			'label' => 'Content minimum height (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);
	/*content_max_width*/
	$wp_customize->add_setting(
		'content_max_width',
		array(
			'default' => '1400',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'content_max_width',
		array(
			'label' => 'Content maximum width (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);
	/*footer_widgets_sect_max_width*/
	$wp_customize->add_setting(
		'footer_widgets_sect_max_width',
		array(
			'default' => '1280',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'footer_widgets_sect_max_width',
		array(
			'label' => 'Footer widgets area max width (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	/*footer_widgets_padding_leftright*/
	$wp_customize->add_setting(
		'footer_widgets_padding_leftright',
		array(
			'default' => '30',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'footer_widgets_padding_leftright',
		array(
			'label' => 'Footer widgets left/right padding (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	/*footer_widgets_padding_topbottom*/
	$wp_customize->add_setting(
		'footer_widgets_padding_topbottom',
		array(
			'default' => '35',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'footer_widgets_padding_topbottom',
		array(
			'label' => 'Footer widgets top/bott padding (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	


	
	
	
	
	/*post_excerpt_length*/
	$wp_customize->add_setting(
		'post_excerpt_length',
		array(
			'default' => '55',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'post_excerpt_length',
		array(
			'label' => 'Post excerpt length (words)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);
	
	
	
	
	
	
	
	function theme_slug_sanitize_checkbox2( $input ){    
		if (isset( $input )) return $input;
		else return "false";
	}


	/*show_full_width_footer_widgets*/
	$wp_customize->add_setting( 'show_full_width_footer_widgets', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('show_full_width_footer_widgets',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Full width footer widgets',
		'type'      => 'checkbox'
		 )
	 );


	




	 
	/*menu_footer_widgets_background*/
	require_once( dirname( __FILE__ ) . '/inc/alpha-color-picker.php' );
	$wp_customize->add_setting(
		'footer_widgets_background',
		array(
			'default'     => 'rgba(238,238,238,1)',
			'type'        => 'theme_mod',
			'capability'  => 'edit_theme_options',
			'transport'   => 'refresh',"sanitize_callback" => "esc_attr"
		)
	);
	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'footer_widgets_background',
			array(
				'label'         => 'Footer widgets area background',
				'section'       => 'tg_layout',
				'settings'      => 'footer_widgets_background',
				'show_opacity'  => true, // Optional.
				'palette'	=> array(
					'rgb(150, 50, 220)', // RGB, RGBa, and hex values supported
					'rgba(50,50,50,0.8)',
					'rgba( 255, 255, 255, 0.2 )', // Different spacing = no problem
					'#00CC99' // Mix of color types = no problem
				)
			)
		)
	);



	
	
	
	
	
	
	
	
	
	/*page_title_color*/ 
	$wp_customize->add_setting( 'page_title_color', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_title_color', array(
		'label' => 'Page title color',
		'section' => 'tg_layout',
		'settings' => 'page_title_color',
	) ) );	
	/*post_title_color*/ 
	$wp_customize->add_setting( 'post_title_color', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_title_color', array(
		'label' => 'Post title color',
		'section' => 'tg_layout',
		'settings' => 'post_title_color',
	) ) );	
	/*page_title_size*/
	$wp_customize->add_setting(
		'page_title_size',
		array(
			'default' => '26',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'page_title_size',
		array(
			'label' => 'Page title size (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	/*post_title_size*/
	$wp_customize->add_setting(
		'post_title_size',
		array(
			'default' => '26',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'post_title_size',
		array(
			'label' => 'Post title size (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	
	
	
			function tg_sanitize_fontweight_pagetitle( $input ) {
			$valid = array(
			'100' => 'Thin',
			'200' => 'Extra-Light',
			'300' => 'Light',
			'400' => 'Normal',
			'500' => 'Medium',
			'600' => 'Semi-Bold',
			'700' => 'Bold',
			'800' => 'Extra-Bold',
			'900' => 'Ultra-Bold',			
			);
			if ( array_key_exists( $input, $valid ) ) {
				return $input;
			} else {
				return '';
			}
			}	
			$bold_choices = array(
				'100' => 'Thin',
				'200' => 'Extra-Light',
				'300' => 'Light',
				'400' => 'Normal',
				'500' => 'Medium',
				'600' => 'Semi-Bold',
				'700' => 'Bold',
				'800' => 'Extra-Bold',
				'900' => 'Ultra-Bold',				
			);
			$wp_customize->add_setting( 'fontweight_pagetitle', array(
					'sanitize_callback' => 'tg_sanitize_fontweight_pagetitle',
					'default' => '400'
				)
			);
			$wp_customize->add_control( 'fontweight_pagetitle', array(
					'type' => 'select',
					"label"    => __( "Page title font weight", "themesgenerator" ),
					/*'description' => __( 'Select your desired font for the body.', 'themesgenerator' ),*/
					'section' => 'tg_layout',
					'choices' => $bold_choices,
					"settings" => "fontweight_pagetitle"
				)
			);
	
	
	
	
			function tg_sanitize_fontweight_posttitle( $input ) {
			$valid = array(
			'100' => 'Thin',
			'200' => 'Extra-Light',
			'300' => 'Light',
			'400' => 'Normal',
			'500' => 'Medium',
			'600' => 'Semi-Bold',
			'700' => 'Bold',
			'800' => 'Extra-Bold',
			'900' => 'Ultra-Bold',			
			);
			if ( array_key_exists( $input, $valid ) ) {
				return $input;
			} else {
				return '';
			}
			}	
			$bold_choices = array(
				'100' => 'Thin',
				'200' => 'Extra-Light',
				'300' => 'Light',
				'400' => 'Normal',
				'500' => 'Medium',
				'600' => 'Semi-Bold',
				'700' => 'Bold',
				'800' => 'Extra-Bold',
				'900' => 'Ultra-Bold',				
			);
			$wp_customize->add_setting( 'fontweight_posttitle', array(
					'sanitize_callback' => 'tg_sanitize_fontweight_posttitle',
					'default' => '400'
				)
			);
			$wp_customize->add_control( 'fontweight_posttitle', array(
					'type' => 'select',
					"label"    => __( "Post title font weight", "themesgenerator" ),
					/*'description' => __( 'Select your desired font for the body.', 'themesgenerator' ),*/
					'section' => 'tg_layout',
					'choices' => $bold_choices,
					"settings" => "fontweight_posttitle"
				)
			);	
	
	
	
	
	
	
				/*page_title_font*/
				 function tgnav_sanitize_fonts_pagetitle( $input ) { $valid = array(
				 "auto" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
				 if ( array_key_exists( $input, $valid ) ) { return $input;
				 } else {
				 return "";
				 } } 
				 
				 $font_choices = array(
				 "inherit" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
			
			
				$wp_customize->add_setting( "page_title_font_pagetitle", array("sanitize_callback" => "tgnav_sanitize_fonts_pagetitle","default" => "inherit"));
				$wp_customize->add_control( "page_title_font_pagetitle", array("type" => "select","label" => __( "Page title font", "themesgenerator" ),"section" => "tg_layout","choices" => $font_choices,"settings" => "page_title_font_pagetitle"));	
				

				/*post_title_font*/
				 function tgnav_sanitize_fonts_posttitle( $input ) { $valid = array(
				 "auto" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
				 if ( array_key_exists( $input, $valid ) ) { return $input;
				 } else {
				 return "";
				 } } 
				 
				 $font_choices = array(
				 "inherit" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
			
			
				$wp_customize->add_setting( "post_title_font_posttitle", array("sanitize_callback" => "tgnav_sanitize_fonts_posttitle","default" => "inherit"));
				$wp_customize->add_control( "post_title_font_posttitle", array("type" => "select","label" => __( "Post title font", "themesgenerator" ),"section" => "tg_layout","choices" => $font_choices,"settings" => "post_title_font_posttitle"));	
		

	

	/*show_posts_sidebar*/
	$wp_customize->add_setting( 'show_posts_sidebar', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('show_posts_sidebar',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Sidebar in blog & WooCommerce',
		'type'      => 'checkbox'
		 )
	 );	
	 
	 
	 
	/*show_back_to_top_button*/
	$wp_customize->add_setting( 'show_back_to_top_button', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('show_back_to_top_button',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Show back to top button',
		'type'      => 'checkbox'
		 )
	 );


	/*back_to_top_button_arrow_color*/ 
	$wp_customize->add_setting( 'back_to_top_button_arrow_color', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_to_top_button_arrow_color', array(
		'label' => 'Back to top arrow',
		'section' => 'tg_layout',
		'settings' => 'back_to_top_button_arrow_color',
	) ) );

	
	/*back_to_top_button_arrow_background*/ 
	$wp_customize->add_setting( 'back_to_top_button_arrow_background', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_to_top_button_arrow_background', array(
		'label' => 'Back to top background',
		'section' => 'tg_layout',
		'settings' => 'back_to_top_button_arrow_background',
	) ) );


	/*back_to_top_button_arrow_hover*/ 
	$wp_customize->add_setting( 'back_to_top_button_arrow_hover', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_to_top_button_arrow_hover', array(
		'label' => 'Back to top hover',
		'section' => 'tg_layout',
		'settings' => 'back_to_top_button_arrow_hover',
	) ) );	




	/*back_to_top_button_align_left*/
	$wp_customize->add_setting( 'back_to_top_button_align_left', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('back_to_top_button_align_left',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Back to top button align left',
		'type'      => 'checkbox'
		 )
	 );
	 
	 
	 
	 
	 
	/*back_to_top_button_opacity*/
	$wp_customize->add_setting(
		'back_to_top_button_opacity',
		array(
			'default' => '1',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'back_to_top_button_opacity',
		array(
			'label' => 'Back to top button opacity',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '0.1', 'max' => '1',
			  ),
		)
	);
	
}
/*Page title font, outside the main customizer function*/
function tgnav_scripts_pagetitle() { $page_title_font_pagetitle = esc_html(get_theme_mod("page_title_font_pagetitle")); if( $page_title_font_pagetitle ) { $not_google_fonts_pagetitle = array("inherit", "Arial", "Brush Script MT", "Comic Sans MS", "Courier New", "Georgia", "Helvetica", "Impact", "Lucida Sans Unicode", "Times New Roman", "Trebuchet MS", "Verdana"); foreach ($not_google_fonts_pagetitle as $url) { if (strpos($page_title_font_pagetitle, $url) !== FALSE) { return true;}}	wp_enqueue_style( "themesgenerator-body-fonts_pagetitle", "//fonts.googleapis.com/css?family=". $page_title_font_pagetitle ); } else { wp_enqueue_style( "themesgenerator-source-body_pagetitle", "//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600");}}add_action( "wp_enqueue_scripts", "tgnav_scripts_pagetitle" );
function tg_sitelayout_latest_posts_2_pagetitle() { $page_title_font_pagetitle = esc_html(get_theme_mod("page_title_font_pagetitle")); if ( $page_title_font_pagetitle ) {	$font_pieces = explode(":", $page_title_font_pagetitle); $custom = "body.page:not(.themesgenerator-front-page) .entry-title { font-family: ".$font_pieces[0]."!important; }"."\n";} if ( $page_title_font_pagetitle ) : ?> <style type="text/css"> <?php echo $custom;?> </style> <?php endif; } add_action( "wp_head", "tg_sitelayout_latest_posts_2_pagetitle" );

/*Post title font, outside the main customizer function*/
function tgnav_scripts_posttitle() { $post_title_font_posttitle = esc_html(get_theme_mod("post_title_font_posttitle")); if( $post_title_font_posttitle ) { $not_google_fonts_posttitle = array("inherit", "Arial", "Brush Script MT", "Comic Sans MS", "Courier New", "Georgia", "Helvetica", "Impact", "Lucida Sans Unicode", "Times New Roman", "Trebuchet MS", "Verdana"); foreach ($not_google_fonts_posttitle as $url) { if (strpos($post_title_font_posttitle, $url) !== FALSE) { return true;}}	wp_enqueue_style( "themesgenerator-body-fonts_posttitle", "//fonts.googleapis.com/css?family=". $post_title_font_posttitle ); } else { wp_enqueue_style( "themesgenerator-source-body_posttitle", "//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600");}}add_action( "wp_enqueue_scripts", "tgnav_scripts_posttitle" );
function tg_sitelayout_latest_posts_2_posttitle() { $post_title_font_posttitle = esc_html(get_theme_mod("post_title_font_posttitle")); if ( $post_title_font_posttitle ) {	$font_pieces = explode(":", $post_title_font_posttitle); $custom = "body.single:not(.themesgenerator-front-page) .entry-title { font-family: ".$font_pieces[0]."!important; }"."\n";} if ( $post_title_font_posttitle ) : ?> <style type="text/css"> <?php echo $custom;?> </style> <?php endif; } add_action( "wp_head", "tg_sitelayout_latest_posts_2_posttitle" );
	



function tg_sitelayout_head_styles() {
	$content_min_height = get_theme_mod( 'content_min_height' ); 	
	if ( $content_min_height != '588' ) :
	?>
		<style type="text/css">
			body:not(.home) .site-content {
				min-height: <?php echo $content_min_height; ?>px;
			}
		</style>
	<?php
	endif;
	$content_max_width = get_theme_mod( 'content_max_width' ); 	
	if ( $content_max_width != '1400' ) :
	?>
		<style type="text/css">
			body:not(.home) .wrap{
				max-width: <?php echo $content_max_width; ?>px;
				margin: 0 auto;
			}
		</style>
	<?php
	endif;
	$footer_widgets_sect_max_width = get_theme_mod( 'footer_widgets_sect_max_width' ); 	
	if ( $footer_widgets_sect_max_width != '1280' ) :
	?>
		<style type="text/css">
			.home .site-footer .widget-area{
				max-width: <?php echo $footer_widgets_sect_max_width; ?>px!important;
			}
		</style>
	<?php
	endif;
	$footer_widgets_padding_leftright = get_theme_mod( 'footer_widgets_padding_leftright' ); 	
	if ( $footer_widgets_padding_leftright != '30' ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				padding-left: <?php echo $footer_widgets_padding_leftright; ?>px!important;
				padding-right: <?php echo $footer_widgets_padding_leftright; ?>px!important;
			}
		</style>
	<?php
	endif;
	$footer_widgets_padding_topbottom = get_theme_mod( 'footer_widgets_padding_topbottom' ); 	
	if ( $footer_widgets_padding_topbottom != '35' ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				padding-top: <?php echo $footer_widgets_padding_topbottom; ?>px!important;
				padding-bottom: <?php echo $footer_widgets_padding_topbottom; ?>px!important;
			}
		</style>
	<?php
	endif;
	
	

	$post_excerpt_length = get_theme_mod( 'post_excerpt_length' ); 	
	if ( $post_excerpt_length != '55' ) :
		function wpdocs_custom_excerpt_length( $length ) {
			$post_excerpt_length = get_theme_mod( 'post_excerpt_length' ); 
			if (empty($post_excerpt_length)) $post_excerpt_length='55';
			return $post_excerpt_length;
		}
		add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );	
	endif;




	
	





	$back_to_top_button_opacity = get_theme_mod( 'back_to_top_button_opacity' ); 	
	if ( $back_to_top_button_opacity != '1' ) :
	?>
		<style type="text/css">
			#backtotopbutton.show {
				opacity: <?php echo $back_to_top_button_opacity; ?>!important;
			}
		</style>
	<?php
	endif;	
	
		

	
	
	

	
	$show_full_width_footer_widgets = get_theme_mod( 'show_full_width_footer_widgets', 'true' );
	if ( $show_full_width_footer_widgets === true ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				width: 100%!important;
			}
		</style>
	<?php
	endif;
	if ( $show_full_width_footer_widgets === false ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				width: 36%;
			}
		</style>
	<?php
	endif;
	
	
	
	
	
	
	

	
	
	
	
	
	$show_back_to_top_button = get_theme_mod( 'show_back_to_top_button', 'true' );
	if ( $show_back_to_top_button === true ) :
	?>
		<style type="text/css">
		#backtotopbutton.show {
				  opacity: 1;
				  visibility: visible;
				}
		</style>
	<?php
	endif;
	if ( $show_back_to_top_button === false ) :
	?>
		<style type="text/css">
			#backtotopbutton.show {
			  opacity: 0;
			  visibility: hidden;
			}
		</style>
	<?php
	endif;	
	



	
	
	$back_to_top_button_align_left = get_theme_mod( 'back_to_top_button_align_left', 'true' );
	if ( $back_to_top_button_align_left === true ) :
	?>
		<style type="text/css">
			#backtotopbutton {
			  left: 30px;
			  right: auto;
			}
		</style>
	<?php
	endif;
	if ( $back_to_top_button_align_left === false ) :
	?>
		<style type="text/css">
			#backtotopbutton {
			  right: 30px;
			}
		</style>
	<?php
	endif;	





	
	
/*Begin page & post title*/		
	$page_title_color = get_theme_mod( 'page_title_color' ); 	
	if (( $page_title_color != 'inherit' )&&( $page_title_color != '' )) :
	?>
		<style type="text/css">
			body.page:not(.themesgenerator-front-page) .entry-title{
				color: <?php echo $page_title_color; ?>!important;
			}
		</style>
	<?php
	endif;	
	$page_title_size = get_theme_mod( 'page_title_size' ); 	
	if ( $page_title_size != '26.5' ) :
	?>
		<style type="text/css">
			body.page:not(.themesgenerator-front-page) .entry-title{
				font-size: <?php echo $page_title_size; ?>px!important;
			}
		</style>
	<?php
	endif;
	
	
	
	
	$page_title_fontweight = esc_html(get_theme_mod('fontweight_pagetitle'));
	if ( $page_title_fontweight ) {
			?>
				<style type="text/css">					
					body.page:not(.themesgenerator-front-page) .entry-title { font-weight: <?php echo $page_title_fontweight;?>!important; }
				</style>
			<?php
	}
		
	$post_title_fontweight = esc_html(get_theme_mod('fontweight_posttitle'));
	if ( $post_title_fontweight ) {
			?>
				<style type="text/css">					
					body.single:not(.themesgenerator-front-page) .entry-title { font-weight: <?php echo $post_title_fontweight;?>!important; }
				</style>
			<?php
	}	




	
		
		
	$post_title_color = get_theme_mod( 'post_title_color' ); 	
	if (( $post_title_color != 'inherit' )&&( $post_title_color != '' )) :
	?>
		<style type="text/css">
			body.single:not(.themesgenerator-front-page) .entry-title{
				color: <?php echo $post_title_color; ?>!important;
			}
		</style>
	<?php
	endif;	
	$post_title_size = get_theme_mod( 'post_title_size' ); 	
	if ( $post_title_size != '26.5' ) :
	?>
		<style type="text/css">
			body.single:not(.themesgenerator-front-page) .entry-title{
				font-size: <?php echo $post_title_size; ?>px!important;
			}
		</style>
	<?php
	endif;	
/*End page & post title*/		


	
	
	
	
	
	
	$back_to_top_button_arrow_color = get_theme_mod( 'back_to_top_button_arrow_color' ); 	
	if (( $back_to_top_button_arrow_color != 'inherit' )&&( $back_to_top_button_arrow_color != '' )) :
	?>
		<style type="text/css">
			#backtotopbutton::after {
				color: <?php echo $back_to_top_button_arrow_color; ?>!important;
			}
		</style>
	<?php
	endif;
	
	
	$back_to_top_button_arrow_background = get_theme_mod( 'back_to_top_button_arrow_background' ); 	
	if (( $back_to_top_button_arrow_background != 'inherit' )&&( $back_to_top_button_arrow_background != '' )) :
	?>
		<style type="text/css">
			#backtotopbutton {
				background-color: <?php echo $back_to_top_button_arrow_background; ?>;
			}
		</style>
	<?php
	endif;	
	
	$back_to_top_button_arrow_hover = get_theme_mod( 'back_to_top_button_arrow_hover' ); 	
	if (( $back_to_top_button_arrow_hover != 'inherit' )&&( $back_to_top_button_arrow_hover != '' )) :
	?>
		<style type="text/css">
			#backtotopbutton:hover {
				background-color: <?php echo $back_to_top_button_arrow_hover; ?>;
			}
		</style>
	<?php
	endif;		
	
	
	
	
	
	$footer_widgets_background = get_theme_mod( 'footer_widgets_background' ); 	
	if ( $footer_widgets_background != 'rgba(238,238,238,1)' ) :
	?>
		<style type="text/css">
			.site-footer {
				background-color: <?php echo $footer_widgets_background; ?>!important;
			}
		</style>
	<?php
	endif;



	
	$show_posts_sidebar = get_theme_mod( 'show_posts_sidebar', 'true' ); 
	/*Sidebar function*/ function init_add_sidebar_classes_to_body2($classes = ""){		$classes[] = "has-sidebar";    return $classes;}	
	if ( $show_posts_sidebar === true ) {
		add_filter("body_class", "init_add_sidebar_classes_to_body2");		
	}
	if ( $show_posts_sidebar === false ) {
		remove_filter("body_class", "init_add_sidebar_classes_to_body2");
		remove_filter("body_class", "init_add_sidebar_classes_to_body");
	}

	
}	
add_action( 'wp_head', 'tg_sitelayout_head_styles' );

function shop_cat_sidebar() {
	get_sidebar();
}
add_action( 'woocommerce_after_shop_loop', 'shop_cat_sidebar', 2);




/*******************************/
/*Translate customizer strings*/
/*****************************/
function youruniqueprefix_filter_gettext( $translated, $original, $domain ) {
 
    // This is an array of original strings
    // and what they should be replaced with
    $strings = array(
        'Your latest posts' => 'Themes Generator',
        'Howdy, %1$s' => 'Greetings, %1$s!',
        // Add some more strings here
    );
 
    // See if the current string is in the $strings array
    // If so, replace it's translation
    if ( isset( $strings[$original] ) ) {
        // This accomplishes the same thing as __()
        // but without running it through the filter again
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }
 
    return $translated;
}
 
add_filter( 'gettext', 'youruniqueprefix_filter_gettext', 10, 3 );






// Wrap all categories in a function
function wcat2() {
    $out = array();
    $categories = get_categories();
	$out['showallcategories'] = 'all';
    foreach( $categories as $category ) {
		/*
        $out[$category->term_id] = array(
            'label' => $category->slug,
            'value' => $category->term_id
        );
		*/
		
		 $out[$category->slug] = $category->slug;
    }
    //return array('options'=>$out);
    return $out;
}


function wpse55748_filter_post_thumbnail_html( $html ) {
    // If there is no post thumbnail,
    // Return a default image
    if ( '' == $html ) {
        /*return '<img src="' . get_template_directory_uri() . '/images/no-photo-available.svg" class="image-size-name" />';*/
		return '<img src="https://gist.githubusercontent.com/xamdam777/451b47c2f450ff13a21e9930f7ba65ff/raw/cd28ec1bd6647f4fca3177fb35c076f40f151440/no-image.svg?sanitize=true" class="image-size-name" />';
		
    }
    // Else, return the post thumbnail
    return $html;
}
add_filter( 'post_thumbnail_html', 'wpse55748_filter_post_thumbnail_html' );


/*Custom js (tracking code)*/
add_action( 'customize_register', 'tg_tracking_code' );
function tg_tracking_code( $wp_customize ) {	 
		$wp_customize->add_section( 'custom_js', array(
			'title'    => __( 'Additional Code', 'textdomain' ),
			'priority' => 190,
		) );
	 
		$wp_customize->add_setting( 'custom_js', array(
			'type' => 'option',
		) );	 
		$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'custom_html', array(
			'label'     => 'Tracking Code',
			'code_type' => 'javascript',
			'settings'  => 'custom_js',
			'section'   => 'custom_js',
		) ) );	 
	}	 
add_action( 'wp_footer', 'prefix_customize_output' );
function prefix_customize_output() {	 
		$js = get_option( 'custom_js', '' );	 
		if ( '' === $js ) {	 
			return;	 
		} 
		echo $js . "\n";
	}
	
/*Activate TG front page after install*/	
function themename_after_setup_theme() {
 $site_type = get_option('show_on_front');
 if($site_type == 'page') {
  update_option( 'show_on_front', 'posts' );
 }
}
add_action( 'after_switch_theme', 'themename_after_setup_theme' );	























/* Page & post settings (title, todo...) */
function themesgenerator_metabox_get_meta( $value ) {
	global $post;
	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function themesgenerator_metabox_add_meta_box() {
	add_meta_box(
		'themesgenerator_metabox-custom-metabox',
		__( 'Page extra options', 'themesgenerator' ),
		'themesgenerator_metabox_html',
		'page',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'themesgenerator_metabox_add_meta_box' );
function themesgenerator_metabox_html( $post) {
	wp_nonce_field( '_themesgenerator_metabox_nonce', 'themesgenerator_metabox_nonce' ); ?>
	<p> <label style="display: block;" for="custom_metabox_show_title"><?php _e( 'Show the page title in the frontend', 'themesgenerator' ); ?></label><br>
		<select name="custom_metabox_show_title" id="custom_metabox_show_title">
			<option value="block" <?php echo (themesgenerator_metabox_get_meta( 'custom_metabox_show_title' ) === 'block' ) ? 'selected' : '' ?>>Yes</option>
			<option value="none" <?php echo (themesgenerator_metabox_get_meta( 'custom_metabox_show_title' ) === 'none' ) ? 'selected' : '' ?>>No</option>
		</select>
	</p>	
<?php
}
function themesgenerator_metabox_showpostmeta_html() {
	add_meta_box(
		'themesgenerator_metabox-custom-metabox-postmeta',
		__( 'Post extra options', 'themesgenerator' ),
		'themesgenerator_postmetabox_html',
		'post',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'themesgenerator_metabox_showpostmeta_html' );
function themesgenerator_postmetabox_html($post) {
	wp_nonce_field( '_themesgenerator_metabox_noncepost', 'themesgenerator_metabox_noncepost' ); ?>
	<p> 
	<label style="display: block;" for="custom_metabox_show_titlepost"><?php _e( 'Show the post title in the frontend', 'themesgenerator' ); ?></label><br>
		<select name="custom_metabox_show_titlepost" id="custom_metabox_show_titlepost">
			<option value="block" <?php echo (themesgenerator_metabox_get_meta( 'custom_metabox_show_titlepost' ) === 'block' ) ? 'selected' : '' ?>>Yes</option>
			<option value="none" <?php echo (themesgenerator_metabox_get_meta( 'custom_metabox_show_titlepost' ) === 'none' ) ? 'selected' : '' ?>>No</option>
		</select>
	</p>
	<p> <label style="display: block;" for="custom_metabox_show_metapost"><?php _e( 'Show the post meta data (date & author) in the frontend', 'themesgenerator' ); ?></label><br>
		<select name="custom_metabox_show_metapost" id="custom_metabox_show_metapost">
			<option value="block" <?php echo (themesgenerator_metabox_get_meta( 'custom_metabox_show_metapost' ) === 'block' ) ? 'selected' : '' ?>>Yes</option>
			<option value="none" <?php echo (themesgenerator_metabox_get_meta( 'custom_metabox_show_metapost' ) === 'none' ) ? 'selected' : '' ?>>No</option>
		</select>
	</p>	
<?php
}
function themesgenerator_metabox_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;		
	if (( ! isset( $_POST['themesgenerator_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['themesgenerator_metabox_nonce'], '_themesgenerator_metabox_nonce' ) )&&( ! isset( $_POST['themesgenerator_metabox_noncepost'] ) || ! wp_verify_nonce( $_POST['themesgenerator_metabox_noncepost'], '_themesgenerator_metabox_noncepost' ) )) return;		
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;	
	if ( isset( $_POST['custom_metabox_show_title'] ) )	update_post_meta( $post_id, 'custom_metabox_show_title', esc_attr( $_POST['custom_metabox_show_title'] ) );
	if ( isset( $_POST['custom_metabox_show_titlepost'] ) )	update_post_meta( $post_id, 'custom_metabox_show_titlepost', esc_attr( $_POST['custom_metabox_show_titlepost'] ) );	
	if ( isset( $_POST['custom_metabox_show_metapost'] ) )	update_post_meta( $post_id, 'custom_metabox_show_metapost', esc_attr( $_POST['custom_metabox_show_metapost'] ) );
}
add_action( 'save_post', 'themesgenerator_metabox_save' );






/**
 * Include the TGM_Plugin_Activation class for Easy Theme and Plugin Upgrades
 */
require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'my_theme_register_required_pluginsEasyUpgrades' );
function my_theme_register_required_pluginsEasyUpgrades() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		/** This is an example of how to include a plugin pre-packaged with a theme */
		/*
		array(
			'name'     => 'TGM Example Plugin', // The plugin name
			'slug'     => 'tgm-example-plugin', // The plugin slug (typically the folder name)
			'source'   => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source
			'required' => false,
		),
		*/
		/** This is an example of how to include a plugin from the WordPress Plugin Repository */
		array(
			'name' => 'Easy Theme and Plugin Upgrades',
			'slug' => 'easy-theme-and-plugin-upgrades',
		)
	);
	/** Change this to your theme text domain, used for internationalising strings */
	$theme_text_domain = 'themesgenerator';
	/**
	 * Array of configuration settings. Uncomment and amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * uncomment the strings and domain.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		/*'domain'       => $theme_text_domain,         // Text domain - likely want to be the same as your theme. */
		/*'default_path' => '',                         // Default absolute path to pre-packaged plugins */
		/*'menu'         => 'install-my-theme-plugins', // Menu slug */
		'strings'      	 => array(
			/*'page_title'             => __( 'Install Required Plugins', $theme_text_domain ), // */
			/*'menu_title'             => __( 'Install Plugins', $theme_text_domain ), // */
			/*'instructions_install'   => __( 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain ), // %1$s = plugin name */
			/*'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
			/*'button'                 => __( 'Install %s Now', $theme_text_domain ), // %1$s = plugin name */
			/*'installing'             => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name */
			/*'oops'                   => __( 'Something went wrong with the plugin API.', $theme_text_domain ), // */
			/*'notice_can_install'     => __( 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', $theme_text_domain ), // %1$s = plugin name, %2$s = TGMPA page URL */
			/*'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ), // %1$s = plugin name */
			/*'notice_can_activate'    => __( 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
			/*'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ), // %1$s = plugin name */
			/*'return'                 => __( 'Return to Required Plugins Installer', $theme_text_domain ), // */
		),
	);
	tgmpa( $plugins, $config );
}

add_action( "customize_register", "themegenchild_register_theme_customizer2" ); function themegenchild_register_theme_customizer2( $wp_customize ) { $wp_customize->add_panel( "featured_images", array("priority" => 70, "theme_supports" => "","title" => __( "Images", "themesgenerator" ), "description" => __( "Set images", "themesgenerator" ), ) );
$wp_customize->add_section( "customtgimg-1" , array("title" => __("Change Image 1","themesgenerator"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-1", array( "sanitize_callback" => "esc_attr", "default" => "//d33rxv6e3thba6.cloudfront.net/2015/11/56711c4496eb08c9070977df/32174-l90ad7.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-1", array( "label"    => __( "Image 1", "themesgenerator" ), "section"  => "customtgimg-1", "settings" => "tgimg-1" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-1", array("selector" => "#tgimg-1",));

$wp_customize->add_section( "customtgimg-2" , array("title" => __("Change Image 2","themesgenerator"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-2", array( "sanitize_callback" => "esc_attr", "default" => "//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-1bw0amh.jpeg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-2", array( "label"    => __( "Image 2", "themesgenerator" ), "section"  => "customtgimg-2", "settings" => "tgimg-2" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-2", array("selector" => "#tgimg-2",));

$wp_customize->add_section( "customtgimg-3" , array("title" => __("Change Image 3","themesgenerator"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-3", array( "sanitize_callback" => "esc_attr", "default" => "//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-13tok9w.jpeg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-3", array( "label"    => __( "Image 3", "themesgenerator" ), "section"  => "customtgimg-3", "settings" => "tgimg-3" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-3", array("selector" => "#tgimg-3",));

$wp_customize->add_section( "customtgimg-4" , array("title" => __("Change Image 4","themesgenerator"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-4", array( "sanitize_callback" => "esc_attr", "default" => "//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-17lu7om.jpeg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-4", array( "label"    => __( "Image 4", "themesgenerator" ), "section"  => "customtgimg-4", "settings" => "tgimg-4" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-4", array("selector" => "#tgimg-4",));

$wp_customize->add_section( "customtgimg-5" , array("title" => __("Change Image 5","themesgenerator"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-5", array( "sanitize_callback" => "esc_attr", "default" => "//d33rxv6e3thba6.cloudfront.net/2016/11/581b45e2d93877bd681e08aa/28315-5vay1p.jpeg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-5", array( "label"    => __( "Image 5", "themesgenerator" ), "section"  => "customtgimg-5", "settings" => "tgimg-5" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-5", array("selector" => "#tgimg-5",));
}
add_action( "customize_register", "themegenchild_register_theme_customizerLinks" ); function themegenchild_register_theme_customizerLinks( $wp_customize ) { $wp_customize->add_panel( "featured_links", array("priority" => 70, "theme_supports" => "","title" => __( "Links", "themesgenerator" ), "description" => __( "Set links", "themesgenerator" ), ) );
$wp_customize->add_section( "customtglink-9999" , array("title" => __("See all","themesgenerator"),	"panel"    => "featured_links","priority" => 1) );


}





add_action( "customize_register", "themegenchild_register_theme_customizer3" ); function themegenchild_register_theme_customizer3( $wp_customize ) { $wp_customize->add_panel( "featured_backgrounds", array("priority" => 70, "theme_supports" => "","title" => __( "Backgrounds", "themesgenerator" ), "description" => __( "Set background image.", "themesgenerator" ), ) );}

function footer_script(){ if( is_home() || is_front_page() ) { ?>
<script>jQuery(document).ready(function(){var e=atob('cGxlYXNlLCB1cGdyYWRlIHRvIGEgcHJlbWl1bSBhY2NvdW50IHRvIHJlbW92ZSBURyBjcmVkaXRz');if (!jQuery('.home .site-info-tgen').length){alert(e); return;}if (jQuery('.home .site-info-tgen').length){/*Avoids undefined*/if (jQuery('.home .site-info-tgen').html().indexOf('themesgenerator.com') > -1){/*ok*/}else{alert(e); return;}}if (!jQuery('.home .site-info-tgen').is(':visible')){alert(e); return;}if (!jQuery('.home div.site-info-tgen > a').is(':visible')){alert(e); return;}});</script>
			<?php }}
add_action('wp_footer', 'footer_script'); ?>