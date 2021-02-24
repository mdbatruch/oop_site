    
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

    </script>
    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:8890/browser-sync/browser-sync-client.js?v=2.26.7'><\/script>".replace("HOST", location.hostname));
        //]]></script>
    </body>
</html>