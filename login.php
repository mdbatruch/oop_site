<?php

  require('initialize.php');

  include('includes/header.php');
  
  global $session;

  if (isset($_SESSION['account']) && $session->is_logged_in_as_admin($_SESSION['account'])) {
    header( 'location: private/index.php' );
  }

  $subtotal = 0;

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);

            $subtotal = '';

            if ($products) {
                foreach ($products as $product_item) {
                    $product_item['price'] = substr($product_item['price'], 1);

                    $total = $product_item['price'] * $product_item['quantity'];
                    
                    $subtotal = intval($subtotal) + intval($total);
                }
            } else {
                $subtotal = 0;
            }
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }


  $site->addHeader();

?>
<header <?= !empty($_SESSION) && $_SESSION['account'] == 'Administrator' ? 'class="sticky-top"' : '';?>>
    <div class="header-container">
        <?php 
            if (!empty($_SESSION) && $_SESSION['account'] == 'Administrator') {
                $site->addAdminBar($site);
            } else {
                $site->addCartHeader($site, $count, $items, $subtotal, $db);
            } ?>
    </div>
</header>
<main class="admin-login d-flex">
  <div class="container">
      <div class="row">
          <div id="content" class="login-page col-12">
              <form id="login" method="post">
                <h3 class="mb-4 w-100 text-white"><img class="icon" src="<?= root_url('uploads/login.png'); ?>" alt="Login Icon" class="img-fluid"> Login</h3>
                <div class="form-container">
                    <div id="form-message"></div>
                      <label class="mb-1 text-white">Username<span class="ast">*</span></label>
                      <input type="text" id="username" name="username" placeholder="Username"/>
                      <div id="username-error"></div>
                    <br />
                      <label class="mb-1 text-white">Password<span class="ast">*</span></label>
                      <input type="password" id="password" name="password" placeholder="Password" value="" />
                      <div id="password-error"></div>
                    <br />
                </div>
                <input type="submit" name="submit" value="Submit" class="btn btn-black" />
                <div class="logged-out">
                    <?php if (isset($_SESSION['logout_message'])) : ?>
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <?php echo $_SESSION['logout_message'];
                            unset($_SESSION['logout_message']);
                            session_destroy(); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      </div>
                    <?php endif; ?>
                </div>
              </form>
          </div>
      </div>
  </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>