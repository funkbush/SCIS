<?php
// Ϊphp��mysql�޳�����ȫhtml���롣
function safestrip($string){
   $string = strip_tags($string);
   $string = mysql_real_escape_string($string);
   return $string;
}
 
//��¼��Ϣ��ʾ����
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
 
// �û���¼����
function login($username, $password){
 
//�����û�������û���������
$user = safestrip($username);
$pass = safestrip($password);
 
//������ת��Ϊmd5��ʽ
$pass = md5($pass);
 
 // ��ѯ���ݿ����û����������Ƿ�ƥ��
 $sql =
 mysql_query("SELECT * FROM user_table WHERE username = '$user'
 AND password = '$pass'")or die(mysql_error());
 
 //�����1���ʾ��֤�ɹ�
 if (mysql_num_rows($sql) == 1) {
 
             //��ʼ��¼��session��
             $_SESSION['authorized'] = true;
 
             // ���¼���ҳ��
            $_SESSION['success'] = '��¼�ɹ�';
            header('Location: ./index.php');
            exit;
 
 } else {
       // ��¼ʧ�ܼ�¼��session��
       $_SESSION['error'] = '�ǳ���Ǹ����������û�������������';
 }
}
?>