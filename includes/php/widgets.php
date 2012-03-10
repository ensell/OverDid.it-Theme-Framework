<?php
/**
 * Expanded Widgets for theme
 *
 * @package WordPress
 * @since 1.0.0
 */

/**
 * Add Custom Widgets for use
 **/
add_action('widgets_init', 'ovd_load_widgets');

function ovd_load_widgets()
{
	register_widget('ovd_menu_widget');
}

class ovd_menu_widget extends WP_Widget
{

    function ovd_menu_widget()
    {
        $widgetOps = array(
            'classname' => 'ovd_menu',
            'description' => 'This widget extends the menu widget functionality'
        );
		$this->WP_Widget('ovd_menu', 'Overdid Custom Menu', $widgetOps);
	}

	function widget($args, $instance)
	{
        extract($args);

		// Get menu
		$ovdMenu = wp_get_nav_menu_object($instance['ovd_menu']);

		if (!$ovdMenu)
			return;

        $instance['title'] = apply_filters(
        	'widget_title',
            $instance['title'], $instance,
            $this->id_base
        );
        $link = $instance['link'];

		echo $before_widget;

		if (!empty($instance['title']))
            echo $before_title . "<a href='" . get_permalink($link) . "'>" .
                $instance['title'] . "</a>" . $after_title;

		wp_nav_menu(array('fallback_cb' => '', 'menu' => $ovdMenu ));

		echo $after_widget;
	}

	function update($newInstance, $oldInstance)
	{
        $instance['title'] = strip_tags(stripslashes($newInstance['title']));
        $instance['link'] = strip_tags(stripslashes($newInstance['link']));
		$instance['ovd_menu'] = (int) $newInstance['ovd_menu'];
		return $instance;
	}

	function form($instance)
	{
        $title      = isset($instance['title']) ? $instance['title'] : '';
        $link       = isset($instance['link']) ? $instance['link'] : '';
		$ovdMenu   = isset($instance['ovd_menu']) ? $instance['ovd_menu'] : '';
		$menus      = get_terms('nav_menu', array('hide_empty' => false));

		// If no menus exists, direct the user to go and create some.
		if (!$menus) {
            echo '<p>'. sprintf(
            	'No menus have been created yet. <a href="%s">Create some</a>.',
                admin_url('nav-menus.php')
            ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				Menu Title:
			</label>
			<input type="text" class="widefat"
				id="<?php echo $this->get_field_id('title'); ?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php echo $title; ?>"
			/>
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('link'); ?>">
				Menu Title Links To:
			</label>
            <?php
			$args = array(
			    'selected'			=> 0,
			    'echo'				=> 1,
			    'name'				=> $this->get_field_name('link'),
			    'selected'			=> $link,
				'show_option_none'	=> '-- Select Page --'
			);
			wp_dropdown_pages($args);
			?>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('ovd_menu'); ?>">
				Select Menu:
			</label>
            <select id="<?php echo $this->get_field_id('ovd_menu'); ?>"
            	name="<?php echo $this->get_field_name('ovd_menu'); ?>">
		    <?php
			foreach ( $menus as $menu ) {
				$selected = $ovdMenu == $menu->term_id ?
					' selected="selected"' : '';
                echo '<option' . $selected . ' value="' .
                    $menu->term_id . '">' . $menu->name . '</option>';
			}
		    ?>
			</select>
		</p>
		<?php
	}
}