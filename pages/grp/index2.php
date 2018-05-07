<?php
////phpinfo();
//class CatalagoMaterial {
//    function CatalagoMaterial($descricaoMaterial)
//    {
//        $this->descricaoMaterial = $descricaoMaterial;
//    }
//}
//
//$contact = new CatalagoMaterial("arroz");

//$params = array(
//  "CatalagoMaterial" => $contact,
//  "description" => "Barrel of Oil",
//  "amount" => 500,
//);
$client = new SoapClient("http://10.1.2.69:9081/grpServiceHttpRouter/services/GrpService/wsdl/GrpService.wsdl");

$ar[] = array('descricaoMaterial' => 'dipirona');
$response = $client->__soapCall("getCatalagoMaterialByDescricaoMaterial", $ar);
//$result = $client->getCatalagoMaterialByDescricaoMaterial($ar);
echo "<pre>";
print_r($response);
echo "</pre>";

// echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
// echo "<pre>";
// var_dump($client->__getFunctions());
// echo "</pre>";
// echo "<pre>";
// var_dump($client->__getTypes());
// echo "</pre>";
// echo "<pre>";
// print_r($client);
// echo "</pre>";
//$result = $client->getMember();
//var_dump($result);
