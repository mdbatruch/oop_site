<?php
    
    require('initialize.php');

    require_once('init.php');

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if (empty($_SESSION)) {
        header('Location: cart');
    } else if ($_SESSION['account'] == 'Administrator') {
        header('Location: index.php');
    }

    $product = new Product($db);

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);

            $subtotal = '';
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

        if ($count == 0) {
            header('Location: cart');
        }

    } else {
        $count = 0;
        $items = null;
    }

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $subtotal, $db); ?>
        </div>
    </div>
</header>
<main id="cart-checkout">
    <div class="container-fluid">
        <div class="row">
        <div id="form-message"></div>
            <div class="col-md-8">
                <div class="col min-12 medium-4 text-right return-to-cart">
                    <a href="<?= root_url('cart'); ?>" class="btn btn-black mx-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                        </svg> 
                        Return to Cart
                    </a>
                </div>
            <div id="stripe-public" data-public-key="<?= $stripe['public_key']; ?>"></div>
            
            <?php $site->addCheckoutForm(); ?>

            <?php $on = false; if ($on) :?>
            <?php if(!empty($successMessage)) { ?>
            <div id="success-message"><?php echo $successMessage; ?></div>
            <?php  } ?>
            <div id="error-message"></div>

            <form id="charge" action="process.php" method="post">
            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="<?= $stripe['public_key']; ?>"
                    data-description="Access for a year"
                    data-amount="15000"
                    data-locale="auto"></script>
            </form>
            <?php if(!empty($successMessage)) { ?>
                <div id="success-message"><?php echo $successMessage; ?></div>
            <?php  } ?>
                <div id="error-message"></div>

                <form id="order" action="process.php" method="post">
                    <div class="field-row">
                        <label>Card Holder Name</label> <span id="card-holder-name-info"
                            class="info"></span><br> <input type="text" id="name"
                            name="name" class="demoInputBox">
                    </div>
                    <div class="field-row">
                        <label>Email</label> <span id="email-info" class="info"></span><br>
                        <input type="text" id="email" name="email" class="demoInputBox">
                    </div>
                    <div class="field-row">
                        <label>Card Number</label> <span id="card-number-info"
                            class="info"></span><br> <input type="text" id="card-number"
                            name="card-number" class="demoInputBox">
                    </div>
                    <div class="field-row">
                        <div class="contact-row column-right">
                            <label>Expiry Month / Year</label> <span id="userEmail-info"
                                class="info"></span><br> <select name="month" id="month"
                                class="demoSelectBox">
                                <option value="08">08</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select> <select name="year" id="year"
                                class="demoSelectBox">
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                                <option value="24">2024</option>
                                <option value="25">2025</option>
                                <option value="26">2026</option>
                                <option value="27">2027</option>
                                <option value="28">2028</option>
                                <option value="29">2029</option>
                                <option value="30">2030</option>
                            </select>
                        </div>
                        <div class="contact-row cvv-box">
                            <label>CVC</label> <span id="cvv-info" class="info"></span><br>
                            <input type="text" name="cvc" id="cvc"
                                class="demoInputBox cvv-input">
                        </div>
                    </div>
                    <div>
                        <input type="submit" name="pay_now" value="Submit"
                            id="submit-btn" class="btnAction"
                            >

                        <div id="loader">
                            <img alt="loader" src="LoaderIcon.gif">
                        </div>
                    </div>
                    <input type='hidden' name='amount' value='0.5'> <input type='hidden'
                        name='currency_code' value='USD'> <input type='hidden'
                        name='item_name' value='Test Product'> <input type='hidden'
                        name='item_number' value='PHPPOTEG#1'>
                </form>
            <?php endif; ?>
        </div>
            <?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && !empty($products)) {
                ?>
                <div class="col min-12 col-md-4 bg-light main-cart-container">
                    <div class="cart-container my-4">
                        <div class="cart-summary-title">
                            <h4>Order Summary</h4> <div id="item-total"></div>
                        </div>
                        <div class="cart-summary">
                            <?php
                                foreach ($products as $product) {
                                    $price = substr($product['price'], 1) * $product['quantity']; ?>

                                    <div class="product d-flex">
                                        <div class="img-container">
                                            <img src="<?= root_url('images/' . $product['image']); ?>" alt="" class="img-fluid">
                                        </div>
                                        <div class="product-order-info px-4" data-id="<?= $product['id']; ?>">
                                            <a class="product-name" href="<?= root_url('product?id=' . $product["id"]); ?>">
                                                <?= $product['name']; ?>
                                            </a>
                                            <div class="product-price d-none"><?= $product['price'] ?></div>
                                            <div class="quantity-container">
                                                QTY: <span class='product-quantity'><?= $product['quantity'] ?></span>
                                            </div>
                                            <div class="price-container">
                                                <span class="dollar-sign">$</span><span class='price'><?= $price; ?></span>
                                            </div>
                                        </div>
                                    </div>
                            <?php   } ?>
                        </div>
                    <div class="quantity-total d-flex">
                        <div class="subtotal pl-0 d-flex">
                            Subtotal
                            <span id="sub-total"></span>
                        </div>
                        <div class="hst-total pl-0 d-flex">
                            HST 13%
                            <span id="hst-total"></span>
                        </div>
                        <div class="total pl-0 d-flex">
                            Total
                            <span id="total"></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else {
                $site->addEmptyCart();
            } ?>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>

<script>
"use strict";
    (function ($) {
            evaluateSubTotal();
            calculateHST();
            orderTotal();
            toggleCartMenu();
    })(jQuery);
</script>

<script type="text/javascript">

    $("#order").submit(function(e){
        e.preventDefault();

            console.log('processing order');

            $("#submit-btn").hide();
            $('input:button.previous').hide();
            $("#loader").show();
            $( "#loader" ).css("display", "inline-block");
            Stripe.createToken({
                number: $('#card-number').val(),
                cvc: $('#cvc').val(),
                exp_month: $('#month').val(),
                exp_year: $('#year').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;

    });
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>

//set your publishable key
Stripe.setPublishableKey("<?= $stripe['public_key']; ?>");

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        //enable the submit button
        $("#submit-btn").show();
        $( "#loader" ).css("display", "none");
        //display the errors on the form
        $("#error-message").html(response.error.message).show();
    } else {

        //get token id
        var token = response['id'];

        //insert the token into the form
        $("#order").append("<input type='hidden' name='token' value='" + token + "' />");

        console.log(response);

        var id = 'order';

        var customer_id = $('.customer').attr('id');

        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();

        var contact_details = {
            name: first_name + " " + last_name,
            phone: $('#phone').val(),
            email: $('#email').val()
        }

        var delivery_address = {
            street: $('#street').val(),
            suite: $('#suite').val(),
            city: $('#city').val(),
            province: $('#province').val(),
            postal: $('#postal').val()
        }

        var billing_address = {
            street: $('#billing-address').val(),
            suite: $('#billing-suite').val(),
            city: $('#billing-town').val(),
            province: $('#billing-province').val(),
            postal: $('#billing-postal').val()
        }

        var option_name = $('#shipping-option .active span.shipping-name').text();
        var option_price = $('#shipping-option .active div.shipping-price').text();
        var option = $('#shipping-option .active span.option-description').text();
        var option_clean = $.trim(option);

        var notes = $('#order-notes').val();

        if (notes == '') {
            var notes = 'None';
        } else {
            var notes = $('#order-notes').val();
        }

        var shipping_information = {
            name: option_name,
            option: option_clean,
            price: option_price,
            order_info: notes,
        }

        var subtotal = $('#sub-total').text();
        var hst = $('#hst-total').text();

        var taxes_subtotals = {
            subtotal: subtotal,
            hst: hst,
        }

        var card_type = $('.step-3 .payment-confirm span').text();

        // if (card_type == '002') {
        //     var card = 'MasterCard';
        // } else if (card_type == '001') {
        //     var card = 'VISA';
        // } else {
        //     var card = '';
        // }

        var expiry = $('#month').val() + '/' + $('#year').val();

        var card_details = {
            card_name: $('#card-holder-name').val(),
            card_expiry: expiry,
            card_type: card_type,
            card_hash: $('.step-3 .card-number-confirm span').text()
        }

        var amount = $('#total').text();

        var order = getCheckoutItems();

        console.log(id, customer_id, contact_details, delivery_address, billing_address, shipping_information, card_details, order, taxes_subtotals, amount, token);

        $.ajax({
                type: "POST",
                url: "private/process.php",
                async: false,
                data: {id, customer_id, contact_details, delivery_address, billing_address, shipping_information, card_details, order, taxes_subtotals, amount, token},
            }).done(function(data){
                console.log(data);
                // console.log(data.order);
                // let order_num = parseFloat(data);
                window.location.href = 'confirmation.php?order=' + data;
            
        });

    }
}
function stripePay(e) {
    e.preventDefault();
    var valid = cardValidation();

    if(valid == true) {
        $("#submit-btn").hide();
        $( "#loader" ).css("display", "inline-block");
        Stripe.createToken({
            number: $('#card-number').val(),
            cvc: $('#cvc').val(),
            exp_month: $('#month').val(),
            exp_year: $('#year').val()
        }, stripeResponseHandler);

        //submit from callback
        return false;
    }
}
</script>