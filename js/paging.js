var arr=document.getElementsByTagName('button');   //可以
var page=1;  // 初始当前页面为1

function goPage(num)   //AJAX实现分页   要得到当前的页码
{
	/*	if(!xmlhttp)    //若没有XHR对象则建一个
		{  
		    xmlhttp=createXHR();
		}*/
		
	var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据  等价于create XMLHttpRequest();

    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();  //IE7及以上新的浏览器新建对象
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//IE6、IE5老浏览器新建对象
    }
	arr[page-1].innerHTML=page;    //实现当前页面按钮页码为黑体大字
	arr[num].innerHTML="<b>"+(num+1)+"</b>";
	//arr[num].style.fontWeight="normal";
	//arr[num].style.color="red";
	page=num+1;   //获得当前页码
    var url1="search_result.php?page="+page;
	var url2="admin_alterresult.php?page="+page;
    //赋值当前分页代码	

    xmlhttp.onreadystatechange=function()
    {
        if(xmlhttp.readyState==4 && xmlhttp.status==200)  //如果请求已完成，且响应已就绪
	    {
            document.getElementById("filecontents").innerHTML=xmlhttp.responseText;          		
	    }
    } 
		
		xmlhttp.open("GET",url2,true);   
		//xmlhttp.setRequestHeader("Content-type","application"/x-www-form-urlencoded);  //这一行不能加，加了会出错，原因待考
        xmlhttp.send(); 
        document.getElementById("nowpage").value=page;		
}

function turn(str)
{   
    var num;
    if(str=="+1")
	{   
	    if(page==13)   //arr.length 得到数组的长度
		{
		    window.alert("The Last Page!");			
		}
		else
		{
		    page=page+1;
			num=page-1;
			goPage(num);
			arr[num-1].innerHTML=num; 
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
            num=page-1;			
			goPage(num);
			arr[num+1].innerHTML=num+2; 
		}
	}
	document.getElementById("nowpage").value=page;
}

function createXHR()
{
    var xmlhttp;  //新建一个XHR变量，用于和服务器交换数据

    if(window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();  //IE7及以上新的浏览器新建对象
    }
    else
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//IE6、IE5老浏览器新建对象
    }
 }