<?php 
date_default_timezone_set("PRC");
$nowtime=time();
$rq=date("Y-m-d",$nowtime);
include("st-navigation.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCIS筹码分布</title>
<script type="text/javascript" src="js/st-search.js"></script>
<script type="text/javascript" src="js/mydate.js"></script>
<link rel="stylesheet" type="text/css" href="css/st-search.css" />

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
   echo "</select>";
?> 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
First-Date:&nbsp;&nbsp;<input type="text" id="sd" onFocus="MyCalendar.SetDate(this)" value="<?php echo $rq;?>" readonly style="border:0px;">
End-Date:&nbsp;&nbsp;<input type="text" id="ed" onFocus="MyCalendar.SetDate(this)" value="<?php echo $rq;?>" readonly style="border:0px;">
<button onclick="check()">Chips!!!</button>
</div>
</br>
</br>
<img id='res' style="float:left">
</body>

</html>