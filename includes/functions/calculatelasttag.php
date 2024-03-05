<?php

require('../app.php');
//print_r($_POST);
use App\Moviles;

$celdap= Moviles::allLDAP();
$ldaptags = Array();
$ldaptagsid = Array();
$ofi=$_POST['ofi'];

foreach ($celdap as $value) {
    if (isset($value->devicetag)) {
        if (preg_match("/" . $ofi . "(\d+)/i", $value->devicetag, $matches)) {
            array_push($ldaptags, $value->devicetag);
            array_push($ldaptagsid, $matches[1]);
        }
    }
}
$max=max($ldaptagsid);
if ($max<100) {
    $data = ($ofi). '00' .($max+1);
}else{
    $data = ($ofi).($max+1);
}


//sort($ldaptags);
//$data .= "<pre>";
//$data .= print_r($ldaptags, TRUE);
//$data .= "</pre>";


//echo $data;



//print_r($ldaptags);



$jsonSearchResults[] =  array(
	'success' => 'YES',
	'data' => $data,
	'error' => "error",
);
echo json_encode ($jsonSearchResults);


?>

