<?php
class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
    }

    public function insertNameEmailPassword(string $name,string $email,string $password) : void
    {

        $statement = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute([':name' => $name, ':email' => $email, ':password' => $password]);
    }
    public function getById(int $id) :array
    {
        $statement = $this->pdo->query("SELECT * FROM users WHERE id = {$id}");
        $user = $statement->fetch();

        return $user;
    }


    public function getByEmail(string $email) : array | false// add false
    {

        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute([':email' => $email]);

        $result = $statement->fetch();

        return $result;
    }

    public function updateEmailById(string $email,int $id) : void
    {
        $statement = $this->pdo->prepare("UPDATE users SET email = :email WHERE id = {$id}");
        $statement->execute([':email' => $email]);
    }

    public function updateNameById(string $name,int $id) : void
    {

        $statement = $this->pdo->prepare("UPDATE users SET name = :name WHERE id = {$id}");
        $statement->execute([':name' => $name]);
    }

    public function updatePasswordById(string $password, int $id) : void
    {
        $statement = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = {$id}");
        $statement->execute([':password' => $password]);
    }
}