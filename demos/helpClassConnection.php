<?php

require_once '../Connection.php';

## Create instance of Connection 
## Pass the server settings to create the connection.

$conn = new Connection('localhost','test','root','');


## Create simple connection.

$link = $conn->SimpleConnectionPDO();

var_dump($link);

## arrangement returned when the function was successful
/*
array (size=5)
  'suc_' => boolean true
  'obj_' => object(PDO)[2]
  'msg_' => string 'Successful connection.' (length=22)
  'num_' => int 0
  'det_' => string 'Connection dns: HOST:localhost, DBNAME:test, DBUSER: root, DBPASS:*****' (length=71)
*/

## The "obj_" key of the array contains the connection to the server and database.
var_dump($link['obj_']);


## fix returned when the function was contains an error
/*
array (size=5)
  'suc_' => boolean false
  'obj_' => 
    array (size=1)
      0 => 
        object(stdClass)[2]
          public 'id' => int 1
          public 'code' => int 1049
          public 'messege' => string 'SQLSTATE[HY000] [1049] Unknown database 'testt'' (length=47)
  'msg_' => string 'SQLSTATE[HY000] [1049] Unknown database 'testt'' (length=47)
  'num_' => int -1
  'det_' => string 'C:\xampp\htdocs\Github\components\Connection.php | Line: 51' (length=59)
*/

### SEE helpClassDataAccess.php TO GET BASE DATA