<?php
/**
 * Archive Display Template
 * @package Wordpress
 * @since 1.0.0
 **/

get_header();
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

	/* Run the loop for the archives page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-archives.php and that will be used instead.
	*/
	get_template_part('loop', 'archive');?>

</div>

<?php
get_sidebar();
get_footer();
