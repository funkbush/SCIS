<?php
include("jpgraph/src/jpgraph.php");
include("jpgraph/src/jpgraph_line.php");
include("jpgraph/src/jpgraph_bar.php");

include_once("st-conn.php");
   
   $num=$_GET['page']; 
   $num_cnt = mysql_num_rows($myquery);
   $querysql = "select * from sz002024 limit ".($num*500).",1000";
   $queryset = @mysql_query($querysql);
   $data1=array();
   $data2=array();
   
   while($row = mysql_fetch_array($queryset, MYSQL_BOTH))  //可以执行
  {
     array_push($data1,$row[2]);
     array_push($data2,$row[3]);
  }
  
  //array_push($data1,2,3);//可以用
/***************************折线图*************************************/
//$data1 = array(1,22,66,5,1,5,6,1,67);//第一条曲线的数组
//$data2 = array(19,23,34,38,45,67,71,78,85,87,90,96);            //第二条曲线的数组

$graph1 = new Graph(1000,330,auto);    //创建新的Graph对象
$graph1->SetScale("lin");    //设置刻度样式
$graph1->SetShadow();                 //设置图像的阴影样式
$graph1->img->SetMargin(50,30,40,50); //设置图像边距
$graph1->title->Set("时间-价格形势图");     //设置图像标题
$graph1->title->SetMargin(20);
$lineplot1=new LinePlot($data1);     //创建设置两条曲线对象
//$lineplot2=new LinePlot($data2);
$lineplot1->value->Show();    //设置显示数字
$lineplot1->value->SetColor("black");
$graph1->Add($lineplot1);             //将曲线放置到图像上
//$graph->Add($lineplot2);
//$graph->xaxis->title->Set("时 间");   //设置坐标轴名称
//$graph->yaxis->title->Set("价 格");
//$graph->xaxis->title->SetMargin(25);
//$graph->yaxis->title->SetMargin(25); 
//$graph->xaxis->SetTickLabels($data2);
$graph1->title->SetFont(FF_SIMSUN,FS_BOLD);    //设置字体
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph1->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());
$lineplot1->SetColor("red");     //设置颜色
//$lineplot2->SetColor("blue");
//$lineplot1->SetLegend("现价");   //设置图例名称
//$lineplot2->SetLegend("Min");
$graph1->legend->SetLayout(LEGEND_HOR);     //设置图例样式和位置
$graph1->legend->Pos(0.5,0.96,"center","bottom");                                                  
/***************************柱状图*************************************/
//$data2 = array(19,23,34,38,45,67,71,78,85,87,96,145);    //定义数组
//$ydata = array("一","二","三","四","五","六","七","八","九","十","十一","十二");
$graph2 = new Graph(1000,330);    //创建新的Graph对象
$graph2->SetScale("lin");
$graph2->SetShadow();    //设置阴影
$graph2->img->SetMargin(50,30,40,50);//设置边距
$barplot = new BarPlot($data2);      //创建BarPlot对象
$barplot->SetFillColor('blue');     //设置颜色
$barplot->value->Show();            //设置显示数字
$graph2->Add($barplot);              //将柱形图添加到图像中
$graph2->title->Set("时间-数量形势图");    //设置标题和X-Y轴标题
$graph2->title->SetColor("black");
$graph2->title->SetMargin(20);
//$graph->xaxis->title->Set("时 间");
$graph2->xaxis->title->SetMargin(25);
//$graph->xaxis->SetTickLabels($data2);
//$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->yaxis->title->Set("数 量");
$graph2->title->SetFont(FF_SIMSUN,FS_BOLD);  //设置字体
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->legend->Pos(0.5,0.96,"center","bottom");

$graph1->Stroke();     //输出图像
//$graph2->Stroke();
?>
