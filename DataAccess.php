<?php

/**
 * Description of DataAccess
 *
 * @author gesfor.rgonzalez
 */
class DataAccess
{
    private $respConn = null;
    private $params = '{":none":"none|string"}';
    private $querycmd = "";
    private $querycrud = "";

    /**
     * 
     * Execute the query and return an array and in the key "obj_" comes the object with the data or a response from the base.
     * The arrangement contains 5 keys:
     * suc_ => bool. (true = Query success)
     * obj_ => object. (Object with database response)
     * msg_ => string. (Message sent by the function)
     * num_ => int. (Number of records returned)
     * det_ => string. (Another more detailed message)     
     * 
     * 
     * @return array
     * 
     */
    public function ExecuteCommand()
    {
        $pars = $this->ValidateParams();
        if ($pars['suc_'] === false) {
            return $pars;
        }
        foreach ($this->CreateJsonEncode() as $key => $value)
        {
            if ($key === 'params') {$ArrayParams = $value;}
            else if ($key === 'vars') {$ArrayVar = $value;}
        }
        $StrQry = $ArrayVar->QueryString;
        try {

            $DatsJson = $this->ExecuteQry($ArrayParams, $StrQry, $ArrayVar);
            return $DatsJson;

        } catch (Exception $Ex) {

            $DatsJson = $this->MsgErrException($Ex);
            return $DatsJson;
        }
    }

    private function ValidateParams()
    {
        $json_valid = $this->CreateJsonEncode();
        if (is_null($json_valid)) {
            $values = array(
                'suc_' => false
                , 'obj_' => array(0 => (object) array('id' => 1, 'code' => 0, 'messege' => 'Error in json string...'))
                , 'msg_' => 'Error in json string. Something is wrong en json string, please validate...'
                , 'num_' => -1
                , 'det_' => "Error in json string. Something is wrong en json string, please validate...",
            );
            return $values;
        }
        else
        {

            $names = '';
            foreach ($this->CreateJsonEncode() as $key => $value)
            {
                if ($key === 'params') {$names .= '1';}
                else if ($key === 'vars') {$names .= '1';}
            }
            if($names !== '11')
            {
                $values = array(
                    'suc_' => false
                    , 'obj_' => array(0 => (object) array('id' => 1, 'code' => 0, 'messege' => 'Error in key(s) of json string...'))
                    , 'msg_' => 'Error in keys of json string.'
                    , 'num_' => -1
                    , 'det_' => 'Error in keys of json string. Example: {"params":{":param1":1},"vars":{"TypeFuncion":"Read",QueryString":"SELECT field1, field2 FROM table1 WHERE field3 = :param1;"}}',
                );
                return $values;
            }

            $values = array(
                'suc_' => true
                , 'obj_' => array(0 => (object) array('id' => 1, 'code' => 1, 'messege' => 'Valid json string'))
                , 'msg_' => 'Parameters ok. Valid json string...'
                , 'num_' => 1
                , 'det_' => "Success parameters!",
            );
            return $values;
        }
    }

    private function ExecuteQry($ArrayParams, $StrSP, $ArrayVar)
    {
        $Statement = $this->respConn->prepare($StrSP);
        $i = 1;

        if(strpos($StrSP, '?'))
        {
            foreach ($ArrayParams as $value) {
                $vals = explode('|',$value);
                $type = $this->TipoDat($vals);
                $Statement->bindValue($i, $type[0], $type[1]);
                $i++;
            }
        }
        else
        {
            foreach ($ArrayParams as $key => $value) {
                $vals = explode('|',$value);
                $type = $this->TipoDat($vals);
                $Statement->bindParam($key, $type[0], $type[1]);
            }
        }

        $result = $Statement->execute();

        if ($result === true) {

            $NumRows = $Statement->rowCount();

            if($ArrayVar->TypeFuncion === 'Read')
            {
                $Table = $Statement->fetchAll(\PDO::FETCH_OBJ);
            }
            else if($ArrayVar->TypeFuncion === 'Insert')
            {
                $last_id = $this->respConn->lastInsertId();
                $Table = array(0 => (object) array('id' => 1, 'code' => $last_id, 'messege' => 'Row id inserted: ' . $last_id ));
            }
            else if($ArrayVar->TypeFuncion === 'Update')
            {
                $last_id = $this->respConn->lastInsertId();
                $Table = array(0 => (object) array('id' => 1, 'code' => $last_id, 'messege' => 'Row updated' ));
            }
            else if($ArrayVar->TypeFuncion === 'Delete')
            {
                $last_id = $this->respConn->lastInsertId();
                $Table = array(0 => (object) array('id' => 1, 'code' => $last_id, 'messege' => 'Row deleted' ));
            }
            else
            {
                $Table = array(0 => (object) array('id' => 1, 'code' => 1, 'messege' => 'Affected rows matched: ' . $NumRows ));
            }

            if ($NumRows === 0) {
                $Table = array(0 => (object) array('id' => 1, 'code' => 0, 'messege' => 'Affected rows matched: ' . $NumRows ));
            }

            $values = array('suc_' => true
                , 'obj_' => $Table
                , 'msg_' => 'Success'
                , 'num_' => $NumRows
                , 'det_' => "Stored Procedure or Query is ok. Affected rows matched: " . $NumRows . ' || ' . $StrSP);
            $DatsJson = $values;
            return $DatsJson;
        } else {
            $values = array('suc_' => false
                , 'obj_' => $result
                , 'msg_' => 'Error'
                , 'num_' => 0
                , 'det_' => "Stored Procedure or Query width errors." . ' || ' . $StrSP);
            $DatsJson = $values;
            return $DatsJson;
        }
    }

    private function TipoDat($dat)
    {
        if($dat[1] === 'string')
        {
            return array($dat[0],PDO::PARAM_STR);
        }
        else if($dat[1] === 'int')
        {
            return array((int)$dat[0],PDO::PARAM_STR);
        }
        else if($dat[1] === 'bool')
        {
            return array((bool)$dat[0],PDO::PARAM_STR);
        }
    }

    private function MsgErrException($Ex)
    {
        $values = array(
            'suc_' => false
            , 'obj_' => array(0 => (object) array('id' => 1, 'code' => $Ex->getCode(), 'messege' => $Ex->getMessage()))
            , 'msg_' => $Ex->getMessage()
            , 'num_' => (int) $Ex->getCode()
            , 'det_' => $Ex->getFile() . " | Line: " . $Ex->getLine(),
        );
        $DatsJson = $values;
        return $DatsJson;
    }

    private function CreateJsonEncode()
    {
        $JsonParams = '{"params":' . $this->params . ',
                "vars":{"TypeFuncion":"' . $this->querycmd . '","QueryString":"' . $this->querycrud . '"}}';

        return json_decode($JsonParams);
    }

    /**
     *
     * We need to pass a connection to the base in order to obtain the data or generate an insert, update or delete.
     * 
     * @param object $respConn_
     */
    public function SetConn($respConn_)
    {
        $this->respConn = $respConn_;
    }

    /**
     * 
     * Parameters to the query. array(":field"=>"value|type[string]")
     * We must send the parameters within an associative array where the key is the name of the field. 
     * The value is separated from a pipe with the data type of the value.
     * Example: array(":field"=>"Hello World|string", ":filed2"=>"25|int")
     * 
     */
    public function setParams($params)
    {
        $this->params = json_encode($params);
    }

    /**
     * 
     * Type of query you want to execute. 
     * SELECT = "Read".
     * INSERT = "Insert"
     * UPDATE = "Update"
     * DELETE = "Delete"
     *
     * @param string $querycmd
     */
    public function setQueryCmd($querycmd)
    {
        $this->querycmd = $querycmd;
    }

    /**
     * 
     * Send the query string as a parameter
     *
     * 
     * @param string $querycrud
     * 
     */
    public function setQueryCrud($querycrud)
    {
        $this->querycrud = $querycrud;

    }
}
