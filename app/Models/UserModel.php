<?php
namespace App\Models;
use App\Utility\DataBase;


// Ce modèle est la représentation "code" de notre table posts
// elle aura donc autant de propriétés qu'il y'a de champs dans la table
// ça nous permettra de manipuler des objets identiques à une entrée de bdd grâce à PDO::FETCH_CLASS
class UserModel
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;

    public function registerUser(): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = "INSERT INTO `User`(`name`, `email`, `password`,`role`) VALUES (:name,:email,:password,:role)";
        $pdoStatement = $pdo->prepare($sql);
        
        $params = [
            ':name' => $this->name,
            ':email' => $this->email,
            ':password' => $this->password,
            ':role' => 3,
        ];
        $queryStatus = $pdoStatement->execute($params);
        
        return $queryStatus;
    }


   // méthode pour vérifier si un email est déjà pris
    public function checkEmail()
    {
        $pdo = DataBase::connectPDO();

        $sql = "SELECT COUNT(*) FROM `User` WHERE `email` = :email";
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $this->email);
        $query->execute();
        $isMail = $query->fetchColumn();
        return $isMail > 0;
    }


    // récupérer un utilisateur via son email
    public static function getUserByEmail($email): ?UserModel
    {

        $pdo = DataBase::connectPDO();

        $sql = 'SELECT * FROM User WHERE email = :email';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([':email' => $email]);
        $result = $pdoStatement->fetchObject('App\Models\UserModel');

        return $result;
    }
    
    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get the value of role
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * Set the value of role
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
    }
}