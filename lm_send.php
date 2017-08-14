<?php

	if(isset($_GET["message"])){
		$message = $_GET["message"];
	} else {
		$message = "Test Message";
	}
	$data = array("m" => $message);
	
	
	if(isset($_GET["regid"])){
		$regid = $_GET["regid"];
	} else {
		$regid = "testid";
	}
	
	if($regid=='all'){
		include_once 'db_functions.php';
        $db = new DB_Functions();
        $sql = mysql_query("select fcm_regid FROM fcm_users");
		$regdata = array();
		while($row = mysql_fetch_array($sql)){
			$regdata[] = $row[0];
		}
		
	} else {
		$regdata = array($regid);	
	}
	
	echo($regdata[0]);
	

	$url = 'https://fcm.googleapis.com/fcm/send';
	$headers = array(
		'Authorization: key=AIzaSyA_WqP8f879ZrrO5TStX7XkcIpdMdgo6uo',
		'Content-Type: application/json'
	);
	
	$fields = array(
		'registration_ids' => $regdata,
		'data' => $data
	);
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);				
    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }
    curl_close($ch);
    echo($result);
    
?>