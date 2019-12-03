function show_new_subject_form() {
  new_subject_form=document.getElementById('new_subject_form');

  new_subject_form.style.visibility='visible';
  new_subject_form.style.opacity='1';
  setTimeout(function(){new_subject_form.getElementsByTagName('input')[2].focus();},100);
}

function hide_new_subject_form() {
  new_subject_form=document.getElementById('new_subject_form');
  new_subject_form.style.visibility='hidden';
  new_subject_form.style.opacity='0';
}

function show_delete_form(id_sujet,titre,date_creation_sujet,prenom,nom) {
  delete_form=document.getElementById('delete_form');
  //on modifie les valeurs du formulaire de suppression
  delete_form.getElementsByTagName('input')[0].value = id_sujet;
  delete_form.getElementsByTagName('input')[1].value = titre;
  delete_form.getElementsByTagName('input')[2].value = date_creation_sujet;
  delete_form.getElementsByTagName('input')[3].value = prenom;
  delete_form.getElementsByTagName('input')[4].value = nom;

  delete_form.style.visibility='visible';
  delete_form.style.opacity='1';
  setTimeout(function(){delete_form.getElementsByTagName('input')[5].focus();},100);
}

function hide_delete_form() {
  var delete_form=document.getElementById('delete_form');
  delete_form.style.visibility='hidden';
  delete_form.style.opacity='0';
}
