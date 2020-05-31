<?php

function updateInvoiceFile($invid) {
	$basepath = $_SERVER['DOCUMENT_ROOT'].'/besthealth/';
	$basepath = $basepath."invoices/";
	$files = scandir($basepath); //scan specified directory
	$key = 'status'; //key to update
	$update = '1'; //update value
	if(count($files) > 0) {
		foreach($files as $file) :
			if(!is_dir($file)) {
				$part = explode('.', $file);

				if($invid == $part[0]) {
					$file_data = file_get_contents($basepath.'/'.$file);
					$array_data = json_decode($file_data);

					if(array_key_exists($key, $array_data->patient)) {
						$array_data->patient->status = $update;
						file_put_contents($basepath.'/'.$file, json_encode($array_data));
						$response = 1; //update success
					}
					break;
				}
				else {
					$response = 0; //no match found
				}
			}
		endforeach;
	}
	else {
		$response = 0; //file does not exist
	}
	return $response;
}

updateInvoiceFile('304177');

?>