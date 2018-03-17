<h2>Пополнить баланс и сделать вклад</h2>


<div class="popolnit_info">
Заходим в свой кошелёк на сайте <a target="_blank" style="color:#009000;text-decoration:underline;font-weight:bold;" href="https://w.qiwi.com">w.qiwi.com</a>
<br>Выбираем раздел "Перевод". Выбираем слева тип перевода "QIWI Яйца"
<br>Нажимаем под яйцом кнопку "Купить".
<br>Выбираем пункт "Купить". Вводим сумму вклада и жмём "Оплатить"
<br>Подтверждаем покупку. Копируем и вставляем "Код ваучера"
<br>
<br>


<?php
if($d_popolnenie!=0){
echo '<big><center><br /><b>Пополнение баланса приостановлено</div></b></center></big>';
}
else{

$b_zam=0;

$depbtq=mysql_query("SELECT SUM(osum2) FROM operations WHERE ologin='$u_login' AND osum>0 AND otype=3 AND odate>'$time'");
$depbtm=mysql_fetch_row($depbtq);
$b_zam=$depbtm[0];


$can_dep='';

if(($d_max-$b_zam)>=$d_min){
$can_dep='от '.$d_min.' до '.($d_max-$b_zam);
}

if($can_dep==''){ echo '<div align="center" style="color:#009000;font-size:20px;font-family:arial;">Достигнут лимит суммы вкладов</div>'; }
else{
echo '
Вы можете сделать вклад на сумму <font style="color:#009000;font-size:20px;font-family:arial;">'.$can_dep.'</font>
';
}
}
?>
</div>

<?php
if($d_popolnenie==0){

$cpop=1;
$cnaq=mysql_query("SELECT * FROM operations WHERE ologin='$u_login' AND osum=0.00 AND osum2=0.00");
$cnam=mysql_num_rows($cnaq);

if($cnam>1){
$cpop=0;
}

if(!empty($_POST['batch']) && ($_POST['plan']==1)){

if($cpop==1){

$batch=preg_replace("#[^0-9a-z]+#i",'',$_POST['batch']);
$plan=$_POST['plan'];

if(strlen($batch)>15 && strlen($batch)<50){

$plusq=mysql_query("SELECT * FROM operations WHERE obatch='$batch'");
if(mysql_num_rows($plusq)==0){

if($plan==1){ $time2=$time+3600*24; $d_proc=150;}
if($plan==2){ $time2=$time+3600*12; $d_proc=125;}
if($plan==3){ $time2=$time+3600*18; $d_proc=150;}


mysql_query("INSERT INTO operations (ologin,otype,osum,osum2,odate,odate2,oplan,oref,obatch,oproc,odays,orefproc) VALUES ('$u_login','3','','','$time2','$time','$plan','$u_ref','$batch','$d_proc','$d_days','$p_ref')") or die('inserting batch data error');
}
}

}

}

if($cpop==0){
echo '<div class="popolnit_nomore">Лимит пополнений, находящихся в обработке.</div>';
}

if($can_dep!='' && $cpop==1){
?>
<center>
<table align="center" cellpadding="0px" cellspacing="0px">
<tr>
<td>
<form id="popolnit" action="/?page=popolnit" method="POST" style="margin:0;padding:0">
<input id="batch" class="popolnit_input" type="text" name="batch" placeholder="Код ваучера" maxlength="50">
<input id="plan" type="hidden" name="plan" value="1">
</form>
</td>
<td>
<a class="popolnit_1" href="javascript:document.getElementById('plan').value=1;with(document.getElementById('popolnit')){ submit(); }">На 24 часа</a>
</td>
</tr>
</table>
</center>
<br>
<center>
<table align="center" cellpadding="0px" cellspacing="0px">
<tr>
<td>



<!--
<a class="popolnit_1" href="javascript:document.getElementById('plan').value=2;with(document.getElementById('popolnit')){ submit(); }">На 12 часов</a>
<a class="popolnit_1" href="javascript:document.getElementById('plan').value=3;with(document.getElementById('popolnit')){ submit(); }">На 18 часов</a>
-->

</td>
</tr>
</table>
</center>
<?php }} ?>

<br>
<br>
<center>
<table align="center" class="popolnit_stat" cellpadding="0px" cellspacing="0px">
<tr>
<td style="width:110px;">Сумма</td>
<td style="width:145px;">Дата</td>
<td style="width:240px;">Ваучер</td>
<td style="width:135px;">Статус</td>
</tr>
</table>
</center>
<center>
<table align="center" style="margin-top:2px;" cellpadding="2px" cellspacing="2px">
<?php
$statsq=mysql_query("SELECT osum2,odate2,oplan,obatch,oback,osum,odays FROM operations WHERE otype=3 AND ologin='$u_login' AND obatch!='' ORDER BY odate2 DESC");
while($statsm=mysql_fetch_row($statsq)){ ?>
<tr>
<td class="popolnit_stat_sum">
<?php
if($statsm[0]>0){ echo str_replace('.00','',number_format($statsm[0],2,'.',',')).' РУБ'; }
else { echo '-//-'; }
?>
</td>
<td class="popolnit_stat_date"><?php echo date('j '.$mdate[date('n',$statsm[1])-1].' H:i',$statsm[1]); ?></td>
<td class="popolnit_stat_batch">
<?php
if($statsm[5]=='0' && $statsm[4]==2){
echo '<font color="red">'.$statsm[3].'</font>';
}
else{
echo $statsm[3];
}
?>
</td>
<?php
if($statsm[5]=='0' && $statsm[4]==''){ echo '<td class="popolnit_stat_batch_1">В обработке</td>'; }
if($statsm[5]=='0' && $statsm[4]==1){ echo '<td class="popolnit_stat_batch_1">К возврату</td>'; }
if($statsm[5]=='0' && $statsm[4]==2){ echo '<td class="popolnit_stat_batch_2">Возвращено</td>'; }
if($statsm[5]>0){ echo '<td class="popolnit_stat_batch_2">Принято</td>'; }
?>
</td>
</tr>
<?php } ?>
</table></center>
</div>

