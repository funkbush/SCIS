<html>
<body>
<table border="1" width="300">
<tr><td>Process:</td><td><div id="progressbar" style="float:left;width:1px;text-align:center;color:#FFFFFF;background-color:#0066CC"></div><div id="progressText" style=" float:left">0%</div></td></tr>
</table>
<script type="text/JavaScript">
//文件长度
var filesize=0;
function $(obj)   //$()定义，简化写法
{
   return document.getElementById(obj);
}

//设置已经下载的,并计算百分比
function setDownloaded(fsize,filesize) 
{
   if(filesize>0) 
   {
       var percent=Math.round(fsize*100/filesize);
       $("progressbar").style.width=(percent+"%");
   
       if(percent>0) 
       {
            $("progressbar").innerHTML=percent+"%";
            $("progressText").innerHTML="";
       } 
       else 
       {
            $("progressText").innerHTML=percent+"%";
       }
    }
}
</script>



<?php
$k=$_GET["k"];
$a=$_GET["a"];
echo "<script>setDownloaded(".($k+1).",".$a.")</script>";//在前台显示已经下载文件大小
?>
</body>
</html>