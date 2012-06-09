<?php
/**
 * Footer Display Template
 *
 *
 * @package Wordpress
 * @since 1.0.0
 */
?>
<div class="clear"></div>
</div>	<!-- End Content -->
<div id="footer-wrap" class="">
    <div id="footer" class="full">
        <div class="footer-column quarter alignleft">
            <ul>
                <?php if (
                    !function_exists('dynamic_sidebar') ||
                        !dynamic_sidebar('Footer Area #1')
                ) : ?>
                <?php endif;?>
            </ul>
            <ul>
                <?php if (
                    !function_exists('dynamic_sidebar') ||
                        !dynamic_sidebar('Footer Area #3')
                ) : ?>
                <?php endif;?>
            </ul>
        </div>

        <div class="footer-column half alignleft">
            <ul>
                 <?php if (
                    !function_exists('dynamic_sidebar') ||
                        !dynamic_sidebar('Footer Area #2')
                ) :?>
                <?php endif;?>
            </ul>
            <ul>
                <?php if (
                    !function_exists('dynamic_sidebar') ||
                        !dynamic_sidebar('Footer Area #4')
                ) : ?>
                <?php endif;?>
            </ul>
        </div>

        <div class="info quarter alignleft">
            <a href="<?php bloginfo('url'); ?>">
                <img src="<?php esc_attr_e(get_option('overdid-footer-logo'));?>"
                    alt="<?php esc_attr_e(get_option('overdid-company-name'));?>" />
            </a>

            <div class="vcard">

                <div class="org">
                    <?php esc_attr_e(get_option('overdid-company-name'));?>
                </div>

                <div class="adr">
                    <div class="street-address">
                        <?php esc_attr_e(get_option('overdid-street'));?>
                    </div>
                    <span class="locality">
                        <?php esc_attr_e(get_option('overdid-city'));?>
                    </span>,&nbsp;
                    <span class="region">
                        <?php esc_attr_e(get_option('overdid-state'));?>
                    </span>,&nbsp;
                    <span class="postal-code">
                        <?php esc_attr_e(get_option('overdid-zip'));?>
                    </span>&nbsp;
                    <span class="country-name">
                        <?php esc_attr_e(get_option('overdid-country'));?>
                    </span>
                </div>

                <div class="tel">
                    <?php esc_attr_e(get_option('overdid-primary-number'));?>
                </div>

            </div>

            <p>&copy; <?php echo date("Y"); ?></p>


        </div>

    </div>

</div>

</div><!-- End Wrapper -->

<?php wp_footer(); ?>

</body>
</html>
