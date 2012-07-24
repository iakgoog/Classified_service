<?php
	//header('content-type: application/json; charset=utf-8');
	include 'config.php';
	
	$email = $_REQUEST['email'];
	$callback = $_GET['callback'];
	//---------------- store information to the server ----------------
	try {
		$DBH = new PDO("mysql:host=$mysql_host; dbname=$mysql_database; charset=utf8", $mysql_user, $mysql_password);	
		$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$STH = $DBH->prepare("SELECT email FROM person WHERE email = :mail");
		$STH->execute(array(':mail' => $email));
		$STH->setFetchMode(PDO::FETCH_ASSOC);
		$affected_rows = $STH->fetchColumn();
		if(!$affected_rows) {
			$message['status'] = '1';
		} else {
			$message['status'] = '0';
		}
		echo $callback . "( '".json_encode($message)."' );";
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
?>