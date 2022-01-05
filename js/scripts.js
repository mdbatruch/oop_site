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


function evaluateProductSubTotal(amount) {

    var current_subtotal = $('.cart-total').text();
    var newtotal = parseFloat(current_subtotal) + parseFloat(amount);

    $('.cart-total').text(newtotal);
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