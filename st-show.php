<?php
  date_default_timezone_set("PRC");
  $nowtime=time();
  $rq=date("Y-m-d",$nowtime);
  include("st-navigation.php");  
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<link rel="stylesheet" type="text/css" href="css/st-show.css" />
<title>SCIS分笔明细</title>
<script type="text/javascript" src="js/st-show.js"></script> 
<script language="JavaScript" src="js/mydate.js"></script> 
</head>
<!--body onload="goPage(1)">-->
<h1><b>SCIS</b></h1>
Date:<input type="text" id="date" onFocus="MyCalendar.SetDate(this)" value="<?php echo $rq;?>" readonly style="border:0px;">Stock:

<?php 
 
include_once("st-conn.php");
  
//*******生成股票选择框**************************   
   $sql="SELECT * FROM stocklist;";
   $res=mysql_query($sql);
   
   echo "<select id='stock'>";  //都是第一页
   
   while($array=mysql_fetch_array($res,MYSQL_BOTH))
   {
       echo "<option value=".$array[0].">".$array[0]."</option>";
   }
   echo "</select>";
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button id="go" onClick="goPage(1)">GO!</button>
<br><br><br>
<div id="jymx" style="width:30%;float:left"></div>
<!--
<div id="scis" style="float:left">
  <div id="pic" style="float:left">
    <image width="950" height="330" id="price">
	<image width="950" height="330" id="quantity">
  </div>
  <div id="jymx"></div>
</div>
-->
</body>
</html>