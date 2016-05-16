<?php 
include ("dbconnect.php");
$sql = "SELECT * FROM user";
$query = mysql_query($sql);

if(mysql_num_rows($query) == 0){
	echo "chua co du lieu";
	
	
	}
	
	else
	 {
		while($row = mysql_fetch_array($query)){
			echo $row[user_name]."</br>";
			
			}
		
		}

?>