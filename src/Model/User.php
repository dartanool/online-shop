<?php
namespace Model;

class User extends \Model\Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    protected static function getTableName() : string
    {
        return 'users';
    }
    public static function insertNameEmailPassword(string $name,string $email,string $password) : void
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare(
            "INSERT INTO $tableName (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute([':name' => $name, ':email' => $email, ':password' => $password]);
    }
    public static function getById(int $id) :self | null
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->query("SELECT * FROM $tableName WHERE id = {$id}");
        $user = $statement->fetch();

        if ($user === false) {
            return null;
        }

        $obj = static::createObject($user);

        return $obj;
    }


    public static function getByEmail(string $email) : self | null// add false
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare("SELECT * FROM $tableName WHERE email = :email");
        $statement->execute([':email' => $email]);

        $result = $statement->fetch();

        if ($result === false) {
            return null;
        }

        $obj = static::createObject($result);

        return $obj;
    }

    public static function updateEmailById(string $email,int $id) : void
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare("UPDATE $tableName SET email = :email WHERE id = {$id}");
        $statement->execute([':email' => $email]);
    }

    public static function updateNameById(string $name,int $id) : void
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare("UPDATE $tableName SET name = :name WHERE id = {$id}");
        $statement->execute([':name' => $name]);
    }

    public static function updatePasswordById(string $password, int $id) : void
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare("UPDATE $tableName SET password = :password WHERE id = {$id}");
        $statement->execute([':password' => $password]);
    }

    private static function createObject(array $data) : self
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