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
 * Retourne la liste des clients présents dans la base de données
 * @param PDO $pdo : connexion à la base de données
 * @return array : liste des clients
 */
function getListeClientsFromBD(PDO $pdo): array
{
    $clients = array();
    $requete = "SELECT * FROM clients ORDER BY NOM_MAGASIN;";
    $resultat = $pdo->query($requete);

    while ($ligne = $resultat->fetch()) {
        $clients[$ligne['ID_CLIENT']] = $ligne;
    }
    return $clients;
}

function getDetailFacture(PDO $pdo, int $idFacture): array
{
    $requete = "SELECT a.DESIGNATION AS ARTICLE, c.DESIGNATION AS COULEUR, t.DESIGNATION AS TAILLE, l.QUANTITE, l.PRIX
                FROM factures_lignes l
                JOIN mezabi3.a_couleurs c on c.CODE_COULEUR = l.COULEUR
                Join mezabi3.a_tailles t on t.CODE_TAILLE = l.TAILLE
                JOIN mezabi3.articles a on a.ID_ARTICLE = l.ARTICLE
                WHERE ID_FCT = :idFacture;";
    $ligneFacture = array();
    $stmt = $pdo->prepare($requete);
    $stmt->bindValue(':idFacture', $idFacture, PDO::PARAM_INT);
    $stmt->execute();

    while ($ligne = $stmt->fetch()) {
        $ligneFacture[] = $ligne;
    }

    return $ligneFacture;
}

function getFactureFromClient(PDO $pdo, int $idClient): array
{
    $requete = "SELECT ID_ENT_FCT, DATE_FCT, NO_FCT
                FROM factures_entetes
                WHERE CLIENT = :idClient;";

    $factures = array();

    $stmt = $pdo->prepare($requete);
    $stmt->bindValue(':idClient', $idClient, PDO::PARAM_INT);
    $stmt->execute();

    while ($ligne = $stmt->fetch()) {
        $factures[] = $ligne;
    }

    return $factures;
}

/**
 * Affiche l'entete d'une facture dans un accordéon
 * @param array $lignesFacture : Le tableau resultant de la requete SQL contenant les entetes de facture
 */
function afficherEnteteAccordeon(array $lignesFacture, array $facture)
{
    echo '<div class="col-8 entete-accordeon">';
    echo 'Facture n&deg;' . $facture['NO_FCT'] . ' du ' . $facture['DATE_FCT'];
    echo '</div>';
    echo '<div class="col-2"></div>';
    echo '<div class="col-2 text-right entete-accordeon">';
    if (!empty($lignesFacture)) {
        $somme = 0;
        foreach ($lignesFacture as $ligne) {
            $somme += $ligne['PRIX'] * $ligne['QUANTITE'];
        }
        echo $somme . ' &euro;';
    } else {
        echo '- &euro;';
    }
    echo '</div>';
}