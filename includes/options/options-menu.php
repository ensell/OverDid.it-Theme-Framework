<?php
/**
 * Options Page
 * @package Wordpress
 * @since 1.0.0
 *
 **/

/**
 * Options pages for defining specific content throughout site
 *
 **/

// create custom plugin settings menu
add_action('admin_menu', 'overdid_options_pages');

function overdid_options_pages()
{

    //Create Theme options page
    add_submenu_page(
    	'themes.php',
    	'Theme Options',
    	'Theme Options',
    	'edit_themes',
        'overdid-theme-options',
        'overdid_theme_options'
    );

	//create new top-level menu
    add_menu_page(
    	'Site Options',
    	'Site Options',
    	'edit_theme_options',
    	'overdid-page-display',
    	'overdid_site_options',
        get_option('overdid-favicon')
    );

	//Add submenu page
    add_submenu_page(
    	'overdid-page-display',
    	'Tracking Options',
    	'Tracking Options',
        'edit_theme_options',
        'overdid-web-options',
        'overdid_tracking_options'
    );

    //Add submenu page
    add_submenu_page(
    	'overdid-page-display',
    	'Location Options',
    	'Location Options',
        'edit_theme_options',
        'overdid-loc-options',
        'overdid_location_options'
    );

	//call register settings function
	add_action('admin_init', 'overdid_register_settings');
}

// Setup for using wordpress upload dialog box in options
function overdid_admin_scripts()
{
    wp_enqueue_script('overdid-admin');
    wp_enqueue_script('overdid-colorpicker');
    wp_localize_script(
    	'overdid-admin', 'overdidAjax',
        array(
		    'ajaxurl' => admin_url('admin-ajax.php'),
		    'NonceRequest' => wp_create_nonce('overdidAjax-nonce-request'),
		)
	);


}

function overdid_admin_styles()
{
	wp_enqueue_style('thickbox');
	wp_enqueue_style('overdid-meta-style');
    wp_enqueue_style('overdid-color');
}

if (
    (isset($_GET['page']) && $_GET['page'] == 'overdid-page-display')
    || (isset($_GET['page']) && $_GET['page'] == 'overdid-web-options')
    || (isset($_GET['page']) && $_GET['page'] == 'overdid-theme-options')
    || (isset($_GET['page']) && $_GET['page'] == 'overdid-loc-options')
    ) {
	add_action('admin_print_scripts', 'overdid_admin_scripts');
	add_action('admin_print_styles', 'overdid_admin_styles');
}

function overdid_register_settings()
{
/*********************************
 * Theme Options Settings
 /**************************************/

     //
    //Theme Options Page
    //
    add_settings_section(
    	'main-section',
    	'Theme Options',
    	'overdid_theme_text',
    	'overdid-theme-options'
    );
    add_settings_section(
    	'Images',
    	'Site Images',
    	'overdid_site_text',
        'overdid-site-options'
    );
    add_settings_section(
    	'Colors',
    	'Site Colors',
    	'overdid_color_text',
        'overdid-site-options'
    );
    add_settings_section(
    	'Url',
    	'Site Links',
    	'overdid_link_text',
        'overdid-site-options'
    );
    add_settings_section(
    	'General',
    	'Site General/Misc Options',
    	'overdid_general_text',
        'overdid-site-options'
    );
    add_settings_section(
    	'meta-section',
    	'Webmaster Codes',
    	'overdid_webmaster_text',
        'overdid-web-options'
    );
    add_settings_section(
    	'analytic-section',
    	'Analytics Codes',
    	'overdid_analytics_text',
        'overdid-web-options'
    );
    add_settings_section(
    	'General',
    	'Site General/Misc Options',
    	'overdid_general_text',
        'overdid-web-options'
    );
     add_settings_section(
    	'data-section',
    	'Location Data',
    	'overdid_location_text',
        'overdid-loc-options'
    );
    add_settings_section(
    	'hours-section',
    	'Business Hours',
    	'overdid_hours_text',
        'overdid-loc-options'
    );
    add_settings_section(
    	'General',
    	'Site General/Misc Options',
    	'overdid_general_text',
        'overdid-loc-options'
    );

    register_setting('overdid-theme-settings', 'overdid-site-options');

    add_settings_field(
    	'overdid-site-options',
    	'Site options',
    	'overdid_custom_options',
        'overdid-theme-options',
        'main-section',
        array(
            'overdid-site-options'
        )
    );

    $options = get_option('overdid-site-options');
    if ($options) {
        foreach ($options as $option) {
            switch ($option['page']) {
                case 'Site':
                    $option['page'] = 'overdid-site-options';
                    $setting = 'overdid-site-settings';
                    break;

                case 'Tracking':
                    $option['page'] = 'overdid-web-options';
                    $option['section'] = 'General';
                    $setting = 'overdid-tracking-settings';
                    break;

                case 'Location':
                    $option['page'] = 'overdid-loc-options';
                    $option['section'] = 'General';
                    $setting = 'overdid-location-settings';
                    break;

                default:
                    break;
            }
            /* TODO add additional business location
             * TODO rethink the layout for the locations page - consider adding entire sections at once
             * such as Add Business #1 - Business #2 - Add Hours - consider radial buttons
             *
             *
             */
            register_setting($setting, $option['ID']);
            //print_r($option);
            if ($option['type'] == 'text') {
                $type = 'overdid_text_input';
            } else {
                $type = 'overdid_media_input';
            }
            add_settings_field(
                $option['ID'],
                $option['name'],
                $type,
                $option['page'],
                $option['section'],
                array(
                    $option['ID'],
                    $option['type'],
                    $option['text']
                )
            );
            //echo $type; echo $option['page'];
        }
    }

    //
    // Tracking Options Settings
    //

    register_setting(
    	'overdid-tracking-settings',
    	'overdid-google-meta',
    	'esc_attr'
    );
    register_setting(
    	'overdid-tracking-settings',
    	'overdid-bing-meta',
    	'esc_attr'
    );
    register_setting(
    	'overdid-tracking-settings',
    	'overdid-yahoo-meta',
    	'esc_attr'
    );
    register_setting(
    	'overdid-tracking-settings',
    	'overdid-google-analytics',
    	'esc_attr'
    );

    add_settings_field(
    	'overdid-google-meta',
    	'Google',
    	'overdid_text_input',
        'overdid-web-options',
        'meta-section',
        array(
            'overdid-google-meta',
            'text',
            'Enter the Google META Tag.'
        )
    );
    add_settings_field(
    	'overdid-bing-meta',
    	'Bing',
    	'overdid_text_input',
    	'overdid-web-options',
        'meta-section',
        array(
            'overdid-bing-meta',
            'text',
            'Enter the Bing META Tag.'
        )
    );
    add_settings_field(
    	'overdid-yahoo-meta',
    	'Yahoo',
    	'overdid_text_input',
    	'overdid-web-options',
        'meta-section',
        array(
            'overdid-yahoo-meta',
            'text',
            'Enter the Yahoo META Tag.'
        )
    );
    add_settings_field(
    	'overdid-google-analytics',
    	'Google', 'overdid_text_input',
        'overdid-web-options',
        'analytic-section',
        array(
            'overdid-google-analytics',
            'textarea',
            'Enter the Google Analytics Code.'
        )
    );


    //
    // Location Options Settings
    //

    register_setting(
    	'overdid-location-settings',
    	'overdid-company-name',
    	'wp_kses_data'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-street',
    	'wp_kses_data'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-city',
    	'wp_kses_data'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-state',
    	'wp_kses_data'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-zip',
    	'wp_kses_data'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-country',
    	'wp_kses_data'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-primary-number',
    	'odit_phone_check'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-fax-number',
    	'odit_phone_check'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-twitter-url',
    	'esc_url_raw'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-facebook-url',
    	'esc_url_raw'
    );
    register_setting(
    	'overdid-location-settings',
    	'overdid-business-hours'
    );

    add_settings_field(
    	'overdid-company-name',
    	'Business Name',
    	'overdid_text_input',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-company-name',
            'text',
            'Business Name'
        )
    );
    add_settings_field(
    	'overdid-street',
    	'Street',
    	'overdid_text_input',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-street',
            'text',
            'Enter the street address of your business.'
        )
    );
    add_settings_field(
    	'overdid-city',
    	'City',
    	'overdid_text_input',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-city',
            'text',
            'Enter you city name.'
        )
    );
    add_settings_field(
    	'overdid-state',
    	'State',
    	'overdid_dropdown_text',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-state',
            array(
                'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL',
                'GA', 'HI', 'ID','IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME',
                'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH',
                'OK', 'OR', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'PA', 'RI',
                'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA', 'WV', 'WI', 'WY'
            ),
            'Select the state your business is in.'
        )
    );
    add_settings_field(
    	'overdid-zip', 'Zip Code',
    	'overdid_text_input',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-zip',
            'text',
            'Enter your business zip code.'
        )
    );
    add_settings_field(
    	'overdid-country',
    	'Country',
    	'overdid_dropdown_text',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-country',
            array(
                'United States', 'Canada', 'Afghanistan', 'Albania', 'Algeria',
                'Andorra', 'Angola', 'Antigua & Deps', 'Argentina', 'Armenia',
                'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain',
                'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize',
                'Benin', 'Bhutan', 'Bolivia', 'Bosnia Herzegovina', 'Botswana',
                'Brazil', 'Brunei', 'Bulgaria', 'Burkina', 'Burundi',
                'Cambodia', 'Cameroon', 'Canada', 'Cape Verdi',
                'Central African Rep', 'Chad', 'Chile', 'China', 'Columbia',
                'Comoros', 'Congo', 'Congo {Democratic Rep}', 'Costa Rica',
                'Croatia', 'Cuba', 'Cyprus', 'Czech Republic', 'Denmark',
                'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor',
                'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea',
                'Eritrea', 'Estonia', 'Ethiopia', 'Fiji', 'Finland', 'France',
                'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Greece',
                'Greneda', 'Guatemala', 'Guinea', 'Guinea-Bissau', 'Guyana',
                'Haiti', 'Honduras', 'Hungary', 'Iceland', 'India', 'Indonesia',
                'Iran', 'Iraq', 'Ireland {Republic}', 'Israel', 'Italy',
                'Ivory Coast', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan',
                'Kenya', 'Kiribati', 'Korea North', 'Korea South', 'Kuwait',
                'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia',
                'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg',
                'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives',
                'Mali', 'Malta', 'Marshall Islands', 'Mauritania', 'Mauritius',
                'Mexico', 'Micronesia', 'Moldova', 'Monaco', 'Mongolia',
                'Morocco', 'Mozambique', 'Myanmar', '{Burma}', 'Namibia',
                'Narau', 'Nepal', 'Netherlands', 'New Zealand', 'Nicaragua',
                'Niger', 'Nigeria', 'Norway', 'Oman', 'Pakistan', 'Palau',
                'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines',
                'Poland', 'Portugal', 'Qatar', 'Romania', 'Russian Federation',
                'Rwanda', 'St Kitts & Nevis', 'St Lucia',
                'St Vincent & Grenadines', 'San Marino', 'Sao Tome & Principe',
                'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone',
                'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands',
                'Somalia', 'South Africa', 'Spain', 'Sri Lanka', 'Sudan',
                'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria',
                'Taiwan', 'Tajikstan', 'Tanzania', 'Thailand', 'Togo', 'Tonga',
                'Trinidad & Tobago', 'Tunisia', 'Turkey', 'Turkmenistan',
                'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates',
                'United Kingdom', 'United States', 'Uruguay', 'Uzbekistan',
                'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam',
                'Western Samoa', 'Yemen', 'Yugoslavia', 'Zambia', 'Zimbabwe'
            ),
            'Select your Country.'
        )
    );
    add_settings_field(
    	'overdid-primary-number',
    	'Primary Phone Number',
    	'overdid_text_input',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-primary-number',
            'text',
            'Enter your primary business number.'
        )
    );
    add_settings_field(
    	'overdid-fax-number',
    	'Fax Number',
    	'overdid_text_input',
        'overdid-loc-options',
        'data-section',
        array(
            'overdid-fax-number',
            'text',
            'Enter your fax number.'
        )
    );
    add_settings_field(
    	'overdid-business-monday',
    	'Monday',
    	'overdid_drop_down_time',
        'overdid-loc-options',
        'hours-section',
        array(
            'overdid-business-hours',
            'overdid-business-monday'
        )
    );
    add_settings_field(
    	'overdid-business-tuesday',
    	'Tuesday',
    	'overdid_drop_down_time',
        'overdid-loc-options',
        'hours-section',
        array(
            'overdid-business-hours',
            'overdid-business-tuesday'
        )
    );
    add_settings_field(
    	'overdid-business-wednesday',
    	'Wednesday',
    	'overdid_drop_down_time',
        'overdid-loc-options',
        'hours-section',
        array(
            'overdid-business-hours',
            'overdid-business-wednesday'
        )
    );
    add_settings_field(
    	'overdid-business-thursday',
    	'Thursday',
    	'overdid_drop_down_time',
        'overdid-loc-options',
        'hours-section',
        array(
            'overdid-business-hours',
            'overdid-business-thursday'
        )
    );
    add_settings_field(
    	'overdid-business-friday',
    	'Friday',
    	'overdid_drop_down_time',
        'overdid-loc-options',
        'hours-section',
        array(
            'overdid-business-hours',
            'overdid-business-friday'
        )
    );
    add_settings_field(
    	'overdid-business-saturday',
    	'Saturday',
    	'overdid_drop_down_time',
        'overdid-loc-options',
        'hours-section',
        array(
            'overdid-business-hours',
            'overdid-business-saturday'
        )
    );
    add_settings_field(
    	'overdid-business-sunday',
    	'Sunday',
    	'overdid_drop_down_time',
        'overdid-loc-options',
        'hours-section',
        array(
            'overdid-business-hours',
            'overdid-business-sunday',
            'Select the business open and close times.'
        )
    );

}

/******************************************************************************
 * Generic input setup functions
 *****************************************************************************/
/**
 * Build a Drop Down Menu Based on Numbers
 *
 * @param 0 - The specific option for this field
 * @param 1 - Minimum numeric value for the drop down
 * @param 2	- Maximum numeric value for the drop down
 * @param 3	- field explanatory text
 **/
function overdid_dropdown_numbers($options)
{
    $name       = $options[0];
    $option     = get_option($name);
    $minValue  = $options[1];
    $maxValue  = $options[2];
    $text       = $options[3];

    echo "<select name='$name'>\n";
    for ($x = $minValue; $x <= $maxValue; $x++) {
        if (isset($option) && $x == $option) {
            echo "<option value='$x' selected='selected'>$x</option>\n";
        } else {
            echo "<option value='$x'>$x</option>\n";
        }
    }
    echo "</select>\n";
    echo "<p><em>$text</em></p>\n";

}

/**
 * Build a Drop Down Menu Based on text
 *
 * @param 0 - The specific option for this field
 * @param 1 - Array of field values
 * @param 2	- Field explanatory text
 **/
function overdid_dropdown_text($options)
{
    $name   = $options[0];
    $option = get_option($name);
    $values = $options[1];
    $text   = $options[2];

    echo "<select name='$name'>\n";

    foreach ($values as $value) {
        if (isset($option) && $value == $option) {
            echo "<option value='$value' selected='selected'>$value</option>\n";
        } else {
            echo "<option value='$value'>$value</option>\n";
        }
    }
    echo "</select>\n";
    echo "<p><em>$text</em></p>\n";

}

/**
 * Build a Text input area
 *
 * @param 0 - The specific option for this field
 * @param 1 - input type
 * @param 2 - Field explanatory text
 **/
function overdid_text_input($options)
{
    $name   = $options[0];
    $option = get_option($name);
    $type   = $options[1];
    $text   = $options[2];

    switch ($type) {
        case 'textarea' :
            echo "<textarea class='wide' rows='5' id='$name' " .
                "name='$name'>$option</textarea>";
            break;

        case 'text' :
            echo "<input type='text' class='wide' id='$name' name='$name' " .
                "value='$option' />";
            break;

    }
    echo "<p><em>$text</em></p>\n";

}

/**
 * Build a media input box
 *
 * @param 0 - The specific option for this field
 * @param 1 - The input type
 * @param 2 - Field explanatory text
 **/
function overdid_media_input($options)
{
    global $cssArray;

    $name   = $options[0];
    $option = esc_attr(get_option($name));
    $type   = $options[1];
    $text   = $options[2];

    if ($type == "image" && $option != "")
        echo "<img class='odit-thumb-preview $name' src='$option' />";?>
    <input type='hidden' class='<?php echo $name;?>' id='<?php echo $name;?>'
        name='<?php echo $name;?>' value='<?php echo $option;?>' />
    <?php if ($type == 'image') : ?>
        <input type="button" rel='overdid-image-upload'
        	class="<?php echo $name;?>"
            value="Upload Image" />
    <?php elseif ($type == 'color') : ?>
        <div class="customWidget">
            <div rel="<?php echo $name;?>"class="colorSelector">
                <div style="background-color: <?php echo $option;?>;">
                </div>
            </div>
            <div class="colorpickerHolder">
            </div>
        </div>

    <?php endif; ?>
    <p><em><?php echo $text;?></em></p>

    <!-- Populate the array for dynamic css file creation -->
    <?php $cssArray[] = array($name, $type, $option);

}


/**
 * Build the Custom Options settings for use in the Site Options Page
 *
 * @param 0 - The specific option for this field
 **/
function overdid_custom_options($options)
{
    $name   = $options[0];
    $options = get_option($name);

    $x = 1;
    if ($options != NULL) {
        foreach ($options as $option) { ?>
            <fieldset class="monitor" id='<?php echo $x;?>'>
                <a class='odit-adjustment'>( + )</a>
                <p>
                    <label class='wide'>Option Name:</label>
                    <input type='text' class='regular-text'
                    	name='<?php echo $name . "[" . $x .
                        "][name]";?>' value='<?php echo $option["name"];?>'/>
                    <br/><label class='wide'></label>
                    <em>The title of this the option.</em>
                </p>
                <div class='sub-fields'>
                    <p>
                        <label class='wide'>Site Options Page:</label>
                        <select rel="show<?php echo $x;?>" name='<?php
                            echo $name . "[" . $x . "][page]";
                            ?>'>
                        <?php
                        $val = $option['page'];
                        $entries = array('--Select--', 'Site', 'Tracking', 'Location');
                        foreach ($entries as $entry) {
                            if ($val == $entry) {
                                echo "<option value='$entry'
                                    selected='selected'>
                                        $entry
                                    </option>\n";
                            } else {
                                echo "<option value='$entry'>$entry</option>\n";
                            }
                        }
                        ?>
                        </select>
                        <em>The page this option should belong to.</em>
                    </p>
                    <p>
                        <label class='wide'>Page Section:</label>
                        <span class='show<?php echo $x;?>'>You only need this if you chose 'Site' as the page above.</span>
                        <select class="show<?php echo $x;?> hide" name='<?php
                            echo $name . "[" . $x . "][section]";
                            ?>'>
                        <?php
                        $val = $option['section'];
                        $entries = array('Images', 'Colors', 'Url', 'General');
                        foreach ($entries as $entry) {
                            if ($val == $entry) {
                                echo "<option value='$entry'
                                    selected='selected'>
                                        $entry
                                    </option>\n";
                            } else {
                                echo "<option value='$entry'>$entry</option>\n";
                            }
                        }
                        ?>
                        </select>
                        <em class="show<?php echo $x;?> hide">The section of the page where this entry will fit.</em>
                    </p>
                    <p>
                        <label class='wide'>Option ID:</label>
                        <input type='text' class='regular-text'
                        	name='<?php echo $name .
                            "[" . $x . "][ID]";?>'
                            value='<?php echo $option["ID"];?>'/><br/>
                        <label class='wide'></label>
                        <em>A unique ID you assign to this option.</em>
                    </p>
                    <p>
                        <label class='wide'>Type:</label>
                        <select name='<?php
                            echo $name . "[" . $x . "][type]";
                            ?>'>
                        <?php
                        $val = $option['type'];
                        $entries = array('text', 'image', 'color');
                        foreach ($entries as $entry) {
                            if ($val == $entry) {
                                echo "<option value='$entry'
                                	selected='selected'>
                                        $entry
                                    </option>\n";
                            } else {
                                echo "<option value='$entry'>$entry</option>\n";
                            }
                        }
                        ?>
                        </select>
                        <em>Select the type of option this will be.</em>
                    </p>
                    <p>
                        <label class='wide'>Explanatory Text:</label>
                        <input type='text' class='regular-text'
                        	name='<?php echo $name .
                            "[" . $x . "][text]";?>'
                            value='<?php echo $option["text"];?>'/>
                            <br/>
                        <label class='wide'></label>
                        <em>Description of what this option will be.</em>
                    </p>
                </div>
            </fieldset>
            <?php $x++;
        }
    }
    ?>
    <a class='opt-addition'>+ Add a new option</a>

    <?php
}

/**
 * Build a drop down for time selections
 *
 * @param 0 - The specific option for this field
 * @param 1 - The input type
 * @param 2 - Field explanatory text
 **/
function overdid_drop_down_time($options)
{
    $settings =     get_option($options[0]);
    $openText =    $options[1];
    $openTime =    $options[0] . "[" . $openText . "][0]";
    $openValue =   $settings[$openText];
    $closeText =   $options[1];
    $closeTime =   $options[0] . "[" . $closeText . "][1]";
    $closeValue =  $settings[$closeText];

    $items = array();
    $times = array('-- Closed --');
    for ($x=1; $x<=24; $x++) {
        array_push($times, $x . ':00', $x . ':15', $x . ':30', $x . ':45');
    }
    foreach ($times as $time) {
        if ($time != "-- Closed --")
            $time = strftime("%l:%M %p", strtotime($time));

        array_push($items, $time);
    }

    echo "<label for='" . $openTime . "'>Open: </label><select id='" .
        $openTime . "' name='" . $openTime . "'>";
    $value = $settings[$openText][0];
    foreach ($items as $item) {
		$selected = ($value == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
	echo "</select>&nbsp;&nbsp;";

    echo "<label for='" . $closeTime . "'>Close: </label><select id='" .
        $closeTime . "' name='" . $closeTime . "'>";
    $value = $settings[$closeText][1];
    foreach ($items as $item) {
		$selected = ($value == $item) ? 'selected="selected"' : '';
		echo "<option value='$item' $selected>$item</option>";
	}
    echo "</select>&nbsp;&nbsp;";

    if (isset($options[2]))
        echo "<p><em>" . $options[2] . "</em></p>";
}


/***************************************************
 * Option Page Displays
 * *************************************************/
/**
 * Theme Options
 */
function overdid_theme_options()
{
?>
    <div class="wrap">
		<div class="icon32" id="icon-themes"><br></div>
		<h2>Theme Options</h2>
		Setup your personalized theme options here.
		<form action="options.php" method="post">
		<?php settings_fields('overdid-theme-settings'); ?>
		<?php do_settings_sections('overdid-theme-options'); ?>
		<p class="submit">
            <input name="Submit" type="submit" class="button-primary"
                value="<?php esc_attr_e('Save Changes'); ?>" />
		</p>
		</form>
	</div>
<?php
}


/**
 * Site Options and dynamic stylesheet creation
 */
function overdid_site_options()
{
    global $cssArray;

?>
	<div class="wrap">
        <div class='icon32' id='icon-options-general'><br></div>
		<h2>Site Display Options</h2>
        Display options for the site.
		<form method="post" action="options.php">
            <?php settings_fields('overdid-site-settings'); ?>
            <?php do_settings_sections('overdid-site-options');?>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary"
                    value="<?php esc_attr_e('Save Changes'); ?>" />
		    </p>
		</form>
	</div>

    <?php overdid_build_css($cssArray);
}


/**
 * Tracking Options
 */
function overdid_tracking_options()
{
?>
    <div class="wrap">
        <div class='icon32' id='icon-options-general'><br></div>
		<h2>Site Tracking Options</h2>
        Tracking script entries from various sources
        <form method="post" action="options.php">
            <?php settings_fields('overdid-tracking-settings'); ?>
            <?php do_settings_sections('overdid-web-options');?>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary"
                    value="<?php esc_attr_e('Save Changes'); ?>" />
		    </p>
		</form>
	</div>
-<?php
}

/**
 * Business Options
 */
function overdid_location_options()
{
?>
    <div class="wrap">
        <div class='icon32' id='icon-options-general'><br></div>
		<h2>Location Options</h2>
        Any options related to your businesses location
        <form method="post" action="options.php">
            <?php settings_fields('overdid-location-settings'); ?>
            <?php do_settings_sections('overdid-loc-options');?>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary"
                    value="<?php esc_attr_e('Save Changes'); ?>" />
		    </p>
		</form>
	</div>
<?php
}


/********************************
 * Pages Header Explanation Text
 *********************************/
// Explanatory text for Theme Options
function overdid_theme_text()
{
    echo "<p>Core theme options setup.</p>";
}

// Explanatory text for generic options
function overdid_site_text()
{
    echo "<p>Standard theme display options</p>";
}

// Explanatory text for additional options
function overdid_color_text()
{
    echo "<p>Display options added from the Theme Options menu</p>";
}

// Explanatory text for additional options
function overdid_link_text()
{
    echo "<p>Display options added from the Theme Options menu</p>";
}

// Explanatory text for additional options
function overdid_general_text()
{
    echo "<p>Display options added from the Theme Options menu</p>";
}

// Explanatory text for additional options
function overdid_webmaster_text()
{
    echo "<p>Javascript provided by the various search engines.</p>";
}

// Explanatory text for additional options
function overdid_analytics_text()
{
    echo "<p>Analytics codes provided by providers.</p>";
}

// Explanatory text
function overdid_location_text()
{
    echo "<p>General location information.</p>";
}

// Explanatory text
function overdid_hours_text()
{
    echo "<p>Select you hours of operation.</p>";
}




/************************************
 * Takes the options passed in and writes out a CSS file
 * $options = an array of options
*************************************/
function overdid_build_css($options)
{
    $content = '';

    if ($options) {
        foreach ($options as $option) {
           //insert option and value to content string
            if ($option[1] == "image") {
                $content .= ".$option[0] { background-image:url('$option[2]'); }\n";

            } elseif ($option[1] == "color") {
                $content .= ".$option[0] { background-color:$option[2]; }\n";

            }

        }

        //open file and write to css file
        $fileOpen = fopen(TEMPLATEPATH . "/options-style.css", "w");
        fwrite($fileOpen, $content);
        fclose($fileOpen);
    }

}

/**
 * Validate to phone numbers - accepts extensions
 *
 * @param $input = string representing the phone number
 **/
function odit_phone_check($input)
{
    $regex = '/^(\D*)?(\d{3})(\D*)?(\d{3})(\D*)?(\d{4})$/';

    if ($input != '') {
        $check = preg_match($regex, $input);
        if (!$check) {
            die('You have entered an invalid phone number - Please press the ' .
            'back button on your browser and correct the issue');
        }
    }

    return $input;

}