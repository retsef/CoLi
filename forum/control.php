<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="control_style.css">
        <link rel="icon" href="/CoLi/resources/images/Hummingbird.png"/>
        <title>OPAC-Dashboard</title>
    </head>
    <body>
        <?php
            include_once("../includes/API/config_auth.php");
            include_once("../includes/API/auth.lib.php");

            list($status, $user) = auth_get_status();

            if($status == AUTH_LOGGED & auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK){
                    $link = "?uid=".$_GET['uid'];
            }else	$link = '';
        ?>
        <div id="offsrceen">
            <?php include 'includes/popup.php'; ?>
        </div>
        <div id="sidebar">
            <?php include 'includes/control_sidebar.php'; ?>
        </div>
        <div id="header">
            <?php include 'includes/control_header.php' ?>
        </div>
        <div id="content">
            <div class="container">
                <?php include 'includes/control_front.php'; ?>
            </div>
        </div>
    </body>
</html>