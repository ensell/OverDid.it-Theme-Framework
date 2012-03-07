<?php
/**
 * admin-style.php
 *
 * Add styling to the Admin Area of WordPress
 *
 * @package WordPress
 * @since 1.0.0
 **/


/**
 * Replace header elements
 *
 * Use admin_head filter to replace the content
 *
 * @since 1.0.0
 *
 */
function overdid_admin_header()
{

	echo "\n<!-- Admin Header Additions -->\n";

	// Load alternate style sheet
    echo "<link rel='stylesheet' type='text/css' href='" .
        get_bloginfo('template_url') . "/includes/css/admin.css' />\n";

	// favicon
	echo '<link rel="icon" href="' . get_option('overdid-favicon') .
		'" type="image/x-icon">';

	echo "<!-- End Admin Header Additions-->\n\n";

}
add_action('admin_head', 'overdid_admin_header');
