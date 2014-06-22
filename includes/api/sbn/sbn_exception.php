<?php

class sbn_exception extends Exception {
    function error_message($msg) {
        echo $msg;
    }
}