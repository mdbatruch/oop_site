<div class="breadcrumbs-container ms-2">
    <a href="<?= root_url('/'); ?>" >Home</a> / 
    <a href="<?= root_url('products'); ?>" ><?= $page; ?></a>
    <?php if ($category) : ?>
        / <a href="<?= root_url('products?page=1&category=' . $category . ''); ?>" ><?= $category; ?> </a>
    <?php endif; ?>
</div>