<?php
/**
 * Archive Display Template
 * @package Wordpress
 * @since 1.0.0
 **/

get_header();
$meta = overdid_get_meta($post->ID);
$columns = new overdid_column($meta);
?>

<div id="main" class="alignright three-quarters">
    <?php the_post(); ?>

    <?php if (is_day()) : ?>
        <span class="page-title"><?php printf(
    'Daily Archives: <span>%s</span>',
    get_the_date()
); ?></span>
    <?php elseif (is_month()) : ?>
        <span class="page-title"><?php printf(
    'Monthly Archives: <span>%s</span>',
    get_the_date('F Y')
); ?></span>
    <?php elseif (is_year()) : ?>
        <span class="page-title"><?php printf(
    'Yearly Archives: <span>%s</span>',
    get_the_date('Y')
); ?></span>
    <?php else :
        single_cat_title('<span class="page-title">Archive for ');
        echo "</span>";
    endif;

	rewind_posts();

	while ( have_posts() ) : the_post(); ?>


	<?php endwhile; ?>
</div>

<?php
get_sidebar();
get_footer();