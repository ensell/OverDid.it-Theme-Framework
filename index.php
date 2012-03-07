<?php
/**
 * Default Post Display Template
 * @package Wordpress
 * @since 1.0.0
 **/

get_header();
$meta = overdid_get_meta($post->ID);
$columns = new overdid_column($meta);
?>
<div id="main" class="alignright three-quarters">
	<?php the_post(); the_content(); ?>
</div>
<?php
get_sidebar();
get_footer();