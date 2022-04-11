<?php

require_once "src/modele/entities/User.php";
require_once "src/modele/entities/Password.php";
require_once "src/usecases/UpdatePasswordUser.php";
require_once "src/modele/constants/ErrorCodes.php";

echo "UseCase : modification du mot de passe" .PHP_EOL;
$login = readline("Entrer votre login : ");
$actualPassword = readline("Entrer votre mot de passe actuel : ");
$newPassword = readline("Entrer votre nouveau mot de passe : ");
$confirmNewPassword = readline("Confirmer votre nouveau mot de passe : ");

$updatePassword = new UpdatePasswordUser();
$res = $updatePassword->execute($login,$actualPassword,$newPassword,$confirmNewPassword);
switch ($res) {
    case ErrorCodes::PASSWORD_INCORRECT:
    case ErrorCodes::LOGIN_INCORRECT :
        echo "Authentication incorrecte";
        break;
    case ErrorCodes::PASSWORD_CONFIRMATION_INCORRECT :
        echo "La confirmation du mot de passe ne correspond pas";
        break;
    case ErrorCodes::PASSWORD_ALREADY_USED :
        echo "Le mot de passe doit être différent du précédent";
        break;
    case ErrorCodes::OK :
        echo "La modification du mot de passe est effective";
        break;
}