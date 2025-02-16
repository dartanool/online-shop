<html lang="en" dir="ltr">
<h2>Cart</h2>
<div class="product-grid">
    <?php foreach ($products as $product):?>
        <div class="product-item">
            <img class="product-image" src="<?php echo $product['image_url']?>" alt="<?php echo $product['name']?>" data-image-width="720" data-image-height="1080">
            <div class="product-info-title">
                <h6 class="product-id"> <?php echo 'id'?></h6>
                <h6 class="product-name"> <?php echo 'name'?></h6>
                <h6 class="product-amount"> <?php echo 'amount'?></h6>
                <h5 class="product-price"><?php echo 'Total cost' ?></h5>
            </div>
            <div class="product-info">
                <h6 class="product-id"> <?php echo $product['id']?></h6>
                <h6 class="product-name"> <?php echo $product['name']?></h6>
                <h6 class="product-amount"> <?php echo $product['amount']?></h6>
                <h5 class="product-price"><?php echo $product['price']*$product['amount']   ?></h5>
            </div>
        </div>
    <?php endforeach ?>
</div>
</html>

<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 10px;
        padding: 20px;
    }

    .product-item {
        padding: 50px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .product-image {
        width: 200px; /* 200px / 1.5 = 133.33px */
        height: 200px; /* 200px / 1.5 = 133.33px */
        object-fit: cover;
    }

    .product-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    .product-info-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 100px;
    }

    .product-id {
        font-size: 30px;
    }
    .product-name {
        font-size: 30px;
    }
    .product-price {
        font-size: 28px;
        color: green;
    }
    .product-amount {
        font-size: 28px;
        color: green;
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
