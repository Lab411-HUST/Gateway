<?php
	require 'dbconnect.php';
	$sql1="SELECT image FROM camera ORDER BY id DESC LIMIT 1";// DESC : giảm dần bắt đầu từ số max 
	//$sql1= "SELECT image FROM camera";
	$query =mysql_query($sql1);
	$row = mysql_fetch_array($query);
	$data = $row['image'];
	
	$sql2= mysql_query("INSERT INTO camera1(image) VALUES ('".$data."') ");
	$row1 = mysql_fetch_array($sql2);
	$da = $row1['image'];
	echo $da;
	
	
	
		//$binary=pack('H*', str_replace(' ', '', $data));
		//file_put_contents("camerasensor.jpeg", $binary);
		//echo '<img src="camerasensor.jpeg" />';
		
	//echo '<img src="data:image/jpeg;base64,"' . $row['image'] . '" />';


 ?>
