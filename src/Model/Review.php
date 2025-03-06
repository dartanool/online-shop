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

    protected function getTableName(): string
    {
        return 'reviews';
    }

    public function create(int $productId, int $userId, string $text, int $score, string $userName) :void
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()}(product_id, user_id, review_text, score, user_name) 
                    VALUES (:productId, :userId, :text, :score, :userName) ");
        $statement->execute([
            'productId' => $productId,
            'userId' => $userId,
            'text' => $text,
            'score' => $score,
            'userName' => $userName]);
    }

    public function getByProductId(int $productId) : array|null
    {
        $statement = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE product_id = {$productId}");
        $reviews = $statement->fetchAll();

        if ($reviews === false){
            return null;
        }

        $objs = [];
        foreach ($reviews as $review){

            $objs[] = $this->createObject($review);

        }

        return $objs;
    }


    private function createObject(array $data): self
    {
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->reviewText = $data['review_text'];
        $obj->score = $data['score'];
        $obj->userName = $data['user_name'];

        return $obj;
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

    public function getUserName(): string
    {
        return $this->userName;
    }



}