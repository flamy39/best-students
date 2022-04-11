<?php

class Password {

    private string $password;
    private DateTime $creationDate;

    /**
     * Password constructor.
     * @param string $password
     * @param DateTime|null $creationDate
     */
    public function __construct(string $password, DateTime $creationDate = null)
    {
        $this->password = $password;
        if ($creationDate === null) {
            $this->creationDate = new DateTime();
        } else {
            $this->creationDate = $creationDate;
        }
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

}