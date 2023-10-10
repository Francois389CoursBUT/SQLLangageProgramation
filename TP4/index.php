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
    // Connexion à la base de données
    $host="localhost"; //IP du serveur
    $db="mezabi3";     //Nom de la base de données
    $user="root";      //Nom de l'utilisateur
    $pass="root";      //Mot de passe de l'utilisateur
    $charset="utf8mb4";//Jeu de caractères utilisé par la base de données

    // Réglage des options
    $options=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false];

    $dns="mysql:host=$host;dbname=$db;charset=$charset";

    try {
        $pdo = new PDO($dns, $user, $pass, $options);
        echo "<h1>Connecté</h1>";

        echo "<h1> Etape 1 </h1>";

        $requete="SELECT * FROM clients";
        $resultat = $pdo->query($requete);


        echo "<table>";
        // En tete du tableau
        echo "<tr>";
        echo "    <th>ID_CLIENT</th>";
        echo "    <th>CODE_CLIENT</th>";
        echo "    <th>NOM_MAGASIN</th>";
        echo "    <th>ADRESSE_1</th>";
        echo "    <th>ADRESSE_2</th>";
        echo "    <th>CODE_POSTAL / VILLE</th>";
        echo "    <th>TELEPHONE</th>";
        echo "    <th>EMAIL</th>";
        echo "</tr>";
        while ($ligne = $resultat->fetch()) {
            echo "<tr>";
                echo "<td>".$ligne['ID_CLIENT']."</td>";
                echo "<td>".$ligne['CODE_CLIENT']."</td>";
                echo "<td>".$ligne['NOM_MAGASIN']."</td>";
                echo "<td>".$ligne['ADRESSE_1']."</td>";
                echo "<td>".$ligne['ADRESSE_2']."</td>";
                echo "<td>".$ligne['CODE_POSTAL']. $ligne['VILLE'] ."</td>";
                echo "<td>".$ligne['TELEPHONE']."</td>";
                echo "<td>".$ligne['EMAIL']."</td>";
            echo "</tr>";
        }
        echo "</table>";

    } catch (PDOException $e){
        echo "<h1>Connexion échouée</h1>";
    }
?>
    </body>
</html>
