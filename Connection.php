<?php

/**
 * Description of classConecction
 *
 * @author gesfor.rgonzalez
 */
class Connection
{

    private $db_host = '';
    private $db_database = '';
    private $db_user = '';
    private $db_password = '';

    /**
     * Pass the server settings to create the connection.
     *
     * @param [string] $db_host_
     * @param [string] $db_database_
     * @param [string] $db_user_
     * @param [string] $db_password_
     */
    public function __construct($db_host_, $db_database_, $db_user_, $db_password_)
    {
        $this->db_host = $db_host_;
        $this->db_database = $db_database_;
        $this->db_user = $db_user_;
        $this->db_password = $db_password_;
    }


    /**
     * This function returns an arrangement. The arrangement contains the connection object and other details.
     * The arrangement contains 5 keys:
     * suc_ => bool. (true = connection success)
     * obj_ => object. (The object of the connection)
     * msg_ => string. (Message sent by the function)
     * num_ => int. (numeric value of the message)
     * det_ => string. (Another more detailed message)
     * 
     * @return array
     */
    public function SimpleConnectionPDO()
    {
        try
        {
            $dsn = sprintf("mysql:host=%s;dbname=%s", $this->db_host, $this->db_database);
            $pdo = new PDO($dsn
                    , $this->db_user
                    , $this->db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET NAMES latin1");

            return $object = array(
               'suc_' => true
               , 'obj_' => $pdo
               , 'msg_' => 'Successful connection.'
               , 'num_' => 0
               , 'det_' => sprintf("Connection dns: HOST:%s, DBNAME:%s, DBUSER: %s, DBPASS:*****", $this->db_host, $this->db_database, $this->db_user)
            );
        } catch (PDOException $Ex)
        {
            return $object = array(
               'suc_' => false
               , 'obj_' => array(0=>(object)array('id' => 1, 'code' => $Ex->getCode(), 'messege' => $Ex->getMessage()))
               , 'msg_' => $Ex->getMessage()
               , 'num_' => -1
               , 'det_' => $Ex->getFile() . " | Line: " . $Ex->getLine()
            );
        }
    }

    public function PersistentConnectionPDO()
    {
        try
        {
            $dsn = sprintf("mysql:host=%s;dbname=%s",  $this->db_host, $this->db_database);
            $pdo = new PDO($dsn
                    , $this->db_user
                    , $this->db_password
                    , array(PDO::ATTR_PERSISTENT => true));

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names latin1");

            return $valores = array(
               'suc_' => true
               , 'obj_' => $pdo
               , 'msg_' => 'Successful connection.'
               , 'num_' => 0
               , 'det_' => sprintf("Connection dns: HOST:%s, DBNAME:%s, DBUSER: %s, DBPASS:*****", $this->db_host, $this->db_database, $this->db_user)
            );
        } catch (PDOException $Ex)
        {
            return $valores = array(
               'suc_' => false
               , 'obj_' => array(0=>(object)array('id' => 1, 'code' => $Ex->getCode(), 'messege' => $Ex->getMessage()))
               , 'msg_' => $Ex->getMessage()
               , 'num_' => 0
               , 'det_' => $Ex->getFile() . " | Line: " . $Ex->getLine()
            );
        }
    }   
   
   
}
