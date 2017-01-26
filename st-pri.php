<?php
include("jpgraph/src/jpgraph.php");
include("jpgraph/src/jpgraph_line.php");
include("jpgraph/src/jpgraph_bar.php");
include_once("st-conn.php");

$stock=$_GET["stock"];
$date=$_GET['date']; 

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

//sleep(5);  //停5s等数据插入mysql 

$querysql="SELECT Price FROM ".$tablename." WHERE Date='\\$date'";
$queryset=@mysql_query($querysql);
   
$data1=array();
  
   
while($row=mysql_fetch_array($queryset,MYSQL_BOTH))  //可以执行
{
    array_push($data1,$row[0]);
}

/***************************折线图*************************************/
$graph = new Graph(950,330,auto);    //创建新的Graph对象
$graph->SetScale("lin");    //设置刻度样式
$graph->SetShadow();                 //设置图像的阴影样式
$graph->img->SetMargin(50,30,40,50); //设置图像边距
$graph->title->Set("时间-价格形势图");     //设置图像标题
$graph->title->SetMargin(20);
$lineplot1=new LinePlot($data1);     //创建设置两条曲线对象
//$lineplot2=new LinePlot($data2);
$lineplot1->value->Show();    //设置显示数字
$lineplot1->value->SetColor("black");
$graph->Add($lineplot1);             //将曲线放置到图像上
//$graph->Add($lineplot2);
//$graph->xaxis->title->Set("时 间");   //设置坐标轴名称
//$graph->yaxis->title->Set("价 格");
//$graph->xaxis->title->SetMargin(25);
//$graph->yaxis->title->SetMargin(25); 
//$graph->xaxis->SetTickLabels($data2);
$graph->title->SetFont(FF_SIMSUN,FS_BOLD);    //设置字体
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());
$lineplot1->SetColor("red");     //设置颜色
//$lineplot2->SetColor("blue");
//$lineplot1->SetLegend("现价");   //设置图例名称
//$lineplot2->SetLegend("Min");
$graph->xaxis->HideTicks(false,false); 
$graph->yaxis->HideTicks(false,false); 
$graph->legend->SetLayout(LEGEND_HOR);     //设置图例样式和位置
$graph->legend->Pos(0.5,0.96,"center","bottom");                                                  
$graph->Stroke();     //输出图像

?>
