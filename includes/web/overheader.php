<ul>
    <?php
    list($status, $user) = $auth->auth_get_status();
    
    switch($status){
        case AUTH_LOGGED:
    ?>
    <li>Benvenuto <?=$user["name"];?></li>
    <li><a href="/CoLi/forum/control.php<?=$link?>">Gestione</a></li>
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
    <li><a href='./index.php?page=help'>Aiuto</a></li>
</ul>