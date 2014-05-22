<div id="login" class="overlay">
    <div class="dialog">
        <div class="dialog_content">
            <div class="dialog_header">
                <h4>Login</h4>
                <a href="">
                    <img src="/CoLi/resources/images/icon/close.png" class="icon" alt="close">
                </a>
            </div>
            <div class="dialog_body">
                <form action="" method="post">
                    <div class="input_group">
                        <div class="input_group_addon">
                            <img src="/CoLi/resources/images/icon/user.png" class="icon" alt="user">
                        </div>
                        <input type="text" placeholder="Username" name="username_box" class="input_group_form">
                    </div>
                    <div class="input_group">
                        <div class="input_group_addon">
                            <img src="/CoLi/resources/images/icon/key.png" class="icon" alt="password">
                        </div>
                        <input type="password" placeholder="Password" name="password_box" class="input_group_form">
                    </div>
                    <?php
                    
                    list($status, $user) = $auth->auth_get_status();

                    if($status == AUTH_NOT_LOGGED){
                        $uname = strtolower(trim($_POST['username_box']));
                        $passw = strtolower(trim($_POST['password_box']));

                        if($uname == "" or $passw == ""){
                            $status = AUTH_INVALID_PARAMS;
                        }else{
                            list($status, $user) = $auth->auth_login($uname, $passw);
                            if(!is_null($user)){
                                list($status, $uid) = $auth->auth_register_session($user);
                            }
                        }
                    }
                    
                    if($_POST){
                        if(isset($_POST['login_btn'])){
                            switch($status){
                            case AUTH_LOGGED:
                                header("Refresh: 1;URL=index.php");
                                echo '<div align="center">Sei gia connesso</div>';
                                break;
                            case AUTH_INVALID_PARAMS:
                                //header("Refresh: 1;URL=index.php");
                                echo '<div align="center">Hai inserito dati non corretti</div>';
                                break;
                            case AUTH_LOGEDD_IN:
                                switch($auth->auth_get_option("TRANSICTION METHOD")){
                                    case AUTH_USE_LINK:
                                        header("Refresh: 1;URL=index.php?uid=".$uid);
                                    break;
                                    case AUTH_USE_COOKIE:
                                        header("Refresh: 1;URL=index.php");
                                        setcookie('uid', $uid);
                                    break;
                                    case AUTH_USE_SESSION:
                                        header("Refresh: 1;URL=index.php");
                                        $_SESSION['uid'] = $uid;
                                    break;
                                }
                                echo '<div align="center">Ciao '.$user['name'].'</div>';
                                break;
                            case AUTH_FAILED:
                                //header("Refresh: 1;URL=index.php");
                                echo '<div align="center">Fallimento durante il tentativo di connessione</div>';
                                break;
                            default:
                                echo '<div align="center">Non riesco a verificare i dati di accesso</div>';
                                break;
                            }
                        }
                    }

                    ?>
                    <div class="input_group_btn">
                        <button type="submit" name="login_btn" class="btn">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

