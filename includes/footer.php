    
    <script src="<?php echo root_url('js/lightbox-plus-jquery.min.js'); ?>"></script>
    <script src="<?php echo root_url('js/bootstrap.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type="text/javascript">

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

            var formId = $('form').attr('id');
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

                        $('#contact-form').trigger("reset");
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

                            $('#login-username-error').html('');
                            $('#login-password-error').html('');

                            $('#login-form-message').html('<div class="alert alert-success">' + data.message + '</div>');

                            $(location).attr('href', data.redirect);

                        }
                });

            });

            // add products on product page
            $('.add-cart-products').click(function(e){

                var user_id = $('.customer').attr('id');
                var cart_id = $('#cart_id').html();
                var id = $(this).attr('data-action');
                var image = $(this).parent().parent().siblings('.img-container').find('.img-thumbnail').attr('src').split("/");

                var product = {
                    id: $(this).attr('data-id'),
                    name: $(this).parent().siblings('.product-link').find('.name').text().replace(/\s+/g, ' ').trim(),
                    description: $(this).parent().siblings('.description').text().replace(/\s+/g, ' ').trim(),
                    image: image[image.length - 1],
                    price: $(this).parent().siblings('.price').text().replace(/\s+/g, ' ').trim(),
                }
                
                console.log(id, user_id, cart_id, product);

                $.ajax({
                        type: "POST",
                        url: "private/process.php",
                        dataType: "json",
                        data: {id: id, user_id: user_id, cart_id: cart_id, product: product},
                    }).done(function(data) {

                        if(!data.success) {

                                $('#cart-message-' + data.id).html('<div class="alert alert-danger mt-3 input-alert-error">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                            } else {

                                $('#cart-message-' + data.id).html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                                // if (data.new_item) {
                                    // update cart count in header on browser side
                                    var cartText = $('.cart-count').text();
                                    var oldCount = cartText.slice(1,-1);

                                    var newCount = parseFloat(oldCount) + 1;
                                    var newCount = "(" + newCount + ")"; 

                                    $('.cart-count').text(newCount);
                                // } 
                                
                                // else {
                                //     $('.cart-count').text("(" + data.quantity + ")");
                                // }

                            }
                    });


            });

            $('#add-cart').click(function(e){

                e.preventDefault(); 

                console.log('cart addition has been attempted');

                var id = $(this).attr('id');
                var user_id = $('.customer').attr('id');
                var cart_id = $('#cart_id').html();
                var quantity = $('#quantity option:selected').text();
                var image = $('#product-image').attr('src').split("/");

                var product = {
                    id: $('#product-info').attr('data-id'),
                    name: $('#name').text(),
                    description: $('#description').text(),
                    image: image[image.length - 1],
                    price: $('#price').text(),
                }

                console.log(id, user_id, cart_id, product, quantity);

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

                                $('#cart-message').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.message + '</div>');

                            } else {

                                var cartText = $('.cart-count').text();
                                var oldCount = cartText.slice(1,-1);

                                var newCount = parseFloat(oldCount) + parseFloat(quantity);

                                var newCount = "(" + newCount + ")"; 

                                $('.cart-count').text(newCount);

                                $('#cart-message').html('<div class="alert alert-success">' + data.message + '</div>');

                            }
                    });
                }

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

                    $('.product-name[data-id="' + data.id + '"]').find('.product-quantity').text(data.quantity);
                    $('.product-name[data-id="' + data.id + '"]').find('.price').text(data.price);
                    $('.product-name[data-id="' + data.id + '"]').find('.remove-item').attr('data-quantity', data.quantity);
                    $('.product-name[data-id="' + data.id + '"]').find('.add-item').attr('data-quantity', data.quantity);

                    if(data.quantity == 0) {
                        $('.product-name[data-id="' + data.id + '"]').remove();
                    }

                    // reevaluate sub total and cart count

                    evaluateCartCount();

                    evaluateSubTotal();

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
                    
                    console.log('Item Addedd!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    $('.product-name[data-id="' + data.id + '"]').find('.product-quantity').text(data.quantity);
                    $('.product-name[data-id="' + data.id + '"]').find('.price').text(data.price);
                    $('.product-name[data-id="' + data.id + '"]').find('.remove-item').attr('data-quantity', data.quantity);
                    $('.product-name[data-id="' + data.id + '"]').find('.add-item').attr('data-quantity', data.quantity);

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
                    
                    $('.product-name[data-id="' + data.id + '"]').remove();

                    // reevaluate sub total and cart count

                    evaluateCartCount();

                    evaluateSubTotal();

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