<?php 
	//header('content-type: application/json; charset=utf-8'); never ever put this in your upload file
	include 'config.php';
	
	$username = $_POST['name'];
	$password = md5($_POST['password']);
	$email = $_POST['email'];
	$address = $_POST['address'];
	$province = $_POST['province'];
	
	//$sql = str_replace("\\'", "'", $_POST['sql']);;
	
	//---------------- store information to the server ----------------
	$sql = "INSERT INTO person (username, password, email, address, province) ";
	$sql .= "VALUES ('$username','$password','$email','$address','$province')";
	
	
	try {
		$dbh = new PDO("mysql:host=$mysql_host; dbname=$mysql_database; charset=utf8", $mysql_user, $mysql_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query("SET NAMES 'utf8'");
        $dbh->query("SET CHARACTER SET 'utf8'");
        //$dbh->query("SET COLLATION_CONNECTION='utf8'");
        $dbh->query("SET character_set_results = 'utf8'");
        $dbh->query("SET character_set_server = 'utf8'");
        $dbh->query("SET character_set_client = 'utf8'");
		$dbh->query($sql);  
		$dbh = null;
		
		$return['msg'] = "SUCCESS";
		echo json_encode($return);
		//echo "Your item has been recorded!"; 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>