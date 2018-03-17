<h2>Ваша реферальная ссылка: <font color="#FF8D1C">http://<?php echo $site; ?>/?ref=<?php echo $u_login; ?></font></h2>



<?php
$refstotq=mysql_query("SELECT login FROM users WHERE ref='".$u_login."'");
$refsq=mysql_query("SELECT ologin,sum(osum2),sum(orefsum) FROM operations WHERE otype=3 AND oref='".$u_login."' AND ologin!='".$u_login."' AND osum2>0 AND obatch!='' AND oback='' GROUP BY ologin ORDER BY sum(osum2) DESC");
$refsar1=array();
while($refsarm=mysql_fetch_row($refstotq)){
$refsar1[$refsarm[0]]=1;
}
?>

<div class="refs_stat">
Всего рефералов: <font color="#FF8D1C"><?php echo mysql_num_rows($refstotq); ?></font>
<br>Активных: <font color="#FF8D1C"><?php echo mysql_num_rows($refsq); ?></font>
<?php
$prib=0;
$prib_text_1='';
$prib_text_2='';
while($refsm=mysql_fetch_row($refsq)){
$prib_text_1.='<img src="images/nu.png">&nbsp;'.$refsm[0].'&nbsp;<font color="#FF8D1C">'.str_replace('.00','',number_format($refsm[1],2,'.',',')).'</font>&nbsp;<font color="#3EAA30">РУБ</font>, ';
$prib+=$refsm[2];
if(isset($refsar1[$refsm[0]])){
unset($refsar1[$refsm[0]]);
}
}
foreach($refsar1 as $re1=>$re2){ $prib_text_2.='<img src="images/nu.png">&nbsp;'.$re1.'&nbsp;<font color="#FF8D1C">0</font>&nbsp;<font color="#3EAA30">РУБ</font>, '; }
?>
<br>Прибыль: <font color="#FF8D1C"><?php echo number_format($prib,2,'.',','); ?> РУБ</font>
</div>
<br>
<div class="refs_who"><?php echo $prib_text_1; ?><br><br><?php echo $prib_text_2; ?></div>

</div>

<div class="main_news_bottom"></div>
