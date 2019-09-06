<?php

require_once '../StringQueryCreator.php';

$sqc = new StringQueryCreator();

$sqc->setTABLE("usuarios");
$sqc->setFIELDS("col1, col2, col3");
$sqc->setVALUES("'Cadena', 5, 'Otra cadena'");
$sqc->setWHERE("col1 = 'Cadena'");

echo $sqc->CreateUpdateString();


