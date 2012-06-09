<?php
/**
 * content-box.php
 * Add Custom Content Area boxes to the pages
 *
 * @package Wordpress
 * @since 1.0.0
 **/

/**
 * Add Custom Content Area boxes to the pages
 **/

/**
 * Create the meta box selector on page
 *
 * @since      2.1
 */
function overdid_meta_select()
{
    add_meta_box(
        'overdid_boxes',
        'Content Areas',
        'overdid_box_num',
        'page',
        'side',
        'high'
    );
    add_action( 'save_post', 'overdid_save_num' );

}

/**
 * Add the meta box and set a save method
 *
 * @since   2.1 - Added functionality to accomodate the meta select box
 */
function overdid_meta_boxes()
{
    // Add meta boxes
    if ( isset( $_GET[ 'post' ] ) ) {
        $boxes = get_post_meta( $_GET[ 'post' ], 'boxes', true );
        for ( $box = 1; $box <= $boxes; $box++ ) {
            add_meta_box(
                'overdid_box_' . $box,
            'Content Area #' . $box,
                'overdid_content_box',
                'page',
                'normal',
                'high',
                $box
            );
        }
    }

    add_action( 'save_post', 'overdid_save_box' );

    if ( isset( $_GET[ 'post' ] ) ) {
        wp_enqueue_script( 'overdid-upload' );
        wp_enqueue_style( 'overdid-meta-style' );

    }
}

/**
 * Display the number selection box
 *
 * @since   2.1
 */
function overdid_box_num()
{
    global $post;
    global $boxes;
    $boxes = get_post_meta( $post->ID, 'boxes', true );
    ?>
<label>Number of Areas</label>
    <select name='boxes'>
        <?php
    for ( $x = 0; $x <= 12; $x++ ) {
        if ( isset( $boxes ) && $x == $boxes ) {
            echo "<option value='$x' selected='selected'>$x</option>\n";
        } else {
            echo "<option value='$x'>$x</option>\n";
        }
    }
    echo "</select>\n";
}

/**
 * Display the custom meta box
 */
function overdid_content_box( $post, $box )
{

    // Retrieve custom meta field values
    $contents = get_post_meta( $post->ID, 'contents' . $box[ 'args' ], true );
    $contents = maybe_unserialize( $contents );
    if ( $contents ) {
        $header = esc_attr( $contents[ 'content' . $box[ 'args' ] . '_header' ] );
        $image = esc_attr( $contents[ 'content' . $box[ 'args' ] . '_image' ] );
        $content = esc_attr( $contents[ 'content' . $box[ 'args' ] . '_content' ] );
        $link = esc_attr( $contents[ 'content' . $box[ 'args' ] . '_link' ] );
        $linkText = esc_attr( $contents[ 'content' . $box[ 'args' ] . '_link_text' ] );
        $linkGet = esc_attr( $contents[ 'content' . $box[ 'args' ] . '_link_get' ] );
    }

    ?>

    <div class='overdid_content'>
        <p class='overdid_headers'>
            <label>Header:</label><br/>
            <input class='wide' type='text'
                   name='content<?php echo $box[ 'args' ];?>_header'
                   value='<?php if ( $contents ) echo $header;?>'/>
        </p>

        <p class="overdid_image_upload">
            <label>Image: </label><br/>
            <?php
            if ( !$contents )
                $image = 1;
            if ( $image != 1 && $image != '' )
                echo "<img class='odit-thumb-preview content" . $box[ 'args' ] .
                "_image' src='$image' />";
            ?>
            <input class='wide' type="text"
                   id="content<?php echo $box[ 'args' ];?>_image"
                   name="content<?php echo $box[ 'args' ];?>_image"
                   value="<?php if ( $contents ) echo $image; ?>"/>
            <input type="button" rel='overdid-image-upload'
                   class='content<?php echo $box[ 'args' ];?>_image'
                   value="Select Image"/>
        </p>

        <p>
            <label id='content<?php echo $box[ 'args' ];?>_content_label'>
                Content:
            </label>
        </p>
        <textarea class="content<?php echo $box[ 'args' ];?>_content wide"
                  id="content<?php echo $box[ 'args' ];?>_content" rows='8'
                  name="content<?php echo $box[ 'args' ];?>_content"><?php
            if ( $contents ) echo $content; ?></textarea>

        <p>
            <label>Link Text: </label><br/>
            <input class='wide' type="text"
                   id="content<?php echo $box[ 'args' ];?>_link_text"
                   name="content<?php echo $box[ 'args' ];?>_link_text"
                   value="<?php if ( $contents ) echo $linkText; ?>" size="46%"/>
        </p>

        <p>
            <label>Link: </label>
            <?php
            if ( !$contents ) $link = '';
            $args = array(
                'selected' => 0,
                'echo' => 1,
                'name' => 'content' . $box[ 'args' ] . '_link',
                'selected' => $link,
                'show_option_none' => 'External Link'
            );
            wp_dropdown_pages( $args );
            ?>
        </p>

        <p>
            <label>External Link or Link Additions: </label><br/>
            <input class='wide' type="text"
                   id="content<?php echo $box[ 'args' ];?>_link_get"
                   name="content<?php echo $box[ 'args' ];?>_link_get"
                   value="<?php if ( $contents ) echo $linkGet; ?>" size="46%"/>
            <em>If using as an External Link, just use the desired URL.<br />
            Otherwise, you can add "?get=variable&etc=something</em>
            
        </p>

    </div>

<?php

}

/**
 * Save the custom meta data
 *
 * @since   2.1
 */
function overdid_save_num()
{
    global $post;
    if ( isset( $_POST[ 'boxes' ] ) ) {
        $boxes = esc_attr( $_POST[ 'boxes' ] );
        update_post_meta( $post->ID, 'boxes', $boxes );
    }
}

function overdid_save_box( $postId )
{
    global $post;
    $boxes = get_post_meta( $post->ID, 'boxes', true );
    for ( $box = 1; $box <= $boxes; $box++ ) {
        if ( isset( $_POST[ 'content' . $box . '_header' ] ) ) {
            $title = 'contents' . $box;
            $content = wpautop( $_POST[ 'content' . $box . '_content' ], $br = 1 );
            $contents = array(
                'content' . $box . '_header' =>
                esc_attr( $_POST[ 'content' . $box . '_header' ] ),
                'content' . $box . '_image' =>
                esc_attr( $_POST[ 'content' . $box . '_image' ] ),
                'content' . $box . '_content' =>
                esc_attr( $content ),
                'content' . $box . '_link_text' =>
                esc_attr( $_POST[ 'content' . $box . '_link_text' ] ),
                'content' . $box . '_link' =>
                esc_attr( $_POST[ 'content' . $box . '_link' ] ),
                'content' . $box . '_link_get' =>
                esc_attr( $_POST[ 'content' . $box . '_link_get' ] )
            );

            update_post_meta( $postId, $title, $contents );

        }
    }

}