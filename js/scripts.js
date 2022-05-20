function evaluateSubTotal() {
    var product = $('.product');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.price').html();

        total += parseFloat(item_total)

        // alert(total);
    });

    $('#sub-total').text('$' + total);
    $('.cart-total').text(total);
}

function evaluateSliderSubTotal() {
    var product = $('.cart-product');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.price').html();

        var quantity = $(this).find('.product-quantity').html();

        var item_total_formatted = item_total.substring(1, item_total.length);

        total += quantity * parseFloat(item_total_formatted)

        // alert(total);
    });

    $('.cart-total').text(total);
}

function evaluateSliderCartSubTotal() {
    var product = $('.cart-product');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.price').html();
        var quantity = $(this).find('.product-quantity').html();
        var item_total_formatted = item_total.substring(1, item_total.length);

        var final_total = item_total_formatted * quantity;

        // console.log(final_total);

        total += parseFloat(final_total);

    });

    $('#cart-sub-total').text('$' + total);
}

function returnSidebarProduct(id, name, description, image, price, quantity, adjust) {

    var product = $('.cart-product');

    var adjust = adjust;

    var str;

    var exists;

    this.quantity = quantity;


    $.each(product , function(index, val) { 
        var existing_name = $(this).find('.name').html().trim();

        var quantity_container = $(this).find('.product-quantity');
        var existing_quantity = $(this).find('.product-quantity').html().trim();

        // console.log(quantity + 'preloop');

        var quantity = self.quantity || 1;

        // console.log(quantity + 'loop');

        // console.log(existing_name + " " + name);
        if (existing_name == name) {
            exists = true;

            if (adjust) {
                if (adjust == 'remove') {
                    var new_quantity = parseFloat(existing_quantity) - 1;
                } else if (adjust == 'add') {
                    var new_quantity = parseFloat(existing_quantity) + parseFloat(quantity);
                }

            } else {
                var new_quantity = parseFloat(existing_quantity) + parseFloat(quantity);
            }

            $(quantity_container).text(new_quantity);

            if (new_quantity == 0) {
                $(this).remove();
            }

            return false;
        } else {
            exists = false;
        }
    });

    if (!exists) {

        // console.log(quantity + 'general');
        // console.log(this.quantity + 'this');
        // console.log(self.quantity + 'self');

        var loc = window.location.pathname;
        var dir = loc.substring(0, loc.lastIndexOf('/'));

        str = `<div class="cart-product my-2 d-flex" data-id="` + id + `">
            <div class="img-container">
                <a href="` + window.location.origin + dir + `/product.php?id=` + id + `">
                    <img src="` + window.location.origin + dir + `/images/` + image + `" alt="" class="img-fluid">
                </a>
            </div>
            <div class="product-order-info px-4">
                <h5 class="name">` + name + `</h5>
                <div class="quantity-container">
                    <span class="product-quantity">` + quantity + `</span> x <span class="price">` + price + `</span>
                </div>
                <div class="delete-product-cart">
                    <button class="btn remove-item-full-cart" data-action="remove-item-full" data-id="` + id + `">
                        Remove
                    </button>
                </div>
            </div>
            </div>`;
        }

    return str;
}

function evaluateProductSubTotal(amount) {

    var current_subtotal = $('.cart-total').text();
    var current_sidebar_subtotal = $('#cart-sub-total').text();
    var newtotal = parseFloat(current_subtotal) + parseFloat(amount);

    $('.cart-total').text(newtotal);
    $('#cart-sub-total').text('$' + newtotal);
}

function evaluateCartCount() {
    var product = $('.product');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.product-quantity').html();

        total += parseFloat(item_total)

        // alert(total);
    });

    $('.cart-count').text(total);
    $('.cart-count-bottom').text(total);

}

function evaluateSliderCartCount() {
    var product = $('.cart-product');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.product-quantity').html();

        total += parseFloat(item_total)

        // alert(total);
    });

    $('.cart-count').text(total);
    $('.cart-count-bottom').text(total);

}

function calculateHST() {

    var product = $('.product');
    var total = 0;

    $.each(product , function(index, val) { 
        var item_total = $(this).find('.price').html();

        total += parseFloat(item_total)

    });
    
    var hst = total * .14;

    hst = (hst).toFixed(2);

    $('#hst-total').text('$' + hst);

}

function getCheckoutItems() {
    var product = $('.product');
    var total = 0;

    var order_items = [];

    $.each(product , function(index, val) { 

        var order_item = {};

        var item_id = $(this).find('.product-order-info').attr('data-id');
        var item_quantity = $(this).find('.product-quantity').html();
        var item_name = $(this).find('.product-name').html().trim();
        var item_individual_price = $(this).find('.product-price').html();
        var item_price = $(this).find('.price').html();

            order_item.item_id = item_id;
            order_item.item_name = item_name;
            order_item.item_quantity = item_quantity;
            order_item.item_price = item_price;
            order_item.item_individual_price = item_individual_price;

        
            order_items.push(order_item);
            
            // console.log(order_items);
    });

    return order_items;
}

function orderTotal() {

    var product = $('.product');
    var total = 0;
    
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.price').html();

        total += parseFloat(item_total)

    });
    
    var hst = total * .14;

    hst = (hst).toFixed(2);

    var finalTotal = parseFloat(total) + parseFloat(hst);

    $('#total').text('$' + finalTotal);

}

function toggleProductGalleryImages() {
    var image = $('.image-gallery img');
    var main = $('.image img');

    var carousel_item = $('.carousel-item');

    console.log(main);
    $.each(image, function(index, val) {
        
        var src = $(this).attr('src');

        // get the images order number
        var order = $(this).attr('data-order');

        console.log(src);

        // when you click on side image
        $(this).on('click', function(){
        
        // replace featured image
        $(main).attr('src', src);

        // add active opacity class
        $(this).addClass('active');

        $(this).siblings().removeClass('active');

        console.log(order);
           
           // loop through carousel items and find the carousel item with the same order number
           $.each(carousel_item, function(index, val) {
            
             var carousel_order = $(this).attr('data-order')

               console.log(carousel_order + ' carousel');
                if (carousel_order == order) {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');
                }
           });

        });

    });
}

function filterProductRange() {

    var $_GET = {};

        // get current url    
        if(document.location.toString().indexOf('?') !== -1) {
            var query = document.location
                        .toString()
                        // get the query string
                        .replace(/^.*?\?/, '')
                        // and remove any existing hash string
                        .replace(/#.*$/, '')
                        .split('&');

            for(var i=0, l=query.length; i<l; i++) {
            var aux = decodeURIComponent(query[i]).split('=');
            $_GET[aux[0]] = aux[1];
            }
        }
    
    var input = $('.price input[type="checkbox"]');

    $.each(input , function(index, val) {

        let value = $(this).attr('value');

        if ($_GET['range'] == $(this).attr('value')) {
            $(this).prop('checked', true);
        }
        
        $(this).on('click', function(){

            $('.price input:checkbox').not(this).prop('checked', false);

            window.location.href = 'products?range=' + value;
        });

    });
}

function toggleLoginRegistration() {
    var register_container = $('.register-container');
    var register = $('.register-option-button');
    var register_form = $('#customer-register');
    
    var login_container = $('.login-container');
    var login = $('.login-option-button');
    var login_form = $('#customer-login');

    $(register).on('click', function(e) {

        e.preventDefault();

        $(this).parents('.register-option').addClass('d-none');
        $(register_form).removeClass('d-none');
        $(register_form).addClass('d-flex');

        $(login_form).toggleClass('d-none');
        $(login).parents('.login-option').removeClass('d-none');
        $(login).parents('.login-option').addClass('d-flex order-2');
        
        if ($(window).width() < 767) {
            $(register_container).removeClass('order-2');
            $(login_container).addClass('order-2');
        }

        window.location.href = '#customer-register';
    });

    $(login).on('click', function(e) {

        e.preventDefault();

        $(this).parents('.login-option').addClass('d-none');
        $(login_form).removeClass('d-none');
        $(login_form).addClass('d-flex order-2');

        $(register_form).addClass('d-none');
        $(register).parents('.register-option').removeClass('d-none');
        $(register).parents('.register-option').addClass('d-flex order-2');

        if ($(window).width() < 767) {
            $(register_container).addClass('order-2');
            $(login_container).removeClass('order-2');
        }

        window.location.href = '#customer-login';
    });

    $(window).resize(function(){
        if ($(window).width() > 767) {
            $(login_container).removeClass('order-2');
            $(register_container).removeClass('order-2');
         }
    });
}

function toggleCartMenu() {
    var cart = $('.cart-toggle');
    var menu = $('.cart-menu');
    var close_button = $('.close-button');
    var body = $('body');

    $(cart).on('click', function(e) {
        e.preventDefault();
        $(menu).addClass('active');
        $(body).addClass('no-scroll');
        $(menu).removeClass('inactive');
        $(body).removeClass('scroll');
    });

    $(close_button).on('click', function(e) {
        $(menu).removeClass('active');
        $(menu).addClass('inactive');
        $(body).removeClass('no-scroll');
        $(body).addClass('scroll');
    });
}

function toggleBodyandFormMessage() {
    var body = $('body');

    $(body).on("click", function(e){

        if($(this).hasClass('no-scroll')) {
            $(body).removeClass('no-scroll');
            $('#form-message').html('');
            
        }    
    });
}

function toggleOrderBillingList() {

    var order = $('.order-pop');
    var billing = $('.billing-pop');
    var close = $('.close-button');
    var body = $('body');

    var order_products = $('.order-products');

    $(order).on("click", function(e){
        e.preventDefault();

        e.stopPropagation();

        let id = $(this).attr('data-id');
        console.log(id);

        $(body).addClass('no-scroll');

        $(this).siblings('.order-products').removeClass('d-none');
    });

    $(billing).on("click", function(e){
        e.preventDefault();

        e.stopPropagation();

        let id = $(this).attr('data-id');
        console.log(id);

        $(body).addClass('no-scroll');

        $(this).parent().siblings('.order-billing').removeClass('d-none');
    });

    $(close).on("click", function(e){
        e.preventDefault();

        e.stopPropagation();

        $(body).removeClass('no-scroll');

        $(this).closest('.order-products, .order-billing').addClass('d-none');
    });
}

function toggleNav() {

    var body = $('body');
    var close_button = $('.close-button');
    var icon = $('#nav-icon2');
    var navbar = $('.navbar-collapse');

    $('.navbar-toggler').click(function(){
		$(icon).addClass('open');
        $(body).addClass('no-scroll');
        $(body).removeClass('scroll');
	});

    $('.close-button').click(function(){
		$(icon).removeClass('open');
        $(body).removeClass('no-scroll');
        $(body).addClass('scroll');
        $(navbar).removeClass('show');
	});
}

function toggleCart() {

    var body = $('body');
    var cart = $('.cart');
    var cart_container = $('.main-cart-container');

    if ($(window).width() < 768) {

    $(cart).click(function(e){
        
        e.preventDefault();

		$(cart_container).addClass('show');
        $(body).addClass('no-scroll');
    });

    $(cart_container).click(function(e){
        
        e.preventDefault();

		$(cart_container).removeClass('show');
        $(body).removeClass('no-scroll');

    });
    }

}

function productTab() {

    var tab = $('.product-ind-meta');

    $(tab).children('h5').click(function(){
        $(this).children('.btn').toggleClass('greentext');
	});
}

function toggleFilter() {

    var filter = $('.filter-container');
    var toggle_filter = $('.toggle-filters');

    var price_container = $('price_container');
    var sort_container = $('.sort-container');

    var body = $('body');

    if ($(window).width() < 768) {

        $(filter).click(function(){

            $(toggle_filter).toggleClass('mobile-layout');
            $(this).find('a').toggleClass('greentext');
            $(this).find('svg').toggleClass('greentext');

            $(body).toggleClass('no-scroll');


        });

        $('.close-inner').click(function(){

            $(toggle_filter).toggleClass('mobile-layout');
            $(filter).find('a').toggleClass('greentext');
            $(filter).find('svg').toggleClass('greentext');

            $(body).toggleClass('no-scroll');

        });

        $('.price-container').click(function(){

            $(this).toggleClass('selected');

        });

        $('.sort-container').click(function(){

            $(this).toggleClass('selected');

        });

    }

    if ($(window).width() > 767) {
        $(toggle_filter).removeClass('mobile-layout');
    }

    $(window).on('resize', function(){
        if ($(window).width() > 767) {
            $(toggle_filter).removeClass('mobile-layout');

            $(filter).click(function(){

                $(toggle_filter).toggleClass('mobile-layout');
                $(this).find('a').toggleClass('greentext');
                $(this).find('svg').toggleClass('greentext');
    
                $(body).toggleClass('no-scroll');
    
    
            });
    
            $('.close-inner').click(function(){
    
                $(toggle_filter).toggleClass('mobile-layout');
                $(filter).find('a').toggleClass('greentext');
                $(filter).find('svg').toggleClass('greentext');
    
                $(body).toggleClass('no-scroll');
    
            });


            $('.price-container').click(function(){

                $(this).toggleClass('selected');

            });

            $('.sort-container').click(function(){

                $(this).toggleClass('selected');

            });
        }
    });
}

function toggleCategories() {

    var nav_header = $('.nav-link-header');
    var pill_container = $('.pill-container');

    var body = $('body');

    if ($(window).width() < 991) {

        $(nav_header).click(function(){

            $(pill_container).toggleClass('show');
            $(body).toggleClass('overlay');

        });
    }

    $(window).resize(function(){
        if ($(window).width() > 991) {
            $(nav_header).click(function(){

                $(pill_container).toggleClass('show');
                $(body).toggleClass('overlay');
    
            });
         }
    });
}