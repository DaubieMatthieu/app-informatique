function show_delete_form(line) {
  var Tableau=document.getElementsByTagName('table')[0];
  delete_form=document.getElementById('delete_form');
  //on récupère les données de la ligne
  nom=Tableau.getElementsByTagName('tr')[line].cells[0].innerHTML;
  prenom=Tableau.getElementsByTagName('tr')[line].cells[1].innerHTML;
  adresse_mail=Tableau.getElementsByTagName('tr')[line].cells[2].innerHTML;
  role=Tableau.getElementsByTagName('tr')[line].cells[3].innerHTML;
  id_utilisateur=Tableau.getElementsByTagName('tr')[line].cells[5].innerHTML;
  //on modifie les valeurs du formulaire de suppression
  delete_form.getElementsByTagName('input')[0].value = id_utilisateur;
  delete_form.getElementsByTagName('input')[1].value = nom;
  delete_form.getElementsByTagName('input')[2].value = prenom;
  delete_form.getElementsByTagName('input')[3].value = adresse_mail;
  delete_form.getElementsByTagName('input')[4].value = role;

  delete_form.style.visibility='visible';
  delete_form.style.opacity='1';
  setTimeout(function(){delete_form.getElementsByTagName('input')[5].focus();},100);
}

function hide_delete_form() {
  var delete_form=document.getElementById('delete_form');
  delete_form.style.visibility='hidden';
  delete_form.style.opacity='0';
}

function show_edit_form(line){
  var Tableau=document.getElementsByTagName('table')[0];
  var edit_form=document.getElementById('edit_form');
  //on récupère les données de la ligne
  nom=Tableau.getElementsByTagName('tr')[line].cells[0].innerHTML;
  prenom=Tableau.getElementsByTagName('tr')[line].cells[1].innerHTML;
  adresse_mail=Tableau.getElementsByTagName('tr')[line].cells[2].innerHTML;
  role=Tableau.getElementsByTagName('tr')[line].cells[3].innerHTML;
  if (role=='Utilisateur') {role='U';}
  if (role=='Gestionnaire') {role='G';}
  if (role=='Administrateur') {return;}
  id_utilisateur=Tableau.getElementsByTagName('tr')[line].cells[5].innerHTML;
  //on modifie les valeurs du formulaire de suppression
  edit_form.getElementsByTagName('input')[0].value = id_utilisateur;
  edit_form.getElementsByTagName('input')[1].value = nom;
  edit_form.getElementsByTagName('input')[2].value = prenom;
  edit_form.getElementsByTagName('input')[3].value = adresse_mail;
  edit_form.getElementsByTagName('select')[0].value = role;

  edit_form.style.visibility='visible';
  edit_form.style.opacity='1';
  setTimeout(function(){edit_form.getElementsByTagName('input')[5].focus();},100);
}

function hide_edit_form() {
  var edit_form=document.getElementById('edit_form');
  edit_form.style.visibility='hidden';
  edit_form.style.opacity='0';
}

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
