<?php

namespace App\Modele;

use App\Utilitaire\Singleton_ConnexionPDO;
use PDO;

class Modele_Jeton
{
    public static function Insert($idUtilisateur, $codeAction = 1)
    {
        $octetsAleatoires = random_bytes(256);
        $jeton = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
            INSERT INTO token (valeur, codeAction, idUtilisateur, dateFin) 
            VALUES (:valeur, :codeAction, :idUtilisateur, :dateFin)
        ');

        $requetePreparee->bindValue(':valeur', $jeton);
        $requetePreparee->bindValue(':codeAction', $codeAction);
        $requetePreparee->bindValue(':idUtilisateur', $idUtilisateur);
        $requetePreparee->bindValue(':dateFin', $expiration);

        if ($requetePreparee->execute()) {
            return $jeton;
        }

        throw new \Exception("Échec de l'insertion du jeton.");
    }

    public static function Update($valeurJeton)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
            UPDATE token 
            SET codeAction = 0 
            WHERE valeur = :valeurJeton AND dateFin > NOW()'
        );

        $requetePreparee->bindParam(':valeurJeton', $valeurJeton);

        if (!$requetePreparee->execute()) {
            throw new \Exception("Échec de la mise à jour du jeton.");
        }
    }

    public static function Search($valeurJeton)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
            SELECT * FROM token 
            WHERE valeur = :valeurJeton AND dateFin > NOW()'
        );

        $requetePreparee->bindParam(':valeurJeton', $valeurJeton);
        $requetePreparee->execute();

        return $requetePreparee->fetch(PDO::FETCH_ASSOC);
    }
}