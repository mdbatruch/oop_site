"use strict";
    (function ($) {
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches
        var count = 1;

        $(".next").click(function(){

            var errors = [];

            var validEmailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            var validPhoneRegex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;

            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var street = $('#street').val();
            var suite = $('#suite').val();
            var city = $('#city').val();
            var province = $('#province').val();
            var postal = $('#postal').val();
            // var payment_method = $('#card-type-picker').val();
            var payment_method = $('#card-type-picker option:selected').text();
            var card_number_method = $('#card-number').val();
            var card_holder = $('#card-holder-name').val();
            var expiry_month = $('#month').val();
            var expiry_year = $('#year').val();
            var cvc = $('#cvc').val();
            var order_notes = $('#order-notes').val();
            var card_number_method_hide = 'XXXXXXXXXXXX' + card_number_method.slice(card_number_method.length - 4);
            var cart_total = $('#total').text();

            var billing_address = $('#billing-address').val();
            var billing_town = $('#billing-town').val();
            var billing_province = $('#billing-province option:selected').text();
            var billing_postal = $('#billing-postal').val();

            var shipping_option = $('#shipping-option').find('.form-field.active input').val();

            var name = $('.step-3 .name-confirm span');
            var phone_value = $('.step-3 .phone-confirm span');
            var email_value = $('.step-3 .email-confirm span');
            var street_value = $('.step-3 .street-confirm span');
            var suite_value = $('.step-3 .suite-confirm span');
            var city_value = $('.step-3 .city-confirm span');
            var province_value = $('.step-3 .province-confirm span');
            var postal_value = $('.step-3 .postal-confirm span');
            var card_number_value = $('.step-3 .card-number-confirm span');
            var payment_value = $('.step-3 .payment-confirm span');
            var order_notes_value = $('.step-3 .notes-confirm span');
            var payment_name_value = $('.step-3 .payment-name-confirm span');
            var expiry_date_value = $('.step-3 .expiry-date-confirm');
            var payment_address_value = $('.step-3 .payment-address-confirm span');
            var payment_town_value = $('.step-3 .payment-town-confirm span');
            var payment_province_value = $('.step-3 .payment-province-confirm span');
            var payment_postal_value = $('.step-3 .payment-postal-confirm span');

            var shipping_option_value = $('.step-3 .shipping-method-confirm span');

            var cart_value = $('.step-3 .amount-confirm span');
            
            if (first_name == '') {
                $('#first_name_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a First Name<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var first_valid = false;
                errors.push(first_valid);
            } else {
                $('#first_name_warning').html('');
                var first_valid = true;
                errors.push(first_valid);
            }

            if (last_name == '') {
                $('#last_name_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a Last Name<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var last_valid = false;
                errors.push(last_valid);
            } else {
                $('#last_name_warning').html('');
                var last_valid = true;
                errors.push(last_valid);
            }

            if (phone == '') {
                $('#phone_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a Phone Number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var phone_valid = false;
                errors.push(phone_valid);
            } else if (!phone.match(validPhoneRegex)) {
                $('#phone_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a valid Phone Number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var phone_valid = false;
                errors.push(phone_valid);
            } else {
                $('#phone_warning').html('');
                var phone_valid = true;
                errors.push(phone_valid);
            }

            if (email == '') {
                $('#email_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter an Email<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var email_valid = false;
                errors.push(email_valid);
            } else if (!email.match(validEmailRegex)) {
                $('#email_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a valid Email<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var email_valid = false;
                errors.push(email_valid);
            } else {
                $('#email_warning').html('');
                var email_valid = true;
                errors.push(email_valid);
            }

            if (street == '') {
                $('#street_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a Street Name and Number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var street_valid = false;
                errors.push(street_valid);
            } else {
                $('#street_warning').html('');
                var street_valid = true;
                errors.push(street_valid);
            }

            if (city == '') {
                $('#city_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a City<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var city_valid = false;
                errors.push(city_valid);
            } else {
                $('#city_warning').html('');
                var city_valid = true;
                errors.push(city_valid);
            }

            if (province == '') {
                $('#province_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please select a Province<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var province_valid = false;
                errors.push(province_valid);
            } else {
                $('#province_warning').html('');
                var province_valid = true;
                errors.push(province_valid);
            }

            if (postal == '') {
                $('#postal_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a Postal Code<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                var postal_valid = false;
                errors.push(postal_valid);
            } else {
                $('#postal_warning').html('');
                var postal_valid = true;
                errors.push(postal_valid);
            }

            // second step validation
            if (count == 2) {
                if (payment_method == 'Select a card type') {
                    $('#card_type_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please select a Card Type<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var method_valid = false;
                    errors.push(method_valid);
                } else {
                    $('#card_type_warning').html('');
                    var method_valid = true;
                    errors.push(method_valid);
                }

                if (billing_address == '') {
                    $('#billing_address_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter the Billing Address<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var billing_address_valid = false;
                    errors.push(billing_address_valid);
                } else {
                    $('#billing_address_warning').html('');
                    var billing_address_valid = true;
                    errors.push(billing_address_valid);
                }

                if (billing_town == '') {
                    $('#billing_town_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter the Billing City<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var billing_town_valid = false;
                    errors.push(billing_town_valid);
                } else {
                    $('#billing_town_warning').html('');
                    var billing_town_valid = true;
                    errors.push(billing_town_valid);
                }

                if (billing_province == '') {
                    $('#billing_province_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please select an option for the Billing Province<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var billing_province_valid = false;
                    errors.push(billing_province_valid);
                } else {
                    $('#billing_province_warning').html('');
                    var billing_province_valid = true;
                    errors.push(billing_province_valid);
                }

                if (billing_postal == '') {
                    $('#billing_postal_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter the Billing Postal Code<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var billing_postal_valid = false;
                    errors.push(billing_postal_valid);
                } else {
                    $('#billing_postal_warning').html('');
                    var billing_postal_valid = true;
                    errors.push(billing_postal_valid);
                }

                if (shipping_option == undefined) {
                    $('#shipping_option_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please select an option for Shipping<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var shipping_option_valid = false;
                    errors.push(shipping_option_valid);
                } else {
                    $('#shipping_option_warning').html('');
                    var shipping_option_valid = true;
                    errors.push(shipping_option_valid);
                }

                if (card_holder == '') {
                    $('#card_holder_name_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter the Card Holder Name<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var card_name_valid = false;
                    errors.push(card_name_valid);
                } else {
                    $('#card_holder_name_warning').html('');
                    var card_name_valid = true;
                    errors.push(card_name_valid);
                }

                if (card_number_method == '') {
                    $('#card_number_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a Card Number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var card_number_valid = false;
                    errors.push(card_number_valid);
                } else if (card_number_method.length != 16 || !/^[0-9]+$/.test(card_number_method)) {
                    $('#card_number_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a Valid Card Number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var card_number_valid = false;
                    errors.push(card_number_valid);
                } else {
                    $('#card_number_warning').html('');
                    var card_number_valid = true;
                    errors.push(card_number_valid);
                }

                if (cvc == '') {
                    $('#cvc_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a CVC number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var cvc_valid = false;
                    errors.push(cvc_valid);
                } else if (cvc.length != 3 || !/^[0-9]+$/.test(cvc)) {
                    $('#cvc_warning').html('<div class="alert alert-danger mt-3 input-alert-error">Please enter a valid CVC number<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var cvc_valid = true;
                    errors.push(cvc_valid);
                } else {
                    $('#cvc_warning').html('');
                    var cvc_valid = true;
                    errors.push(cvc_valid);
                }
            }

            // make sure they are all true
            let checker = arr => arr.every(v => v === true);

            // if all items in errors array are true, then proceed to next step
            if (checker(errors) == true) {

                if(animating) return false;
                animating = true;

                current_fs = $(this).parents('fieldset');
                next_fs = $(this).parents('fieldset').next();
                count++;
                
                //activate next step on progressbar using the index of next_fs
                $(".titles h1").eq($("fieldset").index(current_fs)).removeClass("active");
                $(".titles h1").eq($("fieldset").index(next_fs)).addClass("active");
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                if (count == 2) {
                    $(name).text(first_name + " " + last_name);
                    $(phone_value).text(phone);
                    $(email_value).text(email);
                    $(street_value).text(street);
                    $(suite_value).text(suite);
                    $(city_value).text(city);
                    $(province_value).text(province);
                    $(postal_value).text(postal);


                } else if (count == 3) {

                    $(payment_value).text(payment_method);

                    $(card_number_value).text(card_number_method_hide);

                    $(cart_value).text(cart_total);

                    $(payment_name_value).text(card_holder);

                    if (shipping_option == 'standard') {
                        var shipping_option = `Standard Shipping
                        Estimated 5-10 business Days
                        Shipped by Canada Post`;

                        $(shipping_option_value).text(shipping_option);
                    } else if (shipping_option == 'express-shipping') {

                        var shipping_option = `Express Shipping
                        Estimated 1-3 business Days
                        Shipped by Canada Post`;

                        $(shipping_option_value).text(shipping_option);
                    }

                    $(expiry_date_value).find('span.month').text(expiry_month);
                    $(expiry_date_value).find('span.year').text(expiry_year);

                    $(payment_address_value).text(billing_address);
                    $(payment_town_value).text(billing_town);
                    $(payment_province_value).text(billing_province);
                    $(payment_postal_value).text(billing_postal);

                    if (order_notes == '') {
                        $(order_notes_value).text('None');
                    } else {
                        $(order_notes_value).text(order_notes);
                    }
                }

                // show the next fieldset
                next_fs.show(); 
                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function(now, mx) {
                        //as the opacity of current_fs reduces to 0 - stored in "now"
                        //1. scale current_fs down to 80%
                        // scale = 1 - (1 - now) * 0.2;
                        scale = 1;
                        //2. bring next_fs from the right(50%)
                        left = (now * 50)+"%";
                        //3. increase opacity of next_fs to 1 as it moves in
                        opacity = 1 - now;
                        current_fs.css({
                    'transform': 'scale('+scale+')',
                    'position': 'realtive'
                });
                        // next_fs.css({'left': left, 'opacity': opacity});
                        next_fs.css({'opacity': opacity});
                    }, 
                    duration: 100, 
                    complete: function(){
                        current_fs.hide();
                        animating = false;
                    }, 
                    //this comes from the custom easing plugin
                    easing: 'easeInOutBack'
                });
                }
            
        });

        $(".previous").click(function(){
            if(animating) return false;
            animating = true;
            
            count--;

            current_fs = $(this).parents('fieldset');
            previous_fs = $(this).parents('fieldset').prev();

            if (count == 2) {
                // alert('going back to step 2');
            } else if (count == 1) {
                // alert('going back to step 1');
            }
            
            //de-activate current step on progressbar
            $(".titles h1").eq($("fieldset").index(current_fs)).removeClass("active");
            $(".titles h1").eq($("fieldset").index(previous_fs)).addClass("active");
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            
            // show the previous fieldset
            previous_fs.show(); 
            // hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1-now) * 50)+"%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    // current_fs.css({'left': left});
                    previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
                }, 
                duration: 800, 
                complete: function(){
                    current_fs.hide();
                    animating = false;
                }, 
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".submit").click(function(){
            return false;
        })

        $(".shipping-option .form-field").click(function(){
            $(this).toggleClass('active');

            $(this).siblings().removeClass('active');
        })

})(jQuery);