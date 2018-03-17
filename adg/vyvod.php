<?php
if(!empty($_POST['oid']) && !empty($_POST['obatch'])){
$oid=preg_replace("#[^0-9]+#i",'',$_POST['oid']);
$obatch=preg_replace("#[^0-9a-z]+#i",'',$_POST['obatch']);
if($oid>0 && strlen($obatch)>15){

$ssq=mysql_query("SELECT oback FROM operations WHERE oid='$oid'");
$ssm=mysql_fetch_row($ssq);
if($ssm[0]=='1'){
mysql_query("UPDATE operations SET oback=2,obatch='$obatch' WHERE oid='$oid'") or die(mysql_error());
}
else{
mysql_query("UPDATE operations SET odate2='$time',obatch='$obatch' WHERE oid=$oid") or die(mysql_error());
$avq=mysql_query("SELECT SUM(osum) FROM operations WHERE otype=2 AND odate2!=''");
$avm=mysql_fetch_row($avq);
$aviq=mysql_query("SELECT ologin,osum FROM operations WHERE otype=2 AND odate2!='' ORDER BY odate2 DESC LIMIT 30");
$avin='';
while($avim=mysql_fetch_row($aviq)){
$avin.='<img src="images/nu.png">&nbsp;'.$avim[0].'&nbsp;<font color="#FF8D1C">'.$avim[1].'</font>&nbsp;<font color="#3EAA30">РУБ</font>, ';
}
mysql_query("UPDATE data SET `with`='$avm[0]', with_n='$avin'") or die(mysql_error());
}
}
}
?>



<!-- ВОЗВРАТ СРЕДСТВ -->




<?php
$tovq=mysql_query("SELECT SUM(osum2) FROM operations WHERE oback=1");
$tovm=mysql_fetch_row($tovq);
if($tovm[0]>0){
?>

<div class="admin_vyvod_title">ВОЗВРАТ СРЕДСТВ <font color="#EC7600"><?php echo $tovm[0]; ?></font> РУБ</div>

<br>

<table align="center" class="admin_vyvod_stat" cellpadding="0px" cellspacing="0px">
<tr>
<td style="width:140px;">Дата</td>
<td style="width:110px;">Логин</td>
<td style="width:190px;">Ваучер</td>
<td style="width:100px;">Сумма</td>
<td style="width:120px;">Действие</td>
</tr>
</table>

<form id="vyvod" action="/adg.php?page=vyvod" method="POST" style="margin:0;padding:0">
<input id="oid" type="hidden" name="oid">
<input id="obatch" type="hidden" name="obatch">
</form>

<table align="center" style="margin-top:6px;" cellpadding="0px" cellspacing="0px">
<?php
$statsq=mysql_query("SELECT odate,ologin,osum2,oid FROM operations WHERE oback=1 ORDER BY odate ASC");
while($statsm=mysql_fetch_row($statsq)){ ?>
<tr>
<td class="admin_vyvod_date"><?php echo date('j '.$mdate[date('n',$statsm[0])-1].' H:i',$statsm[0]); ?></td>
<td class="admin_vyvod_login"><?php echo $statsm[5]; ?><?php echo $statsm[1]; ?></td>
<td class="admin_vyvod_batch"><input id="ic<?php echo $statsm[3]; ?>" type="text" maxlenght="50"></td>
<td class="admin_vyvod_sum"><?php echo str_replace('.00','',number_format($statsm[2],0,'','')); ?></td>
<td class="admin_vyvod_action"><a href="javascript:admin_vyvod('<?php echo $statsm[3]; ?>')">Выполнено</a></td>
</tr>
<?php } ?>
</table>
<br>
<?php } ?>


<!-- ВЫВОД СРЕДСТВ -->


<?php
$tovq=mysql_query("SELECT SUM(osum) FROM operations WHERE otype=2 AND odate2=''");
$tovm=mysql_fetch_row($tovq);
?>

<div class="admin_vyvod_title">ВЫВОД СРЕДСТВ <font color="#EC7600"><?php echo $tovm[0]; ?></font> РУБ</div>

<br>

<table align="center" class="admin_vyvod_stat" cellpadding="0px" cellspacing="0px">
<tr>
<td style="width:140px;">Дата</td>
<td style="width:110px;">Логин</td>
<td style="width:190px;">Ваучер</td>
<td style="width:100px;">Сумма</td>
<td style="width:120px;">Действие</td>
</tr>
</table>
<form id="vyvod" action="/adg.php?page=vyvod" method="POST" style="margin:0;padding:0">
<input id="oid" type="hidden" name="oid">
<input id="obatch" type="hidden" name="obatch">
</form>
<table align="center" style="margin-top:6px;"cellpadding="0px" cellspacing="0px">
<?php
$statsq=mysql_query("SELECT odate,ologin,osum,oid FROM operations WHERE otype=2 AND odate2='' ORDER BY odate ASC");
while($statsm=mysql_fetch_row($statsq)){ ?>
<tr>
<td class="admin_vyvod_date"><?php echo date('j '.$mdate[date('n',$statsm[0])-1].' H:i',$statsm[0]); ?></td>
<td class="admin_vyvod_login"><?php echo $statsm[5]; ?><?php echo $statsm[1]; ?></td>
<td class="admin_vyvod_batch">
<form id="vyvod" action="/adg.php?page=vyvod" method="POST" style="margin:0;padding:0">
<input id="oid" type="hidden" name="oid">
<input id="obatch" type="hidden" name="obatch">
<input id="ic<?php echo $statsm[3]; ?>" type="text" maxlenght="50">
</form>
</td>
<td class="admin_vyvod_sum"><?php echo str_replace('.00','',number_format($statsm[2],0,'','')); ?></td>
<td class="admin_vyvod_action"><a href="javascript:admin_vyvod('<?php echo $statsm[3]; ?>')">Выполнено</a></td>
</tr>
<?php } ?>
</table>
