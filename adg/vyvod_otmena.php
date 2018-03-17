<?php
if(!empty($_POST['oid_otmena'])){
$oid_otmena=preg_replace("#[^0-9]+#i",'',$_POST['oid_otmena']);
if($oid_otmena>0){
mysql_query("UPDATE operations SET odate2='',obatch='' WHERE oid=$oid_otmena") or die(mysql_error());
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
?>

<div class="admin_vyvod_otmena_title">ОТМЕНА ВЫВОДА</div>

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

<form id="vyvod_otmena" action="/adg.php?page=vyvod_otmena" method="POST" style="margin:0;padding:0">
<input id="oid_otmena" type="hidden" name="oid_otmena">
</form>

<table align="center" style="margin-top:6px;" cellpadding="0px" cellspacing="0px">
<?php
$statsq=mysql_query("SELECT odate,ologin,obatch,osum,oid FROM operations WHERE otype=2 AND odate2!='' ORDER BY odate DESC");
while($statsm=mysql_fetch_row($statsq)){ ?>
<tr>
<td class="admin_vyvod_date"><?php echo date('j '.$mdate[date('n',$statsm[0])-1].' H:i',$statsm[0]); ?></td>
<td class="admin_vyvod_login"><?php echo $statsm[1]; ?></td>
<td class="admin_vyvod_otmena_batch"><?php echo $statsm[2]; ?></td>
<td class="admin_vyvod_sum"><?php echo str_replace('.00','',number_format($statsm[3],0,'','')); ?> РУБ</td>
<td class="admin_vyvod_otmena"><a href="javascript:admin_vyvod_otmena('<?php echo $statsm[4]; ?>')">В обработке</a></td>
</tr>
<?php } ?>
</table>
