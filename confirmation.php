<?php
    
    require('initialize.php');

    $order = Order::fetchOrderbyId($_GET['order'], $db);

    if (empty($_SESSION)) {
        header('Location: cart.php');
    }

    if ($_SESSION['account'] == 'Administrator') {
        header('Location: index.php');
    }

    // this needs more work to prevent users from revisiting success page

    if ($_SESSION['id'] == $order[0]['customer_id']) {
        // if(!isset($_SESSION['order_success'])) {
        //     $_SESSION['order_success'] = 1;   
        // } else {

            foreach ($_SESSION['orders'] as $key => $value) {
                //check if this is not the first time the page has been viewed
                if($_GET['order'] == $value) {
                
                    unset($_SESSION['order_success']);
                    header('location: index.php');

                    session_write_close();
                    exit();
                }
            // }
        }
    } else {
        header('location: index.php');
        exit();
    }

    // prevent revisits to the page
    // $_SESSION['order_id'] = $order[0]['id'];

    // if(!isset($_SESSION['order_success'])) {
    //     $_SESSION['order_success'] = 1;   
    // } else {
    //     //check if this is not the first time the page has been viewed
    //     if(isset($_SESSION['order_success'])) {
        
    //         header('location: index.php');

    //         session_write_close();
    //         exit();
    //     }
    // }

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";


    $name = Customer::view_customer_info($order[0]['customer_id'], $db);

    // echo '<pre>';
    // print_r($order);

    $customer = $order[0]['customer_id'];

    $time = new DateTime($order[0]['created_at']);

    $date = date_format($time, 'm/d/Y');

    // $product_image = new ProductImage($db);

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        // echo '<pre>';
        // print_r($_SESSION);

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }

    // echo '<pre>';
    // print_r($products);

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $db); ?>
        </div>
    </div>
</header>
<main id="cart">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                Congrats <?= $name['first_name']; ?>, Your order has been sent!
                <div class="col-med-6">
                    Order Number: <?= $order[0]['id']; ?>
                    Order Date: <?= $date; ?>
                    Order Details:
                    <div>
                        Delivery Address and Contact:
                        <?php 
                            $address = json_decode($order[0]['shipping_address']);
                            $contact = json_decode($order[0]['contact_details']);

                            echo $contact->name . '<br/>';
                            echo $contact->phone . '<br/>';
                            echo $contact->email . '<br/>';

                            echo $address->street . '<br/>';
                            echo $address->suite . '<br/>';
                            echo $address->city . '<br/>';
                            echo $address->province . '<br/>';
                            echo $address->postal . '<br/>';
                        
                        ?>
                    </div>
                    <div>
                        Products:
                        <?php foreach($order[0]['products'] as $product) :

                            $image = Product::getProductImage($product->item_name, $db); ?>
                            <img src="images/<?= $image['image']; ?>" class="rounded img-fluid img-thumbnail" alt="<?= $product->item_name; ?>">
                        <?php
                            echo $product->item_name . '<br/>';
                            echo $product->item_quantity . '<br/>';
                            echo $product->item_price . '<br/>';
                        endforeach; ?>
                    </div>
                    <div>
                        Card Information:
                        <?php 
                        
                            $card = json_decode($order[0]['card_info']);

                            echo $card->card_type . '<br/>';
                            echo $card->card_hash . '<br/>';
                        
                        ?>
                    </div>
                    <div>
                        Amount:
                        <?= $order[0]['amount']; ?>
                    </div>
                </div>
            </div>
            <div class="col">
                <a href="<?php echo root_url('index.php'); ?>" class="button nav-link">Back to Homepage</a>
                <a href="<?php echo root_url('products.php'); ?>" class="button nav-link">Continue Shopping</a>
                <a href="<?php echo root_url_private('customer/orders.php?id=' . $customer); ?>" class="button nav-link">View your Orders</a>
            </div>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>