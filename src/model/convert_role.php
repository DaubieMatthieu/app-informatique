<?php

function str_to_char($str) {
  if ($str==='Administrateur') {return('A');}
  if ($str==='Gestionnaire') {return('G');}
  if ($str==='Utilisateur') {return('U');}
  return('error');
}

function char_to_str($char) {
  if ($char==='A') {return('Administrateur');}
  if ($char==='G') {return('Gestionnaire');}
  if ($char==='U') {return('Utilisateur');}
  return('error');
}

?>
