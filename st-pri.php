<?php
include("jpgraph/src/jpgraph.php");
include("jpgraph/src/jpgraph_line.php");
include("jpgraph/src/jpgraph_bar.php");
include_once("st-conn.php");

$stock=$_GET["stock"];
$date=$_GET['date']; 

if(substr($stock,0,1)=='0' or substr($stock,0,1)=='3')   //���ݿ������
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

//sleep(5);  //ͣ5s�����ݲ���mysql 

$querysql="SELECT Price FROM ".$tablename." WHERE Date='\\$date'";
$queryset=@mysql_query($querysql);
   
$data1=array();
  
   
while($row=mysql_fetch_array($queryset,MYSQL_BOTH))  //����ִ��
{
    array_push($data1,$row[0]);
}

/***************************����ͼ*************************************/
$graph = new Graph(950,330,auto);    //�����µ�Graph����
$graph->SetScale("lin");    //���ÿ̶���ʽ
$graph->SetShadow();                 //����ͼ�����Ӱ��ʽ
$graph->img->SetMargin(50,30,40,50); //����ͼ��߾�
$graph->title->Set("ʱ��-�۸�����ͼ");     //����ͼ�����
$graph->title->SetMargin(20);
$lineplot1=new LinePlot($data1);     //���������������߶���
//$lineplot2=new LinePlot($data2);
$lineplot1->value->Show();    //������ʾ����
$lineplot1->value->SetColor("black");
$graph->Add($lineplot1);             //�����߷��õ�ͼ����
//$graph->Add($lineplot2);
//$graph->xaxis->title->Set("ʱ ��");   //��������������
//$graph->yaxis->title->Set("�� ��");
//$graph->xaxis->title->SetMargin(25);
//$graph->yaxis->title->SetMargin(25); 
//$graph->xaxis->SetTickLabels($data2);
$graph->title->SetFont(FF_SIMSUN,FS_BOLD);    //��������
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());
$lineplot1->SetColor("red");     //������ɫ
//$lineplot2->SetColor("blue");
//$lineplot1->SetLegend("�ּ�");   //����ͼ������
//$lineplot2->SetLegend("Min");
$graph->xaxis->HideTicks(false,false); 
$graph->yaxis->HideTicks(false,false); 
$graph->legend->SetLayout(LEGEND_HOR);     //����ͼ����ʽ��λ��
$graph->legend->Pos(0.5,0.96,"center","bottom");                                                  
$graph->Stroke();     //���ͼ��

?>
