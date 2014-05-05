<?php

$server = "opac.sbn.it:2100/nopac";
$syntax = "unimarc";

$session;

function  connect() {
    // establish connection and store session identifier,
    // credentials are an optional second parameter in format "<user>/<passwd>"
    $this->session = yaz_connect($this->server);
    // check whether an error occurred
    if (yaz_error($this->session) != ""){
        die("Error: " . yaz_error($this->session));
    }
    // configure desired result syntax (must be specified in Target Profile)
    yaz_syntax($this->session, $this->syntax);
    // configure YAZ's CCL parser with the mapping from above
    //yaz_ccl_conf($this->session, $this->fields);
}
    

?>

