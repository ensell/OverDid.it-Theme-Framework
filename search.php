<?php
/**
 * Default Search Display Template
 * @package Wordpress
 * @since 1.0.0
 **/

get_header();
$meta = overdid_get_meta($post->ID);
$columns = new overdid_column($meta);
?>
		<div id="main" class="alignright three-quarters">
		<?php if (have_posts()) :
            $term = (isset($_GET['s'])) ? $_GET['s'] : 'No Terms Selected'; ?>
            
            <span class="page-title">
                <?php
                printf(
                	'Search Results For: <span>%s</span>',
                    $term
                ); ?></span>
                
       		<?php while ( have_posts() ) : the_post(); ?>
       		
       		
       		<?php endwhile; ?>
       		
			<div id="post-0" class="post no-results not-found">
				<h2 class="entry-title">'Nothing Found</h2>
				<div class="entry-content">
                    <p>
                        Sorry, but nothing matched your search criteria.
                        Please try again with some different keywords.
                    </p>
					<?php get_search_form(); ?>

				</div>

			</div>

		<?php endif; ?>

		</div>

<?php
get_sidebar();
get_footer();