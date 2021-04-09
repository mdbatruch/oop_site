<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="<?php echo root_url('index.php'); ?>" class="button nav-link">Back to Homepage</a>
            </li>
            <?php
            if(!(basename($_SERVER["SCRIPT_FILENAME"]) == 'index.php')) : ?>
                <li class="nav-item">
                    <a href="<?php echo root_url_private('/customer/index.php?id=' . $_SESSION['id']); ?>" class="button nav-link">Back to Dashboard</a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a href="<?php echo root_url_private('/customer/orders.php?id=' . $_SESSION['id']); ?>" class="button nav-link">View Orders</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo root_url_private('/customer/profile.php?id=' . $_SESSION['id']); ?>" class="button nav-link">Edit Profile</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo root_url('logout.php'); ?>" class="button nav-link">Logout</a>
            </li>
        </ul>
    </div>
</nav>