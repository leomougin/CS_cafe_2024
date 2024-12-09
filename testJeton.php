<?php

require_once './vendor/autoload.php';

use App\Modele\Modele_Jeton;

$idUtilisateur = 1;

try {
    echo "Test Insert...\n";
    $nouveauJeton = Modele_Jeton::Insert($idUtilisateur);
    echo "Succès : Jeton généré : $nouveauJeton\n\n";
} catch (Exception $e) {
    echo "Échec de l'insertion du jeton - " . $e->getMessage() . "\n\n";
}

try {
    echo "Test Search...\n";
    $resultatRecherche = Modele_Jeton::Search($nouveauJeton);
    if ($resultatRecherche) {
        echo "Succès : Jeton trouvé : " . print_r($resultatRecherche, true) . "\n\n";
    } else {
        echo "Aucun jeton valide trouvé pour : $nouveauJeton\n\n";
    }
} catch (Exception $e) {
    echo "Échec de la recherche du jeton - " . $e->getMessage() . "\n\n";
}

try {
    echo "Test Update...\n";
    Modele_Jeton::Update($nouveauJeton);
    echo "Succès : Jeton mis à jour : $nouveauJeton\n\n";
} catch (Exception $e) {
    echo "Échec de la mise à jour du jeton - " . $e->getMessage() . "\n\n";
}