<div class="container-fluid category-search text-white">
    <?php if (isset($_GET['category'])) : ?>
        <div class="row">
            <div class="d-flex justify-content-center py-4">
                <h4>
                    Results for <?= ucwords($_GET['category']); ?>
                </h4>
                <div id="root"></div>
            </div>
        </div>
    <?php endif; ?>
</div>