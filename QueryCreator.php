<?php


class QueryCreator
{

    private $FIELDS = array('*');
    private $TABLE = '';
    private $WHERE = array();
    private $ORDER = array();
    private $DESC = false;
    private $OPTIONS = '';
    private $GROUPBY = array();
    private $HAVING = array();
    private $LIMIT = '';
    private $INNERS = '';
    
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
        $this->WHERE = $WHERE;

        return $this;
    }

    /**
     * Set the array() value of ORDER
     * Set the string value of DESC
     *
     * @return  self
     */ 
    public function setORDER($ORDER, $DESC = false)
    {
        $this->ORDER = $ORDER;
        $this->DESC = $DESC;

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
        $this->GROUPBY = $GROUPBY;

        return $this;
    }

    /**
     * Set the value of HAVING
     *
     * @return  self
     */ 
    public function setHAVING($HAVING)
    {
        $this->HAVING = $HAVING;

        return $this;
    }

    /**
     * Set the value of LIMIT [ 5 | 5,10 | 100,18446744073709551615 ]
     *
     * @return  self
     */ 
    public function setLIMIT($LIMIT)
    {
        $this->LIMIT = $LIMIT;

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
        
        $inners = '';
        foreach ($nomargs as $key => $value)
        {
            $inners .= $value;
        }

        $this->INNERS = $inners;

        return $this;
    }


    public function CreateSimpleSelect()
    {

        $fields = implode(", ",$this->FIELDS);
        $table = $this->TABLE;
        $where = $this->ConstructWhere();
        $order = $this->ConstructOrder();
        $options = $this->OPTIONS;
        $groupby = $this->ConstructGroupBy();
        $having = $this->ConstructHaving();
        $limit = ($this->LIMIT === '') ? '' : 'LIMIT ' . $this->LIMIT;

        $simple_select = "SELECT $options $fields FROM $table $where $groupby $having $order $limit;";
        $simple_select = str_replace("  ", " ", $simple_select);

        return $simple_select;

    }

    public function CreateInnerSelect()
    {

        $fields = implode(", ",$this->FIELDS);
        $table = $this->TABLE;
        $where = $this->ConstructWhere();
        $order = $this->ConstructOrder();
        $options = $this->OPTIONS;
        $groupby = $this->ConstructGroupBy();
        $having = $this->ConstructHaving();
        $limit = ($this->LIMIT = '') ? '' : 'LIMIT ' . $this->LIMIT;
        $inners = $this->INNERS;

        $inner_select = "SELECT $options $fields FROM $table $inners $where $groupby $having $order $limit;";
        $inner_select = str_replace("  ", " ", $inner_select);

        return $inner_select;

    }

    private function ConstructWhere()
    {

        if( empty($this->WHERE ))
        {
            return "";
        }

        $num_param = count($this->WHERE);
        $string_where = "WHERE ";
        $i = 0;

        foreach ($this->WHERE as $key => $value) 
        {
            $string_where .= $key . "='" . $value . "'";
            $i++;
            if( $i < $num_param )
            {
                $string_where .= " AND ";
            }
        }

        return $string_where;
    }

    private function ConstructOrder()
    {

        if( empty($this->ORDER ))
        {
            return "";
        }

        $order = 'ORDER BY ';
        $order .= implode(', ', $this->ORDER );

        if($this->DESC)
        {
            $order .= " DESC ";
        }

        return $order;

    }

    private function ConstructGroupBy()
    {

        if( empty($this->GROUPBY ))
        {
            return "";
        }

        $groupby = 'GROUP BY ';
        $groupby .= implode(', ', $this->GROUPBY );

        return $groupby;

    }

    private function ConstructHaving()
    {

        if( empty($this->HAVING ))
        {
            return "";
        }

        $num_param = count($this->HAVING);
        $string_having = "HAVING ";
        $i = 0;

        foreach ($this->WHERE as $key => $value) 
        {
            $string_having .= $key . "='" . $value . "'";
            $i++;
            if( $i < $num_param )
            {
                $string_having .= " AND ";
            }
        }

        return $string_having;
    }





}