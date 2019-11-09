var executing = (function() {
  var i = 0;
  return function(val) {
    if (typeof val != "undefined") {i=val;}
    return i;
  };
})();


function show_message(text,color) {
  var wait = setInterval(function(){
    if (!executing()){
      clearInterval(wait);
      show_message_next(text,color);
    }
  },100);
}

function show_message_next(text,color) {
  executing(1);
  setTimeout(function() {
    var message = document.getElementById('message');
    message.getElementsByTagName('p')[0].innerHTML = text;
    message.getElementsByTagName('p')[0].style.borderColor = color;
    message.style.visibility = "visible";
    message.style.opacity = "1";
    message.style.width = '400px';
  },500);
  setTimeout(function() {
    message.style.visibility = "hidden";
    message.style.opacity = "0";
    message.style.width = '0';
    executing(0);
  },4000);
}

function get_message(message_get) {
  for (var key in message_get) {
    if (key == 'error') {
      if (message_get['error'] == 0) {message_text='Echec de la connexion';}
      if (message_get['error'] == 1.1 || message_get['error'] == 1.2) {message_text='Erreur client';}
      if (message_get['error'] == 2.1 || message_get['error'] == 2.2) {message_text='Erreur serveur';}
      if (message_get['error'] == 3.1) {message_text='Identifiants incorrects';}
      if (message_get['error'] == 3.2) {message_text='Mot de passe incorrect';}
      if (message_get['error'] == 3.3) {message_text='Les mots de passe ne correspondent pas';}
      if (message_get['error'] == 4) {message_text='Adresse mail déjà utilisée';}
      if (message_get['error'] == 5) {message_text='Erreur session';}
      message_color='red';
    }
    if (key == 'success') {
      if (message_get['success'] == 'edit') {message_text='Utilisateur modifié';}
      if (message_get['success'] == 'delete') {message_text='Utilisateur supprimé';}
      if (message_get['success'] == 'register') {message_text='Profil créé';}
      if (message_get['success'] == 'data_update') {message_text='Données mises à jour';}
      message_color='green';
    }
    if (typeof message_text !== 'undefined' && typeof message_color !== 'undefined') {show_message(message_text,message_color);}
  }
}
