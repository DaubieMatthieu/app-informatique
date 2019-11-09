function show_edit_form(info){
  var edit_form=document.getElementsByClassName('edit_'+info)[0];
  edit_form.style.visibility='visible';
  edit_form.style.opacity='1';
  setTimeout(function(){edit_form.getElementsByTagName('input')[0].focus();},100);
}

function hide_edit_form(info) {
  var edit_form=document.getElementsByClassName('edit_'+info)[0];
  edit_form.style.visibility='hidden';
  edit_form.style.opacity='0';
}
