
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
$cb->SetAddRowFirst(0, '.:Select a Smartphone:.');
$cb->SetItemSelected('2');
$cb->SetID('cmbSmartphones');
$cb->SetName('cmbSmartphones');
$cb->SetClass('form-control');
$cb->SetStyle('font-size:20px; width:345px;');
$cb->SetOnChange("Alerts()");

$cb->SetLabelName("Marcas de Teléfono", "");
$cb->SetBootstrapForm(true);

#======================================================================================================

require_once '../ListBox.php';

$lb = new ListBox();

$lb->SetDataSource($dats['obj_']);
$lb->SetDataValueField('id');
$lb->SetDataTextField('val1');
$lb->SetClass('form-control');
$lb->SetID('lstSmartphones');
$lb->SetName('lstSmartphones');
$lb->SetStyle('font-size:20px; width:345px;');

$lb->SetLabelName("Lista de Marcas", "");
$div2 = '
<div class="form-group">
  <label for="_ID_" class="_LCLASS_">_LNAME_</label>
  _INPUT_
</div>';
$lb->SetWrapHtmlCode($div2);

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
        echo $cb->CreateComboBox();    
        echo '<script> function Alerts() { console.log("ComboBox it changed. Value: " + document.getElementById("cmbSmartphones").value + "."); }</script>';
    ?>

    <?= $lb->CreateListBox(); ?>

    <?php //$cb->CreateComboBox(); ?>

</body>
</html>
