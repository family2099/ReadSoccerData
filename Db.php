<?php
header("content-type: text/html; charset=utf-8");

class database
{
    protected $_dbms = "mysql";             //資料庫類型 
    protected $_host = "localhost";         //資料庫ip位址
    // protected $_port = "3306";           //資料庫埠
    protected $_username = "root";          //資料庫用戶名
    protected $_password = "";              //密碼
    protected $_dbname = "football";            //資料庫名
    // protected $_charset = "utf-8";       //資料庫字元編碼
    public $_dsnconn=null;                    //data soruce name 資料來源
  
    /*-------------------------
    預設先連資料庫
    -------------------------*/
    public function __construct()
    {
        try 
        {
            $this->_dsnconn = new PDO($this->_dbms.':host='.$this->_host.';dbname='.$this->_dbname,$this->_username,$this->_password);
         
            $this->_dsnconn->exec("SET CHARACTER SET utf8");
        } 
        catch (PDOException $e) {
        	return 'Error!: ' . $e->getMessage() . '<br />';
        }
    }
    
    public function insertGame($league, $time, $gameName, $win1, $allHandicap, $allBigSmall, $mono, $win2, $halfHandicap, $halfBigSmall)
    {
        
        $query = "INSERT INTO `game` (`league`, `time`, `gameName`, `win1`, `allHandicap`, `allBigSmall`, `mono`, `win2`, `halfHandicap`, `halfBigSmall`)
            VALUES (:league, :time, :gameName, :win1, :allHandicap, :allBigSmall, :mono, :win2, :halfHandicap, :halfBigSmall)";
        
        $result = $this->_dsnconn->prepare($query);
        $result->execute([
                ':league' => $league,
                ':time' => $time,
                ':gameName' => $gameName,
                ':win1' => $win1,
                ':allHandicap' => $allHandicap,
                ':allBigSmall' => $allBigSmall,
                ':mono' => $mono,
                ':win2' => $win2,
                ':halfHandicap' => $halfHandicap,
                ':halfBigSmall' => $halfBigSmall
            ]);

    }
    
    public function deleteGame()
    {
        $query = "DELETE FROM `game`";
        $result = $this->_dsnconn->prepare($query);
        $result->execute();
        
    }
    
    public function getGame()
    {
        $query = "SELECT * FROM `game`";
        $row = $this->_dsnconn->prepare($query);
        $row->execute();
        $result = $row->fetchAll();
        
        return $result;
    }
   
    /*
    *關閉資料連接
    **/
    public function close() {
        $this->$_dsnconn = null;
    }
}
 
?>