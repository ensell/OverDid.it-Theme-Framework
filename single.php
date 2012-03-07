<?php
/**
 * Default Single Post Display Template
 * @package Wordpress
 * @since 1.0.0
 **/

get_header();
$meta = overdid_get_meta($post->ID);
$columns = new overdid_column($meta);
?>
<div id="main" class="alignright three-quarters">

</div>
<?php
get_sidebar();
get_footer();