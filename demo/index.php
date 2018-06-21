<?php include 'header.php' ?>
<html>
<head>
    <link rel="stylesheet" href="main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>

<body class="single-ico">
<section id='ico-single'>
    <div class="ico-single">
        <div class="box ico-live-wallet" id="live-wallet-mobile">
            <div class="buy">
                <div class="td-live-wallet">
                    <?php
                    if(isset($order->id)){
                        include 'payment.php';
                    } else{
                        include 'create.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="main.js"></script>
</body>
</html>
