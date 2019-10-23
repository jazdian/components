<?php

## Step 1 =============================================================================
require_once '../Connection.php';

## We create an object of the connection.
$conn = new Connection('localhost', 'test', 'root', '');

## We execute the function "SimpleConnectionPDO" to connect to the server
$link = $conn->SimpleConnectionPDO();

## Step 2 =============================================================================

## We create the string with the query to the table
require_once '../StringQueryCreator.php';

$qryStr = new StringQueryCreator();

$qryStr->setFIELDS('id, val1')->setTABLE('pruebas');

$queryString = $qryStr->CreateSelectString();

## Step 3 =============================================================================

## To access the database data we call the class "DataAccess"
require_once '../DataAccess.php';

#Create instance of DataAccess
$exec = new DataAccess();

## To access the data we pass the connection and the query.
#CRUD Create, Read, Update, Delete
$exec->SetConn($link['obj_']);
$exec->setQueryCmd("Read");
$exec->SetQueryCrud($queryString);

## We execute the query and the function does not return the data source in an array with objects.
$dats = $exec->ExecuteCommand();


## Step 4 =============================================================================
## Link the data to the ComboBox class

require_once '../ComboBox.php';

$cb = new ComboBox();

## One of the items that the array returns is the object with the key "obj_". There comes the entire data source
$cb->SetDataSource($dats['obj_']);

## We pass the fields that will serve as value and text.
$cb->SetDataValueField('id');
$cb->SetDataTextField('val1');

## These are the basic data with which we can create a combobox.
// echo $cb->CreateComboBox();

## The following properties are optional. ##############################################################################

## You can add a first or last option to the combobox
$cb->SetAddRowFirst('0', 'First Option');

$li = $dats['num_'] + 1;
$cb->SetAddRowEnd($li, 'Last Option');

## We can also pass the value of the option that will be selected when loading the combobox
$cb->SetItemSelected('2');

## Add an ID or name to the combobox
$cb->SetID('cmbSmartphones');
$cb->SetName('cmbSmartphones');

## We can convert the combobox into a Bootstramp Form control
$cb->SetLabelName("Marcas de Teléfono", "");
$cb->SetBootstrapForm(true);
$cb->SetClass('form-control');

## You can also add styles.
$cb->SetStyle('font-size:18px; width:345px;');

## A javascript function can be added in the SetOnChange, SetOnBlur, SetOnFocus, SetOnSelect, SetOnClick and SetOnSubmit events.
$cb->SetOnChange('MyCombo()');

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

<body>
   <br><br>
   <div class="container">
      <?php echo $cb->CreateComboBox(); ?>
   </div>

   <script>
      function MyCombo() {
         var Val = document.querySelector('#cmbSmartphones').value;
         console.log('Hello World! from a JavaScript function. ' + Val);
      }
   </script>
</body>

</html>
