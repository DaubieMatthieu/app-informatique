<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../../public/css/autre/Faq.css"/>
		<script defer type='text/javascript' src="../../public/js/autre/Faq.js"></script>
		<title>Foire Aux Questions</title>
	</head>

	<body>

		<?php include("../general/Header.php"); ?>

		<!--section messages serveur-->

		<?php include('../general/Message_serveur.php');?>

		<!--section sujets-->

		<section>

			<h1>Questions fréquentes</h1></br>

			<div id="faq">

				<?php
				// connexion à la base de données
				include('../../model/db_connect.php');
				$db = db_connect();
				if ($db===false) {
					?><script> show_message('Connexion à la base de donnée impossible','red'); </script><?php
					exit;
				}

				try {
					$req = "SELECT question, reponse FROM question_faq";
					$rep = $db->query($req);

				} catch (Exception $e)
				{
					?><script type="text/javascript"> show_message('Erreur serveur','red'); </script><?php
					exit;
				}

				if ($rep->rowCount()==0)

				{
					?><script type="text/javascript"> show_message('Aucun sujet trouvé','orange'); </script><?php
				} else {

	      	while ($sujets=$rep->fetch()) {
						?>
						<button class="question"><?php echo $sujets['question']; ?></button>
						<div class="reponse">
							<?php echo '<p>'.$sujets['reponse'].'</p>'; ?>
						</div>
						<?php
					}
				}
				?>

			</div>
		</section>

		<?php include("../general/Footer.php"); ?>

	</body>

</html>
