<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>TP 5-Q3_TEST SQL dans un langage de programmation PDO</title>

        <!-- Bootstrap CSS -->
        <link href="../bootstrap-4.6.2-dist/css/bootstrap.css" rel="stylesheet">

        <!-- Lien vers mon CSS -->
        <link href="TP5-PDO.css" rel="stylesheet">
    </head>

    <body>
    <h1>Test du script de la question 3</h1>
    Tous les champs doivent être en rouge et bloquer l'enregistrement.
    <form method="post" action="TP5-PDO-Q3.php">
        <input type="hidden" name="codeClient" value="Le texte est long">
        <input type="hidden" name="nomMagasin" value="Le texte est trop trop trop trop long">
        <input type="hidden" name="responsable" value="">
        <input type="hidden" name="adresse1" value="Le texte est trop trop trop trop long">
        <input type="hidden" name="adresse2" value="Le texte est trop trop trop trop long">
        <input type="hidden" name="cdp" value="01ABCD">
        <input type="hidden" name="ville" value="Le texte est trop trop trop trop long">
        <input type="hidden" name="categorie" value="98">
        <input type="hidden" name="noTel" value="056565656565">
        <input type="hidden" name="mail" value="toto@@toto.com">
        <button type="submit" class="btn btn-primary " id="submit">Cliquer ici pour tester le script question 3</button>
    </form>
    </body>
</html>