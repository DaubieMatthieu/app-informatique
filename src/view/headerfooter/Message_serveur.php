<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/headerfooter/Message_serveur.css" />
		<script type="text/javascript" src="../../public/js/general/Message_serveur.js"></script>
	</head>

	<body onload=get_message(<?php echo json_encode($_GET);?>);>
    <div id='message'><p></p></div>
  </body>
</html>
