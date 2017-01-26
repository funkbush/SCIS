<?php
//$a1=array("a"=>"red","b"=>"green","c"=>"yellow","d"=>"blue","e"=>"black");
//$a2=array("e"=>"red","f"=>"green","g"=>"blue");

//$result=array_diff($a1,$a2);
//print_r($result);
include_once("st-conn.php");

function prDates($start,$end)  //输出两个日期间的所有日期（包括两个日期）
{
	$dt_start=strtotime($start);
	$dt_end=strtotime($end);
	$arrdate=array();
   
	do 
	{     
		array_push($arrdate,date('Y-m-d',$dt_start));  //将Timestamp转成ISO Date输出
    
	}while(($dt_start+=86400)<=$dt_end);  //重复Timestamp+1天(86400),直至大于结束日期中止
     
	return $arrdate;
}

$sd='2016-05-05';
$ed='2016-06-05';  
$myquery=mysql_query("SELECT Date FROM sz000778 WHERE Date BETWEEN '{$sd}' AND '{$ed}' GROUP BY Date");

$yesdate=array();   //已有日期
$nodate=array();   //缺的日期

while($row=mysql_fetch_array($myquery,MYSQL_BOTH))
{
	array_push($yesdate,$row[0]); 
} 

$arrdate=prDates($sd,$ed);   //获得两个日期间的所有日期名称

$nodate=array_diff($arrdate,$yesdate);
echo '<pre>';
print_r($yesdate);
print_r($nodate);
echo '</pre>';
?>
