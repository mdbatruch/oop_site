<div class="row-second bg-white">
    <div class="container d-flex">
        <div class="col-12 nav-container admin">
            <div id="navigation" class="d-flex h-100" style="width: 100%;">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <div id="nav-icon2">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <div class="close-button justify-content-end">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <?php $site->addNav(); ?>
                    </div>
                </nav>
            </div>
        </div>
        <div class="pt-2 pb-2 logo-container d-flex justify-content-center">
            <a href="<?= root_url('/'); ?>">
                <img src="<?= root_url('images/CastleGames.png'); ?>" alt="Castle Games" class="img-fluid">
            </a>
        </div>
        <div class="d-flex justify-content-end align-self-center cart">
            <div class="d-flex h-100">

            </div>
        </div>
        <div class="d-flex"></div>
    </div>
</div>