<?php
/**
 * Handle ajax calls for adding options to the Theme Options Screen
 * @package Wordpress
 * @since 1.0.0
 **/

add_action('wp_ajax_overdidAjax-options', 'overdidAjax_options');

function overdidAjax_options()
{

	// get the submitted parameters
    $counter	= $_POST['ID'];
    $counter++;
    $nonce      = $_POST['NonceRequest'];

	// check to see if the submitted nonce matches with the
	// generated nonce we created earlier
	if (!wp_verify_nonce($nonce, 'overdidAjax-nonce-request'))
        die ('Busted!');

    // Build new form data for display
    $content =  "<fieldset class='monitor' id='$counter'>";
    $content .= "<p><label class='wide'>Option Name:</label>" .
        "<input type='text' class='regular-text' " .
        "name='overdid-site-options[$counter][name]' value=''/><br/>" .
        "<label class='wide'></label>" .
        "<em>The title of this the option.</em></p>";
    $content .= "<p><label class='wide'>Site Options Page:</label>" .
        "<select rel='show$counter' name='overdid-site-options[$counter][page]'>";
        $value = array('--Select--', 'Site', 'Tracking', 'Location');
        foreach ($value as $val) {
            $content .= "<option value='$val'>$val</option>";
        }
    $content .= "</select>";
    $content .= "<em>The page this option should belong to.</em></p>";
    $content .= "<p><label class='wide'>Page Section:</label>" .
        "<span class='show$counter'>You only need this if you chose 'Site' as the page above.</span>" .
        "<select class='show$counter hide' name='overdid-site-options[$counter][section]'>";
        $value = array('Images', 'Colors', 'Url', 'General');
        foreach ($value as $val) {
            $content .= "<option value='$val'>$val</option>";
        }
    $content .= "</select>";
    $content .= "<em class='show$counter hide'>The section of the page where this entry will fit.</em></p>";
    $content .= "<p><label class='wide'>Option ID:</label><input type='text' " .
        "class='regular-text' name='overdid-site-options[$counter][ID]' " .
        "value=''/><br/><label class='wide'></label>" .
        "<em>A unique ID you assign to this option.</em></p>";
    $content .= "<p><label class='wide'>Type:</label>" .
        "<select name='overdid-site-options[$counter][type]'>";
        $value = array('text', 'image', 'color', 'business location');
        foreach ($value as $val) {
            $content .= "<option value='$val'>$val</option>";
        }
    $content .= "</select>";
    $content .= "<em>Select the type of option this will be.</em></p>";
    $content .= "<p><label class='wide'>Explanatory Text:</label>" .
        "<input type='text' class='regular-text' " .
        "name='overdid-site-options[$counter][text]' value=''/><br/>" .
        "<label class='wide'></label>" .
        "<em>Description of what this option will be.</em></p>";
    $content .= "</fieldset>";

    // response output
	header("Content-Type: application/json");
    $content = array('content' => $content);
    echo json_encode($content);
    die();

}