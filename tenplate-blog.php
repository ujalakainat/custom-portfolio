<?php
/* Template Name: Blog */
get_header(); ?>
<main>
<h1>This is Blog Page Template</h1>

<?php
$query = new WP_Query([
  'post_type' => 'post',
  'posts_per_page' => 5,
]);

if ($query->have_posts()) :
  while ($query->have_posts()) : $query->the_post();
    the_title('<h2>', '</h2>');
    the_excerpt();
  endwhile;
endif;
wp_reset_postdata();
?>
</main>
<?php get_footer(); ?>