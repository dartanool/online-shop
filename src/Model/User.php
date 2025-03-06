<?php
namespace Model;

class User extends \Model\Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    protected function getTableName() : string
    {
        return 'users';
    }
    public function insertNameEmailPassword(string $name,string $email,string $password) : void
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute([':name' => $name, ':email' => $email, ':password' => $password]);
    }
    public function getById(int $id) :self | null
    {

        $statement = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE id = {$id}");
        $user = $statement->fetch();

        if ($user === false) {
            return null;
        }

        $obj = $this->createObject($user);

        return $obj;
    }


    public function getByEmail(string $email) : self | null// add false
    {

        $statement = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE email = :email");
        $statement->execute([':email' => $email]);

        $result = $statement->fetch();

        if ($result === false) {
            return null;
        }

        $obj = $this->createObject($result);

        return $obj;
    }

    public function updateEmailById(string $email,int $id) : void
    {

        $statement = $this->pdo->prepare("UPDATE {$this->getTableName()} SET email = :email WHERE id = {$id}");
        $statement->execute([':email' => $email]);
    }

    public function updateNameById(string $name,int $id) : void
    {

        $statement = $this->pdo->prepare("UPDATE {$this->getTableName()} SET name = :name WHERE id = {$id}");
        $statement->execute([':name' => $name]);
    }

    public function updatePasswordById(string $password, int $id) : void
    {

        $statement = $this->pdo->prepare("UPDATE {$this->getTableName()} SET password = :password WHERE id = {$id}");
        $statement->execute([':password' => $password]);
    }

    private function createObject(array $data) : self
    {
        $obj = new self();

        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->email = $data['email'];
        $obj->password = $data['password'];

        return $obj;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}