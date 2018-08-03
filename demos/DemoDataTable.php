
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

require_once '../DataTable.php';

$dt = new DataTable();
#LINK $dats['obj_'] to ComboBox
$dt->SetDataSource($dats['obj_']);
#[OPTIONAL SetHeader()]
$dt->SetHeader(array('Id', 'Brand', 'Type', 'Item'));
$dt->SetID('dtSmartPhones');
$dt->SetClass('Table');
$dt->SetStyle('#dtSmartPhones{font-size:20px; width:65%;}');
$dt->SetBtnSelect(array('show'=>true,
                        'name'=>'Select Row',
                        'onclick'=>'SelectRow()',
                        'param'=>'id',
                        'colname'=>'Select'));
$dt->SetBtnEdit(array('show'=>true,
                        'name'=>'Edit Row',
                        'onclick'=>'EditRow()',
                        'param'=>'id',
                        'colname'=>'Editar'));
$dt->SetBtnDelete(array('show'=>true,
                        'name'=>'Delete Row',
                        'onclick'=>'',
                        'param'=>'id',
                        'colname'=>'Eliminar'));

$dt->SetScript('function SelectRow(id) { document.getElementById("Msg").innerHTML = "You have selected row: " + id; } ');

echo '<style>.Table{ border-style: dotted; }</style>';
echo $dt->CreateDataTable();

echo '<br><br><div id="Msg"></div>';
