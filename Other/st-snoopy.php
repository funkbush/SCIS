<?php
$url="http://www.baidu.com";
include("snoopy/Snoopy.class.php");
$snoopy=new Snoopy;
$snoopy->fetch($url); //获取所有内容
echo $snoopy->results; //显示结果
//可选以下
//$snoopy->fetchtext; //获取文本内容（去掉html代码）
//$snoopy->fetchlinks; //获取链接
//$snoopy->fetchform; //获取表单
?>

<!--
<meta http-equiv='content-type' content='text/html;charset=utf-8'>
<    
include 'snoopy/Snoopy.class.php';        
$snoopy=new Snoopy();        
$sourceURL="http://www.cnblogs.com/meteoric_cry/archive/2011/05/10/2042512.html";    
$snoopy->fetchlinks($sourceURL);        
$a = $snoopy->results;    
$re="/\d+\.html$/";   //过滤获取指定的文件地址请求    

foreach($a as $tmp) 
{        
    if(preg_match($re,$tmp))
	{           
     	getImgURL($tmp);        
	}    
}    
    
function getImgURL($siteName) 
{        
    $snoopy=new Snoopy();        
	$snoopy->fetch($siteName);               
	$fileContent=$snoopy->results;   //匹配图片的正则表达式        
	$reTag="/<img[^s]+src=\"(http:\/\/[^\"]+).(jpg|png|gif|jpeg)\"[^\/]*\/>/i";                
	if(preg_match($reTag,$fileContent)) 
	{            
	    $ret=preg_match_all($reTag, $fileContent, $matchResult);                        
		
		for ($i=0,$len=count($matchResult[1]);$i<$len;++$i) 
		{                
		    saveImgURL($matchResult[1][$i],$matchResult[2][$i]);           
		}       
	}    
}        

function saveImgURL($name,$suffix) 
{        
    $url=$name.".".$suffix;                
	echo "请求的图片地址：".$url."<br/>";                
	$imgSavePath="E:/";        
	$imgId=preg_replace("/^.+\/(\d+)$/", "\\1", $name);        
	if ($suffix=="gif") 
	{            
	    $imgSavePath.="emotion";        
	} 
	else 
	{           
     	$imgSavePath.="topic";       
	}        
	$imgSavePath.=("/".$imgId.".".$suffix);               
	if(is_file($imgSavePath)) 
	{            
	    unlink($imgSavePath);            
		echo "<p style='color:#f00;'>文件".$imgSavePath."已存在，将被删除</p>";        
	}                
	$imgFile=file_get_contents($url);        
	$flag=file_put_contents($imgSavePath,$imgFile);                
	
	if($flag) 
	{            
	    echo "<p>文件".$imgSavePath."保存成功</p>";        
	}            
}

?>
-->