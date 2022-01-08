<div class="breadcrumbs-container ms-2">
    <a href="<?= root_url('/'); ?>" >Home</a> / 
    <a href="<?= root_url('products.php'); ?>" ><?= $page; ?></a> / 
    <a href="<?= root_url('products.php?page=1&category=' . $product['category_name'] . ''); ?>" ><?= $product['category_name']; ?> </a> /
    <?php if ($product['name']) : ?> 
        <a href="<?= root_url('product.php?id=' . $product['id'] . ''); ?>" ><?= $product['name']; ?></a>
    <?php endif; ?>
</div>