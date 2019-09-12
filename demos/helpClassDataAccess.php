<?php
require_once '../Connection.php';

## SEE HELP TO CREATE A CONNECTION. helpClassConnection.php
$conn = new Connection('localhost','test','root','');
$link = $conn->SimpleConnectionPDO();
###########################################################


require_once '../DataAccess.php';

#Create instance of DataAccess
$exec = new DataAccess();

#Pass object Connection
$exec->SetConn($link['obj_']);


## SEE HELP TO CREATE A QUERY STRING. helpClassStringQueryCreator.php
require_once '../StringQueryCreator.php';
$sqry = new StringQueryCreator();
$sqry->setFIELDS('id, val1, val2, val3');
$sqry->setTABLE('pruebas');
$query = $sqry->CreateSelectString();
#######################################################################

/*
Type of query you want to execute. 
SELECT = "Read".
INSERT = "Insert"
UPDATE = "Update"
DELETE = "Delete"
*/
$exec->setQueryCmd("Read");

## We send the query string as a parameter
$exec->setQueryCrud($query);

## Execute the query and return an array and in the key "obj_" comes the object with the data or a response from the base.
$dats = $exec->ExecuteCommand();

var_dump($dats);

/* 
array (size=5)
    'suc_' => boolean true
    'obj_' => 
        array (size=18)
            0 => 
                object(stdClass)[5]
                public 'id' => string '1' (length=1)
                public 'val1' => string 'Samsung S9' (length=10)
                public 'val2' => string 'Corea' (length=5)
                public 'val3' => string '18501' (length=5)
            1 => 
                object(stdClass)[8]
                public 'id' => string '2' (length=1)
                public 'val1' => string 'Sony Z3' (length=7)
                public 'val2' => string 'Japón' (length=6)
                public 'val3' => string '6550' (length=4)
            2 => 
                object(stdClass)[11]
                public 'id' => string '3' (length=1)
                public 'val1' => string 'iPhone 11' (length=9)
                public 'val2' => string 'USA' (length=3)
                public 'val3' => string '25500' (length=5)
            3 => [...]
    'msg_' => string 'Success' (length=7)
    'num_' => int 18
    'det_' => string 'Stored Procedure or Query is ok. Affected rows matched: 18 || SELECT id, val1, val2, val3 FROM pruebas   ;' (length=106)      
*/

var_dump($dats['obj_']);

/*
array (size=18)
  0 => 
    object(stdClass)[5]
      public 'id' => string '1' (length=1)
      public 'val1' => string 'Samsung S9' (length=10)
      public 'val2' => string 'Corea' (length=5)
      public 'val3' => string '18501' (length=5)
  1 => 
    object(stdClass)[8]
      public 'id' => string '2' (length=1)
      public 'val1' => string 'Sony Z3' (length=7)
      public 'val2' => string 'Japón' (length=6)
      public 'val3' => string '6550' (length=4)
  2 => [...]
*/
