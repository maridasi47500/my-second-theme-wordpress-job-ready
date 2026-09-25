<?php
add_theme_support( 'post-thumbnails' );
//include '../../plugins/musician/musician.php';
//add_action('after_setup_theme', 'wpdocs_theme_setup');
//add_action( 'init', 'wporg_register_taxonomy_musician' );
if ( ! isset ( $content_width) ) {
    $content_width = 800;
}


$args = array(
    'default-color' => '0000ff',
    'default-image' => get_theme_file_uri( 'assets/img/terremusique.png' ) ,
);
add_theme_support( 'custom-background', $args );
add_action( 'after_setup_theme', 'theme_slug_setup' );

function theme_slug_setup() {
	add_editor_style( get_stylesheet_uri() );
}

//function themename_custom_header_setup() {
	$defaults = array(
		// Default Header Image to display.
		'default-image'          => get_theme_file_uri('assets/img/sky.png'),
		// Display the header text along with the image.
		'header-text'            => false,
		// Header text color default.
		'default-text-color'     => '000',
		// Header image width (in pixels).
		'width'                  => 1000,
		// Header image height (in pixels).
		'height'                 => 198,
		// Header image random rotation default.
		'random-default'         => false,
		// Enable upload of image file in admin.
		'uploads'                => false,
		// Function to be called in theme head section.
		//'wp-head-callback'       => 'wphead_cb',
		// Function to be called in preview page head section.
		//'admin-head-callback'    => 'adminhead_cb',
		// Function to produce preview markup in the admin screen.
		//'admin-preview-callback' => 'adminpreview_cb',
	);
//add_theme_support( 'custom-header' );

global $wp_version;
if ( version_compare( $wp_version, '3.4', '>=' ) ) :
        add_theme_support( 'custom-header', $defaults );
else :
	add_custom_image_header( $wp_head_callback, $admin_head_callback );
endif;
function themename_custom_logo_setup() {
	$defaults = array(
		'height'               => 100,
		'width'                => 400,
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => true,
	);
	add_theme_support( 'custom-logo', $defaults );
}
add_action( 'after_setup_theme', 'themename_custom_logo_setup' );
the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) );
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'extra-menu' => __( 'Extra Menu' )
     )
   );
 }
 add_action( 'init', 'register_my_menus' );
//}
//add_action( 'after_setup_theme', 'themename_custom_header_setup' );
/**
 * MyFirstTheme's functions and definitions
 *
 * @package MyFirstTheme
 * @since MyFirstTheme 1.0
 */

/**
 * First, let's set the maximum content width based on the theme's
 * design and stylesheet.
 * This will limit the width of all uploaded images and embeds.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800; /* pixels */
}


if ( ! function_exists( 'myfirsttheme_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various
	 * WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme
	 * hook, which runs before the init hook. The init hook is too late
	 * for some features, such as indicating support post thumbnails.
	 */
	function myfirsttheme_setup() {

		/**
		 * Make theme available for translation.
		 * Translations can be placed in the /languages/ directory.
		 */
		load_theme_textdomain( 'my-second-theme', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to <head>.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for post thumbnails and featured images.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add support for two custom navigation menus.
		 */
		register_nav_menus( array(
			'primary'   => __( 'Primary Menu', 'myfirsttheme' ),
			'secondary' => __( 'Secondary Menu', 'myfirsttheme' ),
		) );

		/**
		 * Enable support for the following post formats:
		 * aside, gallery, quote, image, and video
		 */
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'image', 'video', 'musician' ) );
	}
endif; // myfirsttheme_setup
add_action( 'after_setup_theme', 'myfirsttheme_setup' );



/**
 * Load translations for wpdocs_theme
 */
//function wpdocs_theme_setup(){
//    load_theme_textdomain('wpdocs_theme', get_template_directory() . '/languages');
//}
//function musician_role_template( $templates = '' ) {
//	$musician = get_queried_object();
//	$role   = $musician->roles[0];
//
//	if ( ! is_array( $templates ) && ! empty( $templates ) ) {
//		$templates = locate_template( array( "musician-$role.php", $templates ), false );
//	} elseif ( empty( $templates ) ) {
//		$templates = locate_template( "musician-$role.php", false );
//	} else {
//		$new_template = locate_template( array( "musician-$role.php" ) );
//
//		if ( ! empty( $new_template ) ) {
//			array_unshift( $templates, $new_template );
//		}
//	}
//	return $templates;
//}
//add_filter( 'musician_template', 'musician_role_template' );
//add_action( 'widgets_init', 'my_register_sidebars' );
//function my_register_sidebars() {
//	/* Register the 'primary' sidebar. */
//	register_sidebar(
//		array(
//			'id'            => 'primary',
//			'name'          => __( 'Primary Sidebar' ),
//			'description'   => __( 'A short description of the sidebar.' ),
//			'before_widget' => '<div id="%1$s" class="widget %2$s">',
//			'after_widget'  => '</div>',
//			'before_title'  => '<h3 class="widget-title">',
//			'after_title'   => '</h3>',
//		)
//	);
//	/* Repeat register_sidebar() code for additional sidebars. */
//}
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting, so let it fall
        // through to the standard PHP error handler
        return false;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<p class=\"someerror\"><b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n</p>";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<p class=\"someerror\"><b>My WARNING</b> [$errno] $errstr<br /></p>\n";
        break;

    case E_USER_NOTICE:
        echo "<p class=\"someerror\"><b>My NOTICE</b> [$errno] $errstr<br /></p>\n";
        break;

    default:
        echo "<p class=\"someerror\">Unknown error type: [$errno] $errstr<br /></p>\n";
        echo "  <p class=\"someerror\">Fatal error on line $errline in file $errfile</p>";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

// function to test the error handling
function scale_by_log($vect, $scale)
{
    if (!is_numeric($scale) || $scale <= 0) {
        trigger_error("log(x) for x <= 0 is undefined, you used: scale = $scale", E_USER_ERROR);
    }

    if (!is_array($vect)) {
        trigger_error("Incorrect input vector, array of values expected", E_USER_WARNING);
        return null;
    }

    $temp = array();
    foreach($vect as $pos => $value) {
        if (!is_numeric($value)) {
            trigger_error("Value at position $pos is not a number, using 0 (zero)", E_USER_NOTICE);
            $value = 0;
        }
        $temp[$pos] = log($scale) * $value;
    }

    return $temp;
}

// set to the user defined error handler
$old_error_handler = set_error_handler("myErrorHandler");


/**
 * Register the new widget.
 *
 * @see 'widgets_init'
 */
function wpdocs_register_widgets() {
        register_widget( 'WPDocs_New_Widget' );
        register_widget( 'WPDocs_IG_Widget' );
}


add_action('customize_register','my_customize_register');
add_action('customize_register','other_customize_register');
function other_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'my_important_information', array(
  'title' => __( 'Mes informations à afficher' ),
  //'description' => __( 'Add custom CSS here' ),
  'description' => __( 'ici actualise tes informations à afficher sur la page d accueil et dans le bas de la page' ),
  'panel' => '', // Not typically needed.
  'priority' => 200,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
) );
  $wp_customize->add_section( 'my_media', array(
  'title' => __( 'Personnaliser la Home Page' ),
  //'description' => __( 'Add custom CSS here' ),
  'description' => __( 'préfére une grande image de la ville de nuit' ),
  'panel' => '', // Not typically needed.
  'priority' => 200,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
) );
  $wp_customize->add_setting( 'header_image_description_size', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_description_size', array(
	  'type' => 'range',
  'label' => __( 'taille de la description de l image de page d accueil', 'my-second-theme' ),
    'input_attrs' => array(
    'min' => 14,
    'max' => 60,
    'step' => 2,
  ),

  'section' => 'my_media',
) ) );
    $wp_customize->add_setting( 'header_image_title_color', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
  'default' => '#000',
  'sanitize_callback' => 'sanitize_hex_color',
) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_image_title_color', array(
  'default' => '#000',
  'label' => __( 'couleur du texte dans l image de page d accueil', 'my-second-theme' ),
  'section' => 'my_media',
) ) );

  $wp_customize->add_setting( 'header_image_title_size', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_title_size', array(
	  'type' => 'range',
  'label' => __( 'taille du titre de l image de page d accueil', 'my-second-theme' ),
    'input_attrs' => array(
    'min' => 20,
    'max' => 80,
    'step' => 2,
  ),

  'section' => 'my_media',
) ) );
  $wp_customize->add_setting( 'header_image_top', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_top', array(
	  'type' => 'number',
  'label' => __( 'a quelle distance veux tu ecrire le texte du haut de l image', 'my-second-theme' ),
    'input_attrs' => array(
    'min' => 20,
    'max' => 200,
    'step' => 2,
  ),

  'section' => 'my_media',
) ) );
  $wp_customize->add_setting( 'header_image_title', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_title', array(
	  'type' => 'text',
  'label' => __( 'quel titre veux tu écrire dans l image', 'my-second-theme' ),
  'default' => 'Welcome to my site !',

  'settings' => 'header_image_title',
  'section' => 'my_media',
) ) );
  $wp_customize->add_setting( 'header_image_description', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_title', array(
	  'type' => 'text',
  'label' => __( 'quel titre veux tu écrire dans l image', 'my-second-theme' ),
  'default' => 'Welcome to my site !',

  'settings' => 'header_image_title',
  'section' => 'my_media',
) ) );
  $wp_customize->add_setting( 'header_image_description', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_description', array(
	  'type' => 'text',
  'label' => __( 'quel texte veux tu écrire dans l image', 'my-second-theme' ),
  'default' => 'This is my little home away from home.',

  'settings' => 'header_image_description',
  'section' => 'my_media',
  'width' => '300', 'height' => '300',
) ) );
  $wp_customize->add_setting( 'image_control', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'image_control', array(
  'label' => __( 'Featured Home Page Image Image de la ville /image de héros', 'my-second-theme' ),

  'settings' => 'image_control',
  'section' => 'my_media',
  'width' => '300', 'height' => '300',
  //'mime_type' => 'image',
) ) );
  $wp_customize->add_setting( 'custom_media_css', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( 'custom_media_css', array(
  'label' => __( 'Custom Media CSS', "my-second-theme" ),
  'type' => 'textarea',
  'section' => 'my_media',
) );
}
function my_customize_register( $wp_customize ) {
  //$wp_customize->add_panel("hey");
  //$wp_customize->get_panel("hey");
  //$wp_customize->remove_panel();

  //$wp_customize->add_section("yes");
  //$wp_customize->get_section();
  //$wp_customize->remove_section();

  //$wp_customize->add_setting();
  //$wp_customize->get_setting();
  //$wp_customize->remove_setting();
  $wp_customize->add_setting( 'setting_id', array(
  'type' => 'theme_mod', // or 'option'
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
  'default' => '',
  'transport' => 'refresh', // or postMessage
  'sanitize_callback' => '',
  'sanitize_js_callback' => '', // Basically to_json.
) );
  $wp_customize->add_setting( 'background_color_block_text', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
  'default' => '#000',
  'sanitize_callback' => 'sanitize_hex_color',
) );
  $wp_customize->add_setting( 'color_block_text', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
  'default' => '#fff',
  'sanitize_callback' => 'sanitize_hex_color',
) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_block_text', array(
  'default' => '#000',
  'label' => __( 'couleur du texte dans les  blocks de  texte', 'my-second-theme' ),
  'section' => 'colors',
) ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color_block_text', array(
  'default' => '#000',
  'label' => __( 'couleur du fond des blocks text', 'my-second-theme' ),
  'section' => 'colors',
) ) );
  $wp_customize->add_setting( 'accent_color', array(
  'default' => '#f72525',
  'sanitize_callback' => 'sanitize_hex_color',
) );
  $wp_customize->add_setting( 'myplugin_options[color]', array(
  'type' => 'option',
  'capability' => 'manage_options',
  'default' => '#ff2525',
  'sanitize_callback' => 'sanitize_hex_color',
) );
  $wp_customize->add_setting( 'date_prochain_evenement', array(
  'type' => 'theme_mod',
  'capability' => 'manage_options',
) );
  $wp_customize->add_control( 'date_prochain_evenement', array(
  'type' => 'date',
  'priority' => 10, // Within the section.
  'section' => 'my_important_information', // Required, core or custom.
  'label' => __( 'Date de mon prochain évènement/concert' ),
  //'description' => __( 'This is a date control with a red border.' ),
  'input_attrs' => array(
    'class' => 'my-custom-class-for-js',
    'style' => 'border: 1px solid #900',
    'placeholder' => __( 'mm/dd/yyyy' ),
  ),
  'active_callback' => 'is_front_page',
) );

  $wp_customize->add_control( 'custom_theme_css', array(
  'label' => __( 'Custom Theme CSS', "my-second-theme" ),
  'type' => 'textarea',
  'section' => 'custom_css',
) );
  $wp_customize->add_setting( 'taille_du_titre', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
) );
  $wp_customize->add_control( 'taille_du_titre', array(
  'type' => 'number',
  'section' => 'title_tagline',
  'label' => __( 'Taille du titre' ),
  //'description' => __( 'This is the range control description.' ),
  'input_attrs' => array(
    'min' => 20,
    'max' => 60,
    'step' => 2,
  ),
) );
  $wp_customize->add_setting( 'couleur_du_titre', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
  'default' => '#000',
  'sanitize_callback' => 'sanitize_hex_color',
) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'couleur_du_titre', array(
  'label' => __( 'Couleur du titre', 'my-second-theme' ),
  'section' => 'colors',
) ) );

  $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'audio_control', array(
  'label' => __( 'Featured Home Page Recording', 'my-second-theme' ),
  'section' => 'media',
  'mime_type' => 'audio',
) ) );

  $wp_customize->add_section( 'custom_css', array(
  'title' => __( 'Awesome Custom CSS' ),
  //'description' => __( 'Add custom CSS here' ),
  'panel' => '', // Not typically needed.
  'priority' => 160,
  'capability' => 'edit_theme_options',
  'theme_supports' => '', // Rarely needed.
) );
  // Add a footer/copyright information section.
  $wp_customize->add_section( 'footer' , array(
    'title' => __( 'Footer', 'my-second-theme' ),
    'priority' => 105, // Before Widgets.
  ) );
  $wp_customize->add_panel( 'menus', array(
    'title' => __( 'Awesome Menus' ),
    //'description' => $description, // Include html tags such as <p>.
    'priority' => 160, // Mixed with top-level-section hierarchy.
  ) );
  $wp_customize->add_panel( 'my_menus', array(
    'title' => __( 'Awesome Media' ),
    //'description' => $description, // Include html tags such as <p>.
    'priority' => 180, // Mixed with top-level-section hierarchy.
  ) );
  $wp_customize->add_panel( 'panel_id', array(
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'theme_supports' => 'my-second-theme',
    'title'          => __('awesome title'),
    'description'    => 'wow',
) );
  $section_id=1;
  $section_id="hello";
  $wp_customize->add_section( $section_id , array(
  'title' => "haha",//$menu->name,
  'panel' => 'menus',
) );

  //$wp_customize->add_control();
  //$wp_customize->get_control();
  //$wp_customize->remove_control();
  $nav_menu_setting_id="yoohoo";
  $nav_menu_setting_id=1;
  $item_ids=[1,2];
//  $wp_customize->add_setting( $nav_menu_setting_id, array(
//  'type' => 'nav_menu',
//  'default' => $item_ids,
//) );
  $wp_customize->add_setting( 'couleur_des_liens', array(
   // or 'option'
  'type' => 'theme_mod',
  'capability' => 'edit_theme_options',
  'default' => '#000',
  'sanitize_callback' => 'sanitize_hex_color',
) );
  $wp_customize->add_control(
  new WP_Customize_Image_Control(
    $wp_customize, // WP_Customize_Manager
    'image_de_hero', // Setting id
    array( // Args, including any custom ones.
      'label' => __( 'Image de la ville ' ),
      'section' => 'media',
    )
  )
);
  $wp_customize->add_control(
  new WP_Customize_Color_Control(
    $wp_customize, // WP_Customize_Manager
    'couleur_des_liens', // Setting id
    array( // Args, including any custom ones.
      'label' => __( 'Couleur des liens ' ),
      'section' => 'colors',
    )
  )
);
}
function my_custom_css_output() {
  echo '<style type="text/css" id="custom-theme-css">' .
  get_theme_mod( 'custom_theme_css', '' ) . '</style>';
  echo '<style type="text/css" id="custom-plugin-css">' .
  get_option( 'custom_plugin_css', '' ) . '</style>';
}
add_action( 'wp_head', 'my_custom_css_output');

function menu_customizer_update_nav_menu( $value, $setting ) {
  $menu_id = str_replace( 'nav_menu_', '', $setting->id );
  // ...
  $i = 0;
  foreach( $value as $item_id ) { // $value is ordered array of item ids.
    menu_customizer_update_menu_item_order( $menu_id, $item_id, $i );
  $i++;
  }
}
add_action( 'customize_update_nav_menu', 'menu_customizer_update_nav_menu', 10, 2 );
function menu_customizer_preview_nav_menu( $setting ) {
  $menu_id = str_replace( 'nav_menu_', '', $setting->id );
  add_filter( 'wp_get_nav_menu_items', function( $items, $menu, $args ) use ( $menu_id, $setting ) {
    $preview_menu_id = $menu->term_id;
    if ( $menu_id == $preview_menu_id ) {
      $new_ids = $setting->post_value();
      foreach ( $new_ids as $item_id ) {
        $item = wp_setup_nav_menu_item( $item );
        $item->menu_order = $i;
        $new_items[] = $item;
        $i++;
      }
      return $new_items;
    } else {
      return $items;
    }
  }, 10, 3 );
}
add_action( 'customize_preview_nav_menu', 'menu_customizer_preview_nav_menu', 10, 2 );
add_filter('the_content', 'wp_add_something_to_content');
function wp_add_something_to_content ($content) {
	$add_content="<p>hello ! how are you doing ? content of the article just right here :</p>";
	$somecontent = $add_content . $content;
	return $somecontent;
}
add_filter('get_the_excerpt', 'wp_add_something_to_excerpt');
function wp_add_something_to_excerpt ($content) {
	$add_content="<p>in a few words :</p>";
	$content = $add_content . $content;
	return $content;
}
function allow_users_who_can_edit_posts_to_customize( $caps, $cap, $user_id ) {
	$required_cap = 'edit_posts';
	if ( 'customize' === $cap && user_can( $user_id, $required_cap ) ) {
		$caps = array( $required_cap );
	}
	return $caps;
}
add_filter( 'map_meta_cap', 'allow_users_who_can_edit_posts_to_customize', 10, 3 );
/**
 * Adds a privacy policy statement.
 */
function wporg_add_privacy_policy_content() {
	if ( ! function_exists( 'wp_add_privacy_policy_content' ) ) {
		return;
	}
	$content = '<p class="privacy-policy-tutorial">' . __( 'Some introductory content for the suggested text.', 'text-domain' ) . '</p>'
			. '<strong class="privacy-policy-tutorial">' . __( 'Suggested Text:', 'my_plugin_textdomain' ) . '</strong> '
			. sprintf(
				__( 'When you leave a comment on this site, we send your name, email address, IP address and comment text to example.com. Example.com does not retain your personal data. The example.com privacy policy is <a href="%1$s" target="_blank">here</a>.', 'text-domain' ),
				'https://example.com/privacy-policy'
			);
	wp_add_privacy_policy_content( 'Example Plugin', wp_kses_post( wpautop( $content, false ) ) );
}

add_action( 'admin_init', 'wporg_add_privacy_policy_content' );
