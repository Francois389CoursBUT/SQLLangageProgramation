<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>TP 5 SQL dans un langage de programmation PDO</title>

        <!-- JQuery -->
        <script src="../JQuery-3.7.1/jquery-3.7.1.js" defer></script>

        <!-- Bootstrap -->
        <link href="../bootstrap-4.6.2-dist/css/bootstrap.css" rel="stylesheet">
        <script src="../bootstrap-4.6.2-dist/js/bootstrap.js" defer></script>

        <!-- Lien vers mon CSS -->
        <link href="TP5-PDO.css" rel="stylesheet">

        <script src="script.js" defer></script>
    </head>
    <body>
    <div class="container">
        <?php

        include("fonctions.php");

        /**
         * Fonction qui affoche un label et une saisie de texte
         * @param string $label : texte du label
         * @param string $placeholder : texte qui s'affiche dans la zone de saisie
         * @param string $nomArgPOST : nom de l'argument POST qui contiendra la saisie
         * @return void
         */
        function afficherSaisieTexte(string $label, string $placeholder, string $nomArgPOST, string $colonneBD)
        {
            global $champsValide, $modeModification, $clientAModifier;
            echo '<label for="' . $nomArgPOST . '" ';
            if (!$champsValide['responsable'] && !$modeModification) echo 'class="enRouge"';
            echo '>' . $label . '</label>';

            echo '<input type="text" name="' . $nomArgPOST . '" id="' . $nomArgPOST . '" placeholder="' . $placeholder . '" class="form-control" ';
            if ($modeModification) {
                echo 'value="' . $clientAModifier[$colonneBD] . '">';
            } else if (isset($_POST['responsable'])) {
                echo 'value="' . $_POST['responsable'] . '">';
            } else {
                echo 'value="">';
            }
        }

        function afficheLigneFacture($ligne)
        {
            echo '<tr>';
            echo '<th scope="col">' . $ligne['ARTICLE'] . '</th>';
            echo '<th scope="col">' . $ligne['COULEUR'] . '</th>';
            echo '<th scope="col">' . $ligne['TAILLE'] . '</th>';
            echo '<th scope="col">' . $ligne['QUANTITE'] . '</th>';
            echo '<th scope="col">' . $ligne['PRIX'] . '€</th>';
            echo '<th scope="col">' . $ligne['PRIX'] * $ligne['QUANTITE'] . '&euro;</th>';
            echo '</tr>';
        }

        $insertionClient = "INSERT INTO clients (CODE_CLIENT, NOM_MAGASIN, RESPONSABLE, ADRESSE_1, ADRESSE_2, CODE_POSTAL, VILLE, TYPE_CLIENT, TELEPHONE, EMAIL) VALUES (:codeClient, :nomMagasin, :responsable, :adresse1, :adresse2, :cdp, :ville, :categorie, :noTel, :mail);";
        $updateClient = "UPDATE clients SET CODE_CLIENT = :codeClient, NOM_MAGASIN = :nomMagasin, RESPONSABLE = :responsable, ADRESSE_1 = :adresse1, ADRESSE_2 = :adresse2, CODE_POSTAL = :cdp, VILLE = :ville, TYPE_CLIENT = :categorie, TELEPHONE = :noTel, EMAIL = :mail WHERE ID_CLIENT = :idClient;";

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




        try {
            $pdo = getPDO($dns, $user, $pwd, $options);

            $categories = getListeCategorieFromBD($pdo);
            $clients = getListeClientsFromBD($pdo);

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
                && in_array($_POST['categorie'], array_keys($categories));

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

            //Client à modifier
            $modeModification = isset($_POST['cleClient']) && $_POST['cleClient'] != 'none'
                && in_array($_POST['cleClient'], array_keys($clients));
            $clientAModifier = null;
            if ($modeModification) {
                $clientAModifier = $clients[$_POST['cleClient']];
                $enteteFacture = getFactureFromClient($pdo, $_POST['cleClient']);
            }


            // var_dump($champsValide);
            if (!$toutChampsValide) {
                ?>
                <div class="row">
                    <!-- Modification de client -->
                    <div class="col-12 cadre">
                        <h1>Modifier un client</h1>
                        <form method="post" action="TP5-PDO-Q3.php" id="formModifierClient">
                            <div class="form-row">
                                <div class="form-group col-12">

                                    <label for="selectionClientAModifier">Selectionner un client à modifier </label><br>
                                    <select name="cleClient" class="form-control select-modifier"
                                            id="selectionClientAModifier">
                                        <option class="en-vert" value="none">Cr&eacute;er un nouveau client</option>
                                        <optgroup label="Client existant">
                                            <?php
                                            foreach ($clients as $idClient => $client) {
                                                afficherOption($idClient, $client['NOM_MAGASIN'], isset($_POST['cleClient']) && $_POST['cleClient'] == $idClient);
                                            }
                                            ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Formulaire d'inscription -->
                    <div class="col-12  cadre">
                        <?php
                        if ($modeModification) {
                            echo '<h1>Modification du client : ' . $clientAModifier['NOM_MAGASIN'] . '</h1>';
                        } else {
                            echo '<h1>Formulaire d\'inscription</h1>';
                        }
                        ?>
                        <br>
                        <form method="post" action="TP5-PDO-Q3.php">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <?php afficherSaisieTexte("Code client : ", "Code client (maximum 15 caractères)", "codeClient", 'CODE_CLIENT'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <?php afficherSaisieTexte("Nom magasin : ", "Nom du magasin (maximum 35 caractères)", "nomMagasin", "NOM_MAGASIN"); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <?php afficherSaisieTexte("Nom du responsable : ", "Nom du responsable (maximum 35 caractères)", "responsable", "RESPONSABLE"); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <?php afficherSaisieTexte("Adresse ligne 1 : ", "Ligne d'adresse 1 (maximum 35 caractères)", "adresse1", "ADRESSE_1"); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <?php afficherSaisieTexte("Adresse ligne 2 : ", "Ligne d'adresse 2 (maximum 35 caractères)", "adresse2", "ADRESSE_2"); ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <?php afficherSaisieTexte("Code postal : ", "5 chiffres (Obligatoire)", "cdp", "CODE_POSTAL"); ?>
                                </div>
                                <div class="form-group col-md-10">
                                    <?php afficherSaisieTexte("Ville : ", "Saisissez votre bureau distributeur (maximum 35 caractères)", "ville", "VILLE"); ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="categorie"
                                    <?php
                                    if (!$champsValide['categorie'] && !$modeModification) echo 'class="enRouge"';
                                    echo '>Catégorie : </label>'
                                    ?>
                                    <select name="categorie" class="form-control" id="categorie">

                                        <option value="none">Choisir dans la liste</option>
                                        <?php
                                        foreach ($categories as $codeType => $designation) {
                                            $ligneEstSelectionner = (isset($_POST['categorie']) && $_POST['categorie'] == $codeType)
                                                || ($modeModification && $clientAModifier['TYPE_CLIENT'] == $codeType);
                                            afficherOption($codeType, $designation, $ligneEstSelectionner);
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <?php afficherSaisieTexte("Numéro de téléphone : ", "Format 0565656565", "noTel", "TELEPHONE"); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <?php afficherSaisieTexte("Adresse mail : ", "Saisissez votre adresse E-mail", "mail", "EMAIL"); ?>
                                </div>
                            </div>
                            <?php if ($modeModification) { ?>
                                <input hidden name="cleClient" value="<?php echo $_POST['cleClient'] ?>">
                            <?php } ?>
                            <button type="submit" class="btn btn-primary btn-block">Valider le formulaire</button>
                            <br>
                        </form>
                    </div>

                    <!-- Liste des factures -->
                    <?php
                    if ($modeModification) {
                        ?>
                        <div class="col-12 cadre">
                            <h1>Liste des factures de <?php echo $clientAModifier['NOM_MAGASIN'] ?></h1>
                            <?php
                            if (!empty($enteteFacture)) {
                                ?>
                                <div class="accordion" id="accordionExample">
                                    <?php
                                    $estPremier = true;
                                    foreach ($enteteFacture as $facture) {
                                        $lignesFacture = getDetailFacture($pdo, $facture['ID_ENT_FCT']);
                                        $numeroFacture = $facture['NO_FCT'];
                                        ?>
                                        <div class="card">
                                            <!-- Entete de l'accordeon -->
                                            <div class="card-header" id="headingOne">
                                                <div class="row" type="button" data-toggle="collapse"
                                                     data-target="#collapse<?php echo $numeroFacture ?>"
                                                     aria-expanded="true"
                                                     aria-controls="collapse<?php echo $numeroFacture ?>">
                                                    <?php
                                                        afficherEnteteAccordeon($lignesFacture, $facture);
                                                        ?>
                                                </div>
                                            </div>

                                            <!-- Contenu de l'accordeon -->
                                            <div id="collapse<?php echo $numeroFacture ?>"
                                                 class="collapse <?php if ($estPremier) echo "show" ?>"
                                                 aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="pas-de-padding card-body">
                                                    <?php
                                                    if (empty($lignesFacture)) {
                                                        echo 'Pas de détail pour cette facture';
                                                    } else {
                                                        ?>
                                                        <table class="table table-striped">
                                                            <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">Articles</th>
                                                                <th scope="col">Couleur</th>
                                                                <th scope="col">Taille</th>
                                                                <th scope="col">Quantit&eacute;</th>
                                                                <th scope="col">Prix Unitaire</th>
                                                                <th scope="col">Prix Total</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            foreach ($lignesFacture as $ligne) {
                                                                afficheLigneFacture($ligne);
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $estPremier = false;
                                    }
                                    ?>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="centrer-texte">Pas de facture pour <?php echo $clientAModifier['NOM_MAGASIN'] ?></h3>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                echo '<div class="row">';
                echo '<div class="col-12 cadre">';

                //Modification dans la base de donnée
                if (isset($_POST['cleClient'])) {
                    $requeteModification = $pdo->prepare($updateClient);

                    $requeteModification->bindParam(':codeClient', $_POST['codeClient']);
                    $requeteModification->bindParam(':nomMagasin', $_POST['nomMagasin']);
                    $requeteModification->bindParam(':responsable', $_POST['responsable']);
                    $requeteModification->bindParam(':adresse1', $_POST['adresse1']);
                    $requeteModification->bindParam(':adresse2', $_POST['adresse2']);
                    $requeteModification->bindParam(':cdp', $_POST['cdp']);
                    $requeteModification->bindParam(':ville', $_POST['ville']);
                    $requeteModification->bindParam(':categorie', $_POST['categorie']);
                    $requeteModification->bindParam(':noTel', $_POST['noTel']);
                    $requeteModification->bindParam(':mail', $_POST['mail']);
                    $requeteModification->bindParam(':idClient', $_POST['cleClient']);

                    $requeteModification->execute();

                    echo '<h1 class="centrer-texte">Modification dans la base de donn&eacute;e effectu&eacute;</h1>';

                    echo '<div class="row">';
                    echo '<div class="col-5 centrer-texte">';
                    echo '<h3>Nombre de lignes modifi&eacute; ' . $requeteModification->rowCount() . '</h3>';
                    echo '</div>';

                    echo '<div class="col-7 centrer-texte">';
                    echo '<h3>Identifiant d\'enregistrment modifi&eacute; : ' . $_POST['cleClient'] . '</h3>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    //Insertion dans la base de donnée
                    $requeteInsertion = $pdo->prepare($insertionClient);
                    $requeteInsertion->execute($_POST);
                    echo '<h1 class="centrer-texte">Insertion dans la base de donn&eacute;e effectu&eacute;</h1></br>';
                    echo '<div class="row">';
                    echo '<div class="col-12 centrer-texte">';
                    echo '<p>Identifiant d\'enregistrment cr&eacute;e : ' . $pdo->lastInsertId();
                    echo '</div>';
                    echo '</div>';
                }
                ?>
                <div class="col-12">
                    <a href="TP5-PDO-Q3.php" class="btn btn-primary btn-block">Retour au formulaire</a>
                </div>
                <?php
                echo '</div>';
                echo '</div>';

            }

        } catch (PDOException $e) {
            ?>
            <div class="row">
                <div class="col-12 centrer">
                    <h1>Connexion &eacute;chou&eacute;e</h1>
                </div>
                <div class="col-12">
                    <p>
                        Nous rencontrons actuellement des probl&egrave;mes de connexion &agrave; la base de donn&eacute;es.
                        <br>
                        Veuillez nous excuser pour la g&ecirc;ne occasionn&eacute;e.
                        <br>
                        Revenez plus tard.
                    </p>
                </div>
            </div>

            <?php
            var_dump($e);
        } // Fin du catch
        ?>
    </div>
    </body>
</html>