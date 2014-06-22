<?php
ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="style.css">
        <link rel="icon" href="resources/images/Hummingbird.png"/>
        <title>OPAC-Biblioteca Sassinoro</title>
    </head>
    <body>
        <?php
        /*
        ini_set('display_errors', 1);
        error_reporting(E_ALL | E_STRICT);
        */
        define('ROOT_PATH', realpath(__DIR__));
        
        include_once("includes/api/db/auth/auth_manager.php");

        $auth = new auth_manager();
        $link = $auth->auth_check();
        ?>
        <div id="overheader">
            <div class="container">
                <?php include 'includes/web/overheader.php'; ?>
            </div>
        </div>
        <div id="header">
            <div class="container">
                <?php include 'includes/web/header.php'; ?>
                <?php include 'includes/web/nav.php'; ?>
                <?php include 'includes/web/popup.php'; ?>
            </div>
        </div>
        <div id="content">
            <div class="container">
                <?php
                 switch($_GET['page'])
                {
                    case 'risultati_ricerca':
                       include 'includes/web/risultati_ricerca.php';
                       break;
                    case 'ricerca_avanzata':
                       include 'includes/web/ricerca_avanzata.php';
                       break;
                    case 'registrazione':
                        include 'includes/web/registrazione.php';
                        break;
                    case 'help':
                        include 'includes/web/help.php';
                        break;
                    case 'netiquette':
                        include 'includes/web/netiquette.php';
                        break;
                    default:
                        include 'includes/web/home.php';
                        break;
                }
                ?>
            </div>
        </div>
        <div id="footer">
            <div class="container">
                <?php include 'includes/web/footer.php'; ?>
            </div>
        </div>
    </body>
</html>