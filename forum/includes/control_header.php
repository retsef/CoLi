<div class="bucket">
    <div class="stats"></div>
    <div class="info">
        <ul>
             <?php
            list($status, $user) = auth_get_status();

            switch($status){
                case AUTH_LOGGED:
            ?>
            <li><?=$user["name"];?></li>
            <li><a href="/CoLi/forum/logout.php<?=$link?>">Logout</a></li>
            <?php
                break;
                case AUTH_NOT_LOGGED:
            ?>
            <li><a href="#login" class="popup_listner">Login</a></li>
            <?php
                break;
            }
            ?>
        </ul>
    </div>
</div>
