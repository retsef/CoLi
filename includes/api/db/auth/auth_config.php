<?php

$_CONFIG['host'] = "localhost";
$_CONFIG['user'] = "root";
$_CONFIG['pass'] = "";
$_CONFIG['dbname'] = "users";

$_CONFIG['table_sessioni'] = "sessioni";
$_CONFIG['table_utenti'] = "utenti";
/*
 * Questa table e' una vista 
 * nata dalla join delle table sessioni e utenti
 * 
 * Serve ad ovviare il controllo di TableExists in 
 * db_manager che non riconosce le tabelle create con join
 */
$_CONFIG['table_instance'] = "user_session";

$_CONFIG['expire'] = 3600*24;

//--------------
define('AUTH_LOGGED', 99);
define('AUTH_NOT_LOGGED', 100);

define('AUTH_USE_COOKIE', 101);
define('AUTH_USE_LINK', 103);
define('AUTH_INVALID_PARAMS', 104);
define('AUTH_LOGEDD_IN', 105);
define('AUTH_FAILED', 106);

$_AUTH = array(
    "TRANSICTION METHOD" => AUTH_USE_COOKIE
);
