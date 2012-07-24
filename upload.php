<?php 
	//header('content-type: application/json; charset=utf-8'); never ever put this in your upload file
	include 'config.php';
	
	$image = base64_decode($_REQUEST['image']);
	$item = $_REQUEST['item'];
	$category = $_REQUEST['category'];
	$price = $_REQUEST['price'];
	$person_id = $_REQUEST['id'];
	$description = $_REQUEST['description'];
	$latitude = $_REQUEST['latitude'];
	$longitude = $_REQUEST['longitude'];
	
	//---------------- store image to the server ----------------
	//---------------- http://www.iakgoog.comuv.com/upload/2012/Jul ----------------
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
	
	// write the imgData to the file
	$fp = fopen($path, 'w');
	fwrite($fp, $image);
	fclose($fp);
	
	//---------------- store information to the server ----------------
	
	$sql = "INSERT INTO item (path, item, category, price, person_id, description, lat, lng) ";
	$sql .= "VALUES ('$fullPath','$item','$category','$price','$person_id','$description','$latitude','$longitude')";
	
	try {
		$dbh = new PDO("mysql:host=$mysql_host; dbname=$mysql_database; charset=utf8", $mysql_user, $mysql_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query("SET NAMES 'utf8'");
        $dbh->query("SET CHARACTER SET 'utf8'");
        //$dbh->query("SET COLLATION_CONNECTION='utf8'");
        $dbh->query("SET character_set_results = 'utf8'");
        $dbh->query("SET character_set_server = 'utf8'");
        $dbh->query("SET character_set_client = 'utf8'");
		$stmt = $dbh->query($sql);  
		$dbh = null;
		echo "Your item has been recorded!"; 
		//$msg['status'] = "1";
		//echo $_GET['jsoncallback'] . '(' . json_encode($msg) . ');';
	} catch(PDOException $e) {
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
		echo $e->getMessage(); 
	}
?>