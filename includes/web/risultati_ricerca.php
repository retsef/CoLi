<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include(ROOT_PATH. "/includes/api/sbn/sbn_manager.php");

$sbn = new sbn_manager();

$sbn->sbn_search($_POST['search_box']);

