<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include '../includes/api/db/db_manager.php';
include '../includes/api/db/auth/auth_config.php';

$db = new db_manager($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']);

$db->connect();
$uid = "NULL";

global $_COOKIE;
if(isset($_COOKIE['uid']))
$uid = $_COOKIE['uid'];

print_r($uid);
print "<br></br>";
print_r(time());
print "<br></br>";
//$db->select($_CONFIG['table_sessioni']);
//$res = $db->getResult();
//print_r($res);
//print "<br></br>";
$db->select($_CONFIG['table_utenti'], "*", "username='gm' and password=MD5('test3')");

//print_r($db->getResult());
/*
$db->select("user_session",
            "name,surname,username",
            "uid = '".$uid."'");
*/
print "<br></br>";
$res = $db->getResult();
echo count($res);
print "<br></br>";
echo $db->numResult();

//$db->delete($_CONFIG['table_sessioni'], "user_id = 1");
print "<br></br>";
print_r($res);
print "<br></br>";