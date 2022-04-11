<?php

class User {
    private int $id;
    private string $login;
    private Password $actualPassword;
    private string $firstName;
    private string $lastName;
    private string $email;

    /**
     * User constructor.
     */
    public function __construct()
    {}

    /**
     * @return bool
     */
    public function isPasswordExpired() : bool {
        $dateLimit = new DateTime("-4 months");
        return $this->getActualPassword()->getCreationDate() < $dateLimit;
    }

    public function updatePassword(string $newPassword) : bool {

        if (password_verify($newPassword,$this->actualPassword->getPassword())) {
            echo "Le mot de passe est le même" .PHP_EOL;
            return false;
        }

        $passwordHash = password_hash($newPassword,PASSWORD_ARGON2I);
        $password = new Password($passwordHash);
        $this->actualPassword = $password;
        return true;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return Password
     */
    public function getActualPassword(): Password
    {
        return $this->actualPassword;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @param Password $actualPassword
     */
    public function setActualPassword(Password $actualPassword): void
    {
        $this->actualPassword = $actualPassword;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

}