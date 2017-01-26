<?php
include_once("st-conn.php");
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


