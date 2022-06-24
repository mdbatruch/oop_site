<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?= !empty($title) ? $title : ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- main stylesheet link -->
            <link rel="stylesheet" href="<?php echo root_url('css/font-awesome.min.css'); ?>" />
            <link rel="stylesheet" href="<?php echo root_url('css/styles.css'); ?>">
            <link rel="stylesheet" href="<?php echo root_url('css/bootstrap.css'); ?>" />
            <link rel="stylesheet" href="<?php echo root_url('css/main.chunk.css'); ?>" />
            <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
            <!--[if (lt IE 9)]><script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.helper.ie8.js"></script><![endif]-->
            
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
            <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

            <link rel="icon" href="<?= root_url('images/favicon.ico'); ?>">
            <script src="<?php echo root_url('js/scripts.js'); ?>"></script>
    </head>

<body>