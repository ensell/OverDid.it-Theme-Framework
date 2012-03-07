<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * @package WordPress
 * @since 1.0.0
 */

/* If there are no posts to display, such as an empty archive page */
if (!have_posts()) : ?>
	<div id="post-0" class="post error404 not-found">
		<h2 class="entry-title">Not Found</h2>
		<div class="entry-content">
			<p>
				Apologies, but no results were found for the requested archive.
			</p>

		</div>

	</div>

<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 */ ?>
<?php while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php /* How to display posts in a specific category. */ ?>

	<?php if (in_category('category')) : ?>
		<div class="entry-content">
			<div class="wide-title">
                <h2>
                    <a href='<?php the_permalink();?>'
                    	title='<?php the_title_attribute();?>'>
                        <?php the_title();?>
                    </a>
                </h2>
                <?php
                comments_popup_link(
                    '0 comments',
                    '1 comment',
                    '% comments',
                    'comment-count',
                    'comments are closed'
                );
                ?>

				<span class='post-author'>
                    <?php the_author();?> -
                    <?php $title = the_title_attribute('echo=0');
                    $title = trim($title);
                    if ($title == "") : ?>
                        <a href='<?php the_permalink();?>'>Posted:</a>
                    <?php else : ?>
                        Posted:
                    <?php endif;?>
                </span>


			</div>

			<div class='content-area'>
				<?php the_excerpt(); ?>

			</div>

        </div>

	<?php elseif (is_archive() || is_search()) : ?>
		<div class="entry-content">
			<div class="wide-title">
                <h2>
                    <a href='<?php the_permalink();?>'
                    	title='<?php the_title_attribute();?>'>
                        <?php the_title();?>
                    </a>
                </h2>
                <?php
                comments_popup_link(
                    '0 comments',
                    '1 comment',
                    '% comments',
                    'comment-count',
                    'comments are closed'
                );
                ?>

                <span class='post-author'>
                    <?php the_author();?> -
                    <?php $title = the_title_attribute('echo=0');
                    $title = trim($title);
                    if ($title == "") : ?>
                        <a href='<?php the_permalink();?>'>Posted:</a>
                    <?php else : ?>
                        Posted:
                    <?php endif;?>
                </span>


			</div>

			<div class='content-area'>
				<?php the_excerpt(); ?>

			</div>

		</div>

	<?php elseif (is_page()) :  ?>
		<div class="entry-content">
            <?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>


		</div>

	<?php elseif (is_single()) : ?>
		<div class="entry-content">
			<div class="wide-title">
                <h2>
                    <a href='<?php the_permalink();?>'
                    	title='<?php the_title_attribute();?>'>
                        <?php the_title();?>
                    </a>
                </h2>
                <?php
                comments_popup_link(
                    '0 comments',
                    '1 comment',
                    '% comments',
                    'comment-count',
                    'comments are closed'
                );
                ?>

				<span class='post-author'><?php the_author();?> - Posted:</span>


			</div>

			<div class='content-area'>
                <?php the_content('... (Read More)'); ?>
                <div class='page-links'>
                    <?php wp_link_pages(); ?>
                </div>

			</div>

        </div>

	<?php else : ?>
		<div class="entry-content">
			<div class="wide-title">
                <h2>
                    <a href='<?php the_permalink();?>'
                    	title='<?php the_title_attribute();?>'>
                        <?php the_title();?>
                    </a>
                </h2>
                <?php
                comments_popup_link(
                    '0 comments',
                    '1 comment',
                    '% comments',
                    'comment-count',
                    'comments are closed'
                );
                ?>

				<span class='post-author'>
                    <?php the_author();?> -
                    <?php $title = the_title_attribute('echo=0');
                    $title = trim($title);
                    if ($title == "") : ?>
                        <a href='<?php the_permalink();?>'>Posted:</a>
                    <?php else : ?>
                        Posted:
                    <?php endif;?>
                </span>


			</div>

			<div class='content-area'>
				<?php the_excerpt(); ?>

			</div>

		</div>

	<?php endif; ?>

	</div>

<?php endwhile; ?>
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ($wp_query->max_num_pages > 1) : ?>
    <div id="nav-below" class="navigation">
        <span class="nav-previous">
            <?php
            next_posts_link(
            	'Older posts <span class="meta-nav">&raquo;</span>'
            ); ?>
        </span>
        <span class="nav-next">
            <?php
            previous_posts_link(
            	'<span class="meta-nav">&laquo;</span> Newer posts'
            ); ?>
        </span>

    </div>

<?php endif; ?>

<div id="comment-block">
	<?php
	if (!is_page())
		comments_template(); ?>

</div>
