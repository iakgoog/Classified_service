<?php
	//header('content-type: application/json; charset=utf-8');
	include 'config.php';
	
	$email = $_REQUEST['email'];
	$password = md5($_REQUEST['password']);
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
		$stmt = $dbh->prepare("SELECT * FROM person WHERE email = :mail AND password = :pass");
		$stmt->execute(array(':mail' => $email, ':pass' => $password));
		$items = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		if($items) {
			$items['status'] = "1";
		} else {
			$items['status'] = "0";
		}
		echo $_GET['jsoncallback'] . '(' . json_encode($items) . ');';
		//echo json_encode($items);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
?>