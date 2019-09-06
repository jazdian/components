
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
$exec->setQuerycrud("SELECT id, val1, val2, val3 FROM pruebas;");

$dats = $exec->ExecuteCommand();

#======================================================================================================

require_once '../DataTable.php';

$dt = new DataTable();
#LINK $dats['obj_'] to ComboBox
$dt->SetDataSource($dats['obj_']);
#[OPTIONAL SetHeader()]
$dt->SetHeader(array('Id', 'Brand', 'Type', 'Item'));
$dt->SetID('dtSmartPhones');
$dt->SetClass('table table-dark');
$dt->SetStyle('#dtSmartPhones{font-size:18px; width:65%;}');
$dt->SetBtnSelect(array('show'=>true,
                        'name'=>'Seleccionar',
                        'onclick'=>'SelectRow()',
                        'class' => 'btn btn-success',
                        'param'=>'id',
                        'colname'=>'Seleccionar'));
$dt->SetBtnEdit(array('show'=>true,
                        'name'=>'Editar',
                        'onclick'=>'alert()',
                        'class' => 'btn btn-warning',
                        'param'=>'id',
                        'colname'=>'Editar'));
$dt->SetBtnDelete(array('show'=>true,
                        'name'=>'Delete',
                        'class' => 'btn btn-danger',
                        'onclick'=>'console.log()',
                        'param'=>'id',
                        'colname'=>'Eliminar'));

$dt->SetScript('function SelectRow(id) { document.getElementById("Msg").innerHTML = "You have selected row: " + id; } ');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style="margin:1em;">

    <?php
        echo '<style>.Table{ border-style: dotted; }</style>';
        echo $dt->CreateDataTable();
    ?>
    <br><div id="Msg"></div>

</body>
</html>