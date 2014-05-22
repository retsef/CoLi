<?php
class DB_manager
{
    private $state = false;
    private $connect = "";
    private $select = "";
    
    public function connect($host, $user, $password, $database)
    {
        if(!$this->state)
        {
            if($this->connect = mysql_connect($host, $user, $password) or die (mysql_errno()))
            {
                $this->select = mysql_select_db($database, $this->connect) or die (mysql_errno());
            }
            $this->state = true;
        } else {
            return true;
        }
    }
    
    public function disconnect()
    {
        mysql_close($this->connect);
        $this->state = false;
    }

    public function query($query)
    {
        if(!$this->state)
        {
            $result = mysql_query($query) or die (mysql_error());
            return $result;
        } else {
            return false;
        }
    }

}

?>
