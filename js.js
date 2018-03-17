<!-- ADMIN POPOLNENIE ADMIN POPOLNENIE ADMIN POPOLNENIE ADMIN POPOLNENIE ADMIN POPOLNENIE ADMIN POPOLNENIE -->

function admin_popolnenie(num,act){
document.getElementById('oid').value=num;
document.getElementById('act').value=act;
with(document.getElementById('popolnenie')){
submit();
}
}

function admin_p_input() {
document.getElementById('admin_p_input_i').value=document.getElementById('admin_p_input_i').value.replace(/[^0-9\,\.]+/g,'');
document.getElementById('admin_p_input_i').value=document.getElementById('admin_p_input_i').value.replace(/\,/g,'.');
document.getElementById('admin_p_input_i').value=document.getElementById('admin_p_input_i').value.replace(/\.+/g,'.');
}

<!-- ADMIN_VYVOD ADMIN_VYVOD ADMIN_VYVOD ADMIN_VYVOD ADMIN_VYVOD ADMIN_VYVOD ADMIN_VYVOD ADMIN_VYVOD ADMIN_VYVOD -->

function admin_vyvod(num){
document.getElementById('oid').value=num;
document.getElementById('obatch').value=document.getElementById('ic'+num).value;
with(document.getElementById('vyvod')){
submit();
}
}

function admin_vyvod_otmena(numo){
document.getElementById('oid_otmena').value=numo;
with(document.getElementById('vyvod_otmena')){
submit();
}
}

<!-- REGISTRATION REGISTRATION REGISTRATION REGISTRATION REGISTRATION REGISTRATION REGISTRATION REGISTRATION -->

function reg_u_login(){
var reg_u_login=document.getElementById('u_login').value;
reg_u_login=reg_u_login.replace(/[^a-zA-Z\-\_0-9]+/g,"");
document.getElementById('u_login').value=reg_u_login;
}

function reg_u_qiwi(){
var reg_u_qiwi=document.getElementById('u_qiwi').value;
reg_u_qiwi=reg_u_qiwi.replace(/[^0-9]+/g,"");
document.getElementById('u_qiwi').value=reg_u_qiwi;
}

<!-- VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY VKLADY -->

function vklad() {
var vklad=document.getElementById('vklad_sum').value;
vklad=vklad.replace(/,/g,".");
vklad=vklad.replace(/[^0-9.]/g,"");
vklad=vklad.replace(/(\.[0-9]{2})[0-9]+/g,"$1");
vklad=vklad.replace(/^[0]+0/g,"0");
vklad=vklad.replace(/^[0]+([1-9])/g,"$1");
document.getElementById('vklad_sum').value=vklad;
}

<!-- POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT POPOLNIT -->

function batch2() {
document.getElementById('batch').value=document.getElementById('batch').value.replace(/[^0-9]+/g,'');
}

<!-- VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI VYVESTI -->

function withdrawal() {
document.getElementById('withdrawal_input').value=document.getElementById('withdrawal_input').value.replace(/[^0-9\.]+/g,'');
document.getElementById('withdrawal_input').value=document.getElementById('withdrawal_input').value.replace(/\.+/g,'.');
}

<!-- REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS REVIEWS -->

function smile(sm) {
document.getElementById('reviews_textarea').value+=sm;
reviews_symb_count();
}

function reviews_symb_count(){
document.getElementById('reviews_textarea').value=document.getElementById('reviews_textarea').value.substring(0,300);
document.getElementById('reviews_symbols').innerHTML=(300-document.getElementById('reviews_textarea').value.length);
}

<!-- COUNTDOWN COUNTDOWN COUNTDOWN COUNTDOWN COUNTDOWN COUNTDOWN COUNTDOWN COUNTDOWN COUNTDOWN COUNTDOWN -->

var s_t_tc1=new Array(2,3,4,22,23,24,32,33,34,42,43,44,52,53,54);
var s_t_tc2=new Array(1,21,31,41,51);

function s_t_text(s_t_digit,s_t_text_1,s_t_text_2,s_t_text_3){
s_t_found='n';
for(n=0;n<s_t_tc1.length;n++){
if(s_t_digit==s_t_tc1[n]){  s_t_text_1=s_t_text_2; s_t_found='d'; break; }
}
if(s_t_found=='n'){
for(n=0;n<s_t_tc2.length;n++){
if(s_t_digit==s_t_tc2[n]){ s_t_text_1=s_t_text_3;}
}
}
return s_t_text_1;
}

function s_t_timer(){
if(s_t_cd<=0){
location.href="/?page=popolnit";
return;
}
var s_t_days=(parseInt(s_t_cd/(24*60*60)));
s_t_text_days=s_t_text(s_t_days,'дней','дня','день');
var s_t_sd=s_t_cd-s_t_days*24*3600;
var s_t_hour=(parseInt(s_t_sd/3600));
s_t_text_hour=s_t_text(s_t_hour,'часов','часа','час');
if(s_t_hour<10){s_t_hour='0'+s_t_hour};
var s_t_sl=s_t_sd-s_t_hour*3600;
var s_t_minute=(parseInt(s_t_sl/60));
s_t_text_min=s_t_text(s_t_minute,'минут','минуты','минута');
if(s_t_minute<10){s_t_minute='0'+s_t_minute};
var s_t_seconds=s_t_sl-s_t_minute*60;
s_t_text_sec=s_t_text(s_t_seconds,'секунд','секунды','секунда');
if(s_t_seconds<10){s_t_seconds='0'+s_t_seconds;}
if(s_t_days==0){ s_t_days=''; s_t_text_days=''; }
if(s_t_days=='' && s_t_hour=='00'){ s_t_hour=''; s_t_text_hour=''; }
if(s_t_days=='' && s_t_hour=='' && s_t_minute=='00'){ s_t_hour=''; s_t_text_hour=''; s_t_minute=''; s_t_text_min=''; }
document.getElementById('s_t_dhm').innerHTML=s_t_days+' '+s_t_text_days+'&nbsp;&nbsp;'+s_t_hour+' '+s_t_text_hour+'&nbsp;&nbsp;'+s_t_minute+' '+s_t_text_min+' '+s_t_seconds+' '+s_t_text_sec;
s_t_cd--;
setTimeout('s_t_timer()',1000);
}
