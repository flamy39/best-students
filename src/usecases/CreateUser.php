<?php

require_once "./src/modele/dao/UserDao.php";
require_once "./src/modele/entities/User.php";
require_once "./src/modele/entities/Password.php";
require_once "./src/modele/constants/ErrorCodes.php";

class CreateUser {

    private UserDao $userDao;

    /**
     * CreateUser constructor.
     */
    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    /**
     * @param string $login
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @return int
     */
        public function execute(string $login, string $password, string $firstname, string $lastname, string $email) : int {
        // Recherche si le login est présent dans la table
        $user = $this->userDao->findByLogin($login);
        if ($user) {
            return ErrorCodes::LOGIN_ALREADY_USED;
        }
        // Hash du mot de passe
        $passwordHash = password_hash($password,PASSWORD_ARGON2I);
        $passwordObject = new Password($passwordHash);

        // Création de l'utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setLogin($login);
        $user->setFirstName($firstname);
        $user->setLastName($lastname);
        $user->setActualPassword($passwordObject);

        // Création de l'utilisateur dans la base de données
        $this->userDao->create($user);
        return ErrorCodes::OK;
    }
}