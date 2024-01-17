<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="">
</head>
<body>
<h1>Cart</h1>
<?php if(!empty($productsCart)){
foreach ($productsCart as $key => $elem): ?>
<div class="cart-container">
    <form action="/delete" method="POST">
    <div class="product">
        <img src="<?php echo $productsCartInfo[$key]['link']; ?>" alt="Product 1">
        <div class="product-info">
            <h3><?php echo $productsCartInfo[$key]['name'], $productsCartInfo[$key]['model']; ?></h3>
            <p>Цена:<?php echo $productsCartInfo[$key]['price']; ?>$</p>
            <input type="number" value="<?php echo $productsCartQuantity[$key]['quantity']; ?>">
            <button name="product_id" value="<?php echo $elem['product_id']; ?>">Удалить</button>
            <div class="total">
                <h3>Общая стоимость: <?php echo $productsTotal[$key]['total']; ?>$</h3>
            </div>
        </div>
    </div>
    </form>
</div>
<?php endforeach;} ?>
<tr class="totalprice">
    <td class="light">Сумма заказа:</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2"><?php if(!empty($totalPrice)){
        echo $totalPrice; }?>$</span></td>
</tr>
<button><a class="Order" href="/order">Оформить заказ</a></button>

</body>
</html>
<style>body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .cart-container {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
    }

    .product {
        display: flex;
        margin-bottom: 20px;
    }

    .product img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        margin-right: 20px;
    }

    .product-info {
        display: flex;
        flex-direction: column;
    }

    .product-info h3 {
        margin: 0 0 10px 0;
    }

    .product-info p {
        margin: 0 0 10px 0;
    }

    input[type="number"] {
        width: 50px;
        padding: 5px;
        margin-bottom: 10px;
    }

    button {
        padding: 5px 10px;
        background-color: darkblue;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .total {
        text-align: right;
    }

    button:last-of-type {
        margin-top: 20px;
    }
    .Order {
        padding: 5px 10px;
        background-color: darkblue;
        color: #fff;
        border: none;
        cursor: pointer;
        float: right;
    }
</style>