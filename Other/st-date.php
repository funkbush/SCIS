<?php  
include("st-calc.php");

$stock="002358";   //查询股票代码join('3',str_split($stock));  //在字符串单个字符中插入3
$mark=0;  //默认是深市0
if(substr($stock,0,1)==6)
{
    $mark=1;  //沪市1
}

$date="2015-05-05";  //查询日期

echo $stock."&nbsp;".$date."<br>";  //显示股票和日期

// 设置一些基本的变量来创建socket
$host='59.57.246.165';  //到时候弄一个可选的服务器地址，连接端口只能是7709
$port=7709;
set_time_limit(0);  //设置超时时间，0为无限制
$socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP) or die("Could not create socket\n");  //创建一个Socket
$result=socket_connect($socket,$host,$port) or die("Could not connect to socket\n");  //连接
//********************************************************************************************

function client($stock,$date)
{
    
} 

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
	
	$arrtmp=array(get_time($char[0][0])."&nbsp;".number_format($arrpri[0],2)."&nbsp;".$arrpri[1]."&nbsp;".get_pro($char[0][0])."<br>");;
    //$arrtmp=array(get_time($char[0][0]).",".number_format($arrpri[0],2).",".$arrpri[1].",".get_pro($char[0][0])."<br>");;
	$tmp=$arrpri[0];   //得到基准价格
    
	for($i=1;$i<=$recordSum-1;$i++) //59是数据段所含记录数，在接受包中有
	{        
		$arrpri=get_priqua($char[0][$i]);   //得到偏移量和数量，放进arrpri价格基数及偏移量数组
		$tmp=$tmp+$arrpri[0];
		array_push($arrtmp,get_time($char[0][$i])."&nbsp;".number_format($tmp,2)."&nbsp;".$arrpri[1]."&nbsp;".get_pro($char[0][$i])."<br>");
        //array_push($arrtmp,get_time($char[0][$i]).",".number_format($tmp,2).",".$arrpri[1].",".get_pro($char[0][$i])."<br>"); 
		//利用千位分组来格式化数字的函数number_format($tmp,2)		
	} 
	  
    //*************************************************************************************************************************
    
	$arecord=array_merge($arecord,array_reverse($arrtmp));  //把$arrtmp数组倒过来再合并再倒过来就正了 
}
//****************************************************************************************************************************
socket_close($socket);  // 关闭sockets

for($i=count($arecord)-1;$i>=0;$i--) //打印所有记录
{        
	echo $arecord[$i];				
} 
	  
?>



