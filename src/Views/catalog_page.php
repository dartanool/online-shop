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
            <form class = increase-form onsubmit="return false" method="post">
                <div class="input-box">
                    <input type="hidden" placeholder="Enter product id" value="<?php echo $product->getId()?>" name ="product_id" required>
                </div>
                    <button type="Submit" class="input-box button">+</button>
                <?php foreach ($userProducts as $userProduct): ?>
                        <?php if ($product->getId() === $userProduct->getProductId()): ?>
                            <label class = "product-quantity"><b><?php echo $userProduct->getByUserIdProductId($this->authService->getCurrentUser()->getId(),$product->getId())->getAmount() ?></b></label>
                        <?php endif; ?>
                <?php endforeach; ?>
            </form>
            <form class = "decrease-product" onsubmit="return false"  method="post">
                <div class="input-box">
                    <input type="hidden" placeholder="Enter product id" value="<?php echo $product->getId()?>" name ="product_id" required>
                </div>
                <button type="Submit" class="input-box button">-</button>
            </form>
            <form class = "product" action= "/product" onsubmit="return false"  method="post">
                <div class="input-box">
                    <input type="hidden" placeholder="Enter product id" value="<?php echo $product->getId()?>" name ="product_id" required>
                </div>
                <button type="Submit" class="input-box button">open</button>
            </form>
        </div>

    <?php endforeach ?>
</div>
</html>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $("document").ready(function () {
        $('.increase-form').submit(function () {
            $.ajax({
                type: "POST",
                url: "/add-product",
                data: $(this).serialize(),
                // dataType: 'json',
                success: function (response) {
                    console.log(response);
// Обновляем количество товаров в бейдже корзины
                    $('.product-quantity').text(response.amount)
                },
            });
        });
    });
</script>

<script>
    $("document").ready(function () {
        $('.decrease-product').submit(function () {
            $.ajax({
                type: "POST",
                url: "/decrease-product",
                data: $(this).serialize(),
                // dataType: 'json',
                success: function (response) {
                    console.log(response);
// Обновляем количество товаров в бейдже корзины
                    $('.product-quantity').text(response.amount)
                },
            });
        });
    });
</script>

<script>
    $("document").ready(function () {
        $('.product').submit(function () {
            $.ajax({
                type: "POST",
                url: "/product",
                data: $(this).serialize(),
                // dataType: 'json',
                success: function () {
                    console.log('yes');
                },
            });
        });
    });
</script>


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
