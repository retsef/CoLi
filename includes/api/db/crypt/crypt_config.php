<?php

$_CRYPT['path'] = "";
$_CRYPT['public_key_file'] = "publkey.key";
$_CRYPT['private_key_file'] = "privkey.key";

$_CRYPT['public_key_path'] = $_CRYPT['path'] . $_CRYPT['public_key_file'];
$_CRYPT['private_key_path'] = $_CRYPT['path'] . $_CRYPT['private_key_file'];

$_CRYPT['public_key_stream'] = fopen($_CRYPT['public_key_path'], "r");
$_CRYPT['private_key_stream'] = fopen($_CRYPT['private_key_path'], "r");

$_CRYPT['public_key'] = fread($_CRYPT['public_key_stream'], filesize($_CRYPT['public_key_path']));
$_CRYPT['private_key'] = fread($_CRYPT['private_key_stream'], filesize($_CRYPT['private_key_path']));

fclose($_CRYPT['public_key_stream']);
fclose($_CRYPT['private_key_stream']);
