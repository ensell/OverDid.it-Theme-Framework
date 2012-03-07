<?php
/**
 * Default Page Display Template
 * @package Wordpress
 * @since 1.0.0
 **/

get_header();
$meta = overdid_get_meta($post->ID);
$columns = new overdid_column($meta);
?>
<div id="main" class="alignright three-quarters">
    <?php
    /* Run the loop to output the posts.
     * If you want to overload this in a child theme then include a file
     * called loop-page.php and that will be used instead.
    */
    get_template_part('loop', 'page');
    ?>
</div>
<?php
get_sidebar();
get_footer();
