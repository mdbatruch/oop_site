<?php
    
    require('initialize.php');

    require_once('init.php');

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if (empty($_SESSION)) {
        header('Location: cart.php');
    }
    // if ($count == 0 ) {

    //     echo $count;
    //     // header('Location: cart.php');
    // }

    $product = new Product($db);
    // $product_image = new ProductImage($db);
    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        // echo '<pre>';
        // print_r($_SESSION);

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

        if ($count == 0) {
            header('Location: cart.php');
        }

    } else {
        $count = 0;
        $items = null;
    }

    // echo '<pre>';
    // print_r($products);

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $db); ?>
        </div>
    </div>
</header>
<main id="cart">
<div class="container-fluid">
        <div class="row">
            <div class="col min-12 text-right">
                <a href="<?= root_url('cart.php'); ?>"><< Return to Cart</a>
            </div>
        </div>
        <div class="row">
        <div id="form-message"></div>
            <div class="col-md-8">
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
            <?php 

            if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && empty($products)) {
                    // if ($cart_count < 1 ) {
                        echo "<div class='col-md-12'>";
                            echo "<div class='alert alert-danger'>";
                                echo "No products found in your cart!";
                            echo "</div>";
                        echo "</div>";
                    // }
            } else if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && !empty($products)) {
                ?>
                <div class="col min-12 col-md-4">
                    <div class="cart-container">
                    <h4>Cart Summary</h4>
                        <table class="cart-summary">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                        <?php
                            foreach ($products as $product) {
                                $price = substr($product['price'], 1) * $product['quantity']; ?>
                            <tr class='product col col-sm-12 my-2' data-id='<?= $product['id'] ?>' >
                                <td>
                                    <a class="product-name" href="<?= root_url('product.php?id=' . $product["id"]); ?>">
                                        <?= $product['name']; ?>
                                    </a>
                                </td>
                                <td><span class='product-quantity'><?= $product['quantity'] ?></span></td>
                                <td>$<span class='price'><?= $price; ?></span></td>
                            </tr>
                    <?php   } ?>
                    </table>
                    <div class="quantity-total">
                        <div class="col min-12 subtotal pl-0">
                            Sub Total
                            <span id="sub-total"></span>
                        </div>
                        <div class="col min-12 hst-total pl-0">
                            HST (13%)
                            <span id="hst-total"></span>
                        </div>
                        <div class="col min-12 total pl-0">
                            Total
                            <span id="total"></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else {
                ?>
                <div class='col-md-12'>
                    <div class='alert alert-danger'>
                        Your Cart is empty, please sign in or register
                    </div>
                </div>
        <?php  } ?>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>

<script>
"use strict";
    (function ($) {
            evaluateSubTotal();
            calculateHST();
            orderTotal();
    })(jQuery);
</script>

<script type="text/javascript">

    $("#order").submit(function(e){
        e.preventDefault();

        // alert('order-submitted');

        // var valid = cardValidation();

        // if(valid == true) {
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

            // this
            // stripeResponseHandler(0,0);

            //submit from callback
            return false;

        // } else {
        //     console.log('its not');
        // }

        // console.log(first_name, last_name, phone, email);

        // stripePay(event);

    });
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
// function cardValidation () {
//     var valid = true;
//     var name = $('#name').val();
//     var email = $('#email').val();
//     var cardNumber = $('#card-number').val();
//     var month = $('#month').val();
//     var year = $('#year').val();
//     var cvc = $('#cvc').val();

//     $("#error-message").html("").hide();

//     if (name.trim() == "") {
//         valid = false;
//     }
//     if (email.trim() == "") {
//     	   valid = false;
//     }
//     if (cardNumber.trim() == "") {
//     	   valid = false;
//     }

//     if (month.trim() == "") {
//     	    valid = false;
//     }
//     if (year.trim() == "") {
//         valid = false;
//     }
//     if (cvc.trim() == "") {
//         valid = false;
//     }

//     if(valid == false) {
//         $("#error-message").html("All Fields are required").show();
//     }

//     return valid;
// }

//set your publishable key
Stripe.setPublishableKey("<?= $stripe['public_key']; ?>");

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        //enable the submit button
        console.log('bleh');
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

        var card_type = $('.step-3 .payment-confirm span').text();

        if (card_type == '002') {
            var card = 'MasterCard';
        } else if (card_type == '001') {
            var card = 'VISA';
        } else {
            var card = '';
        }

        var card_details = {
            card_type: card,
            card_hash: $('.step-3 .card-number-confirm span').text()
        }

        var amount = $('#total').text();

        var order = getCheckoutItems();

        console.log(id, customer_id, contact_details, delivery_address, card_details, order, amount, token);

        $.ajax({
                type: "POST",
                url: "private/process.php",
                async: false,
                data: {id, customer_id, contact_details, delivery_address, card_details, order, amount, token},
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