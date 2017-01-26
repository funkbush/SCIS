<?php
   @mysql_connect("localhost","root","")or die("数据库连接失败！");
   @mysql_select_db("stocks")or die("选择的数据库不存在或不可用!");

   //mysql_query("set names gb2312");
   mysql_query("set names utf-8");
?>