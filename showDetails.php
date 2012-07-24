<?php
	header('content-type: application/json; charset=utf-8');
	include 'config.php';
	
	$id = $_REQUEST['id'];
	//$sql = "SELECT * FROM item WHERE item_id = '" .$id. "'";
	$sql = "SELECT person.username, item.path, item.item, item.price, item.description, item.category 
			FROM person
			INNER JOIN item
			ON person.person_id = item.person_id
			WHERE item.item_id = '" .$id. "'";	
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