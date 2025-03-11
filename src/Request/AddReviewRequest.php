<?php

namespace Request;

class AddReviewRequest
{
    public function __construct(private array $data)
    {
    }

    public function getProductId(): int
    {
        return $this->data['productId'];
    }
    public function getReviewText(): string
    {
        return $this->data['reviewText'];
    }
    public function getScore (): float
    {
        return $this->data['score'];
    }

    public function validateReview(): array
    {
        $errors = [];
        $reviewText = $this->data['reviewText'];
        $score = $this->data['score'];

        if (!(isset($reviewText))) {
            $errors['reviewText'] = "Review is not filled";
        } elseif (strlen($reviewText) > 255) {
            $errors['reviewText'] = "Review too long";
        }

        if (!(isset($score))) {
            $errors['score'] = "Score is not filled";
        }

        return $errors;
    }
}