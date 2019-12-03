<?php
session_start();
function reserved($role) {
  if (!isset($_SESSION['role'])) {
    echo "<h1 style='text-align:center'>Vous devez être connecté pour accéder à cette page, vous allez être redirigé vers la page de connexion</h1>";
    ?><script>
    setTimeout(function(){document.location.href="../../view/loggedout/Connexion.php"; ;},7000);
    </script><?php
    exit();
  }
	include("../../model/convert_role.php");//on ouvre la session de l'utilisateur
  if ($role!==char_to_str($_SESSION['role'])) {
    echo "<h1 style='text-align:center;'>Cette page est réservée aux ".strtolower($role)."s, vous allez être redirigé vers la page de connexion</h1>";
    ?><script>
    //setTimeout(function(){document.location.href="../../view/loggedout/Connexion.php"; ;},7000);
    </script><?php
    exit();
  }
}
?>
