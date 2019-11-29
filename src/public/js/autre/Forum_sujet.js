function show_new_message_form() {
  new_message_form=document.getElementById('new_message_form');

  new_message_form.style.visibility='visible';
  new_message_form.style.opacity='1';
  setTimeout(function(){new_message_form.getElementsByTagName('input')[2].focus();},100);
}

function hide_new_message_form() {
  new_message_form=document.getElementById('new_message_form');
  new_message_form.style.visibility='hidden';
  new_message_form.style.opacity='0';
}
