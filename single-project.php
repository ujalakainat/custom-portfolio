<?php get_header(); ?>
<div class="single-wrapper">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="single-project">
      <h1><?php the_title(); ?></h1>

      <p><strong>Project Name:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_project_name', true)); ?></p>

      <p><strong>Description:</strong><br><?php echo wp_kses_post(nl2br(get_post_meta(get_the_ID(), '_project_description', true))); ?></p>

      <p><strong>Start Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_project_start_date', true)); ?></p>

      <p><strong>End Date:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), '_project_end_date', true)); ?></p>

      <p><strong>Project URL:</strong> 
        <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_project_url', true)); ?>" target="_blank" rel="noopener">Visit Project</a>
      </p>

      <div class="project-main-content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
