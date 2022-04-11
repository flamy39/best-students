<?php

require_once "./src/modele/dao/UserDao.php";
require_once "./src/modele/constants/ErrorCodes.php";
require_once "./src/modele/entities/User.php";
require_once "./src/modele/entities/Password.php";

class UpdatePasswordUser {
    private UserDao $userDao;

    /**
     * CreateUser constructor.
     */
    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function execute(string $login, string $actualPassword, string $newPassword, string $confirmNewPassword ) : int {

        $user = $this->userDao->findByLogin($login);
        if (!$user) {
            return ErrorCodes::LOGIN_INCORRECT;
        }

        if (!password_verify($actualPassword,$user->getActualPassword()->getPassword())) {
            return ErrorCodes::PASSWORD_INCORRECT;
        }

        if ($newPassword !== $confirmNewPassword) {
            return ErrorCodes::PASSWORD_CONFIRMATION_INCORRECT;
        }

        if (!$user->updatePassword($newPassword)) {
            return ErrorCodes::PASSWORD_ALREADY_USED;
        }

        // Modification dans la base de données
        $this->userDao->update($user);

        return ErrorCodes::OK;
    }
}