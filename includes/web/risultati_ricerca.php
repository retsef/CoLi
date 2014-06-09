<?php
include(ROOT_PATH. "/includes/api/sbn/sbn_manager.php");

$Get_url = "?page=" .$_GET['page'] . "&search=" .$_GET['search'];

$sbn = new sbn_manager();
try {
    $sbn->sbn_search($_GET['search']);
} catch (Exception $e) {
    echo $e->getMessage();
}

$hits = $sbn->get_hits();

if ($hits) {
    echo "<br>";

if(isset($_GET['s']))
    $start=$_GET['s'];
else
    $start = 1;
$step=20;
$end=$start+$step;

$pre=$start-$step;
$last=$hits-$step;

echo "<div>";
echo "<ol start=".$start.">";
for($i=$start;$i<=$end;$i++){
    echo 
    "<li>
        <ul>";
    echo "<li>";
        print($sbn->get_Result($i));
    echo "</li><br>";
    echo 
    "    </ul>
    </li>";
}
echo "</ol>";
echo "</div>";

echo 
"<div class=nav_bar_page>"
    ."<ul>";
if($start!=1){
echo "<li>"
            . "<a href=" .$Get_url ."&s=1". "><<</a>"
        . "</li>"
        . "<li>"
            . "<a href=" .$Get_url ."&s=".$pre. "> < Prec.</a>"
        . "</li>";
}
echo "<li>"
            . "<a href=" ."". ">"
            . "Visualizzati " .$start. " - " .$end. " di " .$hits. ""
            . "</a>"
        . "</li>";
if($start!=$last) {
echo "<li>"
            . "<a href=" .$Get_url ."&s=".$end. ">Succ. ></a>"
        . "</li>"
        . "<li>"
            . "<a href=" .$Get_url ."&s=".$last. ">>></a>"
        . "</li>";
}
echo "</ul>"
."</div>";

} else 
    echo "No records found.";