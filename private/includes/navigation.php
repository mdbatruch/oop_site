<div id="admin-navigation">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="<?php echo root_url('index.php'); ?>" class="button nav-link">View Site</a>
                </li>
                <?php
                    if($title !== 'Dashboard') : ?>
                <li class="nav-item">
                    <a href="<?php echo root_url_private('index.php'); ?>" class="button nav-link">Dashboard</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?php echo root_url_private('pages/index.php'); ?>" class="button nav-link pr-0">Pages</a>
                    <a href="#" class="nav-link dropdown-toggle pl-0" data-toggle="dropdown"><a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item nav-item">
                            <a href="<?php echo root_url_private('pages/new.php'); ?>" class="button nav-link">Create Page</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo root_url_private('galleries/index.php'); ?>" class="button nav-link pr-0">Galleries</a>
                    <a href="#" class="nav-link dropdown-toggle pl-0" data-toggle="dropdown"><a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item nav-item">
                            <a href="<?php echo root_url_private('galleries/new.php'); ?>" class="button nav-link">Create Gallery</a>
                        </li>
                    </ul>
                </li class="nav-item">
                <li class="nav-item">
                    <a href="<?php echo root_url_private('navigation/index.php'); ?>" class="button nav-link">Navigation</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo root_url_private('orders/index.php'); ?>" class="button nav-link">Orders</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo root_url('logout.php'); ?>" class="button nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</div>