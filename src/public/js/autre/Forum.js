function show_new_subject_form() {
  new_subject_form=document.getElementById('new_subject_form');

  new_subject_form.style.visibility='visible';
  new_subject_form.style.opacity='1';
  setTimeout(function(){new_subject_form.getElementsByTagName('input')[4].focus();},100);
}

function hide_new_subject_form() {
  new_subject_form=document.getElementById('new_subject_form');
  new_subject_form.style.visibility='hidden';
  new_subject_form.style.opacity='0';
}
