<?php
/*
    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);
*/
include(ROOT_PATH. "/includes/api/sbn/sbn_manager.php");

$Get_url = "?page=" .$_GET['page'] . "&search=" .$_GET['search'];

$sbn = new sbn_manager();
try {
    $sbn->sbn_search($_GET['search']);

$hits = $sbn->get_hits();

if ($hits) {

if(isset($_GET['s']))
    $start=$_GET['s'];
else
    $start = 1;
$step=20;
$end=$start+$step;

$pre=$start-$step;
$last=$hits-$step;

?>
<div class="result_list">
    <ol start=<?=$start;?>>
        <?php
        for($i=$start;$i<=$end;$i++){
            $ret= $sbn->parse_unimarc_string($sbn->get_Result($i));
        ?>
        <li>
            <img src="/CoLi/resources/images/Book.png">
            <ul>
                <li>
                    <?=$ret['autore'][0];?> <?=$ret['autore'][1];?>
                </li>
                <li>
                    <a class="link" href="">
                        <?=$ret['titolo'];?>
                    </a>
                </li>
                <li>
                    <?=$ret['publicazione']['luogo'];?>:
                    <?=$ret['publicazione']['indirizzo'];?> 
                    <?=$ret['publicazione']['nome'];?> ,
                    <?=$ret['publicazione']['data'];?>
                </li>
                <li>
                    <ul>
                        <li><a href="">Prenota</a></li>
                        <li>Copie disponibili: n</li>
                        <li>Prenotazioni: n</li>
                    </ul>
                </li>
            </ul>
        </li>
    <?php
        }
    ?>
    </ol>
</div>

<div class=nav_bar_page>
    <ul>
        <?php
            if($start!=1){
        ?>
        <li>
            <a href="<?=$Get_url;?>&s=1"><<</a>
        </li>
        <li>
            <a href="<?=$Get_url;?>&s=<?=$pre;?>"> < Prec.</a>
        </li>
        <?php
            }
        ?>
        <li>
            <a href="">
            Visualizzati <?=$start;?> - <?=$end;?> di <?=$hits;?>
            </a>
        </li>
        <?php
            if($start!=$last) {
        ?>
        <li>
            <a href="<?=$Get_url;?>&s=<?=$end;?>">Succ. ></a>
        </li>
        <li>
            <a href="<?=$Get_url;?>&s=<?=$last;?>">>></a>
        </li>
        <?php
            }
        ?>
    </ul>
</div>
<?php
} else {
?>
<div class="frame" style=" width: 300px; margin-top: 20px; margin-left: auto; margin-right: auto;">
    <h2>Nessun Risultato trovato</h2>
</div>
<?php
}

} catch (sbn_exception $e) {
    ?>
<div class="frame" style=" width: 370px; margin-top: 20px; margin-left: auto; margin-right: auto;">
    <img style="width: 48px; height: 48px; padding-left: 45%;" src="/CoLi/resources/images/warning-256x256.png">
    <h2 style="text-align: center;"><?=$e->getMessage();?></h2>
</div>
<?php
}
?>
