<div class="admin-bar col-12">
    <div class="container-fluid admin-bar-inner">
        <div class="row">
            <div class="col-md-10 admin">
            Hello, <?= $_SESSION['username']; ?>
                <a href="<?= root_url_private('index.php'); ?>">
                    Return to Dashboard
                </a>
            </div>
            <div class="col-md-2 logout">
                <a href="<?= root_url('logout.php'); ?>" class="button">Logout</a>
            </div>
        </div>
    </div>
</div>
<div class="col-12 nav-container admin">
    <div id="navigation" style="width: 100%;">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <?php $site->addNav(); ?>
            </div>
            <form id="search" action="search.php" method="GET" class="form-inline my-2 my-lg-0">
                <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
                <input id="type-search" class="search-term form-control mr-sm-2" type="search" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search">
                <button class="btn my-2 my-sm-0 btn-outline-secondary" type="submit">Search</button>
            </form>
            <div id="display"></div>
        </nav>
    </div>
</div>