<footer id="admin-footer" class="container">
    <div class="row">
        <div class="copyright">&copy; Copyright Mike Batruch</div>
    </div>
</footer>

<script src="<?php echo root_url('js/lightbox-plus-jquery.min.js'); ?>"></script>
    <script src="<?php echo root_url('js/bootstrap.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo root_url('js/nestable.js'); ?>"></script>

    <script type="text/javascript">
        $(function  () {
            // $("ol.navbar-nav").sortable();

        $('.nav-sort').nestable({
            group: 1
        });

        // var output = $('.nav-sort').contents();
        // var output = window.JSON.stringify($('.nav-sort').nestable('serialize'));

        // console.log(output);

        // updateOutput($('#nestable').data('output', $('#nestable-output')));

            $(".save-navigation").on("click", function(e){
                e.preventDefault();

                console.log('a nav edit has been tried');
                    
                    var button = $(this).attr('class');
                    var nav_name = $("ol.navbar-nav").attr('id');
                    var nav_container = $("ol.navbar-nav").contents();

                    console.log(button, nav_name, nav_container);

                    var output = window.JSON.stringify($('.nav-sort').nestable('serialize'));

                    console.log(output);


                    // only one tier item

                    // var order = [];

                    // $('li.nav-item').each(function(i, obj) {
                    //     $item = $(this).index();
                    //     $page = $(this).text();

                    //     order.push({
                    //         order: $item,
                    //         page: $page
                    //     });

                    // });

                    // console.log(order);

                    // end only one tier item

                    $.ajax({
                        type: "POST",
                        url: "../process.php",
                        dataType: "json",
                        data: {id:button, title: nav_name, output},
                    }).done(function(data){

                    if (!data.success) {
                        
                            $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        
                            console.log('nav did not submit!');

                        } else {
                            
                            console.log('nav edited!');

                            $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        }
                    
                });

            });

        });
    </script>

<script type="text/javascript">

    $(".delete").on("click", function(e){
        e.preventDefault();

        console.log('a project deletion has been tried');
            
            // var class = $(this).attr('class');
            var project_id = $(this).attr('data-id');

            console.log(project_id);

    
            $.ajax({
                type: "POST",
                url: "../process.php",
                dataType: "json",
                data: {id:'delete', project_id:project_id},
            }).done(function(data){

            if (!data.success) {

                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('Project did not delete!');

                } else {
                    
                    console.log('Project deleted!');

                    $('.delete[data-id="' + data.id + '"]').closest('.page').remove();

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');
                }
            
        });

    });

    $("#new-page").on("submit", function(e){
        e.preventDefault();

        console.log('a page submission has been tried');

            // $('#page_description').tinymce().save();

            tinyMCE.triggerSave();
            
            var formId = $('form').attr('id');
            var page_name = $("#page_name").val();
            var page_title = $("#page_title").val();
            var page_subtitle = $("#page_subtitle").val();
            var page_description = $("#page_description").val();
            // var page_description = $("#page_description").html(tinymce.get('#page_description').getContent());

            console.log(formId, page_name, page_title, page_subtitle, page_description);
            

            $.ajax({
                type: "POST",
                url: "../process.php",
                dataType: "json",
                data: {name:page_name, title:page_title, subtitle:page_subtitle, description:page_description, id:formId},
            }).done(function(data){

            if (!data.success) {

                    if (data.errors.name) {

                        $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#name-warning').html('');
                    }

                    if (data.errors.title) {

                        $('#title-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.title + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#title-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('page did not submit!');

                } else {

                    $(location).attr('href', data.redirect);
                    
                    console.log('page created!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                }
            
        });

    });

    $("#new-gallery").on("submit", function(e){
        e.preventDefault();

        console.log('a gallery submission has been tried');

            // tinyMCE.triggerSave();
            
            var formId = $('form').attr('id');
            var gallery_title = $("#gallery_title").val();
            var gallery_desc = $("#gallery_description").val();
            var gallery_assoc = $('option:selected', this).attr('value');
            var gallery_images = $('#gallery_images').prop('files');

            if ( $('#gallery_active').is(':checked') ) {

                $('#gallery_active').val(1);
                } else {

                $('#gallery_active').val(0);
                }

            var gallery_active = $("#gallery_active").val();

            // var gallery_description = $("#gallery_description").val();

            var form_data = new FormData();

            form_data.append('id', formId);
            form_data.append('gallery_title', gallery_title);
            form_data.append('gallery_description', gallery_desc);
            form_data.append('gallery_assoc', gallery_assoc);
            form_data.append('gallery_active', gallery_active);

            var totalfiles = document.getElementById('gallery_images').files.length;
                for (var index = 0; index < totalfiles; index++) {
                    form_data.append("gallery_images[]", document.getElementById('gallery_images').files[index]);
                }
            // form_data.append('gallery_images', gallery_images);


            console.log(formId, gallery_title, gallery_assoc, gallery_desc, gallery_active, gallery_images);
            

            $.ajax({
                type: "POST",
                url: "../process.php",
                dataType: "json",
                contentType: false,
                processData: false,
                data: form_data,
            }).done(function(data){

            if (!data.success) {

                    if (data.errors.title) {

                        $('#title-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.title + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#title-warning').html('');
                    }

                    if (data.errors.assoc) {

                        $('#assoc-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.assoc + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');    
                    } else {
                        $('#assoc-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('gallery did not submit!');

                } else {

                    $(location).attr('href', data.redirect);
                    
                    console.log('gallery created!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                }
            
        });

    });

    $(".remove-slide").on("click", function(e){
        $(this).closest('.img-container').remove();
    });

    $("#edit-gallery").on("submit", function(e){
        e.preventDefault();

        console.log('a gallery edit has been tried');

            // tinyMCE.triggerSave();
            
            var formId = $('form').attr('id');
            var gallery_id = $("#gallery_id").val();
            var gallery_title = $("#gallery_title").val();
            var gallery_desc = $("#gallery_description").val();
            var gallery_assoc = $('option:selected', this).attr('value');
            var gallery_images = $('#gallery_images').prop('files');

            if ( $('#gallery_active').is(':checked') ) {

                $('#gallery_active').val(1);
                } else {

                $('#gallery_active').val(0);
                }

            var gallery_active = $("#gallery_active").val();

            // var gallery_description = $("#gallery_description").val();

            var form_data = new FormData();

            form_data.append('id', formId);
            form_data.append('gallery_id', gallery_id);
            form_data.append('gallery_title', gallery_title);
            form_data.append('gallery_description', gallery_desc);
            form_data.append('gallery_assoc', gallery_assoc);
            form_data.append('gallery_active', gallery_active);

            var totalfiles = document.getElementById('gallery_images').files.length;
                for (var index = 0; index < totalfiles; index++) {
                    form_data.append("gallery_images[]", document.getElementById('gallery_images').files[index]);
                }
            // form_data.append('gallery_images', gallery_images);

            var existing = [];

            $('.current-image').each(function(i, obj) {
                $image = $(this).attr('data-name');
                console.log($image);
                existing.push($image);
            });

            form_data.append('existing', existing);


            console.log(formId, gallery_title, gallery_assoc, gallery_active, gallery_images, gallery_desc, existing);
            

            $.ajax({
                type: "POST",
                url: "../process.php",
                dataType: "json",
                contentType: false,
                processData: false,
                data: form_data,
            }).done(function(data){

            if (!data.success) {

                    if (data.errors.title) {

                        $('#title-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.title + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#title-warning').html('');
                    }

                    if (data.errors.assoc) {

                        $('#assoc-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.assoc + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');    
                    } else {
                        $('#assoc-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('gallery did not submit!');

                } else {

                    $(location).attr('href', data.redirect);
                    
                    console.log('gallery created!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '</div>');
                }
            
        });

    });


    $(".delete-gallery").on("click", function(e){
        let modal = $('#id01');
        let modal_delete = $('.confirm-delete-gallery');

        let button_id = $(this).attr('data-id');
        let modal_delete_id = $(modal_delete).attr('data-id');

        $(modal_delete).attr('data-id', button_id);


        $(modal).css('display', 'block');
    });

    $(".confirm-delete-gallery").on("click", function(e){
        e.preventDefault();

        console.log('a gallery deletion has been tried');
            
            var formId = $(this).attr('class');
            var gallery_id = $(this).attr('data-id');

        console.log(formId, gallery_id);

    
            $.ajax({
                type: "POST",
                url: "../process.php",
                dataType: "json",
                data: {gallery_id:gallery_id, id:formId},
            }).done(function(data){

            if (!data.success) {

                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('Gallery did not delete!');

                } else {
                    
                    console.log('Gallery deleted!');

                    let modal = $('#id01');

                    $(modal).css('display', 'none');
                    
                    $('.delete-gallery[data-id="' + data.id + '"]').closest('.gallery').remove();

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></div>');
                }
            
        });

    });


    $("#edit-page").on("submit", function(e){
        e.preventDefault();

        console.log('a page edit has been tried');

            tinyMCE.triggerSave();
            
            var formId = $('form').attr('id');
            var page_id = $("#page_id").val();
            var page_name = $("#page_name").val();
            var page_title = $("#page_title").val();
            var page_subtitle = $("#page_subtitle").val();
            var page_description = $("#page_description").val();

            console.log(formId, page_id, page_name, page_title, page_subtitle, page_description);
            

            $.ajax({
                type: "POST",
                url: "../process.php",
                dataType: "json",
                data: {page_id: page_id, name:page_name, title:page_title, subtitle:page_subtitle, description:page_description, id:formId},
            }).done(function(data){

            if (!data.success) {

                    if (data.errors.name) {

                        $('#name-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.name + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#name-warning').html('');
                    }

                    if (data.errors.title) {

                        $('#title-warning').html('<div class="alert alert-danger mt-3 input-alert-error">' + data.errors.title + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    } else {
                        $('#title-warning').html('');
                    }
                
                    $('#form-message').html('<div class="alert alert-danger">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                
                    console.log('page edit did not work!');

                } else {

                    $(location).attr('href', data.redirect);
                    
                    console.log('page has been edited!');

                    $('#form-message').html('<div class="alert alert-success">' + data.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            
        });

    });
    
    
</script>

</body>
</html>