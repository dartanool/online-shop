<html lang="en" dir="ltr">
<h2>Catalog</h2>
<a href="user-profile">My profile</a>
<a href="cart">My cart</a>
<a href="logout">Logout</a>
<div class="product-grid">
    <?php foreach ($products as $product):?>
        <div class="product-item">
            <img class="product-image" src="<?php echo $product['image_url']?>" alt="<?php echo $product['name']?>" data-image-width="720" data-image-height="1080">
            <div class="product-info">
                <h6 class="product-name"> <?php echo $product['id']?></h6>
                <h6 class="product-name"> <?php echo $product['name']?></h6>
                <h5 class="product-price"><?php echo $product['price']?></h5>
            </div>
            <form action= "/add-product" method="post">
                <div class="input-box">
                    <input type="hidden" placeholder="Enter product id" value="<?php echo $product['id']?>" name ="product_id" required>
                </div>
                <label for="amount"><b>Amount</b></label>
                <?php if (isset($errors['amount'])): ?>
                    <label style="color: red"><?php echo $errors['amount'];?></label>
                <?php endif; ?>
                    <input type="text" placeholder="Enter your amount" name ="amount" required>
                    <button type="Submit" class="input-box button">Add product</button>
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
