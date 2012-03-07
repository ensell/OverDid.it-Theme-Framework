<?php
/**
 * meta_box.php
 * Add Custom Meta boxes to the pages
 *
 * @package Wordpress
 * @since 1.0.0
 **/

/**
 * Call hook to add metabox
 */
add_action('admin_init', 'overdid_page_boxes_init');

/**
 * Add the meta box and set a save method
 */
function overdid_page_boxes_init()
{
	add_meta_box(
		'overdid_meta',
		'Page Headers',
		'overdid_header_box',
		'page',
		'normal',
		'high'
	);
	add_action('save_post', 'overdid_save_header_box');

	foreach (array( 'normal', 'advanced', 'side') as $context) {
        remove_meta_box('postcustom', 'page', $context);

    }

}

/**
 * Display the custom meta box
 */
function overdid_header_box($post, $box)
{



	// Retrieve custom meta field values
	$header = get_post_meta(
        $post->ID,
        'header',
        true
    );
    $sub_head = get_post_meta(
         $post->ID,
      	'sub_head',
         true
    );
    $head_content = get_post_meta(
         $post->ID,
      	'head_content',
         true
    );
	$overdidMetaTitle = get_post_meta(
	    $post->ID,
	    'overdid_meta_title',
	    true
	);
	$overdidKeywords = get_post_meta(
	    $post->ID,
	    'overdid_keywords',
	    true
	);
	$overdidMetaDescription = get_post_meta(
	    $post->ID,
	    'overdid_meta_description',
	    true
	);
    $overdidPpcTracking = get_post_meta(
        $post->ID,
        'overdid_ppc_tracking',
        true
    );

	?>
	<style type='text/css'>
		.wide { width:99%; }
	</style>

    <p>
        <label id='content'>Page Header:</label>
        <textarea class="wide" name="header"><?php
            echo $header; ?></textarea>
    </p>
    <p>
        <label id='content'>Page Sub Header:</label>
        <textarea class="wide" name="sub_head"><?php
            echo $sub_head; ?></textarea>
    </p>
    <p>
        <label id='content'>Page Head Content:</label>
        <textarea class="wide" name="head_content"><?php
            echo $head_content ?></textarea>
    </p>
    <a class='adc-adjustment relative'>( + )</a> Additional Meta Items
    <div class="sub-fields">
        <p>
            <label>Meta Title:</label>
            <input type='text' class='wide' name='overdid_meta_title'
                value='<?php echo esc_attr($overdidMetaTitle);?>' />
        </p>
        <p>
            <label>Meta Keywords:</label>
            <input type='text' class='wide' name='overdid_keywords'
                value='<?php echo esc_attr($overdidKeywords);?>' />
            <em>Separate keywords with a comma.</em>
        </p>
        <p>
            <label>Meta Description:</label>
            <textarea class='wide' name='overdid_meta_description'><?php
                echo esc_attr($overdidMetaDescription);?></textarea>
        </p>
        <p>
            <label>PPC Tracking Code:</label>
            <textarea class='wide' name='overdid_ppc_tracking'><?php
                echo esc_attr($overdidPpcTracking);?></textarea>
        </p>
    </div>

	<?php

}

/**
 * Save the custom meta data
 */
function overdid_save_header_box($postId)
{
	if (isset($_POST['header'])) {
		update_post_meta(
		    $postId,
		    'header',
		    $_POST['header']
		);
		update_post_meta(
		    $postId,
		    'sub_head',
		    $_POST['sub_head']
		);
		update_post_meta(
		    $postId,
		    'head_content',
		    $_POST['head_content']
		);
		update_post_meta(
		    $postId,
		    'overdid_meta_title',
		    esc_attr($_POST['overdid_meta_title'])
		);
		update_post_meta(
	        $postId,
	        'overdid_keywords',
	        esc_attr($_POST['overdid_keywords'])
	    );
        update_post_meta(
            $postId,
            'overdid_meta_description',
            esc_attr($_POST['overdid_meta_description'])
        );
        update_post_meta(
            $postId,
            'overdid_ppc_tracking',
            esc_attr($_POST['overdid_ppc_tracking'])
        );

	}

}
