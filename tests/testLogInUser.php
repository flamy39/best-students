<?php

require_once "./src/usecases/LogInUser.php";
require_once "./src/modele/constants/ErrorCodes.php";

echo "UseCase : connexion de l'utilisateur" .PHP_EOL;
$login = readline("Entrer votre login : ");
$password = readline("Entrer votre mot de passe : ");

$logInUser = new LogInUser();
$res = $logInUser->execute($login,$password);

switch ($res) {
    case ErrorCodes::OK :
        echo "Vous êtes connecté !";
        break;
    case ErrorCodes::PASSWORD_INCORRECT:
    case ErrorCodes::LOGIN_INCORRECT :
        echo "Un problème d'authentifaction est survenu. Verifier votre login ou votre mot de passe;";
        break;
    case ErrorCodes::PASSWORD_EXPIRED:
        echo "Votre mot de passe est expiré. Veuillez le modifier";
        break;
}