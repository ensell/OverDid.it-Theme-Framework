<?php
/**
 * Default Sidebar Display Template
 * @package Wordpress
 * @since 1.0.0
 **/
?>
<div id="sidebar" class="quarter gutter alignleft">
    <ul>
        <?php 	/* Widgetized sidebar */
        if (
            !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar')
        ) : ?>
            <li class="widget_search widget">
                <?php get_search_form(); ?>

            </li>

            <?php wp_list_pages('title_li=<h3>Pages</h3>'); ?>

            <li class="widget widget-archives">
                <h3>Archives</h3>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>

                </ul>

            </li>

            <?php
            wp_list_categories('show_count=1&title_li=<h3>Categories</h3>');
            ?>
            <li class="widget widget-meta">
                <h3>Meta</h3>
                <ul>
                    <?php wp_register(); ?>

                    <li><?php wp_loginout(); ?></li>

                    <?php wp_meta(); ?>

                </ul>

            </li>

        <?php endif; ?>

    </ul>

</div>