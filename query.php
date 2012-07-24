<?php
	header('content-type: application/json; charset=utf-8');
	include 'config.php';
	
	$sql = $_REQUEST['sql'];
	//$sql = "SELECT * FROM upload";
	
	//---------------- store information to the server ----------------
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
		$items = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo $_GET['jsoncallback'] . '(' . json_encode($items) . ');'; 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
?>