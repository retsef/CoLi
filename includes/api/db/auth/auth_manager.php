<?php

include 'auth_config.php';
include "$_SERVER[DOCUMENT_ROOT]/CoLi/includes/api/db/db_manager.php";

class auth_manager {

    private $conn;

    function __construct() {
        global $_CONFIG;

        //$this->conn = mysql_connect($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass']);
        $this->conn = new db_manager($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']);
        $this->conn->connect();
        if (!$this->conn) {
            throw new Exception('Impossibile stabilire una connessione ' . mysql_errno());
        }
        //mysql_select_db($_CONFIG['dbname']);
    }

    function auth_set_option($opt_name, $opt_value) {
        global $_AUTH;

        $_AUTH[$opt_name] = $opt_value;
    }

    function auth_get_option($opt_name) {
        global $_AUTH;

        return is_null($_AUTH[$opt_name]) ? NULL : $_AUTH[$opt_name];
    }

    function auth_clean_expired() {
        global $_CONFIG;

        //$result = mysql_query("SELECT creation_date FROM " . $_CONFIG['table_sessioni'] . " WHERE uid='" . $this->auth_get_uid() . "'");
        $result = $this->conn->select($_CONFIG['table_sessioni'], "cration_date", "uid='" . $this->auth_get_uid() . "'");
        if ($result) {
            $data = $this->conn->getResult();
            if ($data['creation_date']) {
                if ($data['creation_date'] + $_CONFIG['expire'] <= time()) {
                    switch ($this->auth_get_option("TRANSICTION METHOD")) {
                        case AUTH_USE_COOKIE:
                            setcookie('uid');
                            break;
                        case AUTH_USE_LINK:
                            global $_GET;
                            if (isset($_GET['uid']))
                                $_GET['uid'] = NULL;
                            break;
                    }
                }
            }
        }

        $this->conn->delete($_CONFIG['table_sessioni'], "creation_date + " . $_CONFIG['expire'] . " <= " . time());
        /*
          mysql_query("
          DELETE FROM " . $_CONFIG['table_sessioni'] . "
          WHERE creation_date + " . $_CONFIG['expire'] . " <= " . time()
          );
         */
    }

    function auth_get_uid() {

        $uid = NULL;

        switch ($this->auth_get_option("TRANSICTION METHOD")) {
            case AUTH_USE_COOKIE:
                global $_COOKIE;
                if (isset($_COOKIE['uid']))
                    $uid = $_COOKIE['uid'];
                break;
            case AUTH_USE_LINK:
                global $_GET;
                if (isset($_GET['uid']))
                    $uid = $_GET['uid'];
                break;
        }

        return $uid ? $uid : NULL;
    }

    function auth_get_status() {
        global $_CONFIG;

        $this->auth_clean_expired();
        $uid = $this->auth_get_uid();
        if (is_null($uid))
            return array(AUTH_NOT_LOGGED, NULL);
        /*
          $this->conn->select($_CONFIG['table_sessioni'] . " S," . $_CONFIG['table_utenti'] . " U",
          "U.name as name, U.surname as surname, U.username as username",
          "S.user_id = U.id and S.uid = '" . $uid . "'");
        
          $result = mysql_query("SELECT U.name as name, U.surname as surname, U.username as username
          FROM " . $_CONFIG['table_sessioni'] . " S," . $_CONFIG['table_utenti'] . " U
          WHERE S.user_id = U.id and S.uid = '" . $uid . "'");
         */
        $this->conn->select("user_session", "name,surname,username", "uid = '" . $uid . "'");

        if (count($this->conn->getResult()) != 3) {
            return array(AUTH_NOT_LOGGED, NULL);
        } else {
            $user_data = $this->conn->getResult();
            return array(AUTH_LOGGED, array_merge($user_data, array('uid' => $uid)));
        }
    }

    function auth_login($uname, $passw) {
        global $_CONFIG;

        $this->conn->select($_CONFIG['table_utenti'], "*", "username='" . $uname . "' and password=MD5('" . $passw . "')");
        /*
          $result = mysql_query("
          SELECT *
          FROM " . $_CONFIG['table_utenti'] . "
          WHERE username='" . $uname . "' and password=MD5('" . $passw . "')"
          ); */
        if (count($this->conn->getResult()['id']) != 1) {
            return array(AUTH_INVALID_PARAMS, NULL);
        } else {
            return array(AUTH_LOGEDD_IN, $this->conn->getResult());
        }
    }

    function auth_generate_uid() {

        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float) $sec + ((float) $usec * 100000));
        return md5(uniqid(mt_rand(), true));
    }

    function auth_register_session($udata) {
        global $_CONFIG;

        $uid = $this->auth_generate_uid();
        /*
          $this->conn->insert($_CONFIG['table_sessioni'],
          "'" . $uid . "', '" . $udata['id'] . "', " . time(),
          "uid, user_id, creation_date"); */

        $this->conn->insert($_CONFIG['table_sessioni'], array($uid, $udata['id'], time()));

        /*
          mysql_query("
          INSERT INTO " . $_CONFIG['table_sessioni'] . "
          (uid, user_id, creation_date)
          VALUES
          ('" . $uid . "', '" . $udata['id'] . "', " . time() . ")
          "
          ); */
        if (!mysql_insert_id()) {
            return array(AUTH_LOGEDD_IN, $uid);
        } else {
            return array(AUTH_FAILED, NULL);
        }
    }

    function auth_logout() {
        global $_CONFIG;

        $uid = $this->auth_get_uid();

        if (is_null($uid)) {
            return false;
        } else {
            /*
              mysql_query("
              DELETE FROM " . $_CONFIG['table_sessioni'] . "
              WHERE uid = '" . $uid . "'"
              ); */
            $this->conn->delete($_CONFIG['table_sessioni'], "uid = '" . $uid . "'");
            return true;
        }
    }

    function auth_check() {
        list($status, $user) = $this->auth_get_status();

        if ($status == AUTH_LOGGED & $this->auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK) {
            return "?uid=" . $_GET['uid'];
        } else
            return '';
    }

}
