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

//sleep(3);  //ͣ3s�����ݲ���mysql
   
$querysql="SELECT Qua,Pro FROM ".$tablename." WHERE Date='\\$date'";
$queryset=@mysql_query($querysql);
   
$data1=array();
//$data2=array();
 
while($row=mysql_fetch_array($queryset,MYSQL_BOTH))  //����ִ��
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
  
/***************************��״ͼ*************************************/
$graph = new Graph(950,330);    //�����µ�Graph����
$graph->SetScale("lin");
$graph->SetShadow();    //������Ӱ
$graph->img->SetMargin(50,30,40,50);//���ñ߾�
$barplot = new BarPlot($data1);      //����BarPlot����
$barplot->SetFillColor('blue');     //������ɫ
$barplot->value->Show();            //������ʾ����
$graph->Add($barplot);              //������ͼ��ӵ�ͼ����
$graph->title->Set("ʱ��-��������ͼ");    //���ñ����X-Y�����
$graph->title->SetColor("black");
$graph->title->SetMargin(20);
//$graph->xaxis->title->Set("ʱ ��");
$graph->xaxis->title->SetMargin(25);
//$graph->xaxis->SetTickLabels($data2);
//$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->yaxis->title->Set("�� ��");
$graph->title->SetFont(FF_SIMSUN,FS_BOLD);  //��������
$graph->xaxis->HideTicks(false,false); 
$graph->yaxis->HideTicks(false,false); 
//$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);

//$graph->xaxis->SetFont(FF_SIMSUN,FS_BOLD);
//$graph->legend->Pos(0.5,0.96,"center","bottom");
$graph->Stroke();

?>
