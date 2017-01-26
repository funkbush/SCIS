<?php
include_once("st-conn.php");
require_once("jpgraph/src/jpgraph.php");
require_once("jpgraph/src/jpgraph_line.php");
require_once("jpgraph/src/jpgraph_bar.php");

set_time_limit(0);   //页面执行最大时间，0为无限制
$stock=sh601118;
$sd=141204;
$ed=150730;

$price=array();  //价格数组
$qua=array();    //数量数组
$date_row=array();  //统计的日期数组
$c_row=array();  //统计每日换手

//@是PHP提供的错误信息屏蔽的专用符号。
mysql_query("truncate table stock_copy;") or die("Empty table stock_copy Fail!");    //运算前清空表，不能恢复的
mysql_query("insert into stock_copy select Date,Price,sum(Qua) from ".$stock." where Date>='\\$sd' and Date<='\\$ed' group by Date,Price") or die("临时表导入失败!");

$myquery=mysql_query("select Date,sum(Qua)/12000000 from ".$stock." where Date>='\\$sd' and Date<='\\$ed' group by Date") or die("换手率计算失败!");
$m=0;
while($row=mysql_fetch_array($myquery,MYSQL_BOTH))
{
	array_push($date_row,$row[0]);
	array_push($c_row,$row[1]);
	$m++;     //m为要处理的天数
} 

mysql_query("truncate table chips;") or die("Empty table chips Fail!");    //运算前清空表，不能恢复的

for($i=0;$i<$m;$i++)    //
{
    //$check_sql="CREATE TABLE IF NOT EXISTS ".($i+1)."-".$stock."-chips(Price double(6,2) NULL,Qua bigint(20))ENGINE=Memory;"; 
	$mq1=@mysql_query("update chips set Qua=(1-".$c_row[$i].")*Qua") or die("mq1 Fail!");
	$mq2=@mysql_query("insert into chips select Price,Qua from stock_copy where Date=".$date_row[$i]) or die("mq2 Fail!");
	//echo "The ".$i." day is OK!";
}

$myquery=@mysql_query("select Price,sum(Qua) from chips group by Price desc") or die("SQL语句执行失败!");  //group by倒序
while($row=mysql_fetch_array($myquery,MYSQL_BOTH))
{
	array_push($price,$row[0]);
	array_push($qua,$row[1]);
}
//画图是小事!关键是数据要成功导入!图形只是为了验证效果
// Create the graph. These two calls are always required

$graph=new Graph(700,700,auto);
$graph->SetScale('lin',1,1,1,1);  //设置坐标样式为线型
$graph->img->SetAngle(90);   //坐标旋转
$graph->title->Set($stock."   ".$sd."->".$ed);     //设置图像标题
$graph->title->SetMargin(680);
// set major and minor tick positions manually
$graph->SetBox(false);  //图表外框
$graph->xaxis->SetTickLabels($price);
$b1plot=new BarPlot($qua);
// ...and add it to the graPH
$graph->Add($b1plot);
$graph->yaxis->scale->SetGrace(20);
$b1plot->SetColor("red");
$b1plot->SetFillColor("red"); 
$b1plot->SetWeight(2);

$b1plot->SetWidth(1);  //柱的粗细,1为自动调节
$graph->legend->SetLayout(LEGEND_HOR);     //设置图例样式和位置

$graph->Stroke();

?>