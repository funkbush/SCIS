<?php
//***********两个日期之间的所有日期****************
function prDates($start,$end)  //输出两个日期间的所有日期（包括两个日期）
{
	$dt_start=strtotime($start);
	$dt_end=strtotime($end);
	$arrdate=array();
    /*
	while($dt_start<=$dt_end)
	{
		echo date('Y-m-d',$dt_start)."\n";
		$dt_start=strtotime('+1 day',$dt_start);
	}
	*/
	do 
	{ 
        //将 Timestamp 转成 ISO Date 输出
		array_push($arrdate,date('Y-m-d',$dt_start).PHP_EOL);
    
	}while(($dt_start+=86400)<=$dt_end);  //重复Timestamp+1天(86400),直至大于结束日期中止
     
	return $arrdate;
}

print_r(prDates('2010-05-27','2016-02-25'));
echo "----------\n";

?>