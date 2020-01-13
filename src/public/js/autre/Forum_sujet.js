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

function show_delete_form(id_sujet,id_message,prenom,nom,date_poste,texte) {
  delete_form=document.getElementById('delete_form');
  //on modifie les valeurs du formulaire de suppression
  delete_form.getElementsByTagName('input')[0].value = id_sujet;
  delete_form.getElementsByTagName('input')[1].value = id_message;
  delete_form.getElementsByTagName('input')[2].value = prenom;
  delete_form.getElementsByTagName('input')[3].value = nom;
  delete_form.getElementsByTagName('input')[4].value = date_poste;
  delete_form.getElementsByTagName('input')[5].value = texte;

  delete_form.style.visibility='visible';
  delete_form.style.opacity='1';
  setTimeout(function(){delete_form.getElementsByTagName('input')[6].focus();},100);
}

function hide_delete_form() {
  var delete_form=document.getElementById('delete_form');
  delete_form.style.visibility='hidden';
  delete_form.style.opacity='0';
}
