<?php
//$a1=array("a"=>"red","b"=>"green","c"=>"yellow","d"=>"blue","e"=>"black");
//$a2=array("e"=>"red","f"=>"green","g"=>"blue");

//$result=array_diff($a1,$a2);
//print_r($result);
include_once("st-conn.php");

function prDates($start,$end)  //����������ڼ���������ڣ������������ڣ�
{
	$dt_start=strtotime($start);
	$dt_end=strtotime($end);
	$arrdate=array();
   
	do 
	{     
		array_push($arrdate,date('Y-m-d',$dt_start));  //��Timestampת��ISO Date���
    
	}while(($dt_start+=86400)<=$dt_end);  //�ظ�Timestamp+1��(86400),ֱ�����ڽ���������ֹ
     
	return $arrdate;
}

$sd='2016-05-05';
$ed='2016-06-05';  
$myquery=mysql_query("SELECT Date FROM sz000778 WHERE Date BETWEEN '{$sd}' AND '{$ed}' GROUP BY Date");

$yesdate=array();   //��������
$nodate=array();   //ȱ������

while($row=mysql_fetch_array($myquery,MYSQL_BOTH))
{
	array_push($yesdate,$row[0]); 
} 

$arrdate=prDates($sd,$ed);   //����������ڼ��������������

$nodate=array_diff($arrdate,$yesdate);
echo '<pre>';
print_r($yesdate);
print_r($nodate);
echo '</pre>';
?>
