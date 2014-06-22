<?php

include 'auth_config.php';
include 'auth_exception.php';
include "$_SERVER[DOCUMENT_ROOT]/CoLi/includes/api/db/db_manager.php";

/**
 * Classe preposta all'autenticazione
 * 
 * @author Roberto <r.scinocca2@studenti.unimol.it>
 */
class auth_manager {

    private $conn;
    
    /**
     * Questo e' il costrutto di funzione che viene chiamato nel momento si voglia 
     * creare un nuovo oggetto di questo tipo
     * 
     * @global $_CONFIG Array indicizzato contenente le configurazioni
     * @exception Nel caso non si riesca a connettersi al database
     */
    function __construct() {
        global $_CONFIG;

        //$this->conn = mysql_connect($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass']);
        $this->conn = new db_manager($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'], $_CONFIG['dbname']);
        $this->conn->connect();
        if (!$this->conn) {
            throw new auth_exception('Impossibile stabilire una connessione ' . mysql_errno());
        }
        //mysql_select_db($_CONFIG['dbname']);
    }
    
    /**
     * Cambia la metodologia di autenticazione agendo su $_AUTH
     * 
     * @global $_AUTH Contiene la metodologia per l'autentica
     * @param $opt_name Nome dell'indice dell'array $_AUTH
     * @param $opt_value Valore da assegnare
     */
    function auth_set_option($opt_name, $opt_value) {
        global $_AUTH;

        $_AUTH[$opt_name] = $opt_value;
    }

    /**
     * Ottiene la metodologia usata
     * 
     * @global $_AUTH Contiene la metodologia per l'autentica
     * @param $opt_name Nome dell'indice dell'array $_AUTH
     * @return Restituisce il valore contenuto in $_AUTH indice $opt_name,
     *  se esiste, altimenti NULL
     */
    function auth_get_option($opt_name) {
        global $_AUTH;

        return is_null($_AUTH[$opt_name]) ? NULL : $_AUTH[$opt_name];
    }

    /**
     * Rimmuove le sessioni scadute
     * 
     * Verifica la metodologia e nel caso di:
     * cookie: setta un cookie vuoto con l'uid della sessione.
     * link: setta il link a NULL.
     * 
     * @global $_CONFIG Array indicizzato contenente le configurazioni
     * 
     */
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
    }

    /**
     * Ottiene l'uid
     * 
     * @global $_COOKIE Array contente i cookie
     * @uses $uid Codice identificativo che accomuna un utente con una sessione
     * @return Se si e' trovato un uid viene restituito altrimenti NULL
     */
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

    /**
     * 
     * @global $_CONFIG Array indicizzato contenente le configurazioni
     * @return array Restituisce un arrai di due elementi di cui:
     * il primo e' il teg di stato AUTH_NOT_LOGGED/AUTH_LOGGED;
     * il secondo, a seconda delle condizioni e delle combinazioni con il primo, puo' essere:
     *  NULL se l'utente non e' loggato.
     *  Array indicizzato con nome,surname,username,uid dell'utente.
     */
    function auth_get_status() {
        global $_CONFIG;

        $this->auth_clean_expired();
        $uid = $this->auth_get_uid();
        if (is_null($uid))
            return array(AUTH_NOT_LOGGED, NULL);
        
        $this->conn->select($_CONFIG['table_instance'], "name,surname,username", "uid = '" . $uid . "'");
        
        if ($this->conn->numResult() != 1) {
            return array(AUTH_NOT_LOGGED, NULL);
        } else {
            $user_data = $this->conn->getResult();
            return array(AUTH_LOGGED, array_merge($user_data, array('uid' => $uid)));
        }
    }

    /**
     * Funzione per il Login
     * 
     * @global $_CONFIG Array indicizzato contenente le configurazioni
     * @param type $uname Username utente
     * @param type $passw Password utente
     * @return Array Se username e password non sono corrette restituisce un array con AUTH_INVALID_PARAMS e NULL
     * altrimenti restituisce un array con AUTH_LOGEDD_IN e con i risultati della select
     */
    function auth_login($uname, $passw) {
        global $_CONFIG;

        $this->conn->select($_CONFIG['table_utenti'], "*", "username='" . $uname . "' and password=MD5('" . $passw . "')");
        
        if (count($this->conn->getResult()['id']) != 1) {
            return array(AUTH_INVALID_PARAMS, NULL);
        } else {
            return array(AUTH_LOGEDD_IN, $this->conn->getResult());
        }
    }

    /**
     * Genera un uid
     * 
     * @return uid Numero per identificare un utente che accede ad una sessione
     */
    function auth_generate_uid() {

        list($usec, $sec) = explode(' ', microtime());
        mt_srand((float) $sec + ((float) $usec * 100000));
        return md5(uniqid(mt_rand(), true));
    }

    /**
     * Registra una nuova sessione
     * 
     * @global $_CONFIG Array indicizzato contenente le configurazioni
     * @param $udata Array contenente i dati dell'utente (nome,cognome,username,passw...)
     * @return Array Se va a buon fine restituisce un array con AUTH_LOGEDD_IN e l'uid utilizzato
     * altimenti un array con AUTH_FAILED e NULL
     */
    function auth_register_session($udata) {
        global $_CONFIG;

        $uid = $this->auth_generate_uid();

        $this->conn->insert($_CONFIG['table_sessioni'], array($uid, $udata['id'], time()));

        if (!mysql_insert_id()) {
            return array(AUTH_LOGEDD_IN, $uid);
        } else {
            return array(AUTH_FAILED, NULL);
        }
    }

    /**
     * Funzione di Logout
     * 
     * @global $_CONFIG Array indicizzato contenente le configurazioni
     * @return boolean esito dell'operazione
     */
    function auth_logout() {
        global $_CONFIG;

        $uid = $this->auth_get_uid();

        if (is_null($uid)) {
            return false;
        } else {
            $this->conn->delete($_CONFIG['table_sessioni'], "uid = '" . $uid . "'");
            return true;
        }
    }

    /**
     * Controlla se l'utente e' loggato e se usa una metodologia di tipo AUTH_USE_LINK
     * 
     * @return string Contiene l'uid della sessione
     */
    function auth_check() {
        list($status, $user) = $this->auth_get_status();

        if ($status == AUTH_LOGGED & $this->auth_get_option("TRANSICTION METHOD") == AUTH_USE_LINK) {
            return "?uid=" . $_GET['uid'];
        } else
            return '';
    }

}
