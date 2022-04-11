<?php

require_once "src/modele/entities/User.php";

class LoginUserResult {
    private User $user;
    private int $errorCode;

    /**
     * @param User $user
     * @param int $errorCode
     */
    public function __construct(User $user, int $errorCode)
    {
        $this->user = $user;
        $this->errorCode = $errorCode;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
 }