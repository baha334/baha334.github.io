<?php

if(!empty($_POST['oid']) && !empty($_POST['batch']) && !empty($_POST['plan']) && ($_POST['act']==0 || $_POST['act']==1)){
$oid=preg_replace("#[^0-9]+#i",'',$_POST['oid']);
$batch=preg_replace("#[^0-9a-z]+#i",'',$_POST['batch']);
$plan=preg_replace("#[^0-9]+#i",'',$_POST['plan']);
$sum=$_POST['sum'];
$sum=preg_replace("#[^0-9\.]+#",'',$sum);
$sum=preg_replace("#\.+#",'.',$sum);
$sum=number_format($sum,2,'.','');
$d_min=number_format($d_min,2,'.','');
$d_max=number_format($d_max,2,'.','');
if($oid<1 || strlen($batch)<1 || strlen($plan)<1 || strlen($plan)>1){
$p_e='Ошибка oid='.$oid.', batch='.$batch;
}
else{
if($_POST['act']==0){

mysql_query("DELETE FROM operations WHERE oid=$oid") or die('cant delete');
$p_s='Транзакция '.$batch.' успешно удалена';

}
else{

if(empty($sum) || empty($oid)){ $p_e='Сумма или ID отсутствуют'; }
$sum=number_format($sum,2,'.','');

if(empty($p_e) && ($sum==0 || $sum==0.00)){ $p_e='0 РУБ ?'; }


if(empty($p_e)){

$b_zam=0;

$dloq=mysql_query("SELECT ologin,oproc,odays,orefproc FROM operations WHERE oid='$oid'");
$dlom=mysql_fetch_row($dloq);

$depbtq=mysql_query("SELECT SUM(osum2) FROM operations WHERE ologin='$dlom[0]' AND osum>0 AND otype=3 AND odate>'$time'  AND oback=''");
$depbtm=mysql_fetch_row($depbtq);
$b_zam=$depbtm[0];


$oback='1';
$sum2=0;
$refsum=0;
$profit=0;
if(($d_max-$b_zam)>=$d_min){
if($sum>=$d_min && $sum<=($d_max-$b_zam)){
$oback='';
$sum2=$sum*($dlom[1]/100)*$dlom[2];
$refsum=number_format(($sum/100)*$dlom[3],2,'.','');
$profit=$sum*($dlom[1]/100);
}
}



mysql_query("UPDATE operations SET osum='$sum2', osum2='$sum', orefsum='$refsum', oback='$oback', oprofit='$profit' WHERE oid=$oid") or die('cant update');
$p_s='Транзакция '.$batch.' успешно выполнена';

$popscq=mysql_query("SELECT SUM(osum2) FROM operations WHERE otype=3 AND osum2>0 AND obatch!='' AND oback=''");
$popscm=mysql_fetch_row($popscq);
$popsq=mysql_query("SELECT ologin,osum2 FROM operations WHERE otype=3 AND osum2>0 AND obatch!='' AND oback='' ORDER BY odate2 DESC LIMIT 40");
$popsn='';
while($popsm=mysql_fetch_row($popsq)){
$popsn.='<img src="images/nu.png">&nbsp;'.$popsm[0].'&nbsp;<font color="#FF8D1C">'.$popsm[1].'</font>&nbsp;<font color="#3EAA30">РУБ</font>, ';
}
mysql_query("UPDATE data SET plus='$popscm[0]', plus_n='$popsn'") or die(mysql_error());

}

}
}
}

?>

<?php if(!empty($p_e)){ ?><div class="popolnenie_error"><?php echo $p_e; ?></div><?php } ?>
<?php if(!empty($p_s)){ ?><div class="popolnenie_success"><?php echo $p_s; ?></div><?php } ?>

<?php
$popq=mysql_query("SELECT oid,ologin,obatch,oplan FROM operations WHERE otype=3 AND obatch!='' AND osum2=0 ORDER BY odate2 ASC");
$popc=mysql_num_rows($popq);
if($popc>0){
$popm=mysql_fetch_row($popq);
?>
<table align="center" class="admin_popolnenie_stat" cellpadding="0px" cellspacing="0px">
<tr>
<td style="width:120px;"></td>
<td style="width:120px;">Логин</td>
<td style="width:180px;">Ваучер</td>
<td style="width:125px;">Сумма РУБ</td>
<td style="width:110px;"></td>
</tr>
</table>

<table align="center" style="margin-top:10px;" cellpadding="0px" cellspacing="0px">
<tr>
<td class="admin_popolnenie_delete"><a href="javascript:admin_popolnenie('<?php echo $popm[0]; ?>','0')">Удалить</a></td>
<td class="admin_popolnenie_login"><?php echo $popm[1]; ?></td>
<td class="admin_popolnenie_batch" style="font-size:10px;"><?php echo $popm[2]; ?></td>
<td class="admin_popolnenie_sum">

<form id="popolnenie" action="/adg.php?page=popolnenie" method="POST" style="margin:0;padding:0">
<input id="oid" type="hidden" name="oid">
<input id="act" type="hidden" name="act">
<input type="hidden" name="batch" value="<?php echo $popm[2]; ?>">
<input type="hidden" name="plan" value="<?php echo $popm[3]; ?>">
<input id="admin_p_input_i" type="text" name="sum" onkeyup="admin_p_input();" onmouseout="admin_p_input();" maxlength="9">
</form>

</td>
<td class="admin_popolnenie_vypolneno"><a href="javascript:admin_popolnenie('<?php echo $popm[0]; ?>','1')">Выполнено</a></td>
</tr>
</table>
<?php } ?>
