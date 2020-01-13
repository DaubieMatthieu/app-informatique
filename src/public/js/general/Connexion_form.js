function show_connexion_form() {
  connexion_form=document.getElementById('connexion_form');
  connexion_form.style.visibility='visible';
  connexion_form.style.opacity='1';
  setTimeout(function(){connexion_form.getElementsByTagName('input')[0].focus();},100);
}

function hide_connexion_form() {
  connexion_form=document.getElementById('connexion_form');
  connexion_form.style.visibility='hidden';
  connexion_form.style.opacity='0';
}
