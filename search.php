<?php
	header('content-type: application/json; charset=utf-8');
	include 'config.php';
	
	if(isset($_REQUEST['addOptions'])) {
		$catSearch = $_REQUEST['catSearch'];
        $pricedFrom = $_REQUEST['pricedFrom'];
        $pricedTo = $_REQUEST['pricedTo'];
        $distance = $_REQUEST['distance'];
		$myLat = $_REQUEST['myLat'];
		$myLng = $_REQUEST['myLng'];
	}
	
	$sql = "SELECT *, ( 6371 * acos( cos( radians('" . $myLat . "') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('" . $myLng . "') ) + sin( radians('" .$myLat. "') ) * sin( radians( lat ) ) ) ) AS distance";
	//$sql = "SELECT item_id, path, item, category, price, description, lat, lng";
	$fromItem = " FROM item";
	$sqlCondition = "";
	$sqlOptions = array(0 => "", 1 => "", 2 => "" );
	$checkAnd = false;
	
	if($catSearch != "") {
		$sqlCondition = " HAVING";
		$sqlOptions[0] = " category = '" . $catSearch . "'";
		$checkAnd = true;
	}
	if($pricedFrom != "") {
		$sqlCondition = " HAVING";
		if(!$checkAnd) {
			$sqlOptions[1] = " price BETWEEN '" . $pricedFrom . "' AND '" . $pricedTo . "'";
			$checkAnd = true;
		} else {
			$sqlOptions[1] = " AND price BETWEEN '" . $pricedFrom . "' AND '" . $pricedTo . "'";
		}
	}
	if($distance != "") {
		$sqlCondition = " HAVING";
		if(!$checkAnd) { 
			$sqlOptions[2] = " distance < '" . $distance . "'";
		} else {
			$sqlOptions[2] = " AND distance < '" . $distance . "'";
		}
	}
	$sql .= $fromItem . $sqlCondition . $sqlOptions[0] . $sqlOptions[1] . $sqlOptions[2];
	$sql .= " ORDER BY item.item_id DESC";
	
	//printf($sql);
	//print_r($_REQUEST);
	//print_r($sqlOptions);
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
		if($items) {
			$items['status'] = 1;
			//$items['sql'] = $sql;
		} else {
			$items['status'] = 0;
		}
		$items['sql'] = $sql;
		//print_r(json_encode($items));
		echo $_GET['jsoncallback'] . '(' . json_encode($items) . ');'; 
		//echo $_GET['callback'] . '(' . json_encode($items) . ');';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
?>