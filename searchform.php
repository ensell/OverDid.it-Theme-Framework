<?php
/**
 * Default Search Display Template
 * @version 2.0
 * @package Wordpress
 **/
?>
<form method="get" id="searchform" action="<?php echo home_url(); ?>" >
    <input type="text" value="<?php
        echo esc_attr(
            apply_filters(
            	'the_search_query',
                get_search_query()
            )
        ) ?>" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="Search" />
</form>
