<html lang="en" dir="ltr">
<h2>Catalog</h2>
<a href="user_profile">My profile</a>
<div class="product-grid">
    <?php foreach ($products as $product):?>
        <div class="product-item">
            <img class="product-image" src="<?php echo $product['image_url']?>" alt="<?php echo $product['name']?>" data-image-width="720" data-image-height="1080">
            <div class="product-info">
                <h6 class="product-name"> <?php echo $product['id']?></h6>
                <h6 class="product-name"> <?php echo $product['name']?></h6>
                <h5 class="product-price"><?php echo $product['price']?></h5>
            </div>
        </div>
    <?php endforeach ?>
</div>
</html>

<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 13.33px; /* 20px / 1.5 = 13.33px */
        padding: 20px;
    }

    .product-item {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .product-image {
        width: 133.33px; /* 200px / 1.5 = 133.33px */
        height: 133.33px; /* 200px / 1.5 = 133.33px */
        object-fit: cover;
    }

    .product-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    .product-name {
        font-size: 30px;
    }
    .product-price {
        font-size: 28px;
        color: green;
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
