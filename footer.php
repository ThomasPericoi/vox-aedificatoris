    </main>

    <?php
    $footer_name = get_field('footer_name', 'options');
    $footer_email = get_field('footer_email', 'options');
    $footer_phone = get_field('footer_phone', 'options');
    $footer_copyright = get_field('footer_copyright', 'options');

    $menu_locations = get_nav_menu_locations();
    $footer_menu_1 = !empty($menu_locations['menu-footer-1']) ? wp_get_nav_menu_object($menu_locations['menu-footer-1']) : false;
    $footer_menu_2 = !empty($menu_locations['menu-footer-2']) ? wp_get_nav_menu_object($menu_locations['menu-footer-2']) : false;

    $footer_has_identity = has_custom_logo() || $footer_name || $footer_email || $footer_phone;
    $footer_has_columns = $footer_has_identity || $footer_menu_1 || $footer_menu_2;
    $footer_has_content = $footer_has_columns || $footer_copyright;
    ?>

    <?php if ($footer_has_content) : ?>
        <!-- Footer -->
        <footer id="footer">
            <div id="main-footer">
                <div class="container container-lg">
                    <?php if ($footer_has_columns) : ?>
                        <div class="footer-content">
                            <?php if ($footer_has_identity) : ?>
                                <div class="footer-identity">
                                    <?php if (function_exists('the_custom_logo') && has_custom_logo()) : ?>
                                        <div class="footer-logo">
                                            <?php the_custom_logo(); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($footer_name || $footer_email || $footer_phone) : ?>
                                        <address class="footer-contact">
                                            <?php if ($footer_name) : ?>
                                                <span><?= esc_html($footer_name); ?></span>
                                            <?php endif; ?>
                                            <?php if ($footer_email) : ?>
                                                <a href="mailto:<?= esc_attr(sanitize_email($footer_email)); ?>"><?= esc_html($footer_email); ?></a>
                                            <?php endif; ?>
                                            <?php if ($footer_phone) : ?>
                                                <a href="tel:<?= esc_attr(preg_replace('/[^0-9+]/', '', $footer_phone)); ?>"><?= esc_html($footer_phone); ?></a>
                                            <?php endif; ?>
                                        </address>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($footer_menu_1) : ?>
                                <div class="footer-menu">
                                    <h2 class="footer-title"><?= esc_html($footer_menu_1->name); ?></h2>
                                    <nav aria-label="<?= esc_attr($footer_menu_1->name); ?>">
                                        <?php wp_nav_menu(array('theme_location' => 'menu-footer-1', 'menu_class' => 'menu menu-footer', 'container' => false, 'depth' => 1)); ?>
                                    </nav>
                                </div>
                            <?php endif; ?>

                            <?php if ($footer_menu_2) : ?>
                                <div class="footer-menu">
                                    <h2 class="footer-title"><?= esc_html($footer_menu_2->name); ?></h2>
                                    <nav aria-label="<?= esc_attr($footer_menu_2->name); ?>">
                                        <?php wp_nav_menu(array('theme_location' => 'menu-footer-2', 'menu_class' => 'menu menu-footer', 'container' => false, 'depth' => 1)); ?>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($footer_copyright) : ?>
                        <div class="footer-copyright">
                            <p><?= esc_html(wp_date('Y')); ?> <?= esc_html($footer_copyright); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </footer>
    <?php endif; ?>

    <?php wp_footer(); ?>
    </body>

    </html>
