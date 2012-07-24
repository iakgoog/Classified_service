<?php 
	//header('content-type: application/json; charset=utf-8'); never ever put this in your upload file
	include 'config.php';
	
	$fullPath = $_REQUEST['fullPath'];
	$item = $_REQUEST['item'];
	$category = $_REQUEST['category'];
	$price = $_REQUEST['price'];
	$person_id = $_REQUEST['id'];
	$description = $_REQUEST['description'];
	$latitude = $_REQUEST['latitude'];
	$longitude = $_REQUEST['longitude'];
	
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
		
		$msg['status'] = "success";
		echo $_GET['jsoncallback'] . '(' . json_encode($msg) . ');';
	} catch(PDOException $e) {
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
		echo $e->getMessage(); 
	}
?>