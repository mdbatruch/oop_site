function evaluateSubTotal() {
    var product = $('.product');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.price').html();

        total += parseFloat(item_total)

        // alert(total);
    });

    $('#sub-total').text('$' + total);
}

function evaluateCartCount() {
    var product = $('.product');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.product-quantity').html();

        total += parseFloat(item_total)

        // alert(total);
    });

    $('.cart-count').text('(' + total + ')');
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

        var item_quantity = $(this).find('.product-quantity').html();
        var item_name = $(this).find('.product-name').html().trim();
        var item_price = $(this).find('.price').html();

            order_item.item_name = item_name;
            order_item.item_quantity = item_quantity;
            order_item.item_price = item_price;

        
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