<?php

include './includes/api/db/db_manager.php';
include './includes/api/db/auth/auth_config.php';

$db = new db_manager($_CONFIG['host'], 
        $_CONFIG['user'], 
        $_CONFIG['pass'], 
        $_CONFIG['dbname']);

$db->connect();
$db->select($_CONFIG['table_utenti'],"*",
                "username='gm' and password=MD5('test3')");
$res = $db->getResult();
echo sizeof($db->getResult()['id']);
print_r($res);