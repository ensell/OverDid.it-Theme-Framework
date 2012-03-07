<?php
/**
 * 404 Error Display Template
 *
 * @package Wordpress
 * @since 1.0.0
 **/

get_header();
$meta = overdid_get_meta($post->ID);
$columns = new overdid_column($meta);
?>
<div id="main">
	<h2>Error 404 - Not Found</h2>

</div>
<?php
get_sidebar();
get_footer();