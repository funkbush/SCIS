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
   
   while($row = mysql_fetch_array($queryset, MYSQL_BOTH))  //����ִ��
  {
     array_push($data1,$row[2]);
     array_push($data2,$row[3]);
  }
  
  //array_push($data1,2,3);//������
/***************************����ͼ*************************************/
//$data1 = array(1,22,66,5,1,5,6,1,67);//��һ�����ߵ�����
//$data2 = array(19,23,34,38,45,67,71,78,85,87,90,96);            //�ڶ������ߵ�����

$graph1 = new Graph(1000,330,auto);    //�����µ�Graph����
$graph1->SetScale("lin");    //���ÿ̶���ʽ
$graph1->SetShadow();                 //����ͼ�����Ӱ��ʽ
$graph1->img->SetMargin(50,30,40,50); //����ͼ��߾�
$graph1->title->Set("ʱ��-�۸�����ͼ");     //����ͼ�����
$graph1->title->SetMargin(20);
$lineplot1=new LinePlot($data1);     //���������������߶���
//$lineplot2=new LinePlot($data2);
$lineplot1->value->Show();    //������ʾ����
$lineplot1->value->SetColor("black");
$graph1->Add($lineplot1);             //�����߷��õ�ͼ����
//$graph->Add($lineplot2);
//$graph->xaxis->title->Set("ʱ ��");   //��������������
//$graph->yaxis->title->Set("�� ��");
//$graph->xaxis->title->SetMargin(25);
//$graph->yaxis->title->SetMargin(25); 
//$graph->xaxis->SetTickLabels($data2);
$graph1->title->SetFont(FF_SIMSUN,FS_BOLD);    //��������
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph1->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());
$lineplot1->SetColor("red");     //������ɫ
//$lineplot2->SetColor("blue");
//$lineplot1->SetLegend("�ּ�");   //����ͼ������
//$lineplot2->SetLegend("Min");
$graph1->legend->SetLayout(LEGEND_HOR);     //����ͼ����ʽ��λ��
$graph1->legend->Pos(0.5,0.96,"center","bottom");                                                  
/***************************��״ͼ*************************************/
//$data2 = array(19,23,34,38,45,67,71,78,85,87,96,145);    //��������
//$ydata = array("һ","��","��","��","��","��","��","��","��","ʮ","ʮһ","ʮ��");
$graph2 = new Graph(1000,330);    //�����µ�Graph����
$graph2->SetScale("lin");
$graph2->SetShadow();    //������Ӱ
$graph2->img->SetMargin(50,30,40,50);//���ñ߾�
$barplot = new BarPlot($data2);      //����BarPlot����
$barplot->SetFillColor('blue');     //������ɫ
$barplot->value->Show();            //������ʾ����
$graph2->Add($barplot);              //������ͼ��ӵ�ͼ����
$graph2->title->Set("ʱ��-��������ͼ");    //���ñ����X-Y�����
$graph2->title->SetColor("black");
$graph2->title->SetMargin(20);
//$graph->xaxis->title->Set("ʱ ��");
$graph2->xaxis->title->SetMargin(25);
//$graph->xaxis->SetTickLabels($data2);
//$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->yaxis->title->Set("�� ��");
$graph2->title->SetFont(FF_SIMSUN,FS_BOLD);  //��������
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->legend->Pos(0.5,0.96,"center","bottom");

$graph1->Stroke();     //���ͼ��
//$graph2->Stroke();
?>
