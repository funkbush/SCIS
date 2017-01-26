<?php
include_once("st-conn.php");
require_once("jpgraph/src/jpgraph.php");
require_once("jpgraph/src/jpgraph_line.php");
require_once("jpgraph/src/jpgraph_bar.php");

$stock=$_GET["stock"];
$sd=$_GET["sd"];
$ed=$_GET["ed"];

$price=array();  //价格数组
$qua=array();    //数量数组
$date_row=array();  //统计的日期数组
$c_row=array();  //统计每日换手率

if(substr($stock,0,1)=='0' or substr($stock,0,1)=='3')   //数据库里表名
{
	$tablename='sz'.$stock;
}
elseif(substr($stock,0,1)=='6')
{
	$tablename='sh'.$stock;
}
else
{
	$tablename=$stock;
}

//select * from sz000001 where Date between '2016-02-22' and '2016-02-23';
//@是PHP提供的错误信息屏蔽的专用符号。

mysql_query("TRUNCATE TABLE stock_copy;") or die("Empty table stock_copy Fail!");    //运算前清空表，不能恢复的
 

//下面先把两日期间的所有该股记录存入临时表
mysql_query("INSERT INTO stock_copy SELECT Date,Price,sum(Qua) FROM ".$tablename." WHERE Date BETWEEN '{$sd}' AND '{$ed}' GROUP BY Date,Price") or die("临时表导入失败!");
//下面计算实际换手率
$myquery=mysql_query("SELECT Date,sum(Qua)/(SELECT Qua FROM stockf10 WHERE stock='".$stock."') FROM ".$tablename." WHERE Date BETWEEN '{$sd}' AND '{$ed}' GROUP BY Date") or die("换手率计算失败!");

$m=0;  //m为要处理的天数
while($row=mysql_fetch_array($myquery,MYSQL_BOTH))
{
	array_push($date_row,$row[0]);
	array_push($c_row,$row[1]);   //$c_row为每日换手率
	$m++;     
} 

//print_r($c_row);   //OK!

mysql_query("TRUNCATE TABLE chips;") or die("Empty table chips Fail!");    //运算前清空表，不能恢复的

for($i=0;$i<$m;$i++)    //
{    
	$mq1=mysql_query("UPDATE chips SET Qua=(1-".$c_row[$i].")*Qua") or die("mq1 Fail!");  //换手率平均分布，作用到每笔成交明细上
	$mq2=mysql_query("INSERT INTO chips SELECT Price,Qua FROM stock_copy WHERE Date='{$date_row[$i]}'") or die("mq2 Fail!");
	//echo "The ".$i." day is OK!";
}

$myquery=mysql_query("SELECT Price,sum(Qua) FROM chips GROUP BY Price DESC") or die("SQL语句执行失败!");  //group by倒序
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
if($m>0)   //如果要处理的日期大于0，则显示图片否则不显示
{	
	$graph->title->Set($stock."   ".$date_row[0]."->".$date_row[$m-1]);     //设置图像标题
	$graph->title->SetMargin(680);
	// set major and minor tick positions manually
	$graph->SetBox(false);  //图表外框
	$graph->xaxis->SetTickLabels($price);
	$b1plot=new BarPlot($qua);
	// ...and add it to the graPH
	$graph->Add($b1plot);
}
else
{
	$graph->title->Set("No Data");     //设置图像标题
	$graph->title->SetMargin(680);
	// set major and minor tick positions manually
	$graph->SetBox(false);  //图表外框
	$graph->xaxis->SetTickLabels();
	$b1plot=new BarPlot(1000);
	// ...and add it to the graPH
	$graph->Add($b1plot);
}
$graph->yaxis->scale->SetGrace(20);
$b1plot->SetColor("red");
$b1plot->SetFillColor("red"); 
$b1plot->SetWeight(2);

$b1plot->SetWidth(1);  //柱的粗细,1为自动调节
$graph->legend->SetLayout(LEGEND_HOR);     //设置图例样式和位置	

$graph->Stroke();
?>