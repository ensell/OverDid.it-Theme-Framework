<?php
/**
 * The template used to display Comments
 *
 * This is the standard comment form found in the Twenty Ten Theme
 *
 * @package Wordpress
 * @since 1.0.0
 */
?>

<div id="comments">
<?php
    if (post_password_required()) : ?>
    <div class="nopassword"><?php _e(
	'This post is password protected. Enter the password to view any comments.',
	'twentyten'
); ?></div>
	</div><!-- .comments -->
<?php
	return;
endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if (have_comments()) : ?>
    <h3 id="comments-title">
        <?php
        comments_number(
		    sprintf(
		    	'No Responses to %s',
		    	'<em>' . get_the_title() . '</em>'
		    ),
		    sprintf(
		    	'One Response to %s',
		    	'<em>' . get_the_title() . '</em>'
		    ),
		    sprintf(
		    	'%% Responses to %s',
		    	'<em>' . get_the_title() . '</em>'
		    )
        ); ?>
    </h3>

    <?php if (get_comment_pages_count() > 1) : // are there comments to nav ?>
	    <div class="navigation">
            <div class="nav-previous">
                <?php previous_comments_link('&larr; Older Comments'); ?>
            </div>
            <div class="nav-next">
                <?php next_comments_link('Newer Comments &rarr;'); ?>
            </div>
		</div>
    <?php endif; // check for comment navigation ?>

	<ol class="commentlist">
	    <?php wp_list_comments(array('callback' => 'adcuda_comment')); ?>
	</ol>

    <?php if (get_comment_pages_count() > 1) : // are there comments to nav ?>
		<div class="navigation">
            <div class="nav-previous">
                <?php previous_comments_link('&larr; Older Comments'); ?>
            </div>
            <div class="nav-next">
                <?php next_comments_link('Newer Comments &rarr;'); ?>
            </div>
		</div>
    <?php endif; // check for comment navigation ?>

<?php else : // this is displayed if there are no comments so far ?>

    <?php if (comments_open()) : // comments are open, but there no comments ?>

    <?php else : // if comments are closed ?>

	    <p class="nocomments">Comments are closed.</p>

    <?php endif; ?>
<?php endif; ?>

<?php comment_form(); ?>

</div><!-- #comments -->
