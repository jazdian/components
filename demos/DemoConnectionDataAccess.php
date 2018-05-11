<?php

require_once '../Connection.php';
require_once '../DataAccess.php';


#Open connection
#Create instance of Connection 
$conn = new Connection('localhost','test','root','');
#Create simple connection
$link = $conn->SimpleConnectionPDO();

var_dump($link);

//********************************************************************************************************************* */

#Execute query
#Create instance of DataAccess
$exec = new DataAccess();

#Pass parameter Connection
$exec->SetConn($link['obj_']);
//$exec->setParams(array(":val1"=>"Samsung|string",":val2"=>"Telefono celular|string",":val3"=>"175|int"));

#CRUD Create, Read, Update, Delete
//$exec->setQuerycmd("Insert");
$exec->setQuerycmd("Read");

$exec->setQuerycrud("INSERT INTO pruebas (val1,val2, val3) VALUES(:val1, :val2, :val3);");
$exec->setQuerycrud("SELECT val1,val2, val3 FROM pruebas;");


$dats = $exec->ExecuteCommand();

var_dump($dats);
