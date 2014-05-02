<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="/~roberto/Coli_modern/style.css">
        <link rel="icon" href="/~roberto/Coli_modern/resources/images/Book.png"/>
        <title>OPAC-Biblioteca Sassinoro</title>
    </head>
    <body>
        <div id="overheader">
            <div class="container">
                <?php include '../../includes/overheader.php'; ?>
            </div>
        </div>
        <div id="header">
            <div class="container">
                <?php include '../../includes/header.php'; ?>
                <?php include '../../includes/nav.php'; ?>
            </div>
        </div>
        <div id="content">
            <div class="container">
                <?php
                /*
                echo "1";
                echo dirname(__DIR__);
                include_once(dirname(__DIR__)."SBN.php");
                echo "1";
                //$string = $_POST['search_box'];
                //echo "1";
                $sbn = new SBN();
                echo "1";
                $sbn->search("wpe = Peter");
                echo "1";
                */
                include_once("../../includes/API/SBN.php");
                $sbn = new SBN();
                
                
                
                ?>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <?php include '../../includes/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
