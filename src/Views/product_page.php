<!DOCTYPE html>
<html lang="ru">
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--    <title>Страница продукта</title>-->
<!--</head>-->
<!--<body>-->
<div class="product-container">
    <div class="product-info">
        <img class="product-image" src="<?php echo $product->getImageUrl()?>" alt="<?php echo $product->getName()?>">
        <h2 class="product-name"><?php echo $product->getName()?></h2>
        <h3 class="product-price">Цена: <?php echo $product->getPrice()?> руб.</h3>
        <h4 class="description-title">Описание</h4>
            <p class="product-description"><?php echo $product->getDescription()?></p>
    </div>
    <form class="leave-review-form" action= "/add-review" method="post">
        <input type="hidden" placeholder="Enter product id" value="<?php echo $product->getId()?>" name ="product_id" required>
        <textarea placeholder="Оставьте ваш отзыв" name="review-text"></textarea>
        <button type="submit">Оставить отзыв</button>
    </form>
</div>

</body>
</html>


<style>

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #4070f4;
    }

    .product-container {
        max-width: 800px;
        margin: 40px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .product-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .product-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .product-name {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 20px;
        color: #00698f;
        margin-bottom: 20px;
    }

    .description-title {
        font-size: 18px;
        margin-bottom: 10px;
        text-align: center;
    }

    .product-description {
        text-align: justify;
        padding: 0 20px;
    }







    .leave-review-form {
        padding: 0 20px;
        margin-top: 20px;
    }

    .leave-review-form textarea {
        width: 100%;
        height: 100px;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
    }

    .leave-review-form input[type="text"] {
        width: 100%;
        height: 40px;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
    }

    .leave-review-form button[type="submit"] {
        width: 100%;
        height: 40px;
        background-color: #4070f4;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .leave-review-form button[type="submit"]:hover {
        background-color: #00698f;
    }

</style>
