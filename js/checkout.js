"use strict";
    (function ($) {
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches
        var count = 1;

        $(".next").click(function(){

            if(animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            count++;
            
            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            console.log($("#progressbar li").eq($("fieldset").index(next_fs)));

            if (count == 2) {
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var street = $('#street').val();
                var suite = $('#suite').val();
                var city = $('#city').val();
                var province = $('#province').val();
                var postal = $('#postal').val();

                var name = $('.step-3 .name-confirm span');
                var phone_value = $('.step-3 .phone-confirm span');
                var email_value = $('.step-3 .email-confirm span');
                var street_value = $('.step-3 .street-confirm span');
                var suite_value = $('.step-3 .suite-confirm span');
                var city_value = $('.step-3 .city-confirm span');
                var province_value = $('.step-3 .province-confirm span');
                var postal_value = $('.step-3 .postal-confirm span');


                $(name).text(first_name + " " + last_name);
                $(phone_value).text(phone);
                $(email_value).text(email);
                $(street_value).text(street);
                $(suite_value).text(suite);
                $(city_value).text(city);
                $(province_value).text(province);
                $(postal_value).text(postal);


            } else if (count == 3) {

                var payment_method = $('#card-type-picker').val();
                var payment_value = $('.step-3 .payment-confirm span');
                $(payment_value).text(payment_method);

                var card_number_method = $('#card-number').val();
                var card_number_method_hide = 'XXXXXXXXXXXX' + card_number_method.slice(card_number_method.length - 4);
                var card_number_value = $('.step-3 .card-number-confirm span');
                $(card_number_value).text(card_number_method_hide);

                var cart_total = $('#total').text();
                var cart_value = $('.step-3 .amount-confirm span');
                $(cart_value).text(cart_total);
            }

            // alert(name);
            // if (first_name == '') {
            //     $('#first_name').after('<h1>Enter a name</h1>');
            // } else {
                console.log('next clicked');
                //show the next fieldset
            next_fs.show(); 
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50)+"%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                'transform': 'scale('+scale+')',
                'position': 'absolute'
            });
                    // next_fs.css({'left': left, 'opacity': opacity});
                    next_fs.css({'opacity': opacity});
                }, 
                duration: 800, 
                complete: function(){
                    current_fs.hide();
                    animating = false;
                }, 
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
                
            // }
            
        });

        $(".previous").click(function(){
            if(animating) return false;
            animating = true;
            
            count--;

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            if (count == 2) {
                // alert('going back to step 2');
            } else if (count == 1) {
                // alert('going back to step 1');
            }
            
            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            
            //show the previous fieldset
            previous_fs.show(); 
            //hide the current fieldset with style
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
})(jQuery);