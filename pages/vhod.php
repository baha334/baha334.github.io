<br>  <div class="clearFix">
	  </div>
<div id="twitter">
  <div class="wrap clearFix"> 
<?php if(!USER_LOGGED){ ?>
<form id="enter" action="/" method="POST" >
<input class="text" type="text" name="login" placeholder="�����" maxlength="20">
<input class="text" type="text" name="qiwi" placeholder="������" maxlength="30">
<a class="button" href="javascript:with(document.getElementById('enter')){ submit(); }">�����</a>
<?php if(!empty($wrong_lq)){ echo '<br />�������� �����-������'; } ?>
</form>
 </fieldset>
<p><font color="black"><b>749</font> ����������</b></font> | <b>�� �����:  <font color="black">27</font></b> | <b>������: <font color="black">112,292.30</font></b>  ���.| <b> ���������: <font color="blue">241,325.00</font> ���</b> | ������: <font color="red">104,900.20</font> ���.</b></p>

<?php } else { ?>
</form>
      </div>