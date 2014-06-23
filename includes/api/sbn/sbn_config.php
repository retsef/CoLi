<?php

$_SBN['url'] = "opac.sbn.it";
$_SBN['port'] = 2100;
$_SBN['dbname'] = "nopac";

$_SBN['server'] = $_SBN['url'] . ":" . $_SBN['port'] . "/" . $_SBN['dbname'];
//$_SBN['server'] = "opac.sbn.it:2100/nopac";

$_SBN['syntax'] = "UNIMARC";

/*
 * Si faccia riferimento al formato Bib-1
 */
$_SBN['fields'] = array("titolo" => "1=4",
                        "isbn" => "1=7",
                        "issn"   => "1=8",
                        "data_publ"   => "1=31",
                        "autore"   => "1=1004",
                        "casa_ed"   => "1=1018");

