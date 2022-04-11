<?php

require_once "src/modele/entities/User.php";
require_once "src/modele/entities/Password.php";
require_once "src/usecases/CreateUser.php";
require_once "src/modele/constants/ErrorCodes.php";

echo "UseCase : création d'un utilisateur" .PHP_EOL;
$login = readline("Entrer votre login : ");
$password = readline("Entrer votre mot de passe : ");
$firstname = readline("Entrer votre prénom : ");
$lastname = readline("Entrer votre nom : ");
$email = readline("Entrer votre email : ");

$createUser = new CreateUser();
$res = $createUser->execute($login,$password,$firstname,$lastname,$email);
if ($res === ErrorCodes::OK) {
    echo "Votre compte a bien été créé.";
} else {
    echo "Un utilisateur avec le même login existe déjà.";
}