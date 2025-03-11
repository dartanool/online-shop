<?php
namespace Controllers;

use Model\Product;
use Model\Review;
use Model\User;
use Model\UserProduct;
use Request\AddReviewRequest;
use Request\GetProductIdRequest;

class ProductController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private Review $reviewModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->reviewModel = new Review();
        $this->userModel = new User();
    }
    //Catalog
    public function getCatalog() : void
    {
        if (!($this->authService->check())) {
            header('Location: login');
        } else {

            $products = $this->productModel->getById();

            $userProducts =$this->userProductModel->getAllUserProductsByUserId($this->authService->getCurrentUser()->getId());


            require_once "../Views/catalog_page.php";
        }
    }

    public function getProduct(GetProductIdRequest $request):void
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {
            $productId = $request->getProductId();
            $userId =$this->authService->getCurrentUser()->getId();

            $product = $this->productModel->getByProductId($productId);
            $reviews = $this->reviewModel->getByProductId($productId);

            $averageScore = $this->getAverageScore($reviews);

            foreach ($reviews as $review){
                $userId = $review->getUserId();
                $userName = $this->userModel->getById($userId)->getName();
                $review->setUserName($userName);

            }
            require_once "../Views/product_page.php";

        }
    }

    public function addReview(AddReviewRequest $request)
    {
        if (!$this->authService->check()){
            header('Location: login');
        } else {
            $errors = $request->validateReview();

            if (empty($errors)) {

                $userName = $this->authService->getCurrentUser()->getName();
                $userId =$this->authService->getCurrentUser()->getId();
                $productId = $request->getProductId();
                $reviewText = $request->getReviewText();
                $score = $request->getScore();

                $this->reviewModel->create($productId, $userId, $reviewText, $score);

                header('Location: catalog');
            }
            require_once "../Views/product_page.php";

        }
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
            $averageScore = $totalScore;
        }

        return round($averageScore,2);
    }
}