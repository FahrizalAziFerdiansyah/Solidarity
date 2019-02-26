<?php
function getOngkir($src_address,$dst_address,$courier,$berat,$api) {
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL 			=> "https://pro.rajaongkir.com/api/cost",
		CURLOPT_RETURNTRANSFER	=> true,
		CURLOPT_ENCODING		=> "",
		CURLOPT_MAXREDIRS		=> 10,
		CURLOPT_TIMEOUT			=> 30,
		CURLOPT_HTTP_VERSION	=> CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST	=> "POST",
		CURLOPT_POSTFIELDS		=> "origin=".$src_address."&originType=subdistrict&destination=".$dst_address."&destinationType=subdistrict&weight=".$berat."&courier=".$courier."",
		CURLOPT_SSL_VERIFYPEER	=> false,
		CURLOPT_SSL_VERIFYHOST	=> false,
		CURLOPT_HTTPHEADER		=> array(
			"content-type: application/x-www-form-urlencoded",
			"key:eec60c3654cbbad8fddc6c1d51265835"
		),
	));
	
	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		$show = "cURL Error #:" . $err;
	} else {
		$show = $response;
	}
	return $show;
}