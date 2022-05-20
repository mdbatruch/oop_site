<div class="breadcrumbs-container ms-2">
    <a href="<?= root_url('/'); ?>" >Home</a> / 
    <a href="<?= root_url('products'); ?>" ><?= $page; ?></a> / 
    <a href="<?= root_url('products?page=1&category=' . $product['category_name'] . ''); ?>" ><?= $product['category_name']; ?> </a> /
    <?php if ($product['name']) : ?> 
        <a href="<?= root_url('product?id=' . $product['id'] . ''); ?>" ><?= $product['name']; ?></a>
    <?php endif; ?>
</div>