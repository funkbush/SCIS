<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table border="0" width="100%" cellspacing="2" bordercolor="black"><tr><th><b>Date</b></th><th><b>Time</b></th><th><b>Pri</b></th><th><b>Qua</b></th></tr>
<script type="text/javascript" src="js/st-show.js"></script>

<?php
include_once("st-conn.php");
include("st-calc.php");

$stock=$_GET["stock"];  //股票代码join('3',str_split($stock));  //在字符串单个字符中插入3
$num=$_GET["page"];     //页数
$date=$_GET["date"];    //日期
/* 
$stock="000520";  //股票代码join('3',str_split($stock));  //在字符串单个字符中插入3
$num="";     //页数
$date="2015-12-23";    //日期
*/
$mark=0;  //默认是深市0
if(substr($stock,0,1)==6)
{
    $mark=1;  //沪市1
}

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

//如果数据库中没有该股票的表就创建一个，原来是以InnnoDB创建表，现在是以MyISAM创建速度更快，Navicat默认创建是MyISAM
$checktable_sql="CREATE TABLE IF NOT EXISTS ".$tablename."(Date char(10) NULL,Time char(5) NULL,Price double(6,2) NULL,Qua bigint(20) NULL,Pro char(1) NULL)ENGINE=MyISAM;"; 
mysql_query($checktable_sql);

$sqldate=substr($date,0,strlen($date)-0);  //防止PHP向mysql输入命令时多一个空格。。。
$checkdate_sql="SELECT * FROM ".$tablename." WHERE Date='{$sqldate}';"; 
//echo $checkdate_sql."<br>";
//echo mysql_num_rows(mysql_query($checkdate_sql))."<br>";

if(mysql_num_rows(mysql_query($checkdate_sql))==0)   //如果该表中无该日期数据，则从服务器获取并压入数据库
{
    
	// 设置一些基本的变量来创建socket	
	$host='220.178.118.60';  //到时候弄一个可选的服务器地址，连接端口只能是7709
	$port=7709;
	set_time_limit(0);  //设置超时时间，0为无限制
	$socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("Could not create socket\n");  //创建一个Socket
	$result=socket_connect($socket,$host,$port) or die("Could not connect to socket\n");  //连接
	//********************************************************************************************

	//!!!!!一个数据包所含的最大数据为2000条，即D007！！！！

	$receiveStr="";  //初始化接收数据  

	$arecord=array();   //创建总记录数组

	//*********************************************************************
	while($a%2000==0)    //发送、接收数据段并读取
	{
		$a=$a+$recordSum;  //$a是历次接受数据段记录数的叠加
		$b=str_pad(dechex($a),4,0,STR_PAD_LEFT);
	   
		$sendStr="0c013002020112001200b50f".get_date($date)."010".$mark."003".join('3',str_split($stock)).substr($b,2,2).substr($b,0,2)."d007"; //初始发送
		
		$hexstr=hex2asc($sendStr);   //发送数据转为二进制 
		
		if($result==TRUE) 
		{  	//连接
			socket_write($socket,$hexstr); 
			//sleep(1);   //睡1秒
		}
		
		$receiveStr=socket_read($socket,8192,PHP_BINARY_READ);  //接收数据，数据为二进制bin的
		$receiveStrHex=bin2hex($receiveStr);    // 数据转为16进制，要显示并分析的
		
		if(substr($receiveStrHex,24,6)=="060006")  //如果接受的原始数据段出现没记录的标记
		{
			break; //跳出while循环
		}
		
		
		if(substr($receiveStrHex,8,1)==1)   //判断原始数据段解压标识
		{
			$data=substr($receiveStrHex,0,32).bin2hex(gzuncompress(substr($receiveStr,16)));  //zlib函数解压
		}
		else
		{ 
			$data=$receiveStrHex; //不用解压直接输出
		}

		$recordSum=hexdec(substr($data,34,2).substr($data,32,2));   //$recordSum是一个数据段的记录数
		$flag=substr($data,36,8);//每个数据段都有一个当日统一的校验码？
		
	//**************************************下面是读取数据段的内容*****************************************************************
		$str=substr($data,44);  //截取可读取数据
		//$pattern='/(([3][a-f][0][2])|([4-9a][0-9a-f][0][2])|([b][0-2][0][2])|([0][c-f][0][3])|([1-7][0-9a-f][0][3])|([8][0-4][0][3]))([0-9a-f]{2}|([0-9a-f]{3}[1-9a-f])|([0-9a-f]{5}[1-9a-f]))(([0-7][0-9a-f])|([8-9a-f][0-9a-f]{2}[1-9a-f])|([8-9a-f][0-9a-f][8-9a-f][0-9a-f]{2}[1-9a-f]))([0][01][0][0])/';
		$pattern='/(([3][a-f][0][2])|([4-9a][0-9a-f][0][2])|([b][0-2][0][2])|([0][c-f][0][3])|([1-7][0-9a-f][0][3])|([8][0-4][0][3]))(([8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f][8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f]{3})|([0-9a-f]{2}[0-7][0-9a-f][8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{2}[0-7][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{2}[0-7][0-9a-f]{3})|([0-9a-f]{2}[8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{2}[8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{4}))([0][01][0][0])/';
		preg_match_all($pattern,$str,$char);

		//print_r($char[0]);   //数据存在char[0]里

		$arrpri=get_prifou($char[0][0]);  //计算基准价格可能会有问题
		
		//$arrtmp=array(get_time($char[0][0])."&nbsp;".number_format($arrpri[0],2)."&nbsp;".$arrpri[1]."&nbsp;".get_pro($char[0][0])."<br>");;
		$arrtmp=array(get_time($char[0][0]).",".number_format($arrpri[0],2).",".$arrpri[1].",".get_pro($char[0][0])."<br>");;
		$tmp=$arrpri[0];   //得到基准价格
		
		for($i=1;$i<=$recordSum-1;$i++) 
		{        
			$arrpri=get_priqua($char[0][$i]);   //得到偏移量和数量，放进arrpri价格基数及偏移量数组
			$tmp=$tmp+$arrpri[0];
			//array_push($arrtmp,get_time($char[0][$i])."&nbsp;".number_format($tmp,2)."&nbsp;".$arrpri[1]."&nbsp;".get_pro($char[0][$i])."<br>");
			array_push($arrtmp,get_time($char[0][$i]).",".number_format($tmp,2).",".$arrpri[1].",".get_pro($char[0][$i])."<br>"); 
			//利用千位分组来格式化数字的函数number_format($tmp,2)		
		} 
		  
		//*************************************************************************************************************************
		
		$arecord=array_merge($arecord,array_reverse($arrtmp));  //把$arrtmp数组倒过来再合并再倒过来就正了 
	}
	//****************************************************************************************************************************
	socket_close($socket);  // 关闭sockets

	for($i=count($arecord)-1;$i>=0;$i--) //读取所有记录
	{        
		//echo $arecord[$i];
		//$str="(".$date.",".$arecord[$i].")"; 
		//echo $str;
		$brarray=explode(',',$arecord[$i]);  //explode以某个符号隔断
		$strval.="('".$date."','".$brarray[0]."',".$brarray[1].",".$brarray[2].",'".$brarray[3]."'),";   //叠加连结字符串--------------
	}
	//echo $strval;	
	$sql="INSERT INTO ".$tablename."(Date,Time,Price,Qua,Pro) VALUES".substr($strval,0,strlen($strval)-1);  //统一插入，执行mysql命令越少越好
	//echo $sql;
	mysql_query($sql);
	$strval="";

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
if($num=="")
{ 
    $num=1;
}
$querysql="SELECT * FROM ".$tablename." WHERE Date='{$sqldate}' limit ".(($num-1)*30).",30" or die("SQL语句执行失败!"); 
$queryset=@mysql_query($querysql);
 
   $page_size=30;
   $sum_sql="SELECT * FROM ".$tablename." WHERE Date='{$sqldate}';";
   $num_cnt=mysql_num_rows(mysql_query($sum_sql));   //@@@@@@@@@@@@@@@@@注意看说明书啊
   $page_cnt=ceil($num_cnt/$page_size);  //总的分页数，ceil()返回大于的最小正整数
 
   if($page_cnt>1)
   {
	  echo "<div id='page' style='display:none'>".$page_cnt."</div>";
	  echo "<div style='float:right' id='control'>";
	  echo "<button onclick=turn(-1)>Back</button>";
      echo "<button onclick=turn(1)>Next</button></br>"; 
      echo "<div id='nowpage' style='float:left'>".$num."</div><div'> /".$page_cnt."</div>";  
	  echo "</div>";
   }
while($row = mysql_fetch_array($queryset, MYSQL_BOTH))
{
   if($row[4]=='B')
   {
       echo "<tr style='color:red;font-weight:bold' align='middle'>";
   } 
   else if($row[4]=='S')
   { 
       echo "<tr style='color:green;font-weight:bold' align='middle'>";//时间
   }
   else
   {
       echo "<tr style='font-weight:bold' align='middle'>";//时间
   }
       echo "<td>" . $row[0] . "</td>";//日期
       echo "<td>" . $row[1] . "</td>";//时间
	   echo "<td>" . $row[2] . "</td>";   //单价 //表格中单元格居中
       echo "<td>" . $row[3] . "</td>";   //数量
}
echo "</table><br>";
?>

</body>
</html>
