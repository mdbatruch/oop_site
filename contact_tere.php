<?php
    
    require('initialize.php');
    
    $contact_page = new Page("Contact");
    $site->setPage($contact_page);

    $content = 'Contact Page';
    $contact_page->setContent($content);

    $site->render();
?>