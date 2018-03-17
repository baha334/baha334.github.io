<?php
//error_reporting(0);

include('conf.php');

$site=$_SERVER['HTTP_HOST'];

@mysql_query('set character_set_client="cp1251"');
@mysql_query('set character_set_results="cp1251"');
@mysql_query('set collation_connection="cp1251_general_ci"');


ini_set('session.use_cookies', 'On');
ini_set('session.use_trans_sid', 'Off');
session_set_cookie_params(0, '/');

session_start();

$time=time()+$time_move*3600;
$start_time=strtotime($start_data);
$work_time=floor(($time-$start_time)/(24*3600));


if($start_time-$time<=0){
if($d_isum!=0){
$d_max=$d_max+$d_isum*floor(($time-$start_time)/($d_itime*3600));
if($d_max>$d_istop){ $d_max=$d_istop; }
}
}


// ======================================== IP ====================================================================================

if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'),'unknown'))
$ip=getenv('HTTP_CLIENT_IP');
elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
$ip=getenv('HTTP_X_FORWARDED_FOR');
elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv("REMOTE_ADDR"), 'unknown'))
$ip=getenv('REMOTE_ADDR');
elseif(!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
$ip=$_SERVER['REMOTE_ADDR'];
else{$ip='unknown';}


// ======================================== ПЕРЕХОД РЕФЕРАЛА ====================================================================================

if(!empty($_GET['ref'])){
session_unset();
$_GET['ref']=preg_replace("#[^a-z\_\-0-9]+#i",'',$_GET['ref']);
if($_GET['ref']!=''){
$refq=mysql_query("SELECT login FROM users WHERE login='".$_GET['ref']."'");
if(mysql_num_rows($refq)>0){
$refm=mysql_fetch_row($refq);
$_SESSION['ref_login']=$refm[0];
}
}
}

// ======================================== АВТОРИЗАЦИЯ ====================================================================================

define('SID',session_id());

// ФУНКЦИЯ ВХОДА

function login($uname,$qiwi){
$q=mysql_query("SELECT uid,login,qiwi,ref FROM users WHERE login='$uname' AND qiwi='$qiwi';");
$user=mysql_fetch_row($q);

if(!empty($user)) {
session_unset();
$_SESSION['uid']=$user[0];
$_SESSION['login']=$user[1];
$_SESSION['qiwi']=$user[2];
$_SESSION['ref']=$user[3];
$_SESSION['can']=1;
return true;
}
else{
return false;
}
}

//  ЕСЛИ АВТОРИЗОВАН, БЕРЁМ АНКЕТУ ИЗ СЕССИИ

if(!empty($_SESSION['uid']) && !empty($_SESSION['login']) && !empty($_SESSION['qiwi']) && isset($_SESSION['ref'])) {
define('USER_LOGGED',true);
$u_id=$_SESSION['uid'];
$u_login=$_SESSION['login'];
$u_qiwi=$_SESSION['qiwi'];
$u_ref=$_SESSION['ref'];
}
else { define('USER_LOGGED',false); }


// ПРИЁМ ДАННЫХ ИЗ ФОРМЫ

if (!empty($_POST['login']) && !empty($_POST['qiwi'])) {
$_POST['login']=preg_replace("#[^a-z\_\-0-9]+#i",'',$_POST['login']);
$_POST['qiwi']=preg_replace('#[^a-zA-Z\-\_0-9]+#','',$_POST['qiwi']);
$_POST['qiwi']=md5($_POST['qiwi']);
if(login($_POST['login'],$_POST['qiwi'])){ header('Refresh: 0'); exit; }
else{ $wrong_lq=1; }
}


// ========================================  ОНЛАЙН ЮЗЕРЫ  ==============================================================================

function count_online($ip,$time){
if($ip!='unknown'){
$ip=preg_replace("#[^0-9]+#i",'',$ip);
$last_time=$time+20*60;
$result=mysql_query("SELECT last_time FROM online WHERE ip='$ip'");
if(mysql_num_rows($result)>0){ mysql_query("UPDATE online SET last_time=$last_time WHERE ip='$ip' LIMIT 1"); }
else{ mysql_query("INSERT INTO online (ip,last_time) VALUES ('$ip',$last_time)"); }
mysql_query('DELETE FROM online WHERE last_time<'.$time);
}
return mysql_num_rows(mysql_query('SELECT * FROM online'));
}


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

if($start_time-$time>0){
$d_vklad=1;
$d_popolnenie=1;
$d_vyvod=1;
}

$uu=substr($d_users,-2);
$ux1=array(2,3,4,22,23,24,32,33,34,42,43,44,52,53,54,62,63,64,72,73,74,82,83,84,92,93,94);
$ux2=array(1,21,31,41,51,61,71,81,91);
$ut='Участников';
if(in_array($uu,$ux1)){ $ut='Участника'; }
elseif(in_array($uu,$ux2)){ $ut='Участник'; }



?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<title>Qiwi Deposit | Лучший онлайн инвестиционный сервис</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/cabinet.css">
<link rel="stylesheet" href="css/print.css" media="print">
<script src="js/jquery-1.6.4.min.js"></script>
<script src="js/custom.js"></script>
<!--[if lt IE 9]>
<script src="js/css3-mediaqueries.min.js"></script>
<script src="js/html5.js"></script>
<script src="js/IE9.js"></script>
<![endif]-->
</head>
<body>
<header class="clearFix">

</header>
<hr>
<center>
<img src="../css/img/azure/intro-middle.png" alt="По всем вопросам писать на s@999.bz"> 
</center>
<center>
<p>
<a href="/"><img src="images/1.png" alt="Главная"></a>
<a href="?page=faq"><img src="images/2.png" alt="F.A.Q"></a>
<a href="?page=registration"><img src="images/3.png" alt="Регистрация"></a>

</center>
      <h1><strong></strong></h1>
      <p></p>

  </div>
</div>
<br>

<center>
<p><font color="black"><b>749</font> Участников</b></font> | <b>На сайте:  <font color="black">27</font></b> | <b>Баланс: <font color="black">112,292.30</font></b>  руб.| <b> Пополнили: <font color="blue">241,325.00</font> руб</b> | Вывели: <font color="red">104,900.20</font> руб.</b></p>
</center>
<center>
<details open>
<summary><img src="images/4.png" alt="Вход"></a></summary>
<div id="twitter">
  <div class="wrap clearFix"> 
<?php if(!USER_LOGGED){ ?>
<form id="enter" action="/" method="POST" >
<input class="text" type="text" name="login" placeholder="Логин" maxlength="20">
<input class="text" type="text" name="qiwi" placeholder="Пароль" maxlength="30">
<a class="button" href="javascript:with(document.getElementById('enter')){ submit(); }">Войти</a>
<?php if(!empty($wrong_lq)){ echo '<br />Неверный логин-кошелёк'; } ?>
</form>
 </fieldset>
</details>
</p>
</center>
<?php } else { ?>

<center>
<a class="button" href="/?page=vklady">Мои вклады</a>
<a class="button" href="/?page=popolnit">Пополнить баланс</a>
<a class="button" href="/?page=vyvesti">Вывести деньги</a>
<a class="button" href="/?page=refs">Мои рефералы</a>
<a class="button" href="/logout.php">Выход</a> </center>

<?php } ?>


  </div>
</div>

<div id="content">
  <div class="wrap clearFix">
   
<?php
$nay=0;
if(!empty($_GET['page'])){
$req=$_GET['page'];
$req=str_replace('/?page=','',$req);
if(in_array($req,$inc)){ $nay=1; include ('pages/'.$req.'.php'); }
if(USER_LOGGED && in_array($req,$inc_cab)){ $nay=1; include ('cabinet/'.$req.'.php'); }
if(!USER_LOGGED && $req=='registration'){ $nay=1; include ('pages/registration.php'); }
}


if($nay!=1){ include ('pages/main.php'); }
?>

  </div>
</div>

<footer class="clearFix">
  <div class="wrap clearFix">
    <p class="floatRight"> Copyright &copy; 2013 <a href="/">999.bz</a> / <a href="http://999.bz/">999.bz</a><br> All Rights Reserved &ndash; <a href="http://vk.com/trastred">МЫ Вконтакте</a></p>
    <p class="socialIcons"></p>
  </div>
</footer>
</body>
</html>
