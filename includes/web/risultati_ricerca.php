<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL | E_STRICT);

include(ROOT_PATH. "/includes/api/sbn/sbn_manager.php");

$Get_url = "?page=" .$_GET['page'] . "&search=" .$_GET['search'];

$sbn = new sbn_manager();
try {
    $sbn->sbn_search($_GET['search']);
} catch (sbn_exception $e) {
    echo $e->getMessage();
}

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
<style>
        .result_list {}
        .result_list ol {
            margin: 0;
        }
        .result_list ol li:first-child {
            padding: 0;
        }
        .result_list ol > li {
            padding-top: 140px;
        }
        .result_list ol li ul {
            float: left;
        }
        .result_list ul li {
            list-style: none;
        }
        .result_list ul li:first-child {
            padding-top: 10px;
        }
        .result_list ul ul {
            padding: 0; padding-top: 10px; padding-left: 5px;
        }
        .result_list ul ul li {
            display: inline;
        }
    </style>
<div class="result_list">
    <ol start=<?=$start;?>>
        <?php
        for($i=$start;$i<=$end;$i++){
            $ret= $sbn->parse_unimarc_string($sbn->get_Result($i));
        ?>
        <li>
            <img src=../resources/images/Book.png style="float: left;">
            <ul>
                <li>
                    <?=$ret['autore'][0];?> <?=$ret['autore'][1];?>
                </li>
                <li>
                    <a href="" style="text-decoration: none; color: blue;">
                        <?=$ret['titolo'];?>
                    </a>
                </li>
                <li>
                    <?=$ret['publicazione']['luogo'];?>:
                    <?=$ret['publicazione']['indirizzo'];?> ,
                    <?=$ret['publicazione']['nome'];?> ,
                    <?=$ret['publicazione']['data'];?>
                </li>
                <li>
                    <ul>
                        <li><a href="" style="padding: 5px; background-color: #8abb21; border-radius: 3px;">Prenota</a></li>
                        <li style="padding: 5px; background-color: #DDD; border-radius: 3px;">Copie disponibili: n</li>
                        <li style="padding: 5px; background-color: #DDD; border-radius: 3px;">Prenotazioni: n</li>
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
} else 
    echo "No records found.";
?>
