<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>DEMO PDO 1</title>

        <!-- Lien vers Bootstrap CSS -->
        <link href="../bootstrap-4.6.2-dist/css/bootstrap.css" rel="stylesheet">

        <!-- Lien vers mon CSS -->
        <link href="css/monStyle.css" rel="stylesheet">
    </head>

    <body>
<?php
    // Connexion à la base de données
    $host="localhost"; //IP du serveur
    $db="mezabi3";     //Nom de la base de donn&ées
    $user="root";      //Nom de l'utilisateur
    $pass="root";      //Mot de passe de l'utilisateur
    $charset="utf8mb4";//Jeu de caractères utilisé par la base de données

    // R&eacute;glage des options
    $options=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false];

    $dns="mysql:host=$host;dbname=$db;charset=$charset";

    try {
        echo '<div class="container-fluid">';
        $pdo = new PDO($dns, $user, $pass, $options);
        echo "<h1>Connect&eacute;</h1>";

        echo "<h1> Etape 1 </h1>";

        $requete="SELECT * FROM clients";
        $resultat = $pdo->query($requete);

        echo "<div class='row'>";


        echo '<table class="table table-striped">';
        // En tete du tableau
        echo "<tr>";
        echo '    <th scope="col">ID_CLIENT</th>';
        echo '    <th scope="col">CODE_CLIENT</th>';
        echo '    <th scope="col">NOM_MAGASIN</th>';
        echo '    <th scope="col">ADRESSE_1</th>';
        echo '    <th scope="col">ADRESSE_2</th>';
        echo '    <th scope="col">CODE_POSTAL / VILLE</th>';
        echo '    <th scope="col">TELEPHONE</th>';
        echo '    <th scope="col">EMAIL</th>';
        echo "</tr>";
        while ($ligne = $resultat->fetch()) {
            echo "<tr>";
                echo "<td>".$ligne['ID_CLIENT']."</td>";
                echo "<td>".$ligne['CODE_CLIENT']."</td>";
                echo "<td>".$ligne['NOM_MAGASIN']."</td>";
                echo "<td>".$ligne['ADRESSE_1']."</td>";
                echo "<td>".$ligne['ADRESSE_2']."</td>";
                echo "<td>".$ligne['CODE_POSTAL']." ". $ligne['VILLE'] ."</td>";
                echo "<td>".$ligne['TELEPHONE']."</td>";
                echo "<td>".$ligne['EMAIL']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";

//======================================================================================================================
//======================================================================================================================

        echo "<h1> &Eacute;tape 2 </h1>";

        /**
         * Affiche une vignette avec les informations du client
         * La vignette est responsive
         * @param $id
         * @param $codeClient
         * @param $nomMagasin
         * @param $adresse1
         * @param $adresse2
         * @param $codePostaleVille
         * @param $telephone
         * @param $email
         */
        function vignette($id, $codeClient, $nomMagasin, $adresse1, $adresse2, $codePostaleVille, $telephone, $email) {
            echo '<div class="col-md-4 col-sm-6 col-12 vignette">';
                echo '<div class="">';
                    echo '<h5>'.$nomMagasin.'</h5>';
                    echo '<strong>ID : </strong>'.$id.'<br>';
                    echo '<strong>Code client : </strong>'.$codeClient.'<br>';
                    echo '<strong>Adresse : </strong>'.$adresse1.'<br>';
                    echo '<strong>Adresse 2 : </strong>'.$adresse2.'<br>';
                    echo '<strong>Code postal / Ville : </strong>'.$codePostaleVille.'<br>';
                    echo '<strong>T&eacute;l&eacute;phone : </strong>'.$telephone.'<br>';
                    echo '<strong>Email : </strong>'.$email.'<br>';
                echo '</div>';
            echo '</div>';
        }

        $requete="SELECT * FROM clients";
        $resultat = $pdo->query($requete);

        echo '<div class="row">';
        while ($ligne = $resultat->fetch()) {
            vignette($ligne['ID_CLIENT'], $ligne['CODE_CLIENT'], $ligne['NOM_MAGASIN'], $ligne['ADRESSE_1'], $ligne['ADRESSE_2'], $ligne['CODE_POSTAL']. $ligne['VILLE'], $ligne['TELEPHONE'], $ligne['EMAIL']);
        }
        echo '</div>';
        echo '</div>';

    } catch (PDOException $e){
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 centrer">
                    <h1>Connexion &eacute;chou&eacute;e</h1>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                    <p>
                        Nous rencontrons actuellement des probl&egrave;mes de connexion &agrave; la base de donn&eacute;es.
                        <br>
                        Veuillez nous excuser pour la g&ecirc;ne occasionn&eacute;e.
                        <br>
                        Revenez plus tard.
                    </p>
                </div>
                <div class="col-4"></div>
            </div>
        </div>
            <?php
    }
?>
    </body>
</html>
