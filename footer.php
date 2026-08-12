    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="container container-lg">
            <?php if (has_nav_menu('footer-submenu')) : ?>
                <nav aria-label="<?= esc_attr__('Navigation de pied de page', 'vox-aedificatoris'); ?>">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer-submenu',
                        'menu_class' => 'menu menu-footer',
                        'container' => false,
                        'depth' => 1,
                        'fallback_cb' => false,
                    )); ?>
                </nav>
            <?php endif; ?>
        </div>
    </footer>

    <?php wp_footer(); ?>
    </body>

    </html>
