<div class="container">
    <h3>Catalog</h3>
    <div class="Cart">
        <a href="/cart">
            <div class="card-header">
            </div>
            <img class="cart-icon" src="https://media.istockphoto.com/id/1128229893/ru/%D0%B2%D0%B5%D0%BA%D1%82%D0%BE%D1%80%D0%BD%D0%B0%D1%8F/%D0%B7%D0%BD%D0%B0%D1%87%D0%BE%D0%BA-%D0%BA%D0%BE%D1%80%D0%B7%D0%B8%D0%BD%D1%8B-%D0%B4%D0%BB%D1%8F-%D0%BF%D0%BE%D0%BA%D1%83%D0%BF%D0%BE%D0%BA.jpg?s=612x612&w=0&k=20&c=siJWgewo6SkHV9H0PI5Wwn6E-dJLal2yWTMCNtqwQ5M="
                 alt="Card image" width="70" height="70">
            <div class="cart-quantity">
                <?php if(isset($viewData['count'])){ echo $viewData['count']; }?>
            </div>
    </div>
    <div class="card-deck">
        <?php if(!empty($products)){
        foreach($products as $product): ?>
        <div class="card text-center">
            <a href="">
                <div class="card-header">
                </div>
                <img class="card-img-top" src="<?php echo $product->getLink(); ?>" alt="Card image" width="600" height="300">
                <div class="card-body">
                    <p class="card-text text-muted">Name</p>
                    <a href=""><h5 class="card-title"><?php echo $product->getName(), $product->getModel();?></h5></a>
                    <div class="card-footer">
                        <?php echo $product->getPrice(); ?> $
                    </div>
                </div>
        </div>
            <div class="quantity-input">
                <form action="/minus" method="post">
                    <div>
                        <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
                        <label style="color: red"><?php echo $errors['remove_product'] ?? ''; ?></label>
                        <button type="submit" name="decrease">-</button>
                    </div>
                </form>
                <form><input type="text" name="quantity" value="<?php echo $quantityInput[$product->getId()] ?? 0;?>"></form>
                <form action="/plus" method="post">
                    <div>
                        <input type="hidden" name="product_id" value="<?php echo $product->getId();?>">
                        <label style="color: red"><?php echo $errors['remove_product'] ?? ''; ?></label>
                        <button type="submit" name="increase">+</button>
                    </div>
                </form>
        </div>
        </div>
        <?php endforeach;} ?>
</div>
    <p><a class="logout" href="/logout">Logout</a></p>



<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-title {
        font-size: 20px;
    }

    .card-header {
        font-size: 19px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 14px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }

    .logout {
        background-color: darkblue;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        opacity: 0.9;
        float: right;
    }

    .Cart {
        float: right;
    }

    .quantity-input {
        display: flex;
        align-items: center;
        width: 150px;
    }
    .quantity-input input {
        text-align: center;
        width: 40px;
        border: 1px solid #ccc;
    }
    .quantity-input button {
        padding: 5px 10px;
        background-color: darkblue;
        color: white;
        border: none;
        cursor: pointer;
    }

    .cart-icon {
        position: relative;
    }

    .cart-quantity {
        position: absolute;
        top: 120px;
        right: 10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 10px;
        font-size: 12px;
    }
</style>
