<?php


class StringQueryCreator
{

    private $FIELDS = "";
    private $TABLE = "";
    private $WHERE = "";
    private $ORDER = "";
    private $OPTIONS = "";
    private $GROUPBY = "";
    private $HAVING = "";
    private $LIMIT = "";
    private $INNERS = "";
    private $VALUES = "";
    
    /**
     * Set the value of FIELDS
     *
     * @return  self
     */ 
    public function setFIELDS($FIELDS)
    {
        $this->FIELDS = $FIELDS;

        return $this;
    }

    /**
     * Set the value of TABLE
     *
     * @return  self
     */ 
    public function setTABLE($TABLE)
    {
        $this->TABLE = $TABLE;

        return $this;
    }

    /**
     * Set the value of WHERE
     *
     * @return  self
     */ 
    public function setWHERE($WHERE)
    {
        $this->WHERE = "WHERE " . $WHERE;

        return $this;
    }

    /**
     * Set the array() value of ORDER
     * Set the bool value of DESC (by default is FALSE)
     *
     * @return  self
     */ 
    public function setORDER($ORDER, $DESC = false)
    {

        $desc = ($DESC == TRUE) ? "DESC " : ""; 

        $this->ORDER = "ORDER BY " . $ORDER . $desc;

        return $this;
    }

    /**
     * Set the value of OPTIONS [ALL | DISTINCT | DISTINCTROW]
     *
     * @return  self
     */ 
    public function setOPTIONS($OPTIONS)
    {
        $this->OPTIONS = $OPTIONS;

        return $this;
    }

    /**
     * Set the value of GROUPBY
     *
     * @return  self
     */ 
    public function setGROUPBY($GROUPBY)
    {
        $this->GROUPBY = "GROUP BY " . $GROUPBY;

        return $this;
    }

    /**
     * Set the value of HAVING
     *
     * @return  self
     */ 
    public function setHAVING($HAVING)
    {
        $this->HAVING = "HAVING " . $HAVING;

        return $this;
    }

    /**
     * Set the value of LIMIT [ 5 | 5,10 | 100,18446744073709551615 ]
     *
     * @return  self
     */ 
    public function setLIMIT($LIMIT)
    {

        $this->LIMIT = ($LIMIT == "") ? "" : "LIMIT " . $LIMIT;

        return $this;
    }

    /**
     * $inner1 = "INNER JOIN Table T2 ON T1.id = T2.id"
     * $inner1 = "INNER JOIN Table T3 ON T1.id = T3.id"
     * $inner1 = "INNER JOIN Table T4 ON T2.id = T4.id"
     * Set the value of INNERS. Add a Inner for every argument. setINNERS($inner1, $inner2, $inner3...)
     *
     * @return  self
     */ 
    public function setINNERS()
    {

        $numargs = func_num_args();
        $nomargs = func_get_args();
        
        $inners = "";
        foreach ($nomargs as $key => $value)
        {
            $inners .= $value;
        }

        $this->INNERS = $inners;

        return $this;
    }

    /**
     * Set the value of VALUES
     *
     * @return  self
     */ 
    public function setVALUES($VALUES)
    {
        $this->VALUES = $VALUES;

        return $this;
    }    

    public function CreateSelectString()
    {

        $fields = $this->FIELDS;
        $table = $this->TABLE;
        $where = $this->WHERE;
        $order = $this->ORDER;
        $options = $this->OPTIONS;
        $groupby = $this->GROUPBY;
        $having = $this->HAVING;
        $limit = $this->LIMIT = '';
        $inners = $this->INNERS;

        $string_select = "SELECT $options $fields FROM $table $inners $where $groupby $having $order $limit;";
        $string_select = str_replace("  ", " ", $string_select);

        return $string_select;

    }

    public function CreateInsertString()
    {
        $fields = $this->FIELDS;
        $table = $this->TABLE;
        $values = $this->VALUES;

        $string_insert = "INSERT INTO $table ( $fields ) VALUES ( $values );";
        $string_insert = str_replace("  ", " ", $string_insert);
        
        return $string_insert;
    }

    public function CreateUpdateString()
    {

        $table = $this->TABLE;
        $fields = $this->FIELDS;
        $values = $this->VALUES;
        $where = $this->WHERE;

        $arr_fiel = explode(",", $fields);
        $arr_vals = explode(",", $values);

        $col_val = "";

        for ( $i = 0; $i < count( $arr_fiel ); $i++) { 
            
            $col_val .= $arr_fiel[$i] . "=" . $arr_vals[$i] . ",";
        }

        $col_val = trim($col_val, ',');

        $string_update = "UPDATE $table SET $col_val $where;";
        $string_update = str_replace("  ", " ", $string_update);

        return $string_update;        
    }


}