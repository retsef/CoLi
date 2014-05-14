<div id="login" class="overlay">
    <div class="dialog">
        <div class="dialog_content">
            <div class="dialog_header">
                <h4>Login</h4>
                <a href="">
                    <img src="/CoLi/resources/images/icon/close.png">
                </a>
            </div>
            <div class="dialog_body">
                <form action="">
                    <div class="input_group">
                        <img src="/CoLi/resources/images/icon/user.png" alt="use_icon" class="input_addon">
                        <input type="text" placeholder="Username" name="username_box" class="input_form">
                    </div>
                    <div class="input_group">
                        <img src="/CoLi/resources/images/icon/key.png" alt="key_icon" class="input_addon">
                        <input type="password" placeholder="Password" name="password_box" class="input_form">
                    </div>
                    <?php
                    
                    list($status, $user) = auth_get_status();

                    if($status == AUTH_NOT_LOGGED){
                        $uname = strtolower(trim($_GET['username_box']));
                        $passw = strtolower(trim($_GET['password_box']));

                        if($uname == "" or $passw == ""){
                            $status = AUTH_INVALID_PARAMS;
                        }else{
                            list($status, $user) = auth_login($uname, $passw);
                            if(!is_null($user)){
                                list($status, $uid) = auth_register_session($user);
                            }
                        }
                    }
                    
                    if($_GET){
                        if(isset($_GET['login_btn'])){
                            switch($status){
                            case AUTH_LOGGED:
                                //header("Refresh: 5;URL=home.php");
                                echo '<div align="center">Sei gia connesso</div>';
                                break;
                            case AUTH_INVALID_PARAMS:
                                //header("Refresh: 5;URL=home.php");
                                echo '<div align="center">Hai inserito dati non corretti</div>';
                                break;
                            case AUTH_LOGEDD_IN:
                                switch(auth_get_option("TRANSICTION METHOD")){
                                    case AUTH_USE_LINK:
                                        //header("Refresh: 5;URL=home.php?uid=".$uid);
                                    break;
                                    case AUTH_USE_COOKIE:
                                        //header("Refresh: 5;URL=home.php");
                                        //setcookie('uid', $uid, time()+3600*365);
                                    break;
                                    case AUTH_USE_SESSION:
                                        //eader("Refresh: 5;URL=home.php");
                                        $_SESSION['uid'] = $uid;
                                    break;
                                }
                                echo '<div align="center">Ciao '.$user['name'].'</div>';
                                break;
                            case AUTH_FAILED:
                                //header("Refresh: 5;URL=home.php");
                                echo '<div align="center">Fallimento durante il tentativo di connessione</div>';
                                break;
                            default:
                                echo '<div align="center">Non riesco a verificare i dati di accesso</div>';
                                break;
                            }
                        }
                    }

                    ?>
                    <div>
                        <button type="submit" name="login_btn" class="input_button">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

