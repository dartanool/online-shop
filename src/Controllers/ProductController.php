<?php
namespace Controllers;

use Model\Product;
use Model\Review;
use Model\UserProduct;

class ProductController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private Review $reviewModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->reviewModel = new Review();
    }
    //Catalog
    public function getCatalog() : void
    {
        if (!($this->authService->check())) {
            header('Location: login');
        } else {

            $products = $this->productModel->getById();

            //
            $userProducts =$this->userProductModel->getAllUserProductsByUserId($this->authService->getCurrentUser()->getId());


            require_once "../Views/catalog_page.php";
        }
    }

    public function getProduct():void
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {
            $data = $_POST;
            $productId = $data['product_id'];
            $userName = $this->authService->getCurrentUser()->getName();
            $userId =$this->authService->getCurrentUser()->getId();

            $product = $this->productModel->getByProductId($productId);
            $reviews = $this->reviewModel->getByProductId($productId);

            $averageScore = $this->getAverageScore($reviews);

//            $reviews = $this->reviewModel->getByUserIdProductId($userId, $productId);
//
//            foreach ($reviews as $review){
//                $review->setUserName($userName);
//
//            }
            require_once "../Views/product_page.php";

        }
    }

    public function addReview()
    {
        if (!$this->authService->check()){
            header('Location: login');
        } else {
            $data = $_POST;
            $errors = $this->validateReview($data);

            if (empty($errors)) {

                $userName = $this->authService->getCurrentUser()->getName();
                $userId =$this->authService->getCurrentUser()->getId();
                $productId = $data['productId'];
                $reviewText = $data['reviewText'];
                $score = $data['score'];

                $this->reviewModel->create($productId, $userId, $reviewText, $score);
//                $this->reviewModel->setUserName($userName);

                $reviews = $this->reviewModel->getByUserIdProductId($userId, $productId);

                foreach ($reviews as $review){
                    $review->setUserName($userName);

                }

                header('Location: catalog');
            }
            require_once "../Views/product_page.php";

        }
    }

    private function validateReview(array $data): array
    {
        $errors = [];
        $reviewText = $data['reviewText'];
        $score = $data['score'];

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

    private function getAverageScore(array $reviews) : float
    {
        $totalScore = 0;
        $count = 0;
        foreach ($reviews as $review){
            $totalScore += $review->getScore();
            $count++;
        }

        if ($count !== 0){
            $averageScore = $totalScore/$count;
        } else {
            $averageScore = 0;
        }

        return round($averageScore,2);
    }
}