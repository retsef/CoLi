<?php

include_once("includes/API/config_sbn.php");
//include_once("includes/API/sbn.lib.php");

//sbn_search($_POST['search_box']);

$fields = array("wti" => "1=4",
    "ibn" => "1=7",
    "isn" => "1=8",
    "wja" => "1=31",
    "wpe" => "1=1004",
    "wve" => "1=1018");

$ccl_result = array();
//$ccl_query = "(wpe = Liggesmeyer) and (wpe = Peter)";
$ccl_query = $_POST['search_box'];

$sbn = yaz_connect("opac.sbn.it:2100/nopac");
yaz_syntax($sbn, "unimarc");
yaz_ccl_conf($sbn, $fields);

// Parse the CCL query into yaz's native format
$result = yaz_ccl_parse($sbn, $ccl_query, $ccl_results);
if (!$result) {
    echo "Error ccl: " . $ccl_results['errorstring'];
    exit();
}

// Submit the query
$rpn = $ccl_results['rpn'];
yaz_search($sbn, 'rpn', $rpn);
yaz_wait();

// Any errors trying to retrieve this record?
$error = yaz_error($sbn);
if ($error) {
    print "Error: $error\n";
    exit();
}

// yaz_hits returns the amount of found records
$hits = yaz_hits($sbn);
if ($hits > 0) {
    echo "Found $hits hits:<br><br>";
    // yaz_record fetches a record from the current result set,
    // so far I've only seen server supporting string format
    $result = yaz_record($sbn, 1, "string");
    if (!$result) {
        echo "Cant get record";
    } else {
        print($result);
        echo "<br><br>";
    }
    // the parsing functions will be introduced later
    //if($_SBN['syntax'] == "mab") {
    //    $parsedResult = parse_mab_string($result);
    //} else {
    //    $parsedResult = parse_usmarc_string($result);
    //}
    //print_r($parsedResult);
} else
    echo "No records found.";
?>