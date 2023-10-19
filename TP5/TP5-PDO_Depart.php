<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>TP 5 SQL dans un langage de programmation PDO</title>

        <!-- Bootstrap CSS -->
        <link href="bootstrap-4.6.2-dist/css/bootstrap.css" rel="stylesheet">

        <!-- Lien vers mon CSS -->
        <link href="TP5-PDO.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="col-12  cadre">
                <h1>Formulaire d'inscription</h1><br>
                <form method="post" action="TP5-PDO.php">
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
                                <option value="0">Choisir dans la liste</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
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
    </body>
</html>