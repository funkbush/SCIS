var page=1;  // 初始当前页面为1
//document.getElementById("nowpage").innerHTML=page;
var tmpday,tmpstock;   //上一个日期、股票
var i=0;
function turn(str)   //分页后翻页用的
{   
    var num;
    if(str=="+1")
	{   
	    if(page==document.getElementById("page").innerHTML)   //innerHTML可以提出类似div标签中的内容
		{
		    window.alert("The Last Page!");			
		}
		else
		{
		    page=page+1;
			goPage(page);
		}
	}
	else if(str=="-1")
	{
	    if(page==1)
		{
		    window.alert("The First Page!");
		}
		else
		{
		    page=page-1;
			goPage(page);
		}
	}
	document.getElementById("nowpage").innerHTML=page;
}

function goPage(num)   //AJAX实现分页   要得到当前的页码
{
	var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据  等价于create XMLHttpRequest();
	
	var stock=document.getElementById("stock").value;  //得到当前股票
    var date=document.getElementById("day").value;  //得到当前日期
	//document.getElementById("nowstock").innerHTML=stock;
	
	if(tmpday!=date)  //如果不同日期就更新,相同的日期就不更新
	{
	    page=1;
		document.getElementById('price').src="st-pri.php?stock="+stock+"&date="+date;
	    document.getElementById('quantity').src="st-qua.php?stock="+stock+"&date="+date;
	}
	tmpday=date;
	i=i+1;

	if(tmpstock!=stock && i>=2)  //如果不同股票，则要更新日期下拉列表框---------------------------------
	{
	    document.location.reload();	//刷新页面
	}
	tmpstock=stock;
	
    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();  //IE7及以上新的浏览器新建对象
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//IE6、IE5老浏览器新建对象
    }
	

    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4 && xmlhttp.status==200)  //如果请求已完成，且响应已就绪
	    {
            document.getElementById("jymx").innerHTML=xmlhttp.responseText; 			
	    }
    } 
		
		xmlhttp.open("GET","st-jymx.php?stock="+stock+"&page="+num+"&date="+date,true);   
		//xmlhttp.setRequestHeader("Content-type","application"/x-www-form-urlencoded);  //这一行不能加，加了会出错，原因待考
        xmlhttp.send(); 		
}