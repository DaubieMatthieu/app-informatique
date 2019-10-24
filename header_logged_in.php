<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="header_logged_in.css" />
	</head>

	<body>
		<header>
			<ul>
				<li>Infinite Sense<br/>(Home)</li>
				<li>Menu 2</li>
				<li><a href="Profil.php"><?php echo $_SESSION['role'];?></a></li>
			</ul>
		</header>
  </body>
</html>
