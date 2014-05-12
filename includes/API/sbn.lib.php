<?php
/*
// Server URL with port and database descriptor
$server = "z3950.obvsg.at:9991/ACC01";
$syntax = "mab";
// for USMARC example uncomment next $server and $syntax defs
// $server = "aleph.unibas.ch:9909/IDS_UTF";
// $syntax = "usmarc";
// Mapping CCL keywords to Bib-1-Attributes (allows convenient query formulation)
$fields = array("wti" => "1=4",
                "ibn" => "1=7",
                "isn"   => "1=8",
                "wja"   => "1=31",
                "wpe"   => "1=1004",
                "wve"   => "1=1018");
// establish connection and store session identifier,
// credentials are an optional second parameter in format "<user>/<passwd>"
$session = yaz_connect($server);
// check whether an error occurred
if (yaz_error($session) != ""){
    die("Error: " . yaz_error($session));
}
// configure desired result syntax (must be specified in Target Profile)
yaz_syntax($session, $syntax);
// configure YAZ's CCL parser with the mapping from above
yaz_ccl_conf($session, $fields);
 * 
 */
// define a query using CCL (allowed operators are 'and', 'or', 'not')
// available fields are the ones in $fields (again see Target Profile)
//$ccl_query = "(wpe = Liggesmeyer) and (wpe = Peter)";
function sbn_search($ccl_query) {
    //global $_SBN;
    // let YAZ parse the query and check for error
    if (!yaz_ccl_parse($session, $ccl_query, &$ccl_result)){
            die("The query could not be parsed.");
    } else{
        // fetch RPN result from the parser
        $rpn = $ccl_result["rpn"];
        // do the actual query
        yaz_search($session, "rpn", $rpn);
        // wait blocks until the query is done
        yaz_wait();
        if (yaz_error($session) != ""){
            die("Error: " . yaz_error($session));
        }
        // yaz_hits returns the amount of found records
        if (yaz_hits($session) > 0){
            echo "Found some hits:<br>";
            // yaz_record fetches a record from the current result set,
            // so far I've only seen server supporting string format
            $result = yaz_record($session, 1, "string");
            print($result);
            echo "<br><br>";
            // the parsing functions will be introduced later
            if($_SBN['syntax'] == "mab") {
                $parsedResult = parse_mab_string($result);
            } else {
                $parsedResult = parse_usmarc_string($result);
            }
            print_r($parsedResult);
        } else
            echo "No records found.";
    }
}

   
function parse_mab_string($record){
    $result = array();
    // exchange some characters that are returned malformed (collected over time))
    $record = exchange_chars($record);
    // split the returned fields at the record separator character
    $record = explode(chr(0x001E),$record);
    // cut of meta data of the record
    $record[0] = substr($record[0], strpos($record[0],"h001") + 1);
    // examine all fields and extract their contents, the last entry is always empty
    for ($datnum = 0; $datnum <= count($record)-2; $datnum++){
        $data = $record[$datnum];
        // the first 4 chars are the field id
        $field = substr($data,0,4);
        if (!isset($result[$field]))
            $result[$field] = array();
        // the remaining substring is the field value
        array_push($result[$field],substr($record[$datnum],4));
    }
    return $result;
}
 
// the following helper function restores a collection of malformed characters,
// it is based on nearly 3 years experience with several Z39.50 servers
function exchange_chars($rep_string){
    $bad_chars = array(chr(0x00C9)."o", chr(0x00C9)."O", chr(0x00C9)."a",
                       chr(0x00C9)."A", chr(0x00C9)."u", chr(0x00C9)."U",
                       chr(137), chr(136), chr(251) , chr(194)."a" ,
                       chr(194)."i", chr(194)."e", chr(208)."c", chr(194)."E",
                       chr(207)."c", chr(207)."s", chr(207)."S", chr(201)."i",
                       chr(200)."e", chr(193)."e", chr(193)."a", chr(193)."i",
                       chr(193)."o", chr(193)."u", chr(195)."u", chr(201)."e",
                       chr(195).chr(194), "&amp;#263;", "Ã¤");
    $rep_chars = array(     "&ouml;"  ,    "&Ouml;"    ,    "&auml;"    ,
                            "&Auml;"  ,     "&uuml;"   ,     "&Uuml;"   ,
                          ""   ,    ""   , "&szlig;",  "&aacute;"  , 
                       "&iacute;"  , "&eacute;"  , "&ccedil;"  , "&Eacute;"  ,
                       "&#269;"    , "&#353;"    , "&#352;"    , "&iuml;"    ,
                       "&euml;"    , "&egrave;"  , "&agrave;"  , "&igrave;"  ,
                       "oegrave;"  , "&ugrave;"  , "&ucirc;"   , "&euml;"    ,
                       "&auml;"         , "&#263;"    , "&auml;");
    return str_replace($bad_chars, $rep_chars, $rep_string);
}

function parse_usmarc_string($record){
    $ret = array();
    // there was a case where angle brackets interfered
    $record = str_replace(array("<", ">"), array("",""), $record);
    $record = utf8_decode($record);
    // split the returned fields at their separation character (newline)
    $record = explode("\n",$record);
    //examine each line for wanted information (see USMARC spec for details)
    foreach($record as $category){
        // subfield indicators are preceded by a $ sign
        $parts = explode("$", $category);
        // remove leading and trailing spaces
        array_walk($parts, "custom_trim");
        // the first value holds the field id,
        // depending on the desired info a certain subfield value is retrieved
        switch(substr($parts[0],0,3)){
            case "008" : $ret["language"] = substr($parts[0],39,3); break;
            case "020" : $ret["isbn"] = get_subfield_value($parts,"a"); break;
            case "022" : $ret["issn"] = get_subfield_value($parts,"a"); break;
            case "100" : $ret["author"] = get_subfield_value($parts,"a"); break;
            case "245" : $ret["titel"] = get_subfield_value($parts,"a");
                         $ret["subtitel"] = get_subfield_value($parts,"b"); break;
            case "250" : $ret["edition"] = get_subfield_value($parts,"a"); break;
            case "260" : $ret["pub_date"] = get_subfield_value($parts,"c");
                         $ret["pub_place"] = get_subfield_value($parts,"a");
                         $ret["publisher"] = get_subfield_value($parts,"b"); break;
            case "300" : $ret["extent"] = get_subfield_value($parts,"a");
                         $ext_b = get_subfield_value($parts,"b");
                         $ret["extent"] .= ($ext_b != "") ? (" : " . $ext_b) : "";
                         break;
            case "490" : $ret["series"] = get_subfield_value($parts,"a"); break;
            case "502" : $ret["diss_note"] = get_subfield_value($parts,"a"); break;
            case "700" : $ret["editor"] = get_subfield_value($parts,"a"); break;
        }
    }
    return $ret;
}
 
// fetches the value of a certain subfield given its label
function get_subfield_value($parts, $subfield_label){
    $ret = "";
    foreach ($parts as $subfield)
        if(substr($subfield,0,1) == $subfield_label)
            $ret = substr($subfield,2);
    return $ret;
}
 
// wrapper function for trim to pass it to array_walk
function custom_trim(& $value, & $key){
    $value = trim($value);
}

?>

