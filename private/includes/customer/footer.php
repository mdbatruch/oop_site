<div class="container">
        <div class="row">
            <div class="col-lg-3 column logo">
                <img src="<?= root_url('images/CastleGames-White.png'); ?>" alt="Castle Games" class="img-fluid">
            </div>
            <div class="col-6 col-lg-2 column">
                <h4>Information</h4>
                <ul>
                    <li>
                        <a href="<?= root_url('about.php'); ?>">About Us</a>    
                    </li>
                    <li>
                        <a href="<?= root_url('news.php'); ?>">Our Collections</a>
                    </li>
                    <li>
                        <a href="<?= root_url('products.php'); ?>">Our Products</a>    
                    </li>
                    <li>
                        <a href="<?= root_url('news.php'); ?>">Latest News</a>
                    </li>
                    <li>
                        <a href="<?= root_url('contact.php'); ?>">Contact Us</a>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-lg-2 column">
                <h4>Useful Links</h4>
                <ul>
                    <li>
                        <a href="<?= root_url('faq.php'); ?>">Shopping FAQs</a>
                    </li>
                    <li>
                        <a href="<?= root_url('shipping.php'); ?>">Shipping</a>
                    </li>
                    <li>
                        <a href="<?= root_url('sitemap.php'); ?>">Our Sitemap</a>
                    </li>
                    <li>
                        <a href="<?= root_url('terms.php'); ?>">Terms of Use</a>
                    </li>
                    <li>
                        <a href="<?= root_url('privacy-policy.php'); ?>">Privacy Policy</a>  
                    </li>
                </ul>
            </div>
            <div class="col-lg-5 column">
                <h4>About Us</h4>
                <p>
                    Castle Games is an independent game store based in Toronto, Ontario.<br/>
                    We carry rare collectables and collections catered to all types of 
                    enthusiasts and hobbiests.<br/>
                    Got a question? E-mail our team at <a href="mailto:info@castlegames.com">info@castlegames.com</a>.
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

    <script src="js/2.d1644945.chunk.js"></script>
    <script src="js/main.4a4fc564.chunk.js"></script>

    <script type="text/javascript">
        
        toggleBodyandFormMessage();

        toggleCartMenu();

        toggleOrderList();

        toggleNav();

        $(".back-to-top").on("click", function(e) {

            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 'fast');

        });

        $("#customer-update").on("submit", function(e){

            e.preventDefault();

            var id = $(this).attr('id');
            var customer_id = $(this).attr('data-id');
            var username = $('#username').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var email = $('#email').val();
            var street = $('#street').val();
            var suite = $('#suite').val();
            var city = $('#city').val();
            var province = $('#province').val();
            var postal = $('#postal').val();
            var country = $('#country').val();

            var current_password = $('#current_password').val();
            var new_password = $('#new_password').val();
            var validate_password = $('#confirm_new_password').val();

            var address = {
                street: street,
                suite: suite,
                city: city,
                province: province,
                postal: postal,
                country: country
            }

            console.log(id, customer_id, username, first_name, last_name, email, street, suite, city, province, postal, country);

            $.ajax({
                type: "POST",
                url: "../../private/process.php",
                dataType: "json",
                data: {id: id, customer_id: customer_id, first_name: first_name, last_name: last_name, username: username, email: email, address: address, current_password: current_password, new_password: new_password, validate_password: validate_password},
            }).done(function(data){

            if (!data.success) {

                    if(data.errors.firstname) {
                        $('#first_name_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.firstname + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#first_name_warning').html('');
                            }

                    if(data.errors.lastname) {
                        $('#last_name_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.lastname + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#last_name_warning').html('');
                            }

                    if(data.errors.username) {
                        $('#username_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.username + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#username_warning').html('');
                            }

                    if(data.errors.email) {
                        $('#email_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.email + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#email_warning').html('');
                            }

                    if(data.errors.street) {
                        $('#street_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.street + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#street_warning').html('');
                            }

                    if(data.errors.city) {
                        $('#city_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.city + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#city_warning').html('');
                            }

                    if(data.errors.province) {
                        $('#province_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.province + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#province_warning').html('');
                            }

                    if(data.errors.postal) {
                        $('#postal_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.postal + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#postal_warning').html('');
                            }
                    
                    if(data.errors.country) {
                        $('#country_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.country + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#country_warning').html('');
                            }
                    
                    if(data.errors.current_password) {
                        $('#current_password_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.current_password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#current_password_warning').html('');
                            }

                    if(data.errors.validate_password) {
                        $('#password_validate_warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.validate_password + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                            } else {
                                $('#password_validate_warning').html('');
                            }

                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    console.log('Profile did not update!');

                } else {
                    
                    console.log('Profile updated!');

                    $('#form-message').html('<div class="alert alert-success"><img src="<?= root_url('uploads/check.png'); ?>" alt="success" class="img-fluid mb-2">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    $('.username').html(data.username);

                    if ($(window).width() < 991) {
                        $('body').addClass('no-scroll');
                    }
                }
            });

        });

        $(".remove-item-full-cart").on("click", function(e){
            e.preventDefault();

            console.log('an item deletion has been tried');
            
            var formId = $(this).attr('data-action');
            var product_id = $(this).attr('data-id');
            var cart_id = $('#cart_id').text().trim();
            var quantity = $(this).attr('data-quantity');

            var item_removal = $('#item-removal');
            var body = $('body');

            $(item_removal).addClass('d-block');

            console.log(formId, product_id, cart_id);

        $("#confirm-item-removal .cancel").on("click", function(e){
                e.preventDefault();

                e.stopPropagation();

            $(item_removal).removeClass('d-block');
        });

    
        $("#confirm-item-removal .confirm").on("click", function(e){

            e.preventDefault();
            
            e.stopPropagation();

            $(item_removal).removeClass('d-block');

            $.ajax({
                type: "POST",
                url: "../../private/process.php",
                dataType: "json",
                data: {product_id:product_id, id:formId, cart_id: cart_id},
            }).done(function(data){

            if (!data.success) {

                    $('#cart-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');

                    console.log('Item did not delete!');

                } else {
                    
                    console.log('Item deleted!');

                    $('#slider-cart-message-' + data.id).html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');
                    
                    $('.cart-product[data-id="' + data.id + '"]').remove();

                    $('#cart .product[data-id="' + data.id + '"]').remove();

                    evaluateSliderCartCount();

                    evaluateSliderSubTotal();

                    // reevaluate sub total and cart count
                    evaluateSliderCartSubTotal();

                    setTimeout(function() {
                        $('#slider-cart-message-' + data.id).remove();
                    }, 2000);

                }
            });

        });

    });

    </script>
    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:8890/browser-sync/browser-sync-client.js?v=2.26.7'><\/script>".replace("HOST", location.hostname));
        //]]></script>
    </body>
</html>