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
        /*
            ini_set('display_errors', 1);
            error_reporting(E_ALL | E_STRICT);
        */
            include_once("../includes/api/db/auth/auth_manager.php");

            $auth = new auth_manager();
            $link = $auth->auth_check();
        ?>
        <div id="offsrceen">
            <?php include 'includes/web/popup.php'; ?>
        </div>
        <div id="sidebar">
            <?php include 'includes/web/control_sidebar.php'; ?>
        </div>
        <div id="header">
            <?php include 'includes/web/control_header.php' ?>
        </div>
        <div id="content">
            <div class="container">
                <?php
                 switch($_GET['page'])
                {
                    case 'link1':
                        include 'includes/web/control_front.php';
                        break;
                    case 'user_manager':
                        include 'includes/web/control_user.php';
                        break;
                    case 'book_manager' :
                        include 'includes/web/control_book.php';
                        break;
                    default:
                        echo "<div class=bucket> Pagina non trovata </div>";
                        break;
                }
                ?>
            </div>
        </div>
    </body>
</html>