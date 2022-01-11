<div class="container">
        <div class="row">
            <div class="col-md-3 column">
                <img src="<?= root_url('images/CastleGames-White.png'); ?>" alt="Castle Games" class="img-fluid w-50">
            </div>
            <div class="col-md-2 column">
                <h4>Information</h4>
                <ul>
                    <li>About Us</li>
                    <li>Our Collections</li>
                    <li>Our Products</li>
                    <li>Latest News</li>
                    <li>Contact Us</li>
                </ul>
            </div>
            <div class="col-md-2 column">
                <h4>Useful Links</h4>
                <ul>
                    <li>Shopping FAQs</li>
                    <li>Shipping</li>
                    <li>Our Sitemap</li>
                    <li>Terms of Use</li>
                    <li>Privacy Policy</li>
                </ul>
            </div>
            <div class="col-md-5 column">
                <h4>About Us</h4>
                <p>
                    Castle Games is an independent game store based in Toronto, Ontario.
                    We carry rare collectables and collections catered to all types of 
                    enthusiasts and hobbiests.
                    Got a question? E-mail our team at info@castlegames.com.
                </p>
                <ul>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <a href="https://goo.gl/maps/Neruh461mF3iWz9p7">
                            <i class="fas fa-map-marker-alt"></i> 123 First Street, Toronto, ON M5V 2N1
                        </a>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        <a href="tel:+14168675309">(416) 867-5309</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <script src="<?php echo root_url('js/lightbox-plus-jquery.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script src="<?php echo root_url('js/bootstrap.js'); ?>"></script>
    <script src="<?php echo root_url('js/checkout.js'); ?>"></script>
    <script src="<?php echo root_url('js/carousel.js'); ?>"></script>

    <script type="text/javascript">

    // leave here for now for product page
    toggleProductGalleryImages();

    filterProductRange();

        $("#product-image").on("click", function(e) {

            e.preventDefault();
            $('#modal').modal('toggle');

        });

        $(".back-to-top").on("click", function(e) {

            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 'fast');

            });


        $("#clear-category").on("click", function(e){

            e.preventDefault();

            $url = window.location.href.split('?')[0];

            window.location.href = $url;
        });

        $(document).on("change","select#categories",function(){
            var category_list = $('#categories');
            
            $("option[value=" + this.value + "]", this)
                .attr("selected", true).siblings()
                .removeAttr("selected");

                var chosen = $(category_list).children('option:selected').text();

                console.log(chosen);

                if (window.location.href.indexOf("?category") > -1 || window.location.href.indexOf("?page") > -1) {

                    $url = window.location.href.split('?')[0];

                    window.location.href = $url + '?category=' + chosen;

                } else {
                    window.location.href = window.location.href + '?category=' + chosen;
                }

            });
        

        $("#login").on("submit", function(e){

            e.preventDefault();
    
            console.log('a login has been attempted');
    
            // function loginForm() {
    
                var formData = {
                    'username'         : $('input[name=username]').val(),
                    'password'         : $('input[name=password]').val(),
                    'id'               : $('form').attr('id')
                };
                // var username = $("#username").val();
                // var password = $("#password").val();

                console.log(formData);
    
                $.ajax({
                    type: "POST",
                    url: "private/process.php",
                    dataType: "json",
                    data: formData,
                }).done(function(data){
    
                    if (!data.success) {
    
                            if (data.errors.username) {
                                $('#username-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.username + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#username-error').html('');
                            }
    
                            if (data.errors.password) {
                                $('#password-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#password-error').html('');
                            }
                        
                            $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        
                            console.log('Login Not Successful!');
    
                        } else {
    
                            // $('.alert-danger').remove();
    
                            $(location).attr('href', data.redirect);
    
                            // window.location.replace(data.redirecturl);
    
                            // header('Location:' + data.redirecturl);
                            
                            console.log('Login Successful!');
                            // alert('Just got in!');
    
                            $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
    
                            // $('#login-form').trigger("reset");
                        }
                    
                });
    
            // }
            });

        $('#contact').submit(function(e){

            e.preventDefault(); 

            console.log('contact has been attempted');

            // var formId = $('form').attr('id');

            // hardcode form value to prevent overlap with search bar
            var formId = 'contact';
            var name = $('#name').val();
            var email = $('#email').val();
            var file_data = $('#attachment').prop('files')[0];
            var message = $('#message').val();

            var form_data = new FormData();

            form_data.append('id', formId);
            form_data.append('name', name);
            form_data.append('email', email);
            form_data.append('file', file_data);
            form_data.append('message', message);


            console.log(formId, name, email, file_data, message);

            $.ajax({
                type: "POST",
                url: "private/process.php",
                dataType: "json",
                contentType: false,
                processData: false,
                data: form_data,
            }).done(function(data) {

                if(!data.success) {
                    if(data.errors.name) {
                        $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#name-warning').html('');
                            }
                    
                    if(data.errors.email) {
                        $('#email-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.email + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#email-warning').html('');
                            }

                    if(data.errors.message) {
                        $('#message-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#message-warning').html('');
                            }

                        $('#form-message').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.notice + '</div>');

                    } else {

                        $('#name-warning').html('');
                        $('#email-warning').html('');
                        $('#message-warning').html('');

                        $('#form-message').html('<div class="alert alert-success">' + data.notice + '</div>');

                        $('#contact').trigger("reset");
                    }
            });
        });

        $('#customer-register').submit(function(e){

        e.preventDefault(); 

        console.log('customer register has been attempted');

        var id = $(this).attr('id');
        var first_name = $('#firstname').val();
        var last_name = $('#lastname').val();
        var email = $('#email').val();
        var address = $('#address').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var password_validate = $('#confirm-password').val();


        console.log(id, first_name, last_name, email, address, username);

        // data = {id:id, firstname: first_name, lastname: last_name, email: email, address: address, username: username};

        // console.log(data);

        if (password !== password_validate) {
            $('#confirm-password-error').html('<div class="alert alert-danger mt-3 input-alert-error">Passwords do not match, please try again<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        } else {
            $.ajax({
                type: "POST",
                url: "private/process.php",
                dataType: "json",
                data: {id:id, firstname: first_name, lastname: last_name, email: email, address: address, username: username, password: password},
            }).done(function(data) {

                if(!data.success) {
                    if(data.errors.firstname) {
                        $('#firstname-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.firstname + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#firstname-error').html('');
                            }

                    if(data.errors.lastname) {
                        $('#lastname-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.lastname + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#lastname-error').html('');
                            }
                    
                    if(data.errors.email) {
                        $('#email-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.email + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#email-error').html('');
                            }

                    if(data.errors.address) {
                        $('#address-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.address + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#address-error').html('');
                            }

                    if(data.errors.username) {
                        $('#username-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.username + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#username-error').html('');
                            }

                    if(data.errors.password) {
                        $('#password-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#password-error').html('');
                            }


                        $('#form-message').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.message + '</div>');

                    } else {

                        $('#firstname-error').html('');
                        $('#lastname-error').html('');
                        $('#email-error').html('');
                        $('#address-error').html('');
                        $('#username-error').html('');
                        $('#password-error').html('');
                        $('#confirm-password-error').html('');

                        $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                        $(location).attr('href', data.redirect);

                    }
            });
        }

        });

        $('#customer-login').submit(function(e){

            e.preventDefault(); 

            console.log('customer login has been attempted');

            var id = $(this).attr('id');
            var username = $('#login-username').val();
            var password = $('#login-password').val();


            // console.log(username);

                $.ajax({
                    type: "POST",
                    url: "private/process.php",
                    dataType: "json",
                    data: {id: id, username: username, password: password},
                }).done(function(data) {

                    if(!data.success) {

                        if(data.errors.username) {
                            $('#login-username-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.username + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                } else {
                                    $('#login-username-error').html('');
                                }

                        if(data.errors.password) {
                            $('#login-password-error').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                                } else {
                                    $('#login-password-error').html('');
                                }


                            $('#login-form-message').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.message + '</div>');

                        } else {

                            console.log(data);
                            console.log('success!')

                            $('#login-username-error').html('');
                            $('#login-password-error').html('');

                            $('#login-form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                            $(location).attr('href', data.redirect);

                        }
                });

            });

            // add products on product page
            $('.add-cart-products').click(function(e){

                var customer = true;
                var admin = false;

                var user_id = $('.customer').attr('id');
                var cart_id = $('#cart_id').html();
                var id = $(this).attr('data-action');
                var image = $(this).parent().parent().siblings('.img-container').find('.img-fluid').attr('src').split("/");

                var product_price_unformatted = $(this).parent().siblings('.price').attr('data-price');

                var product = {
                    id: $(this).attr('data-id'),
                    name: $(this).parent().siblings('.product-link').find('.name').text().replace(/\s+/g, ' ').trim(),
                    description: $(this).parent().siblings('.description').text().replace(/\s+/g, ' ').trim(),
                    image: image[image.length - 1],
                    price: $(this).parent().siblings('.price').text().replace(/\s+/g, ' ').trim(),
                }
                
                console.log(id, user_id, cart_id, product);

                if (user_id == 'no-customer') {
                    var customer = false;
                    
                    $('#cart-message-' + product.id).html('<div class="alert alert-danger mt-3 input-alert-error">You must register or login to add items to your cart!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    
                } else if (user_id == undefined) {
                    
                    var admin = true;

                    $('#cart-message-' + product.id).html('<div class="alert alert-danger mt-3 input-alert-error">Admins cannot add items to a cart. Create an account or login!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }

                if (customer || admin) {

                    $.ajax({
                            type: "POST",
                            url: "private/process.php",
                            dataType: "json",
                            data: {id: id, user_id: user_id, cart_id: cart_id, product: product},
                        }).done(function(data) {

                            if(!data.success) {

                                    $('#cart-message-' + data.id).html('<div class="alert alert-danger mt-3 input-alert-error">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                                } else {

                                    $('#cart-message-' + data.id).html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                                        // update cart count in header on browser side
                                        var cartText = $('.cart-count').text();

                                        var newCount = parseFloat(cartText) + 1;

                                        $('.cart-count').text(newCount);

                                }
                        });

                }

               evaluateProductSubTotal(product_price_unformatted);

            });

            $('#add-cart').click(function(e){

                e.preventDefault(); 

                console.log('cart addition has been attempted');

                var customer = true;
                var admin = false;

                var id = $(this).attr('id');
                var user_id = $('.customer').attr('id');
                var cart_id = $('#cart_id').html();
                var quantity = $('#quantity option:selected').text();
                var image = $('#product-image').attr('src').split("/");

                var product_price_unformatted = $('#price').attr('data-price');

                var product = {
                    id: $('#product-info').attr('data-id'),
                    name: $('#name').text(),
                    description: $('#description').text(),
                    image: image[image.length - 1],
                    price: $('#price').text(),
                }

                var amount = parseFloat(product_price_unformatted) *  parseFloat(quantity);

                console.log(product_price_unformatted);

                console.log(id, user_id, cart_id, product, quantity);

                if (user_id == 'no-customer') {
                    var customer = false;
                    
                    $('#cart-message').html('<div class="alert alert-danger mt-3 input-alert-error">You must register or login to add items to your cart!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    
                } else if (user_id == undefined) {
                    var customer = false;
                    var admin = true;

                    $('#cart-message').html('<div class="alert alert-danger mt-3 input-alert-error">Admins cannot add items to a cart. Create an account or login!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }

                if (!admin) {

                    if (customer) {

                        if (quantity == 0) {
                            $('#cart-message').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a Quantity!</div>');
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "private/process.php",
                                dataType: "json",
                                data: {id: id, user_id: user_id, cart_id: cart_id, product: product, quantity: quantity},
                            }).done(function(data) {

                                if(!data.success) {

                                        $('#cart-message').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                                    } else {

                                        var cartText = $('.cart-count').text();

                                        var newCount = parseFloat(cartText) + parseFloat(quantity);

                                        $('.cart-count').text(newCount);

                                        $('#cart-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                                    }
                            });
                        }
                    }
                }

                evaluateProductSubTotal(amount);

                });

        // $('#search').submit(function(e){

        //     e.preventDefault(); 

        //     console.log('a search has been attempted');

        //     var formId = $('form').attr('id');
        //     var term = $('.search-term').val();


        //     console.log(formId, term);

        //     $.ajax({
        //         type: "POST",
        //         url: "private/process.php",
        //         dataType: "json",
        //         data: {id: formId, term: term},
        //     }).done(function(data) {

        //         if(!data.success) {

        //                 $('#form-message').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.message + '</div>');

        //                 $(location).attr('href', data.redirect);

        //             } else {

        //                 $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');

        //                 $(location).attr('href', data.redirect);

        //             }
        //     });

        // });



        $(".remove-item").on("click", function(e){
        e.preventDefault();

        console.log('an item deletion has been tried');
            
            var formId = $(this).attr('data-action');
            var product_id = $(this).attr('data-id');
            var cart_id = $('#cart_id').text();
            var quantity = $(this).attr('data-quantity');

        console.log(formId, product_id, cart_id);

    
            $.ajax({
                type: "POST",
                url: "private/process.php",
                dataType: "json",
                data: {product_id:product_id, id:formId, cart_id: cart_id, quantity: quantity},
            }).done(function(data){

            if (!data.success) {

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    console.log('Item did not delete!');

                } else {
                    
                    console.log('Item deleted!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    $('.product[data-id="' + data.id + '"]').find('.product-quantity').text(data.quantity);
                    $('.product[data-id="' + data.id + '"]').find('.price').text(data.price);
                    $('.product[data-id="' + data.id + '"]').find('.remove-item').attr('data-quantity', data.quantity);
                    $('.product[data-id="' + data.id + '"]').find('.add-item').attr('data-quantity', data.quantity);

                    if(data.quantity == 0) {
                        $('.product[data-id="' + data.id + '"]').remove();
                    }

                    // reevaluate sub total and cart count

                    evaluateCartCount();

                    evaluateSubTotal();

                    if ($('.cart-count-bottom').text() == 0) {
                        window.location.href = 'cart.php';
                    }

                }
            
        });

    });

    $(".add-item").on("click", function(e){
        e.preventDefault();

        console.log('an item additon from the cart has been tried');
            
            var formId = $(this).attr('data-action');
            var product_id = $(this).attr('data-id');
            var cart_id = $('#cart_id').text();
            var quantity = $(this).attr('data-quantity');

        console.log(formId, product_id, cart_id, quantity);

    
            $.ajax({
                type: "POST",
                url: "private/process.php",
                dataType: "json",
                data: {product_id:product_id, id:formId, cart_id: cart_id, quantity: quantity},
            }).done(function(data){

            if (!data.success) {

                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    console.log('Item did not add!');

                } else {
                    
                    console.log('Item Added!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    $('.product[data-id="' + data.id + '"]').find('.product-quantity').text(data.quantity);
                    $('.product[data-id="' + data.id + '"]').find('.price').text(data.price);
                    $('.product[data-id="' + data.id + '"]').find('.remove-item').attr('data-quantity', data.quantity);
                    $('.product[data-id="' + data.id + '"]').find('.add-item').attr('data-quantity', data.quantity);

                    // reevaluate sub total and cart count

                    evaluateCartCount();

                    evaluateSubTotal();

                }
            
        });

    });

    $(".remove-item-full").on("click", function(e){
        e.preventDefault();

        console.log('an item deletion has been tried');
            
            var formId = $(this).attr('data-action');
            var product_id = $(this).attr('data-id');
            var cart_id = $('#cart_id').text();
            var quantity = $(this).attr('data-quantity');

        console.log(formId, product_id, cart_id);

    
            $.ajax({
                type: "POST",
                url: "private/process.php",
                dataType: "json",
                data: {product_id:product_id, id:formId, cart_id: cart_id},
            }).done(function(data){

            if (!data.success) {

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    console.log('Item did not delete!');

                } else {
                    
                    console.log('Item deleted!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');
                    
                    $('.product[data-id="' + data.id + '"]').remove();

                    // reevaluate sub total and cart count
                    evaluateCartCount();

                    evaluateSubTotal();

                    if ($('.cart-count-bottom').text() == 0) {
                        window.location.href = 'cart.php';
                    }

                }
            
        });

    });

    </script>
    <script src="js/2.d1644945.chunk.js"></script>
    <script src="js/main.4a4fc564.chunk.js"></script>
    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:8890/browser-sync/browser-sync-client.js?v=2.26.7'><\/script>".replace("HOST", location.hostname));
        //]]></script>
    </body>
</html>