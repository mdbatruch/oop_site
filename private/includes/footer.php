<footer id="admin-footer" class="container">
    <div class="row">
        <div class="copyright">&copy; Copyright Mike Batruch</div>
    </div>
</footer>

<script src="<?php echo root_url('js/lightbox-plus-jquery.min.js'); ?>"></script>
    <script src="<?php echo root_url('js/bootstrap.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

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

    $("#edit-page").on("submit", function(e){
        e.preventDefault();

        console.log('a pageedit has been tried');

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