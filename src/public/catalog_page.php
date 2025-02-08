
<html lang="en" dir="ltr">
<h2>Catalog</h2>
<a href="user_profile">My profile</a>
    <div class="u-repeater u-repeater-1">
        <?php foreach ($products as $product):?>
            <div class="u-container-layout u-similar-container u-valign-bottom u-container-layout-1">
                <img class="u-expanded-width u-image u-image-default u-image-1" src="<?php echo $product['image_url']?>" alt="" data-image-width="720" data-image-height="1080">
                <h6 class="u-custom-font u-font-montserrat u-text u-text-default u-text-2"> <?php echo $product['name']?></h6>
                <h5 class="u-custom-font u-font-montserrat u-text u-text-default u-text-3"><?php echo $product['price']?></h5>
            </div>
        <?php endforeach ?>
    </div>
</html>

<style>
    .u-section-3 .u-container-layout-1 {
        padding: 10px 10px 30px;
    }
    .u-valign-bottom {
        justify-content: flex-end;
    }

    .u-valign-middle, .u-valign-top, .u-valign-bottom {
        display: flex
    ;
        flex-direction: column;
    }

</style>