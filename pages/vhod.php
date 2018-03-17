<br>  <div class="clearFix">
	  </div>
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
<p><font color="black"><b>749</font> Участников</b></font> | <b>На сайте:  <font color="black">27</font></b> | <b>Баланс: <font color="black">112,292.30</font></b>  руб.| <b> Пополнили: <font color="blue">241,325.00</font> руб</b> | Вывели: <font color="red">104,900.20</font> руб.</b></p>

<?php } else { ?>
</form>
      </div>