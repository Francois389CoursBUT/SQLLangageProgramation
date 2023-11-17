<?php
/**
 * Fonction qui affiche une option dans un select
 * Si l'option est s�lectionn�e, on ajoute l'attribut selected
 * @param $value : valeur de l'option
 * @param $textDisplay : texte affich� dans l'option
 * @param $isSelected : bool�en qui indique si l'option est s�lectionn�e
 */
function afficherOption($value, $textDisplay, $isSelected = false)
{
    echo '<option value="' . $value;
    echo $isSelected ? '" selected>' : '">';
    echo $textDisplay . '</option>';
}

/**
 * @param PDO $pdo
 * @return false|PDOStatement
 */
function getListeCategorieFromBD(PDO $pdo): array
{
    $categories = array();
    $requete = "SELECT * FROM c_types ORDER BY DESIGNATION;";
    $resultat = $pdo->query($requete);

    while ($ligne = $resultat->fetch()) $categories[$ligne['CODE_TYPE']] = $ligne['DESIGNATION'];

    return $categories;
}

/**
 * @param string $dns
 * @param string $user
 * @param string $pwd
 * @param array $options
 * @return PDO
 */
function getPDO(string $dns, string $user, string $pwd, array $options): PDO
{
    return new PDO($dns, $user, $pwd, $options);
}

/**
 * Retourne la liste des clients pr�sents dans la base de donn�es
 * @param PDO $pdo : connexion � la base de donn�es
 * @return array : liste des clients
 */
function getListeClientsFromBD(PDO $pdo) :array
{
    $clients = array();
    $requete = "SELECT * FROM clients ORDER BY NOM_MAGASIN;";
    $resultat = $pdo->query($requete);

    while ($ligne = $resultat->fetch()) {
        $clients[$ligne['ID_CLIENT']] = $ligne;
    }
    return $clients;
}