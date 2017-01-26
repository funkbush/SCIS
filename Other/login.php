<?php
// 为php和mysql剔除不安全html代码。
function safestrip($string){
   $string = strip_tags($string);
   $string = mysql_real_escape_string($string);
   return $string;
}
 
//登录信息显示函数
function messages() {
 $message = '';
 if($_SESSION['success'] != '') {
   $message = '<span id="message">'
   .$_SESSION['success'].'</span>';
   $_SESSION['success'] = '';
 }
 if($_SESSION['error'] != '') {
   $message = '<span id="message">'
   .$_SESSION['error'].'</span>';
   $_SESSION['error'] = '';
 }
 return $message;
}
 
// 用户登录函数
function login($username, $password){
 
//过滤用户输入的用户名和密码
$user = safestrip($username);
$pass = safestrip($password);
 
//将密码转换为md5格式
$pass = md5($pass);
 
 // 查询数据库中用户名和密码是否匹配
 $sql =
 mysql_query("SELECT * FROM user_table WHERE username = '$user'
 AND password = '$pass'")or die(mysql_error());
 
 //如果＝1则表示认证成功
 if (mysql_num_rows($sql) == 1) {
 
             //开始记录在session中
             $_SESSION['authorized'] = true;
 
             // 重新加载页面
            $_SESSION['success'] = '登录成功';
            header('Location: ./index.php');
            exit;
 
 } else {
       // 登录失败记录在session中
       $_SESSION['error'] = '非常抱歉，您输入的用户名或密码有误';
 }
}
?>