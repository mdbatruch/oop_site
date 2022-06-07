<div class="row text-center justify-content-center featured-products">
    <h3 class="my-4 py-2">Featured Products</h3>
    <ul class="controls" id="customize-controls" aria-label="Carousel Navigation" tabindex="0">
        <li class="prev" data-controls="prev" aria-controls="customize" tabindex="-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
        </li>
        <li class="next" data-controls="next" aria-controls="customize" tabindex="-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>        
        </li>
    </ul>
    <div class="my-slider">
        <div class="col-md-6 col-xl-3">
            <div class="img-container">
                <img src="<?= root_url('images/fellowship.png'); ?>" alt="Fellowship" class="img-fluid">  
            </div>
            <div class="meta-container">
                <div class="mb-1">
                    <div data-id="13" data-action="add-featured-cart-products" class="add-featured-cart-products d-flex">
                        <div class="btn btn-primary btn-black cart-icon me-2 py-0 rounded-0">
                            Add to Cart
                        </div>
                        <div class="arrow-right"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-plus p-1" viewBox="0 0 16 16">
                            <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </div>
                    <a href="<?= root_url('images/fellowship.png'); ?>" data-lightbox="photos">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-zoom-in p-1 <?= $id; ?>" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z"/>
                            <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="featured-info product-link mt-2">
                    <a href="<?= root_url('product?id=67'); ?>" class='product-link title'>
                        <h4 class="name">The Fellowship of the Ring</h4>
                    </a>
                    <div class="description d-none"></div>
                </div>
                <div class="price" data-price="60">$60.00</div>
                <div id="cart-message-13"></div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="img-container">
                <img src="<?= root_url('images/balrog.jpg'); ?>" alt="Balrog" class="img-fluid">  
            </div>
            <div class="meta-container">
                <div class="mb-1">
                    <div data-id="48" data-action="add-featured-cart-products" class="add-featured-cart-products d-flex">
                        <div class="btn btn-primary btn-black cart-icon me-2 py-0 rounded-0">
                            Add to Cart
                        </div>
                        <div class="arrow-right"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-plus p-1" viewBox="0 0 16 16">
                            <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </div>
                    <a href="<?= root_url('images/Balrog.jpg'); ?>" data-lightbox="photos">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-zoom-in p-1 <?= $id; ?>" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z"/>
                            <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="featured-info product-link mt-2">
                    <a href="<?= root_url('product?id=48'); ?>" class='product-link title'>
                        <h4 class="name">The Balrog</h4>
                    </a>
                    <div class="description d-none"></div>
                </div>
                <div class="price" data-price="75">$75.00</div>
                <div id="cart-message-48"></div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="img-container">
                <img src="<?= root_url('images/battle.png'); ?>" alt="Pelennor Fields" class="img-fluid">
            </div>
            <div class="meta-container">
                <div class="mb-1">
                    <div data-id="68" data-action="add-featured-cart-products" class="add-featured-cart-products d-flex">
                        <div class="btn btn-primary btn-black cart-icon me-2 py-0 rounded-0">
                            Add to Cart
                        </div>
                        <div class="arrow-right"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-plus p-1" viewBox="0 0 16 16">
                            <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </div>
                    <a href="<?= root_url('images/battle.png'); ?>" data-lightbox="photos">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-zoom-in p-1 <?= $id; ?>" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z"/>
                            <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="featured-info product-link mt-2">
                    <a href="<?= root_url('product?id=68'); ?>" class='product-link title'>
                        <h4 class="name">Battle of Pelennor Fields</h4>
                    </a>
                    <div class="description d-none"></div>
                </div>
                <div class="price" data-price="190">$190.00</div>
                <div id="cart-message-68"></div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="img-container">
                <img src="<?= root_url('images/smaug.png'); ?>" alt="Smaug" class="img-fluid">  
            </div>
            <div class="meta-container">
                <div class="mb-1">
                    <div data-id="66" data-action="add-featured-cart-products" class="add-featured-cart-products d-flex">
                        <div class="btn btn-primary btn-black cart-icon me-2 py-0 rounded-0">
                            Add to Cart
                        </div>
                        <div class="arrow-right"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-plus p-1" viewBox="0 0 16 16">
                            <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </div>
                    <a href="<?= root_url('images/Smaug.png'); ?>" data-lightbox="photos">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-zoom-in p-1 <?= $id; ?>" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z"/>
                            <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                    </a>
                </div>
                <div class="featured-info product-link mt-2">
                    <a href="<?= root_url('product?id=66'); ?>" class='product-link title'>
                        <h4 class="name">Smaug</h4>
                    </a>
                    <div class="description d-none"></div>
                </div>
                <div class="price" data-price="670">$670.00</div>
                <div id="cart-message-66"></div>
            </div>
        </div>
    </div>
</div>