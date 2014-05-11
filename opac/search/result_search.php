<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="/~roberto/CoLi/style.css">
        <link rel="icon" href="/~roberto/CoLi/resources/images/Book.png"/>
        <title>OPAC-Biblioteca Sassinoro</title>
    </head>
    <body>
        <?php
            include_once("../../includes/API/config_auth.php");
            include_once("../../includes/API/auth.lib.php");

            list($status, $user) = auth_get_status();

            if($status == AUTH_LOGGED & auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK){
                    $link = "?uid=".$_GET['uid'];
            }else	$link = '';
        ?>
        <div id="overheader">
            <div class="container">
                <?php include '../../includes/overheader.php'; ?>
            </div>
        </div>
        <div id="header">
            <div class="container">
                <?php include '../../includes/header.php'; ?>
                <?php include '../../includes/nav.php'; ?>
                <?php include '../../includes/popup.php'; ?>
            </div>
        </div>
        <div id="content">
            <div class="container">
                <?php include ''; ?>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <?php include '../../includes/footer.php'; ?>
            </div>
        </div>
    </body>
</html>