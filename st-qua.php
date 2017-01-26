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

//sleep(3);  //停3s等数据插入mysql
   
$querysql="SELECT Qua,Pro FROM ".$tablename." WHERE Date='\\$date'";
$queryset=@mysql_query($querysql);
   
$data1=array();
//$data2=array();
 
while($row=mysql_fetch_array($queryset,MYSQL_BOTH))  //可以执行
{ 
    if($row[1]=="S")
	{
	    array_push($data1,(-1)*$row[0]);
    }
	else
	{
	    array_push($data1,$row[0]);
	}
}
  
/***************************柱状图*************************************/
$graph = new Graph(950,330);    //创建新的Graph对象
$graph->SetScale("lin");
$graph->SetShadow();    //设置阴影
$graph->img->SetMargin(50,30,40,50);//设置边距
$barplot = new BarPlot($data1);      //创建BarPlot对象
$barplot->SetFillColor('blue');     //设置颜色
$barplot->value->Show();            //设置显示数字
$graph->Add($barplot);              //将柱形图添加到图像中
$graph->title->Set("时间-数量形势图");    //设置标题和X-Y轴标题
$graph->title->SetColor("black");
$graph->title->SetMargin(20);
//$graph->xaxis->title->Set("时 间");
$graph->xaxis->title->SetMargin(25);
//$graph->xaxis->SetTickLabels($data2);
//$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->yaxis->title->Set("数 量");
$graph->title->SetFont(FF_SIMSUN,FS_BOLD);  //设置字体
$graph->xaxis->HideTicks(false,false); 
$graph->yaxis->HideTicks(false,false); 
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);

//$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->legend->Pos(0.5,0.96,"center","bottom");
$graph->Stroke();

?>
