<!DOCTYPE html>
<html lang="fr">
  <head>
		<meta charset="utf-8">
		<title>DEMO PDO 1</title>
		
		<!-- Lien vers mon CSS -->
		<link href="css/monStyle.css" rel="stylesheet">
		
							
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
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES=>false];
		
		try{	// Bloc try bd injoignable ou si erreur SQL
			$pdo=new PDO($dsn,$user,$pass,$options);										// Connexion PDO
			
			// Exemple 1 query 
			echo "<h1> PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC (default)</h1>";
			$requete="SELECT ID, NOM, PRENOM FROM personnes ORDER BY NOM, PRENOM ASC"  ;	// Définition de la requête
			$resultats=$pdo->query($requete);  												// Execution de la requête
			
			echo "<table>" ;																// Début table
				echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
				$i=0;																		// Compteur de ligne
				while( $ligne = $resultats->fetch() ) { 									// Parcours des lignes
					$i++;																	// Incrémentation compteur de lignes
					echo "<tr>";															// Début d'une ligne d'un tableau
						echo "<td>".$i."</td>";												// Cellule compteur
						echo "<td>".$ligne['ID']."</td>";									// Cellule ID
						echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
						echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
					echo "<tr>";															// Fin ligne
				}
			echo "</table>" ;																// Fin table
			echo "<hr>";
			echo "\n"; // Saut de ligne dans le HTML
			// --------------------------------------------------------------
			echo "<h1> PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ</h1>";
			$requete="SELECT ID, NOM, PRENOM FROM personnes ORDER BY NOM,PRENOM ASC"  ;	// Définition de la requête
			$resultats=$pdo->query($requete);											// Execution de la requête
			$resultats->setFetchMode(PDO::FETCH_OBJ);									// Résultats renvoyés en objets
			
			echo "<table>" ;															// Début table
				echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>"; 		// Première ligne titre
				$i=0;																	// Compteur de ligne		
				while( $ligne = $resultats->fetch() ) {									// Parcours des lignes
					$i++;																// Incrémentation compteur de lignes
					echo "<tr>";														// Début d'une ligne d'un tableau
						echo "<td>".$i."</td>";											// Cellule compteur
						echo "<td>".$ligne->ID."</td>";									// Cellule ID
						echo "<td>".$ligne->NOM."</td>";								// Cellule Nom
						echo "<td>".$ligne->PRENOM."</td>" ;							// Cellule Prénom
					echo "<tr>";														// Fin ligne
				}
			echo "</table>" ;															// Fin table
			
			echo "\n"; // Saut de ligne dans le HTML
			// --------------------------------------------------------------

			
		}catch(PDOException $e){
			//Il y a eu une erreur 
			echo "<h1>Erreur BD ".$e->getMessage();
		}
	?>
	
  </body>
</html>