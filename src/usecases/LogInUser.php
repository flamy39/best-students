<?php

require_once "./src/modele/dao/UserDao.php";
require_once "./src/modele/constants/ErrorCodes.php";

class LogInUser {
    private UserDao $userDao;

    /**
     * CreateUser constructor.
     */
    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function execute(string $login, string $password) : int {
        // Recherche l'utilisateur avec le login
        $user = $this->userDao->findByLogin($login);

        if (!$user) {
            return ErrorCodes::LOGIN_INCORRECT;
        }

       // Test si le mot de passe est expired
        if ($user->isPasswordExpired()) {
            return ErrorCodes::PASSWORD_EXPIRED;
        }

        // L'utilisateur existe
        // Test si le mot de passe correspond
        if (!password_verify($password,$user->getActualPassword()->getPassword())) {
            return ErrorCodes::PASSWORD_INCORRECT;
        }
        // Le mot de passe est correct
        return ErrorCodes::OK;
    }
}