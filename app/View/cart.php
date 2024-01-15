<!DOCTYPE html>
<html>
<head>
    <title>Корзина</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="cart-container">
    <h1>Корзина</h1>
    <div class="product">
        <img src="product1.jpg" alt="Product 1">
        <div class="product-info">
            <h3>Название товара 1</h3>
            <p>Цена: $50</p>
            <input type="number" value="1">
            <button>Удалить</button>
        </div>
    </div>
    <div class="product">
        <img src="product2.jpg" alt="Product 2">
        <div class="product-info">
            <h3>Название товара 2</h3>
            <p>Цена: $75</p>
            <input type="number" value="2">
            <button>Удалить</button>
        </div>
    </div>
    <div class="total">
        <h3>Общая стоимость: $200</h3>
        <button>Оформить заказ</button>
    </div>
</div>
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
        width: 100px;
        height: 100px;
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
        background-color: #007bff;
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
</style>