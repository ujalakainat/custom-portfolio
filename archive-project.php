<?php 
get_header(); 

// Define start and end values
$start = isset($_GET['start_date']) ? trim($_GET['start_date']) : '';
$end = isset($_GET['end_date']) ? trim($_GET['end_date']) : '';

// Prepare query arguments
$args = [
  'post_type' => 'project',
  'posts_per_page' => -1,
  'post_status' => 'publish'
];

// Add filtering if start or end date is provided
if ($start || $end) {
  $args['meta_query'] = [
    'relation' => 'AND',
    [
      'key' => '_project_start_date',
      'value' => $start,
      'compare' => '>=',
      'type' => 'DATE',
    ],
    [
      'key' => '_project_end_date',
      'value' => $end,
      'compare' => '<=',
      'type' => 'DATE',
    ],
  ];
}

// Run the custom query
$projects_query = new WP_Query($args);
?>


<div class="archive-wrapper">
  <h1 class="archive-title">Our Projects</h1>

  <form method="get" class="filter-form">
    <input type="date" name="start_date" value="<?php echo esc_attr($start); ?>">
    <input type="date" name="end_date" value="<?php echo esc_attr($end); ?>">
    <input type="submit" value="Filter Projects">
    <?php if ($start || $end): ?>
      <a href="<?php echo get_post_type_archive_link('project'); ?>" class="clear-button">Clear Filter</a>
    <?php endif; ?>
  </form>

  <div class="projects-grid">
    <?php if ($projects_query->have_posts()) : while ($projects_query->have_posts()) : $projects_query->the_post(); ?>
      <div class="project-card">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p><strong>Client:</strong> <span class="badge"><?php echo esc_html(get_post_meta(get_the_ID(), '_project_name', true)); ?></span></p>
        <p><strong>Start Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_project_start_date', true)); ?></p>
        <p><strong>End Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_project_end_date', true)); ?></p>
        <p><strong>URL:</strong> <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_project_url', true)); ?>" target="_blank">View Project</a></p>
      </div>
    <?php endwhile; else : ?>
      <p>No projects found.</p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</div>

<?php get_footer(); ?>
