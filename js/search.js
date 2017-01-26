function se()
{
	var arr=document.getElementsByTagName('input');
	arr[1].onclick=function()
	{ 
	   var str=document.getElementById("searchtext").value;   //传输文本中有特殊字符比如括号就无法正常
	   document.getElementById("searchresult").src="paging.php?st="+str;
	} 
}
	
