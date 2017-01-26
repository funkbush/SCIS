<?php
include_once("st-conn.php");
include("st-calc.php");

ini_set('memory_limit','-1');//不要限制Mem大小，否则会报错 本文原始链接：http://www.jbxue.com/article/7763.html

$stock=$_GET["stock"];
$server=$_GET["server"];
$sd=$_GET["sd"];
$ed=$_GET["ed"];
/*
$stock=$_POST["stock"];
$server=$_POST["server"];
$sd=$_POST["sd"];
$ed=$_POST["ed"];
*/
echo "xxx".$stock;

$market=0;  //默认是深市0
if(substr($stock,0,1)==6)
{
	$market=1;  //沪市1
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
	
function prDates($start,$end)  //输出两个日期间的所有日期（包括两个日期）
{
	$dt_start=strtotime($start);
	$dt_end=strtotime($end);
	$arrdate=array();
   
	do 
	{     
		array_push($arrdate,date('Y-m-d',$dt_start)/*.PHP_EOL*/);  //将Timestamp转成ISO Date输出 .PHP_EOL相当于换行符
    
	}while(($dt_start+=86400)<=$dt_end);  //重复Timestamp+1天(86400),直至大于结束日期中止
     
	return $arrdate;
}

$arrdate=prDates($sd,$ed);   //获得两个日期间的所有日期名称
$myquery=mysql_query("SELECT Date FROM ".$tablename." WHERE Date BETWEEN '{$sd}' AND '{$ed}' GROUP BY Date");

$yesdate=array();  //数据库中已有日期
$nodate=array();   //数据库中缺的日期

while($row=mysql_fetch_array($myquery,MYSQL_BOTH))
{
	array_push($yesdate,$row[0]); 
} 

$arrdate=prDates($sd,$ed);   //获得两个日期间的所有日期名称

$nodate=array_values(array_diff($arrdate,$yesdate));   //数组从键值0开始编号
//print_r($nodate);

//***********************************遍历***********************************************
//ob_start();
for($k=0;$k<count($arrdate);$k++)   //最复杂的过程，遍历两日期间的所有日
{
	$date=$arrdate[$k];  //日期轮流读
	
	//如果数据库中没有该股票的表就创建一个，原来是以InnnoDB创建表，现在是以MyISAM创建速度更快，Navicat默认创建是MyISAM
	$checktable_sql="CREATE TABLE IF NOT EXISTS ".$tablename."(Date char(10) NULL,Time char(5) NULL,Price double(6,2) NULL,Qua bigint(20) NULL,Pro char(1) NULL)ENGINE=MyISAM;"; 
	mysql_query($checktable_sql);
	
	$checkdate_sql="SELECT * FROM ".$tablename." WHERE Date='{$date}';";   
 	
	//********************************************************************************************	
    $strval="";
	if(mysql_num_rows(mysql_query($checkdate_sql))==0)   //如果该表中无该日期数据，则从服务器获取并压入数据库
	{
		$host=$server;  //可选服务器地址 59.57.246.165
		$port=7709;    //连接端口只能是7709
		set_time_limit(0);  //设置超时时间，0为无限制
		// 设置一些基本的变量来创建socket		
        $socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("Could not create socket!\n");  //创建一个Socket		
		$result=socket_connect($socket,$host,$port) or die("Could not connect to socket!\n");  //连接	
		
		//!!!!!一个数据包所含的最大数据为2000条，即D007！！！！

		$receiveStr="";  //初始化接收数据  

		$arecord=array();   //创建总记录数组
		
//###########################################
		//这四个关键标识要清零，否则很麻烦
		$a=0;    //收到的每个数据段的记录数累加(数据包中截取的)
		$recordSum=0;  //每个数据段的记录数(数据包中截取的)
		$m=0;   //正则表达式拆分的记录数累加
		$flag=0;   //校验码??
//#######################*********************************************************************
		
		while($a%2000==0)    //发送、接收数据段并读取
		{
			$a=$a+$recordSum;  //$a是历次接受数据段记录数的叠加
			$b=str_pad(dechex($a),4,0,STR_PAD_LEFT);
		   
			$sendStr="0c013002020112001200b50f".get_date($date)."010".$market."003".join('3',str_split($stock)).substr($b,2,2).substr($b,0,2)."d007"; //初始发送
			//echo "send".$k.":  ".$sendStr."<br>";
			$hexstr=hex2asc($sendStr);   //发送数据转为二进制 
			
			if($result==TRUE) 
			{  	//连接
				socket_write($socket,$hexstr); 
				//sleep(1);   //睡1秒
			}
			
			$receiveStr=socket_read($socket,8192,PHP_BINARY_READ);  //接收数据，数据为二进制bin的
			$receiveStrHex=bin2hex($receiveStr);    // 数据转为16进制，要显示并分析的
			
			//echo "get".$k.":  ".$receiveStrHex."<br>";
			
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
			
            $receiveStrHex="";
			
			$recordSum=hexdec(substr($data,34,2).substr($data,32,2));   //$recordSum是一个数据段的记录数
			$flag=substr($data,36,8);//每个数据段都有一个当日统一的校验码？
			
		//**************************************下面是读取数据段的内容*****************************************************************
			$str=substr($data,44);  //截取可读取数据
			//$pattern='/(([3][a-f][0][2])|([4-9a][0-9a-f][0][2])|([b][0-2][0][2])|([0][c-f][0][3])|([1-7][0-9a-f][0][3])|([8][0-4][0][3]))([0-9a-f]{2}|([0-9a-f]{3}[1-9a-f])|([0-9a-f]{5}[1-9a-f]))(([0-7][0-9a-f])|([8-9a-f][0-9a-f]{2}[1-9a-f])|([8-9a-f][0-9a-f][8-9a-f][0-9a-f]{2}[1-9a-f]))([0][01][0][0])/';
			$pattern='/(([3][a-f][0][2])|([4-9a][0-9a-f][0][2])|([b][0-2][0][2])|([0][c-f][0][3])|([1-7][0-9a-f][0][3])|([8][0-4][0][3]))(([8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f][8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f]{3})|([0-9a-f]{2}[0-7][0-9a-f][8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{2}[0-7][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{2}[0-7][0-9a-f]{3})|([0-9a-f]{2}[8-9a-f][0-9a-f][8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{2}[8-9a-f][0-9a-f][0-7][0-9a-f])|([0-9a-f]{4}))([0][01][0][0])/';
			preg_match_all($pattern,$str,$char);

			//print_r($char[0]);   //数据存在char[0]里
			
			$m=$m+count($char[0]);  //统计正则表达式截取数据的数组个数
			
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
		
		socket_close($socket);  // 关闭sockets
		
		ob_flush();  //把数据从PHP的缓冲中释放出来   
        flush();   //将释放出来的数据发送到浏览器
		
		//****************************************************************************************************************************
        
		for($i=count($arecord)-1;$i>=0;$i--) //读取所有记录
		{        
			$brarray=explode(',',$arecord[$i]);  //explode以某个符号隔断
			$strval.="('".$date."','".$brarray[0]."',".$brarray[1].",".$brarray[2].",'".$brarray[3]."'),";   //叠加连结字符串--------------
		}
			
		$sql="INSERT INTO ".$tablename."(Date,Time,Price,Qua,Pro) VALUES".substr($strval,0,strlen($strval)-1);  //统一插入，执行mysql命令越少越好
		
		$fhz=mysql_query($sql);
		//$strval="";
		if($fhz==1)
		{
	       echo str_pad("Import".$k.":  ".$stock." ".$date." Data:  ".$m."/".$a."rows OK!<br>",4096);
        }
        elseif($m==0 && $fzh==0)
        {
		   //echo "Import".$k.":  ".$stock." ".$date." Data:  ".$m."/".$a."rows Empty!<br>";
		}
		else
        {
			echo str_pad("Import".$k.":  ".$stock." ".$date." Data:  ".$m."/".$a."rows Failed!<br>",4096);
		}		
	}
	
	else
	{
	    echo str_pad("Import".$k.":  ".$stock." ".$date." Data Already Exist!<br>",4096); 
	}
	
    
	//ob_flush();  
    //flush();
	
	if($k%20==0)   //每处理一百天停两秒
	{
	   sleep(2);
	}
}
 
//ob_end_flush();  
?>