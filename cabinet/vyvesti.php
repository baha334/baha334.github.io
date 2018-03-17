<h2>Вывод денег</h2>


<div class="vyvesti_info">
<?php
if($d_vyvod!=0){
echo '<div class="vyvesti_error">Вывод денег приостановлен</div>';
}
else{
echo 'Вывод от '.$d_wmin.' до '.$d_wmax.' РУБ
<br>
<br>Для активации полученого ваучера:
<br>Заходим в свой кошелёк на сайте <a target="_blank" style="color:#009000;text-decoration:underline;font-weight:bold;" href="https://w.qiwi.com">w.qiwi.com</a>
<br>Выбираем раздел "Перевод". Выбираем слева тип перевода "QIWI Яйца"
<br>Нажимаем "Активировать" и вводим полученый код ваучера.
';
}
?>
</div>



<?php
if($d_vyvod==0){

$b_tot=0;
$b_plus=0;
$b_otn=0;

$depbtq=mysql_query("SELECT ologin,otype,osum,osum2,orefsum,odate,obatch,odate2,oprofit,odays FROM operations WHERE (ologin='$u_login' AND osum>0 AND oback='') OR (oref='$u_login' AND osum>0 AND oback='')");
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

if($b_tot<0) { echo "Ошибка! Баланс $ $b_tot. Сообщите поддержке сайта."; exit; }

if(isset($_POST['sum'])){
$sum=$_POST['sum'];
$sum=preg_replace("#[^0-9\.]+#",'',$sum);
$sum=preg_replace("#\.+#",'.',$sum);

if(empty($sum)){ $sum=0; }

$sum=number_format($sum,2,'.','');

if(!is_numeric($sum)){ $w_e='Введите корректную сумму для вывода'; }
if(empty($w_e) && $sum<$d_wmin){ $w_e='Минимальная сумма для вывода '.$d_wmin.' РУБ'; }
if(empty($w_e) && $sum>$d_wmax){ $w_e='Максимальная сумма для вывода '.$d_wmax.' РУБ'; }
if(empty($w_e) && $sum>$b_tot){ $w_e='На Вашем балансе недостаточно средств'; }

if(empty($w_e) && $sum>$free){
$w_e='В проекте недостаточно средств для вывода<br>Попробуйте вывести '.number_format($free,2,'.','');
}

if(empty($w_e)){

//======================================== ПРОЦЕСС ВЫВОДА ====================================================================

mysql_query("INSERT INTO operations (ologin,otype,osum,odate) VALUES ('$u_login','2','$sum','$time')") or die('error inserting withdrawl');
$w_s=1;
$b_tot-=$sum;
}
}
//==============================================================================================================================
}
?>


<?php
if(!empty($w_e)){ echo '<div class="vyvesti_error">'.$w_e.'</div>'; }
if(!empty($w_s)){ echo '<div class="vyvesti_success">Заявка на вывод '.$sum.' РУБ принята в обработку. Процесс может занять до 24 часов.</div>'; }
?>


<?php if($d_vyvod==0){ ?>

<br>
<center>
<form id="withdrawal" method="POST" action="/?page=vyvesti" style="margin:0;padding:0">
<table align="center" cellpadding="0px" cellspacing="0px">
<tr>
<td class="vyvesti_balance">БАЛАНС: <font color="#FF860D"><?php echo number_format($b_tot,2,'.',','); ?></font> РУБ</td>
<td><font class="vyvesti_sum">СУММА:</font>&nbsp;&nbsp;<input id="withdrawal_input" class="vyvesti_input" type="text" name="sum" onkeyup="withdrawal();" maxlength="9"></td>
<td><a class="vyvesti_button" href="javascript:with(document.getElementById('withdrawal')){ submit(); }">ВЫВЕСТИ</a></td>
</tr>
</table>
</form>
</center>

<?php } ?>


<br>
<br>
<center>
<table align="center" class="vyvesti_stat" cellpadding="0px" cellspacing="0px">
<tr>
<td style="width:120px;">Сумма</td>
<td style="width:150px;">Дата</td>
<td style="width:240px;">Ваучер</td>
<td style="width:130px;">Статус</td>
</tr>
</table>
</center>
<center>
<table align="center" style="margin-top:2px;" cellpadding="2px" cellspacing="2px">
<?php
$statsq=mysql_query("SELECT osum,odate,odate2,obatch FROM operations WHERE otype=2 AND ologin='$u_login' ORDER BY odate DESC");
while($statsm=mysql_fetch_row($statsq)){ ?>
<tr>
<td class="vyvesti_stat_sum"><?php echo str_replace('.00','',number_format($statsm[0],2,'.',',')); ?> РУБ</td>
<td class="vyvesti_stat_date"><?php echo date('j '.$mdate[date('n',$statsm[1])-1].' H:i',$statsm[1]); ?></td>
<td class="vyvesti_stat_batch"><a target="_blank" href="https://w.qiwi.com/eggs/activate/form.action?code=<?php echo $statsm[3]; ?>"><?php echo $statsm[3]; ?></td>
<?php
if($statsm[2]==''){ echo '<td class="vyvesti_stat_batch_1">В обработке</td>'; }
else{ echo '<td class="vyvesti_stat_batch_2">Выполнено</td>'; }
?>
</td>
</tr>
<?php } ?>
</table>
</center>
