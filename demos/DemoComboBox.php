
<?php

require_once '../Connection.php';
require_once '../DataAccess.php';

#Open connection
#Create instance of Connection
$conn = new Connection('localhost', 'test', 'root', '');
#Create simple connection
$link = $conn->SimpleConnectionPDO();

//********************************************************************************************************************* */

#Execute query
#Create instance of DataAccess
$exec = new DataAccess();

#Pass parameter Connection
$exec->SetConn($link['obj_']);

#CRUD Create, Read, Update, Delete
#======================================================================================================

$exec->setQuerycmd("Read");
$exec->setQuerycrud("SELECT id, val1,val2, val3 FROM pruebas;");

$dats = $exec->ExecuteCommand();

#======================================================================================================

require_once '../ComboBox.php';

$cb = new ComboBox();
#LINK $dats['obj_'] to ComboBox
$cb->SetDataSource($dats['obj_']);
$cb->SetDataValueField('id');
$cb->SetDataTextField('val1');
$cb->SetAddRowFirst('.:Select a Smartphone:.');
$cb->SetItemSelected('2');
$cb->SetID('cmbSmartphones');
$cb->SetName('cmbSmartphones');
$cb->SetClass('Combo');
$cb->SetStyle('font-size:20px; width:245px;');
$cb->SetOnChange("Alerts()");


echo '<script> function Alerts() { console.log("ComboBox it changed. Value: " + document.getElementById("cmbSmartphones").value + "."); }</script>';
echo $cb->CreateComboBox();
