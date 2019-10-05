<?php
include_once 'utils.php';
session_start();

$address1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_STRING);
$address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_STRING);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);

$cart = $_SESSION['cart'];
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../main.css" />

    <title>Grampos Store</title>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html"><img src="../images/logo.svg" width="80" height="80" /></a>
            <h1>Grampos</h1>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="../index.html" class="btn btn-primary">
                            Continue Shopping
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <section class="py-5 m-3">
        <div class="container">
            <p>
                You'll find the best deals here.
            </p>
        </div>
        <div class="container">
            <h1 class="m-3">Your order <?php echo $cart['id'] ?> was placed.</h1>
            <h4 class="m-2">See the details below</h4>
        </div>
        <div class="container">
            <div class="row table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-right">Price</th>
                            <th scope="col" class="text-right">Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody id="cart-list">
                        <?php
            foreach ($cart['items'] as $item) {
              ?>
                        <tr>
                            <td class="p-2"><?php echo $item['title'] ?></td>
                            <td class="p-2 text-center"><?php echo $item['qty'] ?></td>
                            <td class="p-2 text-right"><?php echo $item['price'] ?></td>
                            <td class="p-2 text-right"><?php echo $item['price'] * $item['qty'] ?></td>
                        </tr>
                        <?php
            }
            ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th id="cart-items-num" class="text-center"><?php echo orderNumItems($cart) ?></th>
                            <th id="cart-items-total" colspan="2" class="text-right"><?php echo orderValue($cart) ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="container">
            <h4 class="m-2">The order will be delivered to</h4>
        </div>
        <div class="container" class="text-mute">

            <?php echo $address1 ?><br />
            <?php echo $address2 ?><br />
            <?php echo $city ?>
            <?php echo $state ?>
            <?php echo $zip ?>
        </div>
        </div>
        <div class="container">
            <a href="../index.html">Continue Shopping</a>
        </div>
        </div>
    </section>
</body>

</html>