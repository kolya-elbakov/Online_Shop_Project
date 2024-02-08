<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Оформление заказа</h1>
    <form action="/order" method="post">
        <div class="form-group">
            <label for="name">Имя:</label>
            <label style="color: darkred"><?php echo $errors['name'] ?? ''; ?></label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <label style="color: darkred"><?php echo $errors['email'] ?? ''; ?></label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="city">Город:</label>
            <label style="color: darkred"><?php echo $errors['city'] ?? ''; ?></label>
            <input type="text" id="ciry" name="city" required>
        </div>
        <div class="form-group">
            <label for="street">Улица:</label>
            <label style="color: darkred"><?php echo $errors['street'] ?? ''; ?></label>
            <input type="text" id="street" name="street" required>
        </div>
        <div class="form-group">
            <label for="zip">Почтовый индекс:</label>
            <label style="color: darkred"><?php echo $errors['zip'] ?? ''; ?></label>
            <input type="text" id="zip" name="zip" required>
        </div>
        <div class="form-group">
            <label for="payment">Способ оплаты:</label>
            <select id="payment" name="payment" required>
                <option value="credit">Кредитная карта</option>
                <option value="paypal">PayPal</option>
                <option value="cash">Наличные при получении</option>
            </select>
        </div>
        <button type="submit">Подтвердить заказ</button>
    </form>
</div>
</body>
</html>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: darkblue;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: blue;
    }
</style>
