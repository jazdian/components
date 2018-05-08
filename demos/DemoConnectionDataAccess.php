<?php

require_once '../Connection.php';
require_once '../DataAccess.php';


#Open connection
#Create instance of Connection 
$conn = new Connection('localhost','inventarios','root','');
#Create simple connection
$link = $conn->SimpleConnectionPDO();

var_dump($link);

/*
#object return;
array (size=5)
  'suc_' => boolean true
  'obj_' => 
    object(PDO)[2]
  'msg_' => string 'Successful connection.' (length=22)
  'num_' => int 0
  'det_' => string 'Connection dns: HOST:localhost, DBNAME:inventarios, DBUSER: root, DBPASS:*****' (length=78)
*/

//********************************************************************************************************************* */

#Execute query
#Create instance of DataAccess
$exec = new DataAccess();
#Pass parameter Connection
$exec->SetConn($link['obj_']);
#Create Query and parameters in format json string
$JsonParams = '{"params":{":marca":"Xiaomi|string",":sts":"1|int"},
                "vars":{"TypeFuncion":"Insert","QueryString":"INSERT INTO cat_marcas (marca,sts) VALUES(:marca, :sts);"}}';

   //"QueryString":"SELECT id_marca, marca FROM cat_marcas WHERE id_marca = :id_marca;"
   //"UPDATE inventarios.cat_marcas SET marca = 'Samsungss' WHERE id_marca = 2;"
    //"INSERT INTO cat_marcas (marca,sts) VALUES('Xiaomi',1);"

$exec->SetJsonParams(json_decode($JsonParams));
$dats = $exec->ExecuteCommand();

var_dump($dats);
