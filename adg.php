<?php
session_start();

error_reporting(0);

if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown'))
$ip=getenv('HTTP_CLIENT_IP');
elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
$ip=getenv('HTTP_X_FORWARDED_FOR');
elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv("REMOTE_ADDR"), 'unknown'))
$ip=getenv('REMOTE_ADDR');
elseif(!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
$ip=$_SERVER['REMOTE_ADDR'];
else{$ip='unknown';}



if($_SESSION['login']!='admin'){
die('Войдите под своим логином на сайте');
}


$mdate=array('Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря');

include('conf.php');

@mysql_query('set character_set_client="cp1251"');
@mysql_query('set character_set_results="cp1251"');
@mysql_query('set collation_connection="cp1251_general_ci"');

$time=time()+$time_move*3600;


$dataq=mysql_query("SELECT * FROM data");
$d=mysql_fetch_row($dataq);


$d_users=$d[0];
$d_vklad=$d[1];
$d_popolnenie=$d[2];
$d_vyvod=$d[3];
$d_premod_r=$d[4];
$d_count_r=$d[5];
$d_plus=$d[6];
$d_with=$d[7];
$d_plus_n=$d[8];
$d_with_n=$d[9];
$d_new_u=$d[10];

$free=$d_plus-$d_with-($d_plus*($tocom/100));

if(isset($_GET['vklad']) && ($_GET['vklad']==0 || $_GET['vklad']==1)){ mysql_query("UPDATE data SET vklad='".$_GET['vklad']."'"); $d_vklad=$_GET['vklad']; }
if(isset($_GET['popolnenie']) && ($_GET['popolnenie']==0 || $_GET['popolnenie']==1)){ mysql_query("UPDATE data SET popolnenie='".$_GET['popolnenie']."'"); $d_popolnenie=$_GET['popolnenie']; }
if(isset($_GET['vyvod']) && ($_GET['vyvod']==0 || $_GET['vyvod']==1)){ mysql_query("UPDATE data SET vyvod='".$_GET['vyvod']."'"); $d_vyvod=$_GET['vyvod']; }

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<link rel="stylesheet" href="css/admin.css" type="text/css" />
<script type="text/javascript" src="js.js"></script>
</head>
<body>


<table align="center" cellpadding="0px" cellspacing="0px" width="670px">
<tr>
<td class="admin_stat">
ПОПОЛНИЛИ: <font color="#EC7600"><?php echo number_format($d_plus,2,'.',','); ?></font> РУБ <br />
ВЫВЕЛИ: <font color="#EC7600"><?php echo number_format($d_with,2,'.',','); ?></font> РУБ <br />
БАЛАНС <font color="#EC7600"><?php echo number_format($free,2,'.',','); ?></font> РУБ
</td>
</tr>
<?php
$popq=mysql_query("SELECT oid,ologin,obatch,oplan FROM operations WHERE otype=3 AND obatch!='' AND osum2=0 ORDER BY odate2 ASC");
$popc=mysql_num_rows($popq);

$tovq=mysql_query("SELECT osum FROM operations WHERE oback=1");
$tovm=mysql_num_rows($tovq);

$tovaq=mysql_query("SELECT osum FROM operations WHERE otype=2 AND odate2=''");
$tovam=mysql_num_rows($tovaq);
?>

<tr>
<td class="admin_menu">
<a href="/">Главная</a>
<a href="/adg.php?page=popolnenie">Пополнение (<?php echo $popc; ?>)</a>
<a href="/adg.php?page=vyvod">Вывод (<?php echo ($tovm+$tovam); ?>)</a>
<a href="/adg.php?page=vyvod_otmena">Отмена</a>
<?php
if($d_vklad==0){ echo '<a href="/adg.php?vklad=1" style="color:#009000;">Вклад</a>'; }
else{ echo '<a href="/adg.php?vklad=0" style="color:#f00000;">Вклад</a>'; }
if($d_popolnenie==0){ echo '<a href="/adg.php?popolnenie=1" style="color:#009000;">Пополнение</a>'; }
else{ echo '<a href="/adg.php?popolnenie=0" style="color:#f00000;">Пополнение</a>'; }
if($d_vyvod==0){ echo '<a href="/adg.php?vyvod=1" style="color:#009000;border:none;padding:0px;margin:0px;">Вывод</a>'; }
else{ echo '<a href="/adg.php?vyvod=0" style="color:#f00000;border:none;padding:0px;margin:0px;">Вывод</a>'; }
?>
<tr>
<td style="background:#ffffff">
<br>

<?php
if(!empty($_GET['page'])){
$req=$_GET['page'];
$req=str_replace('/?page=','',$req);
$inc=array('vyvod','vyvod_otmena','popolnenie','popolnenie_avto');
if(in_array($req,$inc)){ $nay=1; include ('adg/'.$req.'.php'); }
}
?>

<br>
<br>
</table>
<center>
Copyright © 2013 Qiwi Deposit
</center>
