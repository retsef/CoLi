<?php

/**
 * Classe per la gestione del database
 * 
 * @author Roberto <r.scinocca2@studenti.unimol.it>
 */
class db_manager {
    
    private $status_conn=false;
    
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    
    /**
     * Questo e' il costrutto di funzione che viene chiamato nel momento si voglia 
     * creare un nuovo oggetto di questo tipo
     * 
     * @param type $host indirizzo del database
     * @param type $username Username per il database
     * @param type $password Password per il database
     * @param type $db Nome del database
     */
    function __construct($host, $username, $password, $db) {
        $this->db_host = $host;
        $this->db_user = $username;
        $this->db_pass = $password;
        $this->db_name = $db;
    }
    
    /**
     * Connessione al database
     * 
     * @return boolean esito
     */
    public function connect() {
        if(!$this->status_conn)
        {
            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            if($myconn) {
                $seldb = @mysql_select_db($this->db_name,$myconn);
                if($seldb) {
                    $this->status_conn = true;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    
    /**
     * Disconnessione dal database
     * 
     * @return boolean esito
     */
    public function disconnect() {
        if($this->status_conn) {
            if(@mysql_close()) {
                $this->status_conn = false;
                return true;
            }
            else {
                return false;
            }
        }
    }
    
    private $result = array();
    
    /**
     * Array indicizzato contenente il risultato dell'ultima query
     * 
     * @return Array Array indicizzato di due tipi:
     * Se la query ha dato un solo risultato l'array e' del tipo :
     * Array
     *   (
     *      [id] => O
     *      [nae] => Nae 1
     *      [email] => the@fir.st
     *   )
     * Altrimenti se ha piu' di un elemento:
     * Array
     *   (
     *       [O] => Array
     *           (
     *               [id] => O
     *               [nae] => Nae 1
     *               [email] => the@fir.st
     *           )
     *       [1] => Array
     *           (
     *               [id] => 1
     *               [nae] => Nae 2
     *               [email] => the@seco.nd
     *           )
     *       [2] => Array
     *           (
     *               [id] => 2
     *               [nae] => Nae 3
     *               [email] => 1:he@thi.rd
     *           )
     *   )
     */
    public function getResult() {
        return $this->result;
    }
    
    private $numResults = 0;
    
    /**
     * Numero di risultati ottenuti dall'ultima query
     * 
     * @return type Numero Risultati
     */
    public function numResult() {
        return $this->numResults;
    }

    /**
     * Controlla se una tabella esiste nel database
     * 
     * @param type $table Nome tabella da controllare
     * @return boolean esito
     */
    private function tableExists($table) {
        $tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb) {
            if(mysql_num_rows($tablesInDb)==1) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    /**
     * Esegue una select sul database
     *  
     * Esempio:
     * $db->select('mysqlcrud');
     * 
     * @param type $table Tabella
     * @param type $rows Campi da mastrare come risultato (default *)
     * @param type $where Condizione (default null)
     * @param type $order Ordina risultati secondo il parametro (default null)
     * @return boolean esito
     */
    public function select($table, $rows = '*', $where = null, $order = null) {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
        if($this->tableExists($table)) {
        $query = @mysql_query($q);
        if($query) {
            $this->numResults = mysql_num_rows($query);
            for($i = 0; $i < $this->numResults; $i++) {
                $r = mysql_fetch_array($query);
                $key = array_keys($r);
                for($x = 0; $x < count($key); $x++) {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x])) {
                        if(mysql_num_rows($query) > 1)
                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        else if(mysql_num_rows($query) < 1)
                            $this->result = null;
                        else
                            $this->result[$key[$x]] = $r[$key[$x]];
                    }
                }
            }           
            return true;
        } else {
            return false;
        }
        } else {
            return false;
        }
    }
    
    /**
     * Esegue una insert sul database
     * 
     * Esempio:
     * $db->insert('mysqlcrud',array(3,"Name 4","this@wasinsert.ed"));
     * 
     * @param type $table Tabella del database
     * @param type $values Valori che vanno aggiunti. Se i sono piu' di uno vanno messi in Array
     * @param type $rows Campi della tabella (default null)
     * @return boolean esito
     */
    public function insert($table,$values,$rows = null) {
        if($this->tableExists($table)) {
            $insert = 'INSERT INTO '.$table;
            if($rows != null) {
                $insert .= ' ('.$rows.')';
            }
 
            for($i = 0; $i < count($values); $i++) {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
            $ins = @mysql_query($insert);           
            if($ins) {
                return true;
            }
            else {
                return false;
            }
        }
    }
    
    /**
     * Esegue una delete sul database
     * 
     * Esempio:
     * $db->delete('mysqlcrud','name=Antonio, id=2');
     * 
     * @param type $table Tabella del database
     * @param type $where Condizione (default null)
     * @return boolean esito
     */
    public function delete($table,$where = null) {
        if($this->tableExists($table)) {
            if($where == null) {
                $delete = 'DELETE '.$table;
            } else {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            $del = @mysql_query($delete);
 
            if($del) {
                return true;
            } else {
               return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * Esegue una update sul database
     * 
     * Esempio:
     * $db->update('mysqlcrud',array('name'=>'Changed!'),array('id',1));
     * 
     * @param type $table Tabella del database
     * @param Array $rows Array contenete il valore e l'alias del nome nella tabella
     * @param Array $where Array di condizione contenete il valore e l'alias del nome nella tabella
     * @return boolean
     */
    public function update($table,$rows,$where)
    {
        if($this->tableExists($table)) {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for($i = 0; $i < count($where); $i++) {
                if($i%2 != 0) {
                    if(is_string($where[$i])) {
                        if(($i+1) != null)
                            $where[$i] = '"'.$where[$i].'" AND ';
                        else
                            $where[$i] = '"'.$where[$i].'"';
                    }
                }
            }
            $where = implode('=',$where);
             
             
            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++) {
                if(is_string($rows[$keys[$i]])) {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                } else {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }
                 
                // Parse to add commas
                if($i != count($rows)-1) {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            $query = @mysql_query($update);
            if($query) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
}

