<?php get_header(); ?>

<!-- Hero -->
<section id="error-404" class="hero hero-simple home-404">
    <div class="container container-sm">
        <h1><?= esc_html__('Page introuvable', 'vox-aedificatoris'); ?></h1>
        <p><?= esc_html__('Cette page n’existe pas ou a été déplacée.', 'vox-aedificatoris'); ?></p>
        <a href="<?= esc_url(home_url('/')); ?>"><?= esc_html__('Retour à l’accueil', 'vox-aedificatoris'); ?></a>
    </div>
</section>

<?php get_footer(); ?>
