<?php
namespace App\Fonctions;
    function Redirect_Self_URL():void{
        unset($_REQUEST);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

function GenereMDP($nbChar) :string{

    return "secret";
}

    function CalculComplexiteMdp(string $motDePasse): int
    {
        $longueur = strlen($motDePasse);
        $tailleJeuCaracteres = 0;

// Détection des types de caractères dans le mot de passe
        if (preg_match('/[a-z]/', $motDePasse)) {
            $tailleJeuCaracteres += 26; // Lettres minuscules
        }
        if (preg_match('/[A-Z]/', $motDePasse)) {
            $tailleJeuCaracteres += 26; // Lettres majuscules
        }
        if (preg_match('/[0-9]/', $motDePasse)) {
            $tailleJeuCaracteres += 10; // Chiffres
        }
        if (preg_match('/[^a-zA-Z0-9]/', $motDePasse)) {
            $tailleJeuCaracteres += 32; // Symboles (approximé)
        }

// Calcul de l'entropie en bits
        $entropie = $longueur * log($tailleJeuCaracteres, 2);

        return (int)round($entropie);
    }

