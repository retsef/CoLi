<ul>
    <?php
    switch($status){
        case AUTH_LOGGED:
    ?>
    <li>Benvenuto <?=$user["name"];?></li>
    <li><a href="logout.php<?=$link?>">Logout</a></li>
    <?php
        break;
        case AUTH_NOT_LOGGED:
    ?>
    <li><a href="#login" class="popup_listner">Login</a></li>
    <?php
        break;
    }
    ?>
    <li><a href='/CoLi/opac/support/help.php'>Aiuto</a></li>
</ul>