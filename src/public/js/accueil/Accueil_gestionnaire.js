function show_pre_register_form(line){
  var pre_register_form=document.getElementById('pre_register_form')

  pre_register_form.style.visibility='visible';
  pre_register_form.style.opacity='1';
  setTimeout(function(){pre_register_form.getElementsByTagName('input')[2].focus();},100);
}

function hide_pre_register_form() {
  var pre_register_form=document.getElementById('pre_register_form');
  pre_register_form.style.visibility='hidden';
  pre_register_form.style.opacity='0';
}
