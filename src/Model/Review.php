<?php

namespace Model;

class Review extends Model
{
    private int $id;
    private int $productId;
    private int $userId;
    private string $reviewText;
    private int $score;
    private string $userName;
    private string $createdAt;

    protected static function getTableName(): string
    {
        return 'reviews';
    }

    public static function create(int $productId, int $userId, string $text, int $score) :void
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare(
            "INSERT INTO $tableName (product_id, user_id, review_text, score) 
                    VALUES (:productId, :userId, :text, :score) ");
        $statement->execute([
            'productId' => $productId,
            'userId' => $userId,
            'text' => $text,
            'score' => $score]);
    }

    public static function getByProductId(int $productId) : array|null
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->query("SELECT * FROM $tableName WHERE product_id = {$productId}");
        $reviews = $statement->fetchAll();

        if ($reviews === false){
            return null;
        }

        $objs = [];
        foreach ($reviews as $review){

            $objs[] = static::createObject($review);

        }

        return $objs;
    }
        private static function createObject(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->reviewText = $data['review_text'];
        $obj->score = $data['score'];
        $obj->createdAt = $data['created_at'];

        return $obj;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getReviewText(): string
    {
        return $this->reviewText;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }
    public function getUserName(): string
    {
        return $this->userName;
    }





}