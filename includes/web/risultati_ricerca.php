<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include_once '../api/sbn/sbn_manager.php';

$sbn = sbn_manager();

$sbn->sbn_search($_GET['search_box']);

