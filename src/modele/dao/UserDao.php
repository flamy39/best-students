<?php

require_once "src/modele/entities/User.php";
require_once "src/modele/entities/Password.php";
require_once "./config/Database.php";

class UserDao {
    private PDO $pdo;

    public function __construct() {
        $dsn = "mysql:host=".Database::HOST_NAME.";dbname=".Database::DATABASE.";charset=utf8";
        $this->pdo = new PDO($dsn,Database::USERNAME,Database::PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    /**
     * @param string $login
     * @return User|null
     */
    public function findByLogin(string $login) : ?User {
        $requestSQL = "SELECT * FROM user WHERE login=:login";
        $request = $this->pdo->prepare($requestSQL);
        $request->execute([
            ":login" => $login
        ]);
        $userDB = $request->fetch(PDO::FETCH_ASSOC);
        $user = null;
        // test si un utilisateur possède ce login
        if ($userDB) {
            $user = $this->createUser($userDB);
        }
        return $user;
    }

    public function create(User $user)  {
        $requestSQL = "INSERT INTO user (login,password,date_creation,firstname,lastname,email) VALUES (:login,:password,:dateCreation,:firstname,:lastname,:email)";
        $request = $this->pdo->prepare($requestSQL);
        $request->execute([
           ":login" => $user->getLogin(),
           ":password" => $user->getActualPassword()->getPassword(),
           ":dateCreation" => $user->getActualPassword()->getCreationDate()->format("Y-m-d"),
           ":firstname" => $user->getEmail(),
           ":lastname" => $user->getLastName(),
           ":email" => $user->getEmail(),
        ]);
    }

    public function update(User $user) {
        $requestSQL = "UPDATE user SET login = :login, password = :password, date_creation = :dateCreation, firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id" ;
        $request = $this->pdo->prepare($requestSQL);
        $request->execute([
            ":id" => $user->getId(),
            ":login" => $user->getLogin(),
            ":password" => $user->getActualPassword()->getPassword(),
            ":dateCreation" => $user->getActualPassword()->getCreationDate()->format("Y-m-d"),
            ":firstname" => $user->getFirstName(),
            ":lastname" => $user->getLastName(),
            ":email" => $user->getEmail()
        ]);
    }

    private function createUser(array $userDB): User
    {
        $user = new User();
        $user->setId($userDB["id"]);
        $user->setLogin($userDB["login"]);
        $user->setEmail($userDB["email"]);
        $user->setLastName($userDB["lastname"]);
        $user->setFirstName($userDB["firstname"]);
        $password = new Password($userDB["password"], new DateTime($userDB["date_creation"]));
        $user->setActualPassword($password);
        return $user;
    }


}