<?php
session_start();
require 'dbconnect.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ImageMap</title>
</head>

<body>
<?php 
	//$sql= "SELECT *FROM cdata INNER JOIN  camera1 ON cdata.mac= camera1.mac ";
		$sql = "SELECT mac, time, img FROM camera1 WHERE mac = '02' ORDER BY id DESC LIMIT ";
		$query = mysql_query($sql);
		$row = mysql_fetch_array($query);
		$timestamp = $row['time'];
		$data = $row['img'];
		$mac = $row['mac'];
		$binary=pack('H*', str_replace(' ', '', $data));
		$now = getdate(); 
		$time = $now["hours"]  . $now["minutes"]  . $now["seconds"] ;
		file_put_contents("C:\\xampp\\htdocs\\sg\\ImageMap\\'".$mac.$time."'.jpeg", $binary);
		$folder_path = 'ImageMap/'; //image's folder path

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