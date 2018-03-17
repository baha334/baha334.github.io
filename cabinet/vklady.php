<h2>Мои вклады</h2>

<?php
$b_plus=0;
$b_with=0;
$b_ref=0;
$b_zam=0;
$b_raz=0;
$b_act=0;
$b_tot=0;
$b_otn=0;

$b_acts=200;
//echo strtotime('05.01.2013 15:00').'<br>';
//echo strtotime('15.01.2013 15:00').'<br>';


$depbtq=mysql_query("SELECT ologin,otype,osum,osum2,orefsum,odate,obatch,odate2,oprofit,odays FROM operations WHERE (ologin='$u_login' AND osum>0 AND oback='') OR (oref='$u_login' AND osum>0  AND oback='')");
while($depbtm=mysql_fetch_row($depbtq)){

if($depbtm[0]!=$u_login && $depbtm[1]==3 && $depbtm[6]!=''){ $b_ref+=$depbtm[4]; }

if($depbtm[0]==$u_login && $depbtm[1]==2){ $b_with+=$depbtm[2]; }

if($depbtm[0]==$u_login && $depbtm[1]==3 && $depbtm[6]!=''){ $b_plus+=$depbtm[3]; }

if($depbtm[0]==$u_login && $depbtm[1]==3 && $depbtm[5]>$time){
$b_zam+=$depbtm[3];
$b_act++;
$b_col=floor(($time-$depbtm[7])/(24*3600));
$b_raz+=$b_col*$depbtm[8];
}

if($depbtm[0]==$u_login && $depbtm[1]==3 && $depbtm[5]<=$time){
$b_raz+=$depbtm[2];
$b_otn+=$depbtm[3];
}

}

$b_tot=$b_ref+$b_plus-$b_otn-$b_with-$b_zam+$b_raz;


if($d_vklad==0){

// ====================================== ОПЕРАЦИЯ ВКЛАДЫВАНИЯ ==========================================

if($b_tot<0) { echo "Ошибка! Баланс $b_tot РУБ. Сообщите поддержке сайта."; exit; }

if(isset($_POST['depo']) && ($_POST['plan']==1)){

$depo=$_POST['depo'];
$depo=preg_replace("#[^0-9\.]+#",'',$depo);
$depo=preg_replace("#\.+#",'.',$depo);
$oplan=$_POST['plan'];

if(empty($depo)){ $depo=0; }

$depo=number_format($depo,2,'.','');

if(!is_numeric($depo)){ $d_e='Введите корректную сумму'; }
if($b_act>$b_acts-1){ $d_e='Разрешено не более '.$b_acts.' замороженных вкладов'; }
if(empty($d_e) && $depo<$d_min){ $d_e='Минимальная сумма вклада '.$d_min.' РУБ'; }
if(empty($d_e) && $depo>$b_tot){ $d_e='На Вашем балансе недостаточно средств для вклада'; }
if(empty($d_e) && ($b_zam+$depo)>$d_max){ $d_e='Сумма замороженных вкладов не должна превышать '.$d_max.' РУБ<br>Вы можете вложить максимум '.($d_max-$b_zam).' РУБ'; }

if(empty($d_e)){

if($oplan==1){ $sum=number_format($depo*(150/100),2,'.',''); $odate=$time+3600*24; $profit=$depo*(150/100); $d_proc=150; }

if($oplan==2){ $sum=number_format($depo*(125/100),2,'.',''); $odate=$time+3600*12; $profit=$depo*(125/100); $d_proc=125;  }
if($oplan==3){ $sum=number_format($depo*(150/100),2,'.',''); $odate=$time+3600*18; $profit=$depo*(150/100); $d_proc=150;  }




mysql_query("INSERT INTO operations (ologin,otype,osum,osum2,odate,odate2,oplan,oproc,odays,oprofit) VALUES ('$u_login','3','$sum','$depo','$odate','$time','$oplan','$d_proc','$d_days','$profit')") or die('inserting batch data error');

$b_tot-=$depo;

}

}

}
?>


<div class="vklady_balance">БАЛАНС: <font color="#FF860D"><?php echo number_format($b_tot,2,'.',','); ?></font> РУБ</div>
<div class="vklady_stat">
ПОПОЛНЕНО: <font color="#FF860D"><?php echo str_replace('.00','',number_format($b_plus,2,'.',',')); ?> РУБ</font>
ЗАРАБОТАНО: <font color="#FF860D"><?php echo str_replace('.00','',number_format($b_raz,2,'.',',')); ?> РУБ</font>
РЕФЕРАЛЬНЫЕ: <font color="#FF860D"><?php echo str_replace('.00','',number_format($b_ref,2,'.',',')); ?> РУБ</font>
ВЫВЕДЕНО: <font color="#FF860D"><?php echo str_replace('.00','',number_format($b_with,2,'.',',')); ?> РУБ</font>
</div>

<?php if(!empty($d_e)){ echo '<div class="vklady_error">'.$d_e.'</div>';} ?>


<?php if($d_vklad!=0){ ?>
<big><center><br /><b>Создание вкладов приостановлено</b></center></big>
<?php } ?>


<?php if($d_vklad==0){

$can_dep='Достигнут лимит суммы вкладов';
if(($d_max-$b_zam)>=$d_min){
$can_dep='Вы можете вложить от '.$d_min.' до '.($d_max-$b_zam);
}
?>

<div style="padding-bottom:30px;text-align:center;font-family:arial;font-size:16px;font-weight:bold;color:#3EAA30;">
Заморожено <?php echo $b_zam; ?> РУБ <?php echo $can_dep; ?>
</div>

<center>
<table align="center" cellpadding="0px" cellspacing="0px">
<tr>
<td>
<form id="vklad_form" action="/?page=vklady" method="POST" style="margin:0;padding:0">
<input id="vklad_sum" onkeyup="vklad();" onmouseout="vklad();" class="vklady_input" type="text" name="depo" placeholder="Вложить" maxlength="10">
<input id="plan" type="hidden" name="plan" value="1">
</form>
</td>
<td>

<a class="vklady_1" href="javascript:document.getElementById('plan').value=1;with(document.getElementById('vklad_form')){ submit(); }">На 24 часа</a>

<!--
<a class="vklady_1" href="javascript:document.getElementById('plan').value=2;with(document.getElementById('vklad_form')){ submit(); }">На 12 часов</a>
<a class="vklady_1" href="javascript:document.getElementById('plan').value=3;with(document.getElementById('vklad_form')){ submit(); }">На 18 часов</a>
-->

</td>

</tr>
</table>
</center>
<?php } ?>

<center>
<br /><br />
<table class="vklady_table" cellpadding="0px" cellspacing="0px">
<tr>
<td width="220px"style="padding-left:10px;">Дата вклада, окончания</td>
<td width="170px">Вклад, %, Прибыль</td>
<td width="130px">Заработано</td>
<td width="135px">Статус</td>
</tr>
</table>
</center>
<center>
<table style="margin-top:4px;" cellpadding="0px" cellspacing="0px">

<?php
$que=1;
$depn=1;
$depz_t=array();
$depzq=mysql_query("SELECT odate2,oplan,osum2,osum,odate,odate2,oproc,oprofit,odays,oplan FROM operations WHERE otype=3 AND odate>$time AND ologin='$u_login' AND osum>0 ORDER BY odate2 DESC");
$deptot=mysql_num_rows($depzq);
while($depzm=mysql_fetch_row($depzq)){

if($depzm[9]==1){ $depz_t[]=$depzm[5]+(floor(($time-$depzm[5])/(24*3600)))*24*3600+24*3600; }

if($depzm[9]==2){ $depz_t[]=$depzm[5]+(floor(($time-$depzm[5])/(12*3600)))*12*3600+12*3600; }
if($depzm[9]==3){ $depz_t[]=$depzm[5]+(floor(($time-$depzm[5])/(12*3600)))*18*3600+18*3600; }


echo '
<tr>
<td class="vklady_date_1">'.date('j '.$mdate[date('n',$depzm[0])-1].' H:i',$depzm[0]).' - '.date('j '.$mdate[date('n',$depzm[4])-1].' H:i',$depzm[4]).'</td>
<td class="vklady_sum_1">'.str_replace('.00','',number_format($depzm[2],2,'.',',')).' Р '.$depzm[6].'% '.str_replace('.00','',number_format($depzm[7],2,'.',',')).' Р</td>
<td class="vklady_sum_2">'.str_replace('.00','',number_format(floor(($time-$depzm[5])/(24*3600))*$depzm[7],2,'.',',')).'/'.str_replace('.00','',number_format($depzm[3],2,'.',',')).' РУБ</td>
<td class="vklady_status_zam"><font id="zam_'.$depn.'"></font> <font color="#339AD5">'.(floor(($time-$depzm[5])/(24*3600))).'/'.$depzm[8].'</font></td>
</tr>';

$depn++;
}




echo '<script type="text/javascript">';
$n=0;
foreach($depz_t as $dz_time){
$n++;
echo 'var a'.$n.'='.($dz_time-$time+1).';
function c'.$n.'(){
if(a'.$n.'>=1){
var h'.$n.'=(parseInt(a'.$n.'/3600));
if(h'.$n.'<10){h'.$n.'="0"+h'.$n.'};
var sl'.$n.'=a'.$n.'-h'.$n.'*3600;
var m'.$n.'=(parseInt(sl'.$n.'/60));
if(m'.$n.'<10){m'.$n.'="0"+m'.$n.'};
var ls'.$n.'=sl'.$n.'-m'.$n.'*60;
if(ls'.$n.'<10){ls'.$n.'="0"+ls'.$n.';}
document.getElementById("zam_'.$n.'").innerHTML=h'.$n.'+":"+m'.$n.'+":"+ls'.$n.';
a'.$n.'--;
setTimeout("c'.$n.'()",1010);
}
else{
location.href=location.href;
}
}
c'.$n.'();';
}
echo '</script>';


?>

<?php
$que=1;
$depn=1;
$deprq=mysql_query("SELECT odate2,oplan,osum2,osum,odate FROM operations WHERE otype=3 AND odate<=$time AND osum>0 AND ologin='$u_login' ORDER BY odate DESC");
$deptot=mysql_num_rows($deprq);
while($deprm=mysql_fetch_row($deprq)){

echo '
<tr>
<td class="vklady_date_1">'.date('j '.$mdate[date('n',$deprm[0])-1].' H:i',$deprm[0]).' - '.date('j '.$mdate[date('n',$deprm[4])-1].' H:i',$deprm[4]).'</td>
<td class="vklady_sum_1">'.str_replace('.00','',number_format($deprm[2],2,'.',',')).' РУБ</td>
<td class="vklady_sum_2">'.str_replace('.00','',number_format($deprm[3],2,'.',',')).' РУБ</td>
<td class="vklady_status_raz">Отработано</td>
</tr>';

$depn++;
}

?>

</table>
</center>

</div>
