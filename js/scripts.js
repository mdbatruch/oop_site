function evaluateSubTotal() {
    var product = $('.product-name');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.price').html();

        total += parseFloat(item_total)

        // alert(total);
    });

    $('#sub-total').text('$' + total);
}

function evaluateCartCount() {
    var product = $('.product-name');
    var total = 0;
    $.each(product , function(index, val) { 
        var item_total = $(this).find('.product-quantity').html();

        total += parseFloat(item_total)

        // alert(total);
    });

    $('.cart-count').text('(' + total + ')');
    $('.cart-count-bottom').text(total);
}