<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>TP 5 SQL dans un langage de programmation PDO</title>

        <!-- Bootstrap CSS -->
        <link href="../bootstrap-4.6.2-dist/css/bootstrap.css" rel="stylesheet">

        <!-- Lien vers mon CSS -->
        <link href="TP5-PDO.css" rel="stylesheet">
    </head>
    <body>
    <?php

    /**
     * Fonction qui affiche une option dans un select
     * Si l'option est sélectionnée, on ajoute l'attribut selected
     * @param $value : valeur de l'option
     * @param $textDisplay : texte affiché dans l'option
     * @param $isSelected : booléen qui indique si l'option est sélectionnée
     */
    function afficherOption($value, $textDisplay, $isSelected = false)
    {
        echo '<option value="' . $value ;
        echo $isSelected ? '" selected>' :'">';
        echo $textDisplay . '</option>';
    }

    //Connexions à la BD
    $host = "localhost";
    $db = "mezabi3";
    $charset = "utf8mb4";
    $user = "root";
    $pwd = "root";

    $options=[
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false];

    $dns="mysql:host=$host;dbname=$db;charset=$charset";

    try {
        echo '<div class="container">';
        $pdo = new PDO($dns, $user, $pwd, $options);


    ?>

            <div class="col-12  cadre">
                <h1>Formulaire d'inscription</h1><br>
                <form method="post" action="TP5-PDO-Q1.php">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="codeClient">Code Client : </label>
                            <input type="text" name="codeClient" placeholder="Code client (maximum 15 caractères)"
                                   class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="nomMagasin">Nom magasin : </label>
                            <input type="text" name="nomMagasin" placeholder="Nom du magasin (maximum 35 caractères)"
                                   class="form-control" value="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="responsable">Nom du Responsable : </label>
                            <input type="text" name="responsable" placeholder="Nom du responsable (maximum 35 caractères)"
                                   class="form-control" value="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="adresse1">Adresse ligne 1 : </label>
                            <input type="text" name="adresse1" placeholder="Ligne d'adresse 1 (maximum 35 caractères)"
                                   class="form-control" value="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="adresse2">Adresse ligne 2 : </label>
                            <input type="text" name="adresse2" placeholder="Ligne d'adresse 2 (maximum 35 caractères)"
                                   class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="cdp">Code postal :</label>
                            <input type="text" name="cdp" placeholder="5 chiffres (Obligatoire)" class="form-control" value="">
                        </div>
                        <div class="form-group col-md-10">
                            <label for="ville">Ville : </label>
                            <input type="text" name="ville"
                                   placeholder="Taper votre bureau distributeur (maximum 35 caractères)" class="form-control"
                                   value="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="categorie">Catégorie : </label>
                            <select name="categorie" class="form-control">
                                <option value="choisi">Choisir dans la liste</option>
                                <?php
                                $requete = "SELECT * FROM c_types;";
                                $resultat = $pdo->query($requete);

                                while ($categorie = $resultat->fetch()) {
                                    afficherOption($categorie['CODE_TYPE'],$categorie['DESIGNATION'],false);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="noTel">Numéro de téléphone :</label>
                            <input type="text" name="noTel" placeholder="Format 0565656565" class="form-control" value="">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mail">Adresse Mail : </label>
                            <input type="text" name="mail" placeholder="Taper votre adresse E-mail" class="form-control"
                                   value="">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Valider le formulaire</button>
                    <br>
                </form>
            </div>
        </div>
    <?php
    } catch (PDOException $e) {
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