<?php
/**
 * Theme Functions
 */

// Theme Setup
function custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
  register_nav_menus(array(
    'primary' => __('Primary Menu'),
  ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Enqueue Styles and Scripts
function custom_theme_scripts() {
    wp_enqueue_style('main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');

// Register Custom Post Type: Projects
function create_custom_post_type_projects() {
    register_post_type('project', [
        'labels' => [
            'name' => 'Projects',
            'singular_name' => 'Project'
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'create_custom_post_type_projects');

// Add Custom Meta Boxes
function add_project_meta_boxes() {
    add_meta_box('project_details', 'Project Details', 'project_meta_callback', 'project', 'normal', 'default');
}
add_action('add_meta_boxes', 'add_project_meta_boxes');

// Display Custom Meta Fields in Meta Box
function project_meta_callback($post) {
    $name = get_post_meta($post->ID, '_project_name', true);
    $description = get_post_meta($post->ID, '_project_description', true);
    $start_date = get_post_meta($post->ID, '_project_start_date', true);
    $end_date = get_post_meta($post->ID, '_project_end_date', true);
    $url = get_post_meta($post->ID, '_project_url', true);
    ?>
    <p>
        <label>Project Name:</label><br>
        <input type="text" name="project_name" value="<?php echo esc_attr($name); ?>">
    </p>
    <p>
        <label>Project Description:</label><br>
        <textarea name="project_description" rows="4" cols="50"><?php echo esc_textarea($description); ?></textarea>
    </p>
    <p>
        <label>Start Date:</label><br>
        <input type="date" name="project_start_date" value="<?php echo esc_attr($start_date); ?>">
    </p>
    <p>
        <label>End Date:</label><br>
        <input type="date" name="project_end_date" value="<?php echo esc_attr($end_date); ?>">
    </p>
    <p>
        <label>Project URL:</label><br>
        <input type="url" name="project_url" value="<?php echo esc_attr($url); ?>">
    </p>
    <?php
}

// Save Meta Box Data
function save_project_meta_data($post_id) {
    if (array_key_exists('project_name', $_POST)) {
        update_post_meta($post_id, '_project_name', sanitize_text_field($_POST['project_name']));
    }
    if (array_key_exists('project_description', $_POST)) {
        update_post_meta($post_id, '_project_description', sanitize_textarea_field($_POST['project_description']));
    }
    if (array_key_exists('project_start_date', $_POST)) {
        update_post_meta($post_id, '_project_start_date', sanitize_text_field($_POST['project_start_date']));
    }
    if (array_key_exists('project_end_date', $_POST)) {
        update_post_meta($post_id, '_project_end_date', sanitize_text_field($_POST['project_end_date']));
    }
    if (array_key_exists('project_url', $_POST)) {
        update_post_meta($post_id, '_project_url', esc_url_raw($_POST['project_url']));
    }
}
add_action('save_post', 'save_project_meta_data');

// Custom REST API Endpoint
function register_custom_project_api() {
    register_rest_route('custom/v1', '/projects', [
        'methods' => 'GET',
        'callback' => 'custom_get_projects',
    ]);
}
add_action('rest_api_init', 'register_custom_project_api');

function custom_get_projects() {
    $args = [
        'post_type' => 'project',
        'posts_per_page' => -1,
    ];
    $query = new WP_Query($args);
    $projects = [];
    while ($query->have_posts()) {
        $query->the_post();
        $projects[] = [
            'title' => get_the_title(),
            'name' => get_post_meta(get_the_ID(), '_project_name', true),
            'description' => get_post_meta(get_the_ID(), '_project_description', true),
            'url' => get_post_meta(get_the_ID(), '_project_url', true),
            'start_date' => get_post_meta(get_the_ID(), '_project_start_date', true),
            'end_date' => get_post_meta(get_the_ID(), '_project_end_date', true),
        ];
    }
    wp_reset_postdata();
    return $projects;
}



function register_projects_api_endpoint() {
  register_rest_route('custom/v1', '/projects', array(
    'methods'  => 'GET',
    'callback' => 'get_custom_projects_data',
    'permission_callback' => '__return_true' // Public access
  ));
}
add_action('rest_api_init', 'register_projects_api_endpoint');

function get_custom_projects_data() {
  $args = array(
    'post_type'      => 'projects',
    'posts_per_page' => -1,
  );

  $query = new WP_Query($args);
  $projects = array();

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $projects[] = array(
        'title'        => get_the_title(),
        'project_url'  => get_post_meta(get_the_ID(), '_project_url', true),
        'start_date'   => get_post_meta(get_the_ID(), '_project_start_date', true),
        'end_date'     => get_post_meta(get_the_ID(), '_project_end_date', true),
      );
    }
    wp_reset_postdata();
  }

  return rest_ensure_response($projects);
}
