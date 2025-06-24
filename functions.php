<?php
/**
 * Esparta digital functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Esparta_digital
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function espartadigital_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Esparta digital, use a find and replace
		* to change 'espartadigital' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'espartadigital', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'espartadigital' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'espartadigital_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'espartadigital_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function espartadigital_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'espartadigital_content_width', 640 );
}
add_action( 'after_setup_theme', 'espartadigital_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function espartadigital_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'espartadigital' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'espartadigital' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'espartadigital_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function espartadigital_scripts() {
	wp_enqueue_style( 'espartadigital-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'espartadigital-style', 'rtl', 'replace' );

	wp_enqueue_script( 'espartadigital-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'espartadigital_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Limpieza de elementos HEAD
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');

// Desactiva emojis completamente
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

// Cargar bootstrap internamente
function espartadigital_enqueue_assets() {
    wp_enqueue_style(
        'bootstrap-css',
        get_template_directory_uri() . '/css/bootstrap.min.css',
        array(),
        '5.3.7'
    );

    wp_enqueue_script(
        'bootstrap-js',
        get_template_directory_uri() . '/js/bootstrap.bundle.min.js',
        array('jquery'), 
        '5.3.7',
        true
    );
}
add_action('wp_enqueue_scripts', 'espartadigital_enqueue_assets');


/**
 * Panel de administración para insertar scripts en HEAD, BODY y FOOTER
 */

// Crear el menú en el admin
function espartadigital_add_backend() {
    add_menu_page(
        'Inserción script',
        'Inserción script',
        'manage_options',
        'esparta_script',
        'front_esparta_script',
        'dashicons-editor-code',
        80
    );
}
add_action('admin_menu', 'espartadigital_add_backend');

// Mostrar formulario
function front_esparta_script() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Guardar datos si se envía el formulario y nonce válido
    if (
        isset($_POST['esparta_script_nonce']) &&
        wp_verify_nonce($_POST['esparta_script_nonce'], 'esparta_script_save')
    ) {
        if (isset($_POST["script_head_options"])) {
            update_option('script_espartadigital_head', wp_unslash($_POST["script_head_options"]));
        }
        if (isset($_POST["script_body_options"])) {
            update_option('script_espartadigital_body', wp_unslash($_POST["script_body_options"]));
        }
        if (isset($_POST["script_footer_options"])) {
            update_option('script_espartadigital_footer', wp_unslash($_POST["script_footer_options"]));
        }
        echo '<div class="updated"><p>Scripts guardados correctamente.</p></div>';
    }

    // Formulario de inserción
    ?>
    <div class="wrap">
        <h1>Inserción de Scripts</h1>
        <form method="post" action="">
            <?php wp_nonce_field('esparta_script_save', 'esparta_script_nonce'); ?>

            <h3>HEAD</h3>
            <textarea name="script_head_options" style="width: 100%; height: 200px;"><?php echo esc_textarea(get_option('script_espartadigital_head', '')); ?></textarea>

            <h3>BODY</h3>
            <textarea name="script_body_options" style="width: 100%; height: 200px;"><?php echo esc_textarea(get_option('script_espartadigital_body', '')); ?></textarea>

            <h3>FOOTER</h3>
            <textarea name="script_footer_options" style="width: 100%; height: 200px;"><?php echo esc_textarea(get_option('script_espartadigital_footer', '')); ?></textarea>

            <p><input type="submit" class="button-primary" value="Guardar cambios"></p>
        </form>
    </div>
    <?php
}

// Inyección en <head>
function add_espartadigital_head() {
    $script = get_option('script_espartadigital_head', '');
    if (!empty($script)) {
        echo "\n<!-- Script HEAD -->\n" . $script . "\n<!-- /Script HEAD -->\n";
    }
}
add_action('wp_head', 'add_espartadigital_head');

// Inyección en <body>
function add_espartadigital_body() {
    $script = get_option('script_espartadigital_body', '');
    if (!empty($script)) {
        echo "\n<!-- Script BODY -->\n" . $script . "\n<!-- /Script BODY -->\n";
    }
}
add_action('wp_body_open', 'add_espartadigital_body');

// Inyección en footer
function add_espartadigital_footer() {
    $script = get_option('script_espartadigital_footer', '');
    if (!empty($script)) {
        echo "\n<!-- Script FOOTER -->\n" . $script . "\n<!-- /Script FOOTER -->\n";
    }
}
add_action('wp_footer', 'add_espartadigital_footer');