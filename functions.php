<?php
/**
 * Theme Functions File
 * @package Wordpress
 * @since 1.0.0
 *
 * */

/**
 * Register widgetized areas via array
 *
 * Add sidebars to the widgets panel in admin
 *
 * @since 1.0.0
 *
 */
if (function_exists('register_sidebar')) {
    $allWidgetizedAreas = array(
        array(
            'name' => 'Sidebar',
        ),
        array(
            'name' => 'Footer Area #1'
        ),
        array(
            'name' => 'Footer Area #2'
        ),
        array(
            'name' => 'Footer Area #3'
        ),
        array(
            'name' => 'Footer Area #4'
        )
    );

    foreach ($allWidgetizedAreas as $widgetArea) {
        $widname = $widgetArea['name'];
        $beforeWidget = !isset($widgetArea['before_widget']) ? '<li id="%1$s" class="widget-container %2$s">' : $widgetArea['before_widget'];
        $afterWidget = !isset($widgetArea['after_widget']) ? '</li>' : $widgetArea['after_widget'];
        $beforeTitle = !isset($widgetArea['before_title']) ?
                '<h3 class="widget-title">' : $widgetArea['before_title'];
        $afterTitle = !isset($widgetArea['after_title']) ? '</h3>' : $widgetArea['after_title'];

        register_sidebar(
                array(
                    'name' => $widname,
                    'before_widget' => $beforeWidget,
                    'after_widget' => $afterWidget,
                    'before_title' => $beforeTitle,
                    'after_title' => $afterTitle
                )
        );
    }
}

/**
 * Include other function pages
 */
include_once 'includes/options/admin-style.php';
include_once 'includes/options/options-menu.php';
include_once 'includes/php/meta-box.php';
include_once 'includes/php/columns.php';
include_once 'includes/php/content-box.php';
include_once 'includes/php/options-ajax.php';
include_once 'includes/php/widgets.php';

/**
 * Setup scripts and styles
 *
 * Do registrations on admin_init for later use in admin option pages and meta
 * boxes
 *
 * @since 1.0.0
 *
 */
function overdid_init()
{
    wp_register_script(
            'overdid-admin', get_bloginfo('template_url') .
            '/js/overdid-admin.js', array('jquery', 'media-upload',
        'thickbox')
    );
    wp_register_script(
            'overdid-colorpicker', get_bloginfo('template_url') .
            '/js/colorpicker.js', array('jquery')
    );
    wp_register_style(
            'overdid-meta-style', get_bloginfo('template_url') .
            '/css/meta-style.css'
    );
    wp_register_style(
            'overdid-color', get_bloginfo('template_url') .
            '/css/colorpicker.css'
    );

    if (isset($_GET['post'])) {
        wp_enqueue_script('overdid-admin');
		wp_enqueue_style('overdid-meta-style');

	}

    // Setup the selection area for the number of content boxes on page
    overdid_meta_select();

    // Call meta boxes for pages
    overdid_meta_boxes();
}

add_action('admin_init', 'overdid_init');

/**
 * Theme specific options
 *
 *  Setup menu system and other theme specific wordpress functions using
 *  after_setup_theme hook
 *
 *  @since 1.0.0
 *
 */
function overdid_setup()
{

    // Use the Wordpress Nav Menu
    register_nav_menus(
            array(
                'top-nav' => 'Top Navigation',
                'primary' => 'Primary Navigation',
            )
    );

    // This theme styles the visual editor with editor-style.css to match the
    // theme style.
    add_editor_style();

    // Add post thumbnail support
    add_theme_support('post-thumbnails');

    // Add RSS feed links
    add_theme_support('automatic-feed-links');
}

add_action('after_setup_theme', 'overdid_setup');

/**
 * Insert Theme Header Additions
 *
 * Add any theme specific items that need to be placed in the wp_head call
 *
 * @since 1.0.0
 *
 */
function overdid_header_additions()
{
    global $post;
    // Collect options
    $favicon = esc_attr(get_option('overdid-favicon'));
    $googleMeta = htmlspecialchars_decode(
            get_option(
                    'overdid-google-meta'
            ), ENT_QUOTES
    );
    $bingMeta = htmlspecialchars_decode(
            get_option(
                    'overdid-bing-meta'
            ), ENT_QUOTES
    );
    $yahooMeta = htmlspecialchars_decode(
            get_option(
                    'overdid-yahoo-meta'
            ), ENT_QUOTES
    );
    $metaTitle = esc_attr(
            get_post_meta($post->ID, 'overdid_meta_title', true)
    );
    $keywords = esc_attr(
            get_post_meta($post->ID, 'overdid_keywords', true)
    );
    $metaDescription = esc_attr(
            get_post_meta($post->ID, 'overdid_meta_description', true)
    );

	$ppc = get_post_meta($post->ID, 'overdid_ppc_tracking', true);
    if ($ppc)
        echo html_entity_decode($ppc);

    // Add meta
    echo "\n\n<!-- Begin Theme Header Additons -->\n";
    if ($favicon) {
        echo "<link rel='Shortcut Icon' type='image/x-icon' " .
        "href='$favicon' />\n";
    }

    if ($googleMeta) echo "$googleMeta\n";

    if ($bingMeta) echo "$bingMeta\n";

    if ($yahooMeta) echo "$yahooMeta\n";

    if ($metaTitle) {
        echo "<title>$metaTitle</title>\n";
    } else {
        ?>
        <title>
            <?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>
        </title>

        <?php
    }

    if ($keywords) echo "<META name='keywords' content='$keywords'>\n";

    if ($metaDescription) echo "<META name='description' content='$metaDescription'>\n";

    echo "<!-- End Theme Header Additions -->\n\n";
}

add_action('wp_head', 'overdid_header_additions');

/**
 * Add Stylesheets to header
 *
 * Place any theme stylesheets into the header and allow a hook for child theme
 * submissions as well
 *
 * @since 1.0.0
 *
 */
function overdid_stylesheet_import()
{
    ?>
    <link rel="stylesheet"
          href="<?php bloginfo('template_url'); ?>/css/options-style.css"
          type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css"
          type="text/css" media="screen" />
    <?php
  }

  /**
   * Insert Theme Footer Additions
   *
   * Add any theme items that need to be placed into the footer via the wp_footer
   * call
   *
   * @since 1.0.0
   *
   */
  function overdid_footer_additions()
  {
      // Get options
      $analytics = htmlspecialchars_decode(
              get_option(
                      'overdid-google-analytics'
              ), ENT_QUOTES
      );

      echo "\n\n<!-- Begin Theme Footer Additions -->\n";
      if ($analytics) echo "$analytics\n";

      echo "<!-- End Theme Footer Additions -->\n\n";
  }

  add_action('wp_footer', 'overdid_footer_additions');


  /**
   * Collect Post Meta Fields
   *
   * Gather the meta fields related to a the content meta boxes for a site and
   * return the data.
   *
   * @since 1.0.0
   *
   * @param Int $ID - the post ID
   */
  function overdid_get_meta($id)
  {
      $boxes = get_post_meta($id, 'boxes', true);
      $meta = array(
          'main_header' => get_post_meta($id, 'header', true),
          'main_sub_head' => get_post_meta($id, 'sub_head', true),
          'main_content' => get_post_meta($id, 'head_content', true)
      );

      if ($boxes >= '1') {
          for ($x = 1; $x <= $boxes; $x++) {
              $contents = get_post_meta($id, 'contents' . $x, true);
              $contents = maybe_unserialize($contents);
              $addon = array(
                  'content' . $x . '_header' =>
                  htmlspecialchars_decode(
                          $contents['content' . $x . '_header']
                  ),
                  'content' . $x . '_sub_head' =>
                  htmlspecialchars_decode(
                          $contents['content' . $x . '_sub_head']
                  ),
                  'content' . $x . '_image' =>
                  htmlspecialchars_decode(
                          $contents['content' . $x . '_image']
                  ),
                  'content' . $x . '_content' =>
                  htmlspecialchars_decode(
                          $contents['content' . $x . '_content']
                  ),
                  'content' . $x . '_link' =>
                  htmlspecialchars_decode(
                          $contents['content' . $x . '_link']
                  ),
                  'content' . $x . '_link_text' =>
                  htmlspecialchars_decode(
                          $contents['content' . $x . '_link_text']
                  ),
                  'content' . $x . '_link_get' =>
                  htmlspecialchars_decode(
                          $contents['content' . $x . '_link_get']
                  )
              );

              $meta = array_merge($meta, $addon);
          }
      }

      return $meta;
  }

  /**
   * Add nofollow to all off-site links
   *
   * A content filter to replace all external links with the no follow attribute
   *
   * @since 1.0.0
   *
   */
  function overdid_nofollow($content)
  {

      $site = get_bloginfo('url');
      $expr = "/href=['\"].*?['\"]/";
      $content = preg_replace_callback(
              $expr, create_function(
                      '$matches', '$pos = strripos($matches[0], get_bloginfo("url"));
            if (!$pos) {
                return str_ireplace(
                    "href=",
"rel=\"nofollow\" href=",
$matches[0]
);
            } else {
                return $matches[0];
            }'
              ), $content
      );

      return $content;
  }

  add_filter('the_content', 'overdid_nofollow');

  /**
   * No follow bookmarks
   *
   * Add rel=nofollow to all links created through the wordpress links system
   *
   * @since 1.0.0
   *
   */
  function overdid_nofollow_bookmarks($links)
  {

      foreach ($links as $link) {
          $link->link_rel = trim("nofollow $link->link_rel");
      }
      return $links;
  }

  add_filter('get_bookmarks', 'overdid_nofollow_bookmarks');

  /**
   * Customize the Comment display if the child theme wishes to
   *
   * @since 1.0.0
   */
  function overdid_comment($comment, $args, $depth)
  {
      $GLOBALS['comment'] = $comment;
      ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <div id="comment-<?php comment_ID(); ?>">
        <div class="reply">
            <?php
            comment_reply_link(
                    array_merge(
                            $args, array(
                        'depth' => $depth,
                        'max_depth' => $args['max_depth']
                            )
                    )
            );
            ?>

        </div>

        <div class="comment-author vcard">
            <?php
            echo get_avatar(
                    $comment, $size = '48', $default = '<path_to_url>'
            );
            printf(
                    '<cite class="fn">%s</cite>
                    <span class="says">says:</span>', get_comment_author_link()
            );
            ?>
        </div>

        <?php if ($comment->comment_approved == '0') : ?>
            <em>Your comment is awaiting moderation.</em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata">
            <a href="<?php
    echo htmlspecialchars(
            get_comment_link($comment->comment_ID)
    )
        ?>">
                   <?php
                   printf(
                           '%1$s at %2$s', get_comment_date(), get_comment_time()
                   );
                   ?>
            </a>
            <?php edit_comment_link('(Edit)'); ?>

        </div>

        <?php comment_text() ?>

    </div>
    <?php
}




/**
 * Displays the hours the business is open.
 * @param  boolean $short        True/False for Short/Long days of the week. Default is True (Short)
 * @param  string  $before       Text before the day. Default is "".
 * @param  string  $after        Text after the day. Default is a line break.
 * @param  boolean $combine_days Whether to combine the days if the times are the same. Does not work right now. Defaults to false.
 * @return void                  None.
 *
*/
function overdid_business_hours($short = true, $before = "", $after = "<br />", $combine_days = false) {

	// TODO: Make combine_days work.
	$business_hours = get_option('overdid-business-hours');
	$days_of_week = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	$short_days_of_week = array('Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun');

	$i = 0;
	foreach ($business_hours as $days) :
		if($days[0] !== 'Closed' && $days[1] !== 'Closed') :

			$days[0] = preg_replace("/:00/", "", $days[0]);
			$days[0] = preg_replace("/ /", "", $days[0]);
			$days[0] = strtolower($days[0]);
			$days[1] = preg_replace("/:00/", "", $days[1]);
			$days[1] = preg_replace("/ /", "", $days[1]);
			$days[1] = strtolower($days[1]);

			if($short == false)
				echo $before . $days_of_week[$i] . ": " . $days[0] . " - " . $days[1] . $after;
			else
				echo $before . $short_days_of_week[$i] . ": " . $days[0] . " - " . $days[1] . $after;

		endif; // if day does not equal Closed

		$i++;
	endforeach;
} // /overdid_business_hours()


