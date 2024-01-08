
<body>
<div class="container">
    <nav>
        <img src="https://s.auto.drom.ru/i24266/dealers/dealer/desc/158782/gen380_24654fef-9ed1-4de0-afe6-a4ff947d2af3.jpg" alt="o">
    </nav>
    <div class="caption">
        <p>Your order from</p>
        <h5>TOP CAR</h5>
    </div>
    <div class="orders-box">
        <?php $products = $this->productModel->getAll();
        foreach($products as $product): ?>
        <div class="order order1">
            <p<a href="#"><h5 class="order order1"><?php echo $product['name'], $product['model'];?></h5></a></p>
            <span class="minus">-</span>
            <div class="box-1">
                <p>1</p>
            </div>
            <span class="plus">+</span>
            <div class="price"> <?php echo $product['price']; ?> $</div>
            <div class="xmark-box">
                <i class="fa-solid fa-x"></i> <!--plus-->
            </div>
            <?php endforeach; ?>
        </div>

        <div class="btn">Checkout</div>
    </div>
</div>




<script src="https://kit.fontawesome.com/8535745612.js" crossorigin="anonymous"></script>
</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    *,*:before,*:after{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }
    body{
        background-color: #eeeeee;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container{
        width: 100%;
        max-width: 400px;
        background-color: #fff;
    }
    .container >nav{
        background-color: darkblue;
        height: 120px;
        width: 100%;
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: end;
    }
    .container >nav >img{
        width: 100px;
        position: relative;
        transform: translateY(50%);
        box-shadow: 0 0 0 8px #fff;
        border-radius: 50%;
        background-color: #ffffff;
    }
    .container >.caption{
        margin-top: 4rem;
        display: flex;
        flex-direction: column;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        width: fit-content;
        text-align: center;
        color: #222;
        line-height: 1.4;
    }
    .container >.caption >h5{
        font-size: 17px;
        letter-spacing: 1px;
    }
    .container > .orders-box{
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        position: relative;

    }
    .container > .orders-box >.order{
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        color:#000;
        margin-bottom: 1.5rem;
    }
    .container > .orders-box >.order> span:nth-of-type(1){
        margin: 0 -10px;
        color: #000;
        font-weight: 900;
    }
    .container > .orders-box >.order> span:not(span:nth-of-type(1)){
        cursor: pointer;
        font-size: 18px;
    }
    .container > .orders-box >.order> .box-1{
        margin: 0 -7px;
        border: 1px solid #a3080c;
        box-shadow: inset 0 0 0 .7px #a3080c;
        border-radius: 7px;
        color: #000;
        font-weight: 900;
        padding: 5px 7px;
    }
    .container > .orders-box .order >p{
        font-weight: 600;
    }
    .container > .orders-box> .order> .xmark-box >i{
        font-size: 16px;
        color: #f3f3f3;
        background-color: #a3080c;
        padding: 5px 8px;
        border-radius: 50%;
        transition: all .15s;
        cursor: pointer;
    }
    .container > .orders-box> .order> .xmark-box >i:hover{
        filter: sepia(60%);
    }
    .container > .orders-box> .order:nth-of-type(2)> .xmark-box >i{

    }

    .container > .orders-box > .beverage-box >img{
        width: 27px;
        background-color: #f3f3f3;
        border-radius: 6px;
        border: 1px solid #a3080c;
    }

    .container > .orders-box >.beverage-box{
        border-radius: 6px;
        cursor: pointer;
        width: 50%;
        padding: 5px;
        background-color: #a3080c;
        color: #f3f3f3;
        letter-spacing: .5px;
        font-weight: 100;
        display: flex;
        gap: .3rem;
        align-items: center;
        margin-bottom: 1rem;
        transition: all .3s;
    }
    .container > .orders-box >.beverage-box:hover{
        filter: sepia(60%);
    }
    .container > .orders-box >.bill-box{
        background-color: #f0f0f0;
        color: #333;
        display: flex;
        justify-content: space-between;
        padding: .5rem;
        border-radius: 6px;
        line-height: 1.4;
    }
    .container > .orders-box >.btn{
        background-color: #f0f0f0;
        color: #a3080c;
        margin-top: 1rem;
        padding: .5rem;
        border-radius: 7px;
        text-align: left;
        letter-spacing: .4px;
        cursor: pointer;
        transition: all .4s ease-out;
    }
    .container > .orders-box >.btn:hover{
        background-color: #a3080c;
        color: #e8e8e8;
    }
    @media screen and (min-width:500px){
        body{
            height: 100vh;
        }
        .container{
            border-radius: 8px;
        }
        nav{
            border-radius: 8px 8px 0 0 ;
        }
        .container > .orders-box >.order> span:nth-of-type(1){
            margin: 0 -20px;
        }
        .container > .orders-box >.order> .box-1{
            margin: 0 -17px;
        }
    }
    .price{
        text-align: right;
    }
</style>
