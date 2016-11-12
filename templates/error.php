<?php

function show_error($code){
    switch($code){
        case 404:
            require_once("error/error_404.php");
            break;
        default:
            require_once("error/error_default.php");
            break;
    }
}