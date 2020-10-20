<?php

    function root_url($string) {

        if ($string[0] != '/') {
            $string = "/" . $string;
        }

        return 'http://' . SITE_ROOT . $string;
    }

    function root_url_private($string) {

        if ($string[0] != '/') {
            $string = "/" . $string;
        }

        return 'http://' . SITE_ROOT_PRIVATE . $string;
    }

?>