<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach($products as $product): ?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    Hit!
                </div>
                <img class="card-img-top" src="<?php echo $product['link']; ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted">Category name</p>
                    <a href="#"><h5 class="card-title"><?php echo $product['name'], $product['model'];?></h5></a>
                    <div class="card-footer">
                        <?php echo $product['price']; ?> $
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <p><a class="logout" href="/logout">Sign in</a>.</p>
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

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
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
        width: 100%;
        opacity: 0.9;
    }
</style>
