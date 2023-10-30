<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>TP 5 SQL dans un langage de programmation PDO</title>

        <!-- Bootstrap CSS -->
        <link href="../bootstrap-4.6.2-dist/css/bootstrap.css" rel="stylesheet">

        <!-- Lien vers mon CSS -->
        <link href="TP5-PDO.css" rel="stylesheet">

        <script src="script.js" defer></script>
    </head>
    <body>
    <?php

    include("fonctions.php");

    $insertionClient = "INSERT INTO clients (CODE_CLIENT, NOM_MAGASIN, RESPONSABLE, ADRESSE_1, ADRESSE_2, CODE_POSTAL, VILLE, TYPE_CLIENT, TELEPHONE, EMAIL) VALUES (:codeClient, :nomMagasin, :responsable, :adresse1, :adresse2, :cdp, :ville, :categorie, :noTel, :mail);";



    //Connexions à la BD
    $host = "localhost";
    $db = "mezabi3";
    $charset = "utf8mb4";
    $user = "root";
    $pwd = "root";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false];

    $dns = "mysql:host=$host;dbname=$db;charset=$charset";

    echo '<div class="container">';

    try {
        $pdo = getPDO($dns, $user, $pwd, $options);

        $categories = getListeCategorieFromBD($pdo);

        //Vérification des entrées
        $champsValide = array();

        //Test de la validité des champs
        //Code client
        $champsValide['codeClient'] = isset($_POST['codeClient']) && $_POST['codeClient'] != ""
            && strlen($_POST['codeClient']) <= 15;

        //Nom magasin
        $champsValide['nomMagasin'] = isset($_POST['nomMagasin']) && $_POST['nomMagasin'] != ""
            && strlen($_POST['nomMagasin']) <= 35;

        //Responsable
        $champsValide['responsable'] = isset($_POST['responsable']) && $_POST['responsable'] != ""
            && strlen($_POST['responsable']) <= 35;

        //Adresse 1
        $champsValide['adresse1'] = isset($_POST['adresse1']) && $_POST['adresse1'] != ""
            && strlen($_POST['adresse1']) <= 35;

        //Adresse 2
        $champsValide['adresse2'] = isset($_POST['adresse2']) && $_POST['adresse2'] != ""
            && strlen($_POST['adresse2']) <= 35;

        //Code postal
        $champsValide['cdp'] = isset($_POST['cdp']) && $_POST['cdp'] != ""
            && preg_match("/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/", $_POST['cdp']);

        //Ville
        $champsValide['ville'] = isset($_POST['ville']) && $_POST['ville'] != ""
            && strlen($_POST['adresse1']) <= 35;

        //Catégorie
        $champsValide['categorie'] = isset($_POST['categorie']) && $_POST['categorie'] != 'none'
            && 1 <= $_POST['categorie'] && $_POST['categorie'] <= sizeof($categories);

        //Numéro de téléphone
        $champsValide['noTel'] = isset($_POST['noTel']) && $_POST['noTel'] != ""
            && preg_match("/^[0-9]{10}$/", $_POST['noTel']);

        //Adresse mail
        $champsValide['mail'] = isset($_POST['mail']) && $_POST['mail'] != ""
            && filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL);

        //Traitement des saisie avec htmlentities()
        foreach ($_POST as $cle => $valeur) {
            $_POST[$cle] = htmlentities($valeur);
        }

        $toutChampsValide = true;
        foreach ($champsValide as $champs => $valeur) {
            $toutChampsValide &= $valeur;
        }
//        var_dump($champsValide);
        if (!$toutChampsValide) {
            ?>

            <div class="col-12  cadre">
                <h1>Formulaire d'inscription</h1><br>
                <form method="post" action="TP5-PDO-Q3.php">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="codeClient"
                            <?php
                            if (!$champsValide['codeClient']) echo 'class="enRouge"';
                            echo '>Code Client : </label>'
                            ?>

                            <input type="text" id="codeClient" name="codeClient" placeholder="Code client (maximum 15 caractères)"
                                   class="form-control"
                            <?php
                            if (isset($_POST['codeClient'])) {
                                echo 'value="' . $_POST['codeClient'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="nomMagasin"
                            <?php
                            if (!$champsValide['nomMagasin']) echo 'class="enRouge"';
                            echo '>Nom magasin : </label>'
                            ?>
                            <input type="text" name="nomMagasin" id="nomMagasin" placeholder="Nom du magasin (maximum 35 caractères)"
                                   class="form-control"
                            <?php
                            if (isset($_POST['nomMagasin'])) {
                                echo 'value="' . $_POST['nomMagasin'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="responsable"
                            <?php
                            if (!$champsValide['responsable']) echo 'class="enRouge"';
                            echo '>Nom du Responsable : </label>'
                            ?>

                            <input type="text" name="responsable" id="responsable"
                                   placeholder="Nom du responsable (maximum 35 caractères)"
                                   class="form-control"
                            <?php
                            if (isset($_POST['responsable'])) {
                                echo 'value="' . $_POST['responsable'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="adresse1"
                            <?php
                            if (!$champsValide['adresse1']) echo 'class="enRouge"';
                            echo '>Adresse ligne 1 : </label>'
                            ?>
                            <input type="text" name="adresse1" id="adresse1" placeholder="Ligne d'adresse 1 (maximum 35 caractères)"
                                   class="form-control"
                            <?php
                            if (isset($_POST['adresse1'])) {
                                echo 'value="' . $_POST['adresse1'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="adresse2"
                            <?php
                            if (!$champsValide['adresse2']) echo 'class="enRouge"';
                            echo '>Adresse ligne 2 : </label>'
                            ?>
                            <input type="text" name="adresse2" id="adresse2"
                                   placeholder="Ligne d'adresse 2 (maximum 35 caractères)"
                                   class="form-control"
                            <?php
                            if (isset($_POST['adresse2'])) {
                                echo 'value="' . $_POST['adresse2'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="cdp"
                            <?php
                            if (!$champsValide['cdp']) echo 'class="enRouge"';
                            echo '>Code postal :</label>'
                            ?>
                            <input type="text" name="cdp" id="cdp"
                                   placeholder="5 chiffres (Obligatoire)" class="form-control"
                            <?php
                            if (isset($_POST['cdp'])) {
                                echo 'value="' . $_POST['cdp'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                        <div class="form-group col-md-10">
                            <label for="ville"
                            <?php
                            if (!$champsValide['ville']) echo 'class="enRouge"';
                            echo '>Ville : </label>'
                            ?>
                            <input type="text" name="ville" id="ville"
                                   placeholder="Taper votre bureau distributeur (maximum 35 caractères)"
                                   class="form-control"
                            <?php
                            if (isset($_POST['ville'])) {
                                echo 'value="' . $_POST['ville'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="categorie"
                            <?php
                            if (!$champsValide['categorie']) echo 'class="enRouge"';
                            echo '>Catégorie : </label>'
                            ?>
                            <select name="categorie" class="form-control" id="categorie">

                                <option value="none">Choisir dans la liste</option>
                                <?php
                                foreach ($categories as $codeType => $designation) {
                                    afficherOption($codeType, $designation, $_POST['categorie'] == $codeType);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="noTel"
                            <?php
                            if (!$champsValide['noTel']) echo 'class="enRouge"';
                            echo '>Numéro de téléphone :</label>'
                            ?>
                            <input type="text" name="noTel" id="noTel"
                                   placeholder="Format 0565656565" class="form-control"
                            <?php
                            if (isset($_POST['noTel'])) {
                                echo 'value="' . $_POST['noTel'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mail"
                            <?php
                            if (!$champsValide['mail']) echo 'class="enRouge"';
                            echo '>Adresse Mail : </label>'
                            ?>
                            <input type="text" name="mail" id="mail" placeholder="Taper votre adresse E-mail" class="form-control"
                            <?php
                            if (isset($_POST['mail'])) {
                                echo 'value="' . $_POST['mail'] . '">';
                            } else echo 'value="">'
                            ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Valider le formulaire</button>
                    <br>
                </form>
            </div>
            </div>
            <?php
        } else {
            //TODO Insérer les donnée dans la table

            $requeteInsertion = $pdo->prepare($insertionClient);
            $requeteInsertion->execute($_POST);

            echo '<div class="row">';
            echo '<p>Insertion dans la base de donnée effectuée</p></br>';
            echo '<p>Identifiant d\'enregistrment crée : ' . $pdo->lastInsertId();
            echo '</div>';
        }


    } catch (PDOException $e) {
        ?>
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
    } // Fin du catch
    ?>
    </body>
</html>