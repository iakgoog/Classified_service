<?php
	header('content-type: application/json; charset=utf-8');
	//---------------- return [full path], [path], [file name] to PhoneGap ----------------
	//---------------- in this 'http://www.iakgoog.comuv.com/upload/2012/Jul' format ----------------
	$dir = 'upload/'.date("Y").'/';
	if (!file_exists($dir)) {
		$makeDir = mkdir($dir);
	}	
	$dir .= date("M").'/';
	if (!file_exists($dir)) {
		$makeDir = mkdir($dir);
	}	
	$file = md5(date('Ymdgisu')).'.jpg';
	$path = $dir.$file;
	$fullPath = 'http://'.$_SERVER['HTTP_HOST'].'/'.$path;
	
	$message = array( "fullPath" => $fullPath, "path" => $dir, "fileName" => $file);
	//print_r($array); //DEBUG
	//echo json_encode($message);
	echo $_GET['jsoncallback'] . '(' . json_encode($message) . ');'; 
?>