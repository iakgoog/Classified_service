<?php
	//print_r($_POST);
	//print_r($_FILES);
	//print something from the server to PhoneGap 
	move_uploaded_file($_FILES["file"]["tmp_name"], $_POST['path'].$_FILES["file"]["name"]);
?>