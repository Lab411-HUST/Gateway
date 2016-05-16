<?php
session_start();
require 'dbconnect.php';
require('SampleImage.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>ViewImage</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="map1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#top_page{
		width:980px;
		height:350px;
		
		}
	.slide{
	cursor:pointer;
	}
	#bottom_page{
	width: 960px;
	height: auto;
	background: #6E8B3D;
	margin: 10px;
	position: relative;
	padding-top: 10px;
		}
	#allview{
	display:none;
		
		}
	
	#left_con{
		width: 300px;
		height: 300px;
		float: left;
    	overflow: auto; 
		
		}
	#right_con{
	width: 500px;
	
	height: 300px;
	float: right;
	overflow: auto; 
}
.log4{
	border-bottom: solid 1px #b0bb88;
	display: block;
	font: bold 21px Comfortaa;
	padding-bottom: 10px;
	color: #212713;
	margin-top: 50px;
}
.log3{
	border-bottom: solid 1px #b0bb88;
	display: block;
	font: bold 30px Comfortaa;
	padding-bottom: 10px;
	color: #212713;
	float: right;
}

</style>
<script type="text/javascript" src = "jquery.js"></script>
<script language="javascript">
        //*******************************
	     $(document).ready(function(e) {
         var isLogin='<?php if(isset($_SESSION['login_status'])){if($_SESSION['login_status']=='yes')echo 'yes';else echo 'no';}else    echo 'no';?>';
	     var isLevel='<?php if(isset($_SESSION['level'])){echo $_SESSION['level'];}?>';
	     if(isLogin=='yes'){			 
		//var content = "<table><tr><td><a href='signout.php'>Ðăng xuất</a></td><td></td></tr></table>";
		var content = "<table><tr><td><i>Xin chào bạn </i><b> [ </b><u id='log'><?php if(isset($_SESSION['login_status'])){ echo $_SESSION['user'];} ?></u><b> ] </b></td><td></td></tr></table>";
		$('#ttlogin').append(content);
	}
	else{
		var content = "<table><tr><td> <a href='register.php'>Đăng ký</a>&nbsp&nbsp&nbsp&nbsp<a href='login.php'>Đăng nhập</a></td></td></tr></table>";
		$('#ttlogin').append(content);
	}
	
	$("#log").click(function(e) {
		$("#menulogin").css('left',e.pageX - 150);
		$("#menulogin").css('top',e.pageY + 10);
        $("#menulogin").show();
    });
	
	$("#txtbutton").click(function(e) {
		$("#allview").slideToggle("fast");
		});
	
	$(document).bind("mouseup",function(e){
		$("#menulogin").hide();
		});
    });
</script>
	<script type="text/javascript" src="js/jquery.jmslideshow.js"></script>
<?php
$j=0;
while($j<30)
{
 ?>   
    <script type="text/javascript">
$(document).ready(function(){			
	$('<?php print '#lvd'.$j; ?>').click(function(){
		$('<?php print '#pvd'.$j ?>').slideToggle("fast");
        
	});				
});
		</script>
        <?php 
        $j++;
        } ?>

</head>

<body>
<form method="POST" name="video">
   
<div id="wrap">
  	<div id="top">
    	<div id="ttlogin"></div> <br />
        <div id="banner">
	    <embed src="http://bannertudong.com/uploads/system/flash/20110503/view.swf" quality="high" bgcolor="#ffffff" wmode="transparent" menu="false" width="1000" height="250" name="Editor" align="middle" allowScriptAccess="always" flashVars='xml=http://bannertudong.com/uploads/user/20150818/33399/33399.xml?0' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
        </div>
        <div id = "menulogin" class="ctmenu">
           <table>
	           <tr><td class="menuitem" id = "tt"><a href="">Chỉnh sửa thông tin</a></td></tr>
	           <tr><td class="menuitem" id = "pass"><a href="change_pass.php"> Đổi mật khẩu </a></td></tr>
               <tr><td class="menuitem" id = "out"> <a href="signout.php">Đăng xuất</a></td></tr>
           </table>
        </div>
	<div id="menu">
		<ul>			
	      	<li ><a href="index.php"><span>Bo nhúng</span></a></li>
	      	<li ><a href="mapvl.php"><span>Bản đồ</span></a></li>
            <li><a href="draw.php"><span>Vẽ đồ thị</span></a></li>
	      	<li><a href="video.php"><span>Video</span></a></li>
	      	<li><a href="camera.php"><span>Camera</span></a></li>	      
            <li ><a href="truccanh.php"><span>Trực canh</span></a></li>
             <li class="active"><a href="viewImage.php"><span>Image</span></a></li>
            <?php if(isset($_SESSION['login_status'])) 
					if($_SESSION['login_status']=='yes') {
						if($_SESSION['level'] == 1){
			?>
            <li><a href="manage.php"><span>Quản lý</span></a></li>
            <?php }}?>
	   	</ul>
	</div>
    </div>
    <div style="padding-bottom:170px"></div>

  	<div id="contentwrap">
    
 <!-- Ban do khu vuc vuon lan -->
    <div id="mainpage">
		<div id = "top_page" >
	
    <?php
		
		/*****************create image*********************************/
		
		$sql1="SELECT image, mac FROM camera ORDER BY id DESC LIMIT 1";
		$query =mysql_query($sql1);
		$row1 = mysql_fetch_array($query);
		$data = $row1['image'];
		$mac = $row1 ['mac'];
		$binary=pack('H*', str_replace(' ', '', $data));
		file_put_contents("camerasensor.jpeg", $binary);
		
		$sql= "INSERT INTO camera1(img, mac) VALUES ('".$data."', '".$mac."')";
		mysql_query($sql);
		
	?>
	<script type="text/javascript">
		function checkOther(select){
			$size = select[select.selectedIndex].value;
			if( select[select.selectedIndex].value=="1" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(100);
					 $image1->save('cam.jpeg');  
				?>	
				$("#imageid").attr("src","cam.jpeg");
			}
			if( select[select.selectedIndex].value=="2" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(50);
					 $image1->save('cam1.jpeg');  
				?>	
				$("#imageid").attr("src","cam1.jpeg");
			}
			if( select[select.selectedIndex].value=="3" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(75);
					 $image1->save('cam2.jpeg');  
				?>	
				$("#imageid").attr("src","cam2.jpeg");
			}
			if( select[select.selectedIndex].value=="4" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(125);
					 $image1->save('cam3.jpeg');  
				?>	
				$("#imageid").attr("src","cam3.jpeg");
			}
			if( select[select.selectedIndex].value=="5" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(150);
					 $image1->save('cam4.jpeg');  
				?>	
				$("#imageid").attr("src","cam4.jpeg");
			}
			if( select[select.selectedIndex].value=="6" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(175);
					 $image1->save('cam5.jpeg');  
				?>	
				$("#imageid").attr("src","cam5.jpeg");
			}
			if( select[select.selectedIndex].value=="7" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(200);
					 $image1->save('cam6.jpeg');  
				?>	
				$("#imageid").attr("src","cam6.jpeg");
			}
			if( select[select.selectedIndex].value=="8" ){
				<?php
					$image1 = new SimpleImage();
					$image1->load('camerasensor.jpeg');
					$image1->scale(250);
					 $image1->save('cam7.jpeg');  
				?>	
				$("#imageid").attr("src","cam7.jpeg");
			}
			
			
		}
	
	</script>
    
        
		<select id="zoom" align='center' onchange="checkOther(this)">
			<option value="1">100</option>
			<option value="2">50</option>
			<option value="3">75</option>
			<option value="4">125</option>
			<option value="5">150</option>
			<option value="6">175</option>
			<option value="7">200</option>
			<option value="8">250</option>
		</select>
		<p align='center' >
		   <img src="camerasensor.jpeg" id="imageid"/></p>
		</div> 
        
        <div id="bottom_page">
        <h3  id= "txtbutton" class ="slide ">Xem tất cả ảnh:  
         <button type="button" > ALL </button>	
			</h3>
       
        <div id="allview"> 
        	<?php 
		$now = getdate(); 
		$time = $now["hours"]  . $now["minutes"]  . $now["seconds"] ;
		$sql2 = "SELECT img FROM camera1 ORDER BY id DESC LIMIT 1 ";
		$query2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($query2);
		$data1 = $row2['img'];
		$binary=pack('H*', str_replace(' ', '', $data1));
		file_put_contents("C:\\xampp\\htdocs\\sg\\imagesensor\\'".$mac. $time."'.jpeg", $binary);
		$folder_path = 'imagesensor/'; //image's folder path

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
            <?php 
	//$sql= "SELECT *FROM cdata INNER JOIN  camera1 ON cdata.mac= camera1.mac ";
		$sql3 = "SELECT mac, time, img FROM camera1 WHERE mac = '03' ORDER BY id DESC LIMIT 1";
		$query1 = mysql_query($sql3);
		$row = mysql_fetch_array($query);
		$timestamp = $row['time'];
		$data = $row['img'];
		$mac = $row['mac'];
		$binary=pack('H*', str_replace(' ', '', $data));
		$now = getdate(); 
		$time = $now["hours"]  . $now["minutes"]  . $now["seconds"] ;
		file_put_contents("C:\\xampp\\htdocs\\sg\\ImageMap03\\'".$mac.$time."'.jpeg", $binary);
		
		$sql4 = "SELECT mac, time, img FROM camera1 WHERE mac = '04' ORDER BY id DESC LIMIT 1";
		$query4 = mysql_query($sql4);
		$row4 = mysql_fetch_array($query4);
		//$timestamp = $row['time'];
		$data4 = $row4['img'];
		$mac4 = $row4['mac'];
		$binary4=pack('H*', str_replace(' ', '', $data4));
		$now = getdate(); 
		$time = $now["hours"]  . $now["minutes"]  . $now["seconds"] ;
		file_put_contents("C:\\xampp\\htdocs\\sg\\ImageMap04\\'".$mac4.$time."'.jpeg", $binary4);
		
		$sql6 = "SELECT mac, time, img FROM camera1 WHERE mac = '06' ORDER BY id DESC LIMIT 1";
		$query6 = mysql_query($sql6);
		$row6 = mysql_fetch_array($query6);
		//$timestamp = $row['time'];
		$data6 = $row6['img'];
		$mac6 = $row6['mac'];
		$binary6=pack('H*', str_replace(' ', '', $data6));
		$now = getdate(); 
		$time = $now["hours"]  . $now["minutes"]  . $now["seconds"] ;
		file_put_contents("C:\\xampp\\htdocs\\sg\\ImageMap03\\'".$mac6.$time."'.jpeg", $binary6);
       ?>
       
        </div>
         </div>
	<div id="bottom">
		<div id="footer">
	        <div id="fl_right">Copyright by <a href="#">Lab 411</a></div>
	        <div class="clear"></div>
		</div>
    </div>
</div>
<div id="contentbtm"></div>
</div>
</body>
</html>


<?php
//mysql_close($connect);
?>
