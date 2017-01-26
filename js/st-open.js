function op()
{
    var arr=document.getElementsByTagName('input');
	arr[0].onclick=function(){window.open("st-show.php");}
	arr[1].onclick=function(){window.open("st-import.php");}
	arr[2].onclick=function(){window.open("st-search.php");}
	arr[3].onclick=function(){window.open("vcode.php");}
}