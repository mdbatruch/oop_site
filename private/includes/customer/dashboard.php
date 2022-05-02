<?php $page = basename($_SERVER['PHP_SELF'], '.php'); ?>

<div class="row customer-top justify-content-center py-4">
    <div class="col-12 col-md-9 my-4 text-center">
        <h3>Welcome back, <span class="username"><?= $_SESSION['username']; ?></span></h3>
        <div class="container-fluid link-container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <a href="<?php echo root_url_private('/customer/orders.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2 <?= $page == 'orders' ? 'active' : ''; ?>">View Past Orders</a>
                </div>
                <div class="col-12 col-lg-4">
                    <a href="<?php echo root_url_private('/customer/profile.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2 <?= $page == 'profile' ? 'active' : ''; ?>">Edit Profile</a>
                </div>
                <div class="col-12 col-lg-4">
                    <a href="<?= root_url('products.php'); ?>" class="btn btn-lightgrey py-3 my-2">Start Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>