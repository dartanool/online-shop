<html lang="en" dir="ltr">
<h2>Catalog</h2>
<a href="user-profile">My profile</a>
<a href="cart">My cart</a>
<a href="logout">Logout</a>
<div class="product-grid">
    <?php foreach ($products as $product):?>
        <div class="product-item">
            <img class="product-image" src="<?php echo $product->getImageUrl()?>" alt="<?php echo $product->getName()?>" data-image-width="720" data-image-height="1080">
            <div class="product-info">
                <h6 class="product-name"> <?php echo $product->getId()?></h6>
                <h6 class="product-name"> <?php echo $product->getName()?></h6>
                <h5 class="product-price"><?php echo $product->getPrice()?></h5>
            </div>
            <label for="amount"><b>Amount</b></label>
            <form action= "/add-product" method="post">
                <div class="input-box">
                    <input type="hidden" placeholder="Enter product id" value="<?php echo $product->getId()?>" name ="product_id" required>
                </div>
                    <button type="Submit" class="input-box button">+</button>
                <?php if (isset($errors['amount'])): ?>
                    <label style="color: red"><?php echo $product->getId();?></label>
                <?php endif; ?>
<!--                <label for="amount"><b>--><?php //echo $userProduct->getByUserIdProductId($this->getCurrentUserId(),$product->getId())->getAmount() ?><!--</b></label>-->
            </form>
            <form action= "/decrease-product" method="post">
                <div class="input-box">
                    <input type="hidden" placeholder="Enter product id" value="<?php echo $product->getId()?>" name ="product_id" required>
                </div>
                <button type="Submit" class="input-box button">-</button>
            </form>
            <form action= "/product" method="post">
                <div class="input-box">
                    <input type="hidden" placeholder="Enter product id" value="<?php echo $product->getId()?>" name ="product_id" required>
                </div>
                <button type="Submit" class="input-box button">open</button>
            </form>
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
    .input-box.button input{
        color: #fff;
        letter-spacing: 1px;
        border: none;
        background: #4070f4;
        cursor: pointer;
    }
    .input-box.button input:hover{
        background: #0e4bf1;
    }
</style>
