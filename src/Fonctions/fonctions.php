<?php
namespace App\Fonctions;
    use PHPMailer\PHPMailer\PHPMailer;

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

    function passgen1($nbChar)
    {
        $chaine = "ABCDEFGHIJKLMONOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&é\"'(-è_çà)=$^*ù!:;,~#{[|`\^@]}¤€";
        $pass = '';
        for ($i = 0; $i < $nbChar; $i++) {
            $pass .= $chaine[random_int(0, strlen($chaine) - 1) % strlen($chaine)];
        }
        return $pass;
    }
    function envoyerMail($message) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = '127.0.0.1';
        $mail->Port = 1025; //Port non crypté
        $mail->SMTPAuth = false; //Pas d’authentification
        $mail->SMTPAutoTLS = false; //Pas de certificat TLS
        $mail->setFrom('admin@gmail.fr', 'admin');
        $mail->addAddress($_REQUEST["email"]);
        if ($mail->addReplyTo('test@labruleriecomtoise.fr', 'admin')) {
            $mail->Subject = 'Objet : Bonjour !';
            $mail->isHTML(false);
            $mail->Body = "Voici votre nouveau mot de passe : $message";

            if (!$mail->send()) {
                $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
            } else {
                $msg = 'Message envoyé ! Merci de nous avoir contactés.';
            }
        } else {
            $msg = 'Il doit manquer qqc !';
        }
        echo $msg;
    }

