<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include(ROOT_PATH. "/includes/api/sbn/sbn_manager.php");

$sbn = new sbn_manager();
try {
    $sbn->sbn_search($_POST['search_box']);
} catch (Exception $e) {
    echo $e->getMessage();
}

$hits = $sbn->get_hits();

if ($hits) {
    echo "Found ".$hits ." hits:<br>";

$start=1;
$end=5;

echo "<ol>";
for($i=$start;$i<=$end;$i++){
    echo 
    "<li>
        <ul>";
    echo "<li>";
        print($sbn->get_Result($i));
    echo "</li>";
    echo 
    "    </ul>
    </li>";
}
echo "</ol>";

} else 
    echo "No records found.";