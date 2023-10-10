<!DOCTYPE html>
<html lang="fr">
  <head>
		<meta charset="utf-8">
		<title>DEMO PDO 1</title>
		
		<!-- Lien vers mon CSS -->
		<link href="css/monStyle.css" rel="stylesheet">
		
		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
							
   </head>

  <body>
  
	<?php 
		$host='localhost';	// Serveur de BD
		$db='demopdo';		// Nom de la BD
		$user='root';		// User 
		$pass='root';		// Mot de passe
		$charset='utf8mb4';	// charset utilisé
		
		// Constitution variable DSN
		$dsn="mysql:host=$host;dbname=$db;charset=$charset";
		
		// Réglage des options
		$options=[																				 
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,
			PDO::ATTR_EMULATE_PREPARES=>false];
		
		try{	// Bloc try bd injoignable ou si erreur SQL
			$pdo=new PDO($dsn,$user,$pass,$options);											// Connexion PDO
			
			
			echo "<h1> Exemple avec images</h1>";
			$requete="SELECT ID, NOM, PRENOM, PHOTO FROM personnes ORDER BY NOM,PRENOM ASC"  ; 	// Définition de la requête
			$resultats=$pdo->query($requete);  													// Execution de la requête
			
			echo "<div class='container'>" ;													// container bootstrap
				echo "<div class='row'>";  														// 1 seule ligne
					while( $ligne = $resultats->fetch() ) {										// Parcours des lignes
						echo "<div class='col-xs-12 col-sm-6 col-md-3 centrer'>"; 				// Case bootstrap responsive
							echo "<img src='images/".$ligne->PHOTO."' class='img-circle taille50p' alt='Photo'><br/>"; // Image
							echo "<h2>".$ligne->NOM." ".$ligne->PRENOM."</h2>"; 				// Nom prénom
						echo "</div>";															// Fin case bootstrap
					}
				echo "</div>" ;																	// Fin ligne
			echo "</div>" ;																		// Fin container
			
		}catch(PDOException $e){
			//Il y a eu une erreur 
			echo "<h1>Erreur BD ".$e->getMessage();
		}
	?>
	
  </body>
</html>