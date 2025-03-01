<html lang="en" dir="ltr">
<body>
<div class="wrapper">
    <h2>Create order</h2>
    <form action= "/create-order" method="post">
        <label for="name"><b>Name</b></label>
        <?php if(isset($errors['name'])):?>
            <label style="color: red"> <?php echo $errors['name'];?></label>
        <?php endif;?>
        <div class="input-box">
            <input type="text" placeholder="Enter your name" id="name" name ="name" required>
        </div>
            <?php if(isset($data['name'])):?>
                value="<?php echo $data['name'];?>"
            <?php endif;?>
        <label for="address"><b>Адрес доставки</b></label>
        <?php if(isset($errors['address'])):?>
            <label style="color: red"> <?php echo $errors['address'];?></label>
        <?php endif;?>
        <div class="input-box">
            <input type="text" placeholder="Enter your address" id="address" name="address" required>
        </div>
            <?php if(isset($data['address'])):?>
                value="<?php echo $data['address'];?>"
            <?php endif;?>
        <label for="phone"><b>Номер телефона</b></label>
        <?php if(isset($errors['phone'])):?>
            <label style="color: red"> <?php echo $errors['phone'];?></label>
        <?php endif;?>
        <div class="input-box">
            <input type="tel" placeholder="+7 (___) ___-__-__" id="phone" name="phone" required>
        </div>
            <?php if(isset($data['phone'])):?>
                value="<?php echo $data['phone'];?>"
            <?php endif;?>
        <label for="text"><b>Комментарий</b></label>
        <div class="input-box">
            <input type="text" placeholder="Enter your comment" id="name" name ="comment" >
        </div>
            <?php if(isset($data['comment'])):?>
                value="<?php echo $data['comment'];?>"
            <?php endif;?>
        <div class="wrapper">
            <?php foreach ($newOrderProducts as $newOrderProduct): ?>
                <h3><?php echo $newOrderProduct['name']?></h3>
                <label for="amount">Количество:</label>
                <input type="number" id="amount" name="amount" min="1" value=<?php echo $newOrderProduct['amount']?> required>
                <div>
                    <label for="amount">Стоимость за 1 шт:</label>
                    <label class="price">₽ <?php echo $newOrderProduct['price']?></>
                </div>
                <div>
                    <label for="totalProduct">Итого:</label>
                    <label class="price">₽ <?php echo $newOrderProduct['totalSum'];?></label>
                </div>
            <?php endforeach; ?>
            <h3><label for="totalOrder">Заказ на сумму:</label></h3>
            <div class="price">₽ <?php echo $total;?></div>
        </div>
        <div class="input-box button">
            <input type="Submit" value="Create order">
        </div>
    </form>
</div>
</body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    body{
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #4070f4;
    }
    .wrapper{
        position: relative;
        max-width: 1000px;
        width: 100%;
        background: #fff;
        padding: 34px;
        border-radius: 6px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    .wrapper h2{
        position: relative;
        font-size: 22px;
        font-weight: 600;
        color: #333;
    }
    .wrapper h2::before{
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 28px;
        border-radius: 12px;
        background: #4070f4;
    }
    .wrapper form{
        margin-top: 30px;
    }
    .wrapper form .input-box{
        height: 52px;
        margin: 18px ;
    }
    form .input-box input{
        height: 100%;
        width: 100%;
        outline: none;
        padding: 0 15px;
        font-size: 17px;
        font-weight: 400;
        color: #333;
        border: 1.5px solid #C7BEBE;
        border-bottom-width: 2.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .input-box input:focus,
    .input-box input:valid{
        border-color: #4070f4;
    }
    form .policy{
        display: flex;
        align-items: center;
    }
    form h3{
        position: relative;
        font-size: 22px;
        font-weight: 600;
        color: #333;
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
