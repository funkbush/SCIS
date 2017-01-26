<?php 
date_default_timezone_set("PRC");
$nowtime=time();
$rq=date("Y-m-d",$nowtime);
include("st-navigation.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCIS分笔明细导入</title>
<script type="text/javascript" src="js/st-import.js"></script>
<script type="text/javascript" src="js/mydate.js"></script>
<link rel="stylesheet" type="text/css" href="css/st-import.css" />

</head>
<body>
<h1><b>SCIS</b></h1>

<?php 

include_once("st-conn.php"); 
 
//*******生成股票选择框**************************   
   $sql="SELECT * FROM stocklist;";
   $res=mysql_query($sql);
   
   echo "Stock:&nbsp;&nbsp;&nbsp;<select id='stock'>";  //都是第一页
   
   while($array=mysql_fetch_array($res,MYSQL_BOTH))
   {
       echo "<option value=".$array[0].">".$array[0]."</option>";
   }
   echo "</select>&nbsp;";

 //*******生成服务器选择框**************************   
   $sql="SELECT * FROM servers;";
   $res=mysql_query($sql);
   
   echo "Server:&nbsp;&nbsp;&nbsp;<select id='server'>"; 
  
   while($array=mysql_fetch_array($res,MYSQL_BOTH))
   {      
		echo "<option value=".$array[2].">".$array[2]."</option>";
	
   }
   echo "</select>";
?> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
First-Date:&nbsp;&nbsp;<input type="text" id="sd" onFocus="MyCalendar.SetDate(this)" value="<?php echo $rq;?>" readonly style="border:0px;">
End-Date:&nbsp;&nbsp;<input type="text" id="ed" onFocus="MyCalendar.SetDate(this)" value="<?php echo $rq;?>" readonly style="border:0px;">
<input type="button" value="Check&&Get!!!" id="btn" onclick="check()">
</div>
</br>
</br>
<div id="pro" style="float:left"></div>
</br>
<table border="1" width="500">
<tr>Process:<td><div id="progressbar" style="float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#0066CC"></div><div id="progressText" style=" float:left">0%</div></td></tr>
</table>
</br>
<div id="res" style="float:left"></div>
</body>

</html>