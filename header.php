<?php
/**
 * The template used to display the header
 *
 * @package Wordpress
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie7" <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 8]>
<html class="ie8" <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml">
<!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>;
				charset=<?php bloginfo('charset'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php
		wp_head();

			if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply');

			// add stylesheet links from functions.php
			overdid_stylesheet_import();
			?>

			<!--[if lt IE 9]>
			<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
			<![endif]-->

	</head>

	<body <?php body_class(); ?>>
		<div id="wrapper">
				<?php if (is_front_page()) : ?>
					<div id="header-wrap" class="header-wrap-home">
				<?php else: ?>
					<div id="header-wrap">
				<?php endif; ?>

					<div id="header" class="full">
						<div id="logo">
								<a href="<?php bloginfo('url'); ?>">
									<img src="<?php esc_attr_e(get_option('overdid-logo')); ?>"
											alt="<?php the_title(); ?>">
								</a>

						</div>

						<?php
						$imageId = get_post_thumbnail_id($post->ID);
						$header = get_post_meta($post->ID, 'header', true);
						$subHead = get_post_meta($post->ID, 'sub_head', true);
						$content = get_post_meta($post->ID, 'head_content', true);


						wp_nav_menu(
									array(
										'theme_location' => 'top-nav',
										'menu_class' => 'top-nav',
										'fallback_cb' => '',
									)
						);

						wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_class' => 'primary',
										'depth' => 2
									)
						);
						?>
						<div class="full header-banner" style="background:url(<?php
						echo wp_get_attachment_url($imageId); ?>) no-repeat;">
								<div class="banner-content">
								<?php if ($header) : ?>
										<h1 class="head-prehome"><?php echo $header; ?></h1>
									<?php endif;
									if ($subHead) : ?>
										<span class="head-home"><?php echo $subHead; ?></span>
									<?php endif;
									if ($content) : ?>
										<span class="head-content"><?php echo $content; ?></span>
									<?php endif; ?>

								</div>

						</div><!-- /.header-banner -->

					</div><!-- /#header -->

				</div><!-- /#header-wrap -->

				<div id="content" class="full">
