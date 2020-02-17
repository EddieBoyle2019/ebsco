<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$api_key = '2YPSgidTwDaXf1d26VR004C0dcromPtB27mkBEE2';

$url = 'https://sandbox.ebsco.io/rm/rmaccounts/apidvgvmt/packages?search=boston&orderby=relevance&count=10&offset=1';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$headers = [
	 'X-API-Key : ' . $api_key,
	 'Content-Type: application/json',
	 'Accept : application/json'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

curl_close($ch);

//var_dump(json_decode($result, true));

$data = json_decode($result, true);

//recursive funtion
function printAll($a) {
    if (!is_array($a)) {
        //echo $a, '<br/>';
        return;
    }

    foreach($a as $k => $value) {

    	 if (($k == "packageName") && (!is_array($value)))
	 {
		echo $value . "<br/>";
	 }
    	 if (($k == "vendorId") && (!is_array($value)))
	 {
		echo $value . "<br/>";
	 }
         printAll($k);
         printAll($value);

    }
}

printAll($data);

?>