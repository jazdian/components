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

#CRUD Create, Read, Update, Delete
#======================================================================================================

$exec->setParams(array(":val1"=>"iPhone|string",":val2"=>"Smarthphone|string",":val3"=>"255|int"));
$exec->setQuerycmd("Insert");
$exec->setQuerycrud("INSERT INTO pruebas (val1,val2, val3) VALUES(:val1, :val2, :val3);");

$dats = $exec->ExecuteCommand();
var_dump($dats);

#======================================================================================================
/*
$exec->setQuerycmd("Read");
$exec->setQuerycrud("SELECT id, val1,val2, val3 FROM pruebas;");

$dats = $exec->ExecuteCommand();
var_dump($dats);
*/
#======================================================================================================

