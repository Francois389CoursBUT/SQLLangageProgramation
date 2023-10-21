<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>DEMO PDO 2-1</title>

        <!-- Lien vers mon CSS -->
        <link href="css/monStyle.css" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">

    </head>

    <body>

    <?php
    $host = 'localhost';    // Serveur de BD
    $db = 'demopdo';        // Nom de la BD
    $user = 'root';        // User
    $pass = 'root';        // Mot de passe
    $charset = 'utf8mb4';    // charset utilisé

    // Constitution variable DSN
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    // Réglage des options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false];

    try {    // Bloc try bd injoignable ou si erreur SQL
        $pdo = new PDO($dsn, $user, $pass, $options);

        /*
                    // Exemple 1 Requete préparées
                    echo '<h1>Exemple 1 - SELECT * FROM personnes WHERE NOM = ? AND PRENOM = ? </h1>';

                    $nom="Dupont";
                    $prenom="Albert";

                    $stmt = $pdo->prepare('SELECT * FROM personnes WHERE NOM = ? AND PRENOM = ? ');	// Préparation de la requête
                    $stmt->execute([$nom, $prenom]);												// Execution de la requête avec envoi des paramètres


                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $stmt->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $stmt->rowCount().' clients trouvé(s).';
                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */
        // ------------------------------------------------------------------------------------------------------

        /*
                    // Exemple 2 Requete préparées
                    echo '<h1>Exemple 2 - SELECT * FROM personnes WHERE NOM = ? AND PRENOM = ? Avec bindParam</h1>';

                    $nom="Dupont";
                    $prenom="Albert";

                    $stmt = $pdo->prepare('SELECT * FROM personnes WHERE NOM = ? AND PRENOM = ? ');	// Préparation de la requête
                    $stmt->bindParam(1, $nom);														// Envoi du paramètre 1
                    $stmt->bindParam(2, $prenom);													// Envoi du paramètre 2
                    $stmt->execute();																// Execution de la requête


                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $stmt->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $stmt->rowCount().' clients trouvé(s).';
                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML

        */
        // ------------------------------------------------------------------------------------------------------

        /*
                    // Exemple 3 Requete préparées
                    echo '<h1>Exemple 3 - SELECT * FROM personnes WHERE NOM = :leNom AND PRENOM = :lePrenom </h1>';

                    $nom="Dupont";
                    $prenom="Albert";

                    $stmt = $pdo->prepare('SELECT * FROM personnes WHERE NOM = :leNom AND PRENOM = :lePrenom ');	// Préparation de la requête
                    $stmt->execute(["leNom"=>$nom,"lePrenom"=>$prenom]);											// Execution de la requête avec envoi des paramètres

                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $stmt->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $stmt->rowCount().' clients trouvé(s).';
                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */
        // ------------------------------------------------------------------------------------------------------

        /*
                    // Exemple 4 Requete préparées
                    echo '<h1>Exemple 4 - SELECT * FROM personnes WHERE NOM = :leNom AND PRENOM = :lePrenom  avec bindParam</h1>';

                    $nom="Dupont";
                    $prenom="Albert";

                    $stmt = $pdo->prepare('SELECT * FROM personnes WHERE NOM = :leNom AND PRENOM = :lePrenom ');	// Préparation de la requête

                    $stmt->bindParam("leNom", $nom);												// Envoi du paramètre 1
                    $stmt->bindParam("lePrenom", $prenom);											// Envoi du paramètre 2
                    $stmt->execute();																// Execution de la requête


                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $stmt->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $stmt->rowCount().' clients trouvé(s).';									// Nombre d'items retournés par la requete


                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */

        /*
                    // Exemple 5 - Requete préparées avec like
                    echo '<h1>Exemple 5 - SELECT * FROM personnes WHERE NOM like :leNom  avec bindParam</h1>';

                    $nom="Dup%";

                    $stmt = $pdo->prepare('SELECT * FROM personnes WHERE NOM like :leNom ');		// Préparation de la requête

                    $stmt->bindParam("leNom", $nom);												// Envoi du paramètre 1
                    $stmt->execute();																// Execution de la requête

                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $stmt->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $stmt->rowCount().' clients trouvé(s).';									// Nombre d'items retournés par la requete


                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */

        /*
                    // Exemple 6 - Requete préparées insert
                    echo '<h1>Exemple 6 - INSERT INTO CLIENT (NOM,PRENOM,PHOTO)</h1>';

                    $nom="NouveauNOM";
                    $prenom="NouveauPRENOM";
                    $photo="f034520-adef-4rtf-b931.jpg";


                    $stmt = $pdo->prepare('INSERT INTO personnes (NOM,PRENOM,PHOTO) VALUES (:leNom, :lePrenom, :laPhoto) ');		// Préparation de la requête

                    $stmt->bindParam("leNom", $nom);												// Envoi du paramètre 1
                    $stmt->bindParam("lePrenom", $prenom);											// Envoi du paramètre 2
                    $stmt->bindParam("laPhoto", $photo);											// Envoi du paramètre 3
                    $stmt->execute();																// Execution de la requête
                    echo "Id de l'enregistrment créé : ".$pdo->lastInsertId()."<br/>";

                    $IDEnregistrementCree=$pdo->lastInsertId() ; 									// On garde l'id pour le supprimer plus tard

                    // Réaffichage table après insertion
                    $requete="SELECT ID, NOM, PRENOM FROM personnes ORDER BY ID"  ;	// Définition de la requête
                    $resultats=$pdo->query($requete);  												// Execution de la requête

                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $resultats->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $resultats->rowCount().' clients trouvé(s).';								// Nombre d'items retournés par la requete


                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */

        /*
                    // ---------------------------------------------------------------------------
                    // Exemple 7 - Requete préparées update
                    echo "<h1>Exemple 7 - UPDATE CLIENT SET PRENOM='Albert Premier' WHERE ID = '1'</h1>";

                    $prenom="Albert Premier";

                    $stmt = $pdo->prepare("UPDATE personnes SET PRENOM = :lePrenom WHERE ID='1'");		// Préparation de la requête

                    $stmt->bindParam("lePrenom", $prenom);											// Envoi du paramètre 1

                    $stmt->execute();																// Execution de la requête


                    // Réaffichage table après insertion
                    $requete="SELECT ID, NOM, PRENOM FROM personnes ORDER BY ID"  ;	// Définition de la requête
                    $resultats=$pdo->query($requete);  												// Execution de la requête

                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $resultats->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $resultats->rowCount().' clients trouvé(s).';									// Nombre d'items retournés par la requete


                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */

        /*
                    // ---------------------------------------------------------------------------
                    // Exemple 8 - Requete préparées suppression
                    echo "<h1>Exemple 8 - DELETE FROM CLIENT WHERE ID = $IDEnregistrementCree</h1>";


                    $stmt = $pdo->prepare("DELETE FROM personnes WHERE ID = :ID");					// Préparation de la requête

                    $stmt->bindParam("ID", $IDEnregistrementCree);									// Envoi du paramètre 1

                    $stmt->execute();																// Execution de la requête


                    // Réaffichage table après insertion
                    $requete="SELECT ID, NOM, PRENOM FROM personnes ORDER BY ID"  ;	// Définition de la requête
                    $resultats=$pdo->query($requete);  												// Execution de la requête

                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $resultats->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $resultats->rowCount().' clients trouvé(s).';									// Nombre d'items retournés par la requete


                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */

        /*
                    // ---------------------------------------------------------------------------
                    // Exemple 9 - Injection de code
                    echo "<h1>Exemple 9 - Injection de code</h1>";

                    $prenom="Hervé";
                    //$prenom = "Jean';delete from personnes ; -- '" ;
                    $requete="select * from personnes where id = '$prenom'" ;

                    echo "Prenom=".$prenom."<br>";
                    echo "Requete=".$requete."<br>";

                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */


        // ---------------------------------------------------------------------------
        // Exemple 10 - Transactions et exécutions multiples
        /*
                    // Affichage table avant insertion
                    $requete="SELECT ID, NOM, PRENOM FROM personnes ORDER BY ID"  ;					// Définition de la requête
                    $resultats=$pdo->query($requete);  												// Execution de la requête
                    echo "<h1>AVANT INSERTION</h1>";
                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $resultats->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $resultats->rowCount().' clients trouvé(s).';								// Nombre d'items retournés par la requete


                    class Personne {			// Class personne
                        private $nom ;			// Propriété nom
                        private $prenom;		// Propriété Prénom
                        private $photo;			// Propriété photo

                        public function __construct($leNom, $lePrenom, $photo){		// Constructeur//
                            $this->nom=$leNom;
                            $this->prenom=$lePrenom;
                            $this->photo=$photo;
                        }
                        public function setNom($leNom) { 							// Setter Nom //
                            $this->nom=$leNom;
                        }
                        public function getNom() { 									// Getter Nom//
                            return $this->nom;
                        }
                        public function setPrenom($leNom) { 						// Setter Prénom//
                            $this->prenom=$leNom;
                        }
                        public function getPrenom() { 								// Getter //
                            return $this->prenom;
                        }
                        public function setPhoto($leNom) { 							// Setter //
                            $this->photo=$leNom;
                        }
                        public function getPhoto() { 								// Getter //
                            return $this->photo;
                        }
                    }
                    // Tableau personnes
                    $personnes[]=new Personne('Nom1','Prenom1','photo1.jpg');
                    $personnes[]=new Personne('Nom2','Prenom2','photo2.jpg');
                    $personnes[]=new Personne('Nom3','Prenom3','photo3.jpg');
                    //$personnes[]=new Personne('Nom4','Prenom4','12345678901234567890123456789012345.jpg');

                    try {
                        $pdo->beginTransaction();														// Début de la transaction

                        $stmt = $pdo->prepare('INSERT INTO personnes (NOM,PRENOM,PHOTO) VALUES (?, ?, ?) ');
                        foreach ($personnes as $personne) {
                            $stmt->execute([$personne->getNom(), $personne->getPrenom(), $personne->getPhoto() ]);
                        }
                        $pdo->commit();													// Commit si tout s'est bien passé
                    } catch (exception $e1) { 											// Une erreur est arrivée pendant l'exécution
                        $pdo->rollBack();												// Annulation de toute la transaction (plusieurs requetes)
                        echo "<br/>Erreur pendant les insertions ".$e1->getMessage();
                    }

                    // Réaffichage table après insertion
                    $requete="SELECT ID, NOM, PRENOM FROM personnes ORDER BY ID"  ;					// Définition de la requête
                    $resultats=$pdo->query($requete);  												// Execution de la requête
                    echo "<h1>APRES INSERTION</h1>";
                    echo "<table>" ;																// Début table
                        echo "<tr><td>No</td><td>ID</td><td>Nom</td><td>Prénom</td><tr>";			// Première ligne titre
                        $i=0;																		// Compteur de ligne
                        while( $ligne = $resultats->fetch() ) { 											// Parcours des lignes
                            $i++;																	// Incrémentation compteur de lignes
                            echo "<tr>";															// Début d'une ligne d'un tableau
                                echo "<td>".$i."</td>";												// Cellule compteur
                                echo "<td>".$ligne['ID']."</td>";									// Cellule ID
                                echo "<td>".$ligne['NOM']."</td>";									// Cellule Nom
                                echo "<td>".$ligne['PRENOM']."</td>";								// Cellule Prénom
                            echo "<tr>";															// Fin ligne
                        }
                    echo "</table>" ;																// Fin table
                    echo $resultats->rowCount().' clients trouvé(s).';									// Nombre d'items retournés par la requete


                    echo "<hr>";
                    echo "\n"; // Saut de ligne dans le HTML
        */
        // ---------------------------------------------------------------------------
        // Exemple 11 - Appel d'une fonction
        /*
                    // Code pour creer la fonction //
                    // delimiter //
                    // DROP procedure IF EXISTS combienDePersonnes //
                    // CREATE procedure combienDePersonnes()
                    // BEGIN
                        // DECLARE x INT;
                        // SET x = (select count(*) from personnes) ;
                        // SELECT x AS nbP;
                    // END; //
                    // call combienDePersonnes() //


                    // Appel fonction
                    $res = $pdo->query('call combienDePersonnes()')->fetchAll();							// Appel de la fonction
                    echo "<h1>Il y a ".$res[0]['nbP']." personne(s) dans la base de données</h1><br><br>";	// Récupération du nombre de personnes
        */
        // ---------------------------------------------------------------------------
        // Exemple 12 - Appel d'une procédure
        /*
                    // Code création procédure
                    // delimiter //
                    // DROP procedure IF EXISTS creerPersonne //
                    // CREATE procedure creerPersonne(IN nom varchar(35), IN prenom varchar(35), IN photo VARCHAR(35))
                    // BEGIN
                    // DECLARE ID INT;
                    // INSERT INTO personnes(NOM,PRENOM,PHOTO) VALUES(nom,prenom,photo) ;
                    // SET ID=(SELECT LAST_INSERT_ID());
                    // SELECT ID;
                    // END; //
                    // call  creerPersonne('NOM','PRENOM','PHOTO') //

                    echo "<h1>Insertion d'une personne(s) dans la base de données grace à la procédure stockée creerPersonne</h1><br><br>";


                    $stmt = $pdo->prepare('CALL creerPersonne( :nom, :prenom, :photo)');			// Prépare pour l'insertion

                    $nom="nom" ;
                    $prenom="prenom" ;
                    $photo="photo" ;
                    $resultat=null ;

                    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR); 								// Parametre 1
                    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);							// Parametre 2
                    $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);								// Parametre 3

                    $stmt->execute();																// Execution
                    $ID=$stmt->fetch()["ID"];															// Récupération de l'ID inséré

                    echo "<h1>Une personne a été insérée dans la table, ID = ".$ID."</h1><br><br>";
                    $stmt->closeCursor();

        */
    } catch (PDOException $e) {
        //Il y a eu une erreur
        echo "<h1>Erreur BD " . $e->getMessage();
    }

    ?>

    </body>
</html>