<?php

$_SBN['url'] = "opac.sbn.it";
$_SBN['port'] = 2100;
$_SBN['dbname'] = "nopac";

$_SBN['server'] = $_SBN['url'] . ":" . $_SBN['port'] . "/" . $_SBN['dbname'];

$_SBN['syntax'] = "unimarc";

$_SBN['fields'] = array("wti" => "1=4",
                        "ibn" => "1=7",
                        "isn"   => "1=8",
                        "wja"   => "1=31",
                        "wpe"   => "1=1004",
                        "wve"   => "1=1018");

$session = yaz_connect($_SBN['server']);
// check whether an error occurred
if (yaz_error($_SBN['server']) != ""){
    die("Error: " . yaz_error($_SBN['server']));
}

yaz_syntax($session, $_SBN['syntax']);
yaz_ccl_conf($session, $_SBN['fields']);

?>
