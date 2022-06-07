<?php

    if ($_SERVER['SERVER_NAME'] == 'castlegames.mike-batruch.ca') {
        $protocol = 'https://';
    } else {
        $protocol = 'http://';
    }


    function root_url($string) {

        global $protocol;

        if ($string[0] != '/') {
            $string = "/" . $string;
        }

        return $protocol . SITE_ROOT . $string;
    }

    function root_url_private($string) {

        global $protocol;

        if ($string[0] != '/') {
            $string = "/" . $string;
        }

        return $protocol . SITE_ROOT_PRIVATE . $string;
    }

?>