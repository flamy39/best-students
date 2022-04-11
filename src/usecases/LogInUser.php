<?php

require_once "./src/modele/dao/UserDao.php";
require_once "./src/modele/constants/ErrorCodes.php";
require_once "./src/modele/entities/User.php";
require_once "./src/usecases/LoginUserResult.php";

class LogInUser {
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
     * @return LoginUserResult
     */
    public function execute(string $login, string $password) : LoginUserResult {
        // Recherche l'utilisateur avec le login
        $user = $this->userDao->findByLogin($login);

        if (!$user) {
            return new LoginUserResult($user,ErrorCodes::LOGIN_INCORRECT);
        }

       // Test si le mot de passe est expired
        if ($user->isPasswordExpired()) {
            return new LoginUserResult($user,ErrorCodes::PASSWORD_EXPIRED);
        }

        // L'utilisateur existe
        // Test si le mot de passe correspond
        if (!password_verify($password,$user->getActualPassword()->getPassword())) {
            return new LoginUserResult($user,ErrorCodes::PASSWORD_INCORRECT);
        }
        // Le mot de passe est correct
        return new LoginUserResult($user,ErrorCodes::OK);
    }
}