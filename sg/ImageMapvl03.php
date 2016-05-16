<?php
session_start();
require 'dbconnect.php';
//require("viewImage.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ImageMap</title>
</head>

<body>
<?php 
	 	$sql = "SELECT  time FROM camera1 WHERE mac = '03' ORDER BY id DESC LIMIT 1";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$timestamp = $row['time'];
		$folder_path = 'ImageMap03/'; //image's folder path

		$num_files = glob($folder_path . "*.{JPG,jpeg,gif,png,bmp}", GLOB_BRACE);

		$folder = opendir($folder_path);
 
		if($num_files > 0)
		{
 		while(false !== ($file = readdir($folder))) 
 		{
  		$file_path = $folder_path.$file;
 	 	$extension = strtolower(pathinfo($file ,PATHINFO_EXTENSION));
 	 	if($extension=='jpeg' || $extension =='png' || $extension == 'gif' || $extension == 'bmp') 
  		{ 
		echo $timestamp;
  	 	?>
            <a href="<?php echo $file_path; ?>"><img src="<?php echo $file_path; ?>"  height="100" /></a>
                        <?php
			
 		 }
 		}
		}
		else
		{
		 echo "the folder was empty !";
		}
		closedir($folder);
		
		


?>

</body>
</html>