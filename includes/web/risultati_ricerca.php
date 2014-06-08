<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include(ROOT_PATH. "/includes/api/sbn/sbn_manager.php");

$sbn = new sbn_manager();
try {
    $sbn->sbn_search($_GET['search']);
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

echo 
"<div class=nav_bar_page>"
    ."<ul>"
        . "<li>"
            . "<a href=" ."". "><<</a>"
        . "</li>"
        . "<li>"
            . "<a href=" ."". "> < Prec.</a>"
        . "</li>"
        . "<li>"
            . "<a href=" ."". ">"
            . "Visualizzati" .$start. " - " .$end. " di " .$hits. ""
            . "</a>"
        . "</li>"
        . "<li>"
            . "<a href=" ."". ">Succ. ></a>"
        . "</li>"
        . "<li>"
            . "<a href=" ."". ">>></a>"
        . "</li>"
    ."</ul>"
."</div>";
        
        
        

} else 
    echo "No records found.";