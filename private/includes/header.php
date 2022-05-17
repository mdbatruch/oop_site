<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= $title; ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- main stylesheet link -->
            <link rel="stylesheet" href="<?php echo root_url('css/font-awesome.min.css'); ?>" />
            <link rel="stylesheet" href="<?php echo root_url('css/styles.css'); ?>">
            <link rel="stylesheet" href="<?php echo root_url('css/bootstrap.css'); ?>" />

            <link rel="icon" href="<?= root_url('images/favicon.ico'); ?>">

            <script src="<?php echo root_url('js/scripts.js'); ?>"></script>

            <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

            <script>
                tinymce.init({
                    forced_root_block : "",
                    entity_encoding: 'raw',
                    selector: '#page_description',
                    remove_linebreaks : false,
                });
            </script>
            </style>
    </head>

<body>