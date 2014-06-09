<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include '../includes/api/db/db_manager.php';

$db = new db_manager('localhost', 'root', '', 'opac');
$db->connect();

$db->select('libro');
print_r($db->getResult());

$db->insert('libro', array(20,'pippo','frollini'));

$db->select('libro');
print_r($db->getResult());
