<?php
$reg_show=1;
if(!isset($_POST['u_login'])){
$u_login='';
$u_qiwi='';
}
else{
$warning='';

$u_login=$_POST['u_login'];
$u_login=preg_replace('#[^a-zA-Z\-\_0-9]+#','',$u_login);
$u_login=trim($u_login);

if(strlen($u_login)<3){ $warning.='Логин не меньше 3 символов<br>'; }
else{
$ulq=mysql_query("SELECT login FROM users WHERE login LIKE '".$u_login."'");
if(mysql_num_rows($ulq)>0){ $warning.='Этот логин занят<br>'; }
}

$u_qiwi=$_POST['u_qiwi'];
$u_qiwi=preg_replace('#[^a-zA-Z\-\_0-9]+#','',$u_qiwi);
if(strlen($u_qiwi)<3){ $warning.='Пароль не менее 3 символов<br>'; }
if(strlen($u_qiwi)>30){ $warning.='Пароль не более 30 символов<br>'; }

if($warning==''){
$u_ref=''; if(!empty($_SESSION['ref_login'])){ $u_ref=$_SESSION['ref_login']; }
$regq=mysql_query("INSERT INTO users (login,qiwi,ref,date) VALUES ('$u_login','".md5($u_qiwi)."','$u_ref','$time')");

$regusepq=mysql_query("SELECT uid FROM users");
$r_users=mysql_num_rows($regusepq);
$regtoputnu='';
$regnusq=mysql_query("SELECT login FROM users ORDER BY date DESC LIMIT 80");
while($regnusm=mysql_fetch_row($regnusq)){ $regtoputnu.='<img src="images/nu.png"> '.$regnusm[0].' '; }
mysql_query("UPDATE data SET users='$r_users', new_u='$regtoputnu'");

$reg_show=0;
}}
?>


<h2>РЕГИСТРАЦИЯ В ПРОЕКТЕ</h2>



<?php if($reg_show==0){ ?>
<div class="reg_s_title">Теперь Вы зарегистрированы в нашем проекте!</div>
<div align="center" class="reg_s_date">
Логин: <font color="#77AF1B"><?php echo $u_login; ?></font>
<br>Пароль: <font color="#FF962D"><?php echo $u_qiwi; ?></font>
</div>
<?php } ?>

<?php if($reg_show==1){ ?>






<form id="registration" method="POST" action="/?page=registration" style="margin:0;padding:0">

<?php
if($warning!=''){
echo '<tr><td class="reg_warning" colspan="3">'.$warning.'</td></tr>';
}
?>
<center>
<b>Логин</b>:<input id="u_login" onkeyup="reg_u_login();" class="text" type="text" name="u_login" placeholder="" autocomplete="off" maxlength="20" value="<?php echo $u_login; ?>">
<br /><br />
<b>Пароль</b>:<input class="text" id="u_qiwi" type="text" name="u_qiwi" placeholder="" maxlength="30" value="<?php echo $u_qiwi; ?>">
<br /><br />
<b>Реферал</b>: <input class="text" "placeholder="<?php if(!empty($_SESSION['ref_login'])){ echo $_SESSION['ref_login']; }?>">
<br /><br />
<a class="button" href="javascript:with(document.getElementById('registration')){ submit(); }">РЕГИСТРАЦИЯ</a></center>

<div class="reg_danger">
Это касса взаимопомощи.
Вы получаете прибыль за счёт вклада последующих участников. Если приток иссякнет - будет нечем платить. <u>Вы можете всё проиграть!</u>
<br>
В проекте могут принимать участие лица, достигшие 18 лет. Администрация не может гарантировать возврат вложенных денег. В любой момент вы можете ничего не получить. 
</div>


</table>
</form>

<?php } ?>

</div>

<div class="main_news_bottom"></div>
