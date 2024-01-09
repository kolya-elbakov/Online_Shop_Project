global$products;
<div class="container">
    <h3>Catalog</h3>
    <div class="Cart">
        <a href="/cart">
            <div class="card-header">
            </div>
            <img class="card-img-top" src="https://media.istockphoto.com/id/1128229893/ru/%D0%B2%D0%B5%D0%BA%D1%82%D0%BE%D1%80%D0%BD%D0%B0%D1%8F/%D0%B7%D0%BD%D0%B0%D1%87%D0%BE%D0%BA-%D0%BA%D0%BE%D1%80%D0%B7%D0%B8%D0%BD%D1%8B-%D0%B4%D0%BB%D1%8F-%D0%BF%D0%BE%D0%BA%D1%83%D0%BF%D0%BE%D0%BA.jpg?s=612x612&w=0&k=20&c=siJWgewo6SkHV9H0PI5Wwn6E-dJLal2yWTMCNtqwQ5M="
                 alt="Card image" width="50" height="50">
    </div>
    <div class="card-deck">
        <?php $products = $this->productModel->getAll();
        foreach($products as $product): ?>
        <div class="card text-center">
            <a href="">
                <div class="card-header">
                </div>
                <img class="card-img-top" src="<?php echo $product['link']; ?>" alt="Card image" width="600" height="300">
                <div class="card-body">
                    <p class="card-text text-muted">Name</p>
                    <a href="#"><h5 class="card-title"><?php echo $product['name'], $product['model'];?></h5></a>
                    <div class="card-footer">
                        <?php echo $product['price']; ?> $
                    </div>
                </div>
                <div class="add">
                    <form action="/cart" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <p><a class="addToCart" href="/cart">Add to cart</a></p>
                    </form>
                </div>
        </div>
        </div>
        <?php endforeach; ?>
</div>
    <p><a class="logout" href="/logout">Logout</a></p>
</div>


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

    .addToCart {
        background-color: black;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 50%;
        opacity: 0.9;
    }

    .Cart {
        float: right;
    }
</style>
